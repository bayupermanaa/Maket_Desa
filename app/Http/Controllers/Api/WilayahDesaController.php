<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BanjarDinas;
use App\Models\Penduduk;
use Illuminate\Http\JsonResponse;

class WilayahDesaController extends Controller
{
    private function normalizeLabel(?string $value): string
    {
        $text = strtolower(trim((string) $value));
        $text = preg_replace('/\s+/', ' ', $text ?? '');
        $text = str_replace(['banjar', 'dinas'], '', $text ?? '');
        $text = preg_replace('/[^a-z0-9 ]/', '', $text ?? '');
        return trim($text ?? '');
    }

    private function normalizeGeometry(array $geometry): ?array
    {
        $type = $geometry['type'] ?? null;
        $coordinates = $geometry['coordinates'] ?? null;

        if (!is_string($type) || !is_array($coordinates)) {
            return null;
        }

        if ($type === 'Polygon') {
            $geometry['coordinates'] = array_map(
                fn ($ring) => $this->normalizeRing($ring),
                $coordinates
            );
            return $geometry;
        }

        if ($type === 'MultiPolygon') {
            $geometry['coordinates'] = array_map(
                fn ($polygon) => array_map(
                    fn ($ring) => $this->normalizeRing($ring),
                    is_array($polygon) ? $polygon : []
                ),
                $coordinates
            );
            return $geometry;
        }

        return null;
    }

    private function normalizeRing(array $ring): array
    {
        return array_map(function ($point) {
            if (!is_array($point) || count($point) < 2) {
                return $point;
            }

            $x = $point[0];
            $y = $point[1];

            if (!is_numeric($x) || !is_numeric($y)) {
                return $point;
            }

            $lng = (float) $x;
            $lat = (float) $y;

            // GeoJSON wajib [lng, lat]. Jika terbaca [lat, lng], tukar.
            if (abs($lat) > 90 && abs($lng) <= 90) {
                return [$lat, $lng];
            }

            return [$lng, $lat];
        }, $ring);
    }

    public function banjarDinas(): JsonResponse
    {
        $banjars = BanjarDinas::query()
            ->where('is_active', true)
            ->orderBy('nama')
            ->with(['markers' => function ($query) {
                $query->where('is_active', true)->orderBy('nama');
            }])
            ->get();

        $banjarLookup = [];
        foreach ($banjars as $banjar) {
            $banjarLookup[$banjar->id] = $this->normalizeLabel($banjar->nama);
        }

        $populationByBanjarId = array_fill_keys(array_keys($banjarLookup), 0);

        $penduduks = Penduduk::query()
            ->get(['dusun', 'alamat', 'kode_keluarga']);

        foreach ($penduduks as $penduduk) {
            $candidates = [
                $this->normalizeLabel($penduduk->dusun ?? ''),
                $this->normalizeLabel($penduduk->alamat ?? ''),
                $this->normalizeLabel($penduduk->kode_keluarga ?? ''),
            ];

            foreach ($banjarLookup as $banjarId => $banjarKey) {
                if ($banjarKey === '') {
                    continue;
                }

                foreach ($candidates as $candidate) {
                    if ($candidate === '' || $candidate === '0') {
                        continue;
                    }

                    if ($candidate === $banjarKey || str_contains($candidate, $banjarKey)) {
                        $populationByBanjarId[$banjarId]++;
                        continue 3;
                    }
                }
            }
        }

        $features = $banjars->map(function (BanjarDinas $banjar) use ($populationByBanjarId) {
            $geometryRaw = json_decode($banjar->geojson, true);
            $geometry = is_array($geometryRaw) ? $this->normalizeGeometry($geometryRaw) : null;

            if (!$geometry || !isset($geometry['type'])) {
                return null;
            }

            $totalPenduduk = (int) ($populationByBanjarId[$banjar->id] ?? 0);

            return [
                'type' => 'Feature',
                'properties' => [
                    'id' => $banjar->id,
                    'nama' => $banjar->nama,
                    'total_penduduk' => $totalPenduduk,
                    'markers' => $banjar->markers->map(fn ($marker) => [
                        'id' => $marker->id,
                        'nama' => $marker->nama,
                        'lat' => (float) $marker->latitude,
                        'lng' => (float) $marker->longitude,
                        'icon_url' => $marker->icon_url,
                        'alamat' => $marker->alamat,
                    ])->values(),
                ],
                'geometry' => $geometry,
            ];
        })->filter()->values();

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
