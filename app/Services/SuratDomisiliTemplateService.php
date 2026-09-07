<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class SuratDomisiliTemplateService
{
    private array $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function templatePath(): string
    {
        return storage_path('app/templates/surat-keterangan-domisili.docx');
    }

    public function viewData(PengajuanSurat $surat): array
    {
        $detail = $surat->detail_surat ?? [];

        return [
            'nomor_surat' => $detail['nomor_surat'] ?? '',
            'nama_pejabat' => $detail['nama_pejabat'] ?? '',
            'jabatan_pejabat' => $detail['jabatan_pejabat'] ?? '',
            'nama_banjar' => $detail['nama_banjar'] ?? '',
            'nomor_surat_banjar' => $detail['nomor_surat_banjar'] ?? '',
            'tanggal_surat_banjar' => $this->formatNullableDate($detail['tanggal_surat_banjar'] ?? null),
            'tanggal_surat' => $this->formatNullableDate($detail['tanggal_surat'] ?? null),
            'jabatan_ttd' => $detail['jabatan_ttd'] ?? '',
            'nama_ttd' => $detail['nama_ttd'] ?? '',
            'nama' => $surat->nama,
            'tempat_tanggal_lahir' => trim(($detail['tempat_lahir'] ?? '') . ' / ' . $this->formatNullableDate($detail['tanggal_lahir'] ?? null), ' /'),
            'kebangsaan' => $detail['kebangsaan'] ?? '',
            'agama' => $detail['agama'] ?? '',
            'jenis_kelamin' => $detail['jenis_kelamin'] ?? '',
            'pekerjaan' => $detail['pekerjaan'] ?? '',
            'nomor_ktp' => $surat->nik,
            'alamat_asal' => $surat->alamat,
            'maksud_tujuan' => $surat->keperluan,
            'keterangan_lain' => $detail['keterangan_lain'] ?? '',
        ];
    }

    public function generateDocx(PengajuanSurat $surat): array
    {
        $templatePath = $this->templatePath();
        if (!is_file($templatePath)) {
            throw new RuntimeException('Template Surat Keterangan Domisili tidak ditemukan.');
        }

        $outputDir = storage_path('app/generated-surat');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $filename = Str::slug('surat-keterangan-domisili-' . $surat->nama . '-' . $surat->id) . '.docx';
        $outputPath = $outputDir . DIRECTORY_SEPARATOR . now()->format('YmdHis') . '-' . $filename;

        if (!copy($templatePath, $outputPath)) {
            throw new RuntimeException('Gagal menyalin template surat.');
        }

        $zip = new ZipArchive();
        if ($zip->open($outputPath) !== true) {
            throw new RuntimeException('Gagal membuka template surat.');
        }

        $documentXml = $zip->getFromName('word/document.xml');
        if ($documentXml === false) {
            $zip->close();
            throw new RuntimeException('Struktur template surat tidak valid.');
        }

        foreach ($this->fieldMap($surat) as $needle => $value) {
            $documentXml = $this->fillParagraphValue($documentXml, $needle, $value);
        }

        $zip->addFromString('word/document.xml', $documentXml);
        $zip->close();

        return ['path' => $outputPath, 'filename' => $filename];
    }

    public function generatePdf(PengajuanSurat $surat)
    {
        return Pdf::loadView('surat.domisili-preview', [
            'surat' => $surat,
            'data' => $this->viewData($surat),
            'printMode' => true,
        ])->setPaper('a4', 'portrait');
    }

    private function fieldMap(PengajuanSurat $surat): array
    {
        $data = $this->viewData($surat);

        return [
            'NOMOR' => $data['nomor_surat'],
            'Nama' => $data['nama_pejabat'],
            'Jabatan' => $data['jabatan_pejabat'],
            'Nomor :' => $data['nomor_surat_banjar'],
            '1. Nama' => $data['nama'],
            'Tempat / Tanggal lahir' => $data['tempat_tanggal_lahir'],
            'Kebangsaan' => $data['kebangsaan'],
            'Agama' => $data['agama'],
            'Jenis Kelamin' => $data['jenis_kelamin'],
            'Pekerjaan' => $data['pekerjaan'],
            'Nomor KTP' => $data['nomor_ktp'],
            'Alamat Asal' => $data['alamat_asal'],
            '2. Maksud dan Tujuan' => $data['maksud_tujuan'],
            '3. Keterangan lain' => $data['keterangan_lain'],
        ];
    }

    private function fillParagraphValue(string $xml, string $needle, ?string $value): string
    {
        $value = htmlspecialchars((string) ($value ?: '-'), ENT_XML1 | ENT_COMPAT, 'UTF-8');
        $done = false;

        return preg_replace_callback('/<w:p\b[\s\S]*?<\/w:p>/', function ($matches) use ($needle, $value, &$done) {
            if ($done) {
                return $matches[0];
            }

            $paragraph = $matches[0];
            $plain = html_entity_decode(strip_tags($paragraph), ENT_QUOTES | ENT_XML1, 'UTF-8');
            $plain = preg_replace('/\s+/', ' ', $plain);

            if (!str_contains($plain, $needle)) {
                return $paragraph;
            }

            $done = true;
            $colonRuns = [];
            if (!preg_match_all('/<w:t\b([^>]*)>([^<]*:\s*)<\/w:t>/', $paragraph, $colonRuns, PREG_OFFSET_CAPTURE)) {
                return $paragraph;
            }

            $last = count($colonRuns[0]) - 1;
            $full = $colonRuns[0][$last][0];
            $offset = $colonRuns[0][$last][1];
            $attrs = $colonRuns[1][$last][0];
            $text = $colonRuns[2][$last][0];
            $replacement = '<w:t' . $attrs . '>' . $text . ' ' . $value . '</w:t>';

            return substr_replace($paragraph, $replacement, $offset, strlen($full));
        }, $xml);
    }

    private function formatNullableDate(mixed $date): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            $date = \Carbon\Carbon::parse($date);
            return $date->format('d') . ' ' . $this->months[(int) $date->format('n')] . ' ' . $date->format('Y');
        } catch (\Throwable) {
            return (string) $date;
        }
    }
}
