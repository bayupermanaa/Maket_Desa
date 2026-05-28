<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class SuratUsahaTemplateService
{
    private array $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function templatePath(): string
    {
        return storage_path('app/templates/surat-keterangan-usaha.docx');
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
            'tempat_tanggal_lahir' => trim(($detail['tempat_lahir'] ?? '') . ', ' . $this->formatNullableDate($detail['tanggal_lahir'] ?? null), ' ,'),
            'kebangsaan' => $detail['kebangsaan'] ?? '',
            'agama' => $detail['agama'] ?? '',
            'jenis_kelamin' => $detail['jenis_kelamin'] ?? '',
            'pekerjaan' => $detail['pekerjaan'] ?? '',
            'nomor_ktp' => $surat->nik,
            'alamat' => $surat->alamat,
            'maksud_tujuan' => $surat->keperluan,
            'keterangan_lain' => $detail['keterangan_lain'] ?? '',
        ];
    }

    public function generateDocx(PengajuanSurat $surat): array
    {
        $templatePath = $this->templatePath();
        if (!is_file($templatePath)) {
            throw new RuntimeException('Template Surat Keterangan Usaha tidak ditemukan.');
        }

        $outputDir = storage_path('app/generated-surat');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $filename = Str::slug('surat-keterangan-usaha-' . $surat->nama . '-' . $surat->id) . '.docx';
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

        $data = $this->viewData($surat);
        foreach ($this->paragraphMap($data) as $needle => $replacement) {
            $documentXml = $this->replaceParagraphText($documentXml, $needle, $replacement);
        }
        $documentXml = $this->replaceParagraphText(
            $documentXml,
            'Alamat',
            'Alamat : ' . ($data['alamat'] ?: '-'),
            true
        );
        $documentXml = $this->replaceLastParagraphText(
            $documentXml,
            'Buruan,',
            'Buruan, ' . ($data['tanggal_surat'] ?: '-')
        );
        $documentXml = $this->replaceLastParagraphText(
            $documentXml,
            'Perbekel Desa Buruan',
            $data['jabatan_ttd'] ?: '-'
        );

        $zip->addFromString('word/document.xml', $documentXml);
        $zip->close();

        return ['path' => $outputPath, 'filename' => $filename];
    }

    public function generatePdf(PengajuanSurat $surat)
    {
        return Pdf::loadView('surat.usaha-preview', [
            'surat' => $surat,
            'data' => $this->viewData($surat),
            'printMode' => true,
        ])->setPaper('a4', 'portrait');
    }

    private function paragraphMap(array $data): array
    {
        return [
            'NOMOR' => 'NOMOR : ' . ($data['nomor_surat'] ?: '-'),
            'Nama' => 'Nama : ' . ($data['nama_pejabat'] ?: '-'),
            'Jabatan' => 'Jabatan : ' . ($data['jabatan_pejabat'] ?: '-'),
            'Yang juga berdasarkan' => 'Yang juga berdasarkan Surat Keterangan dari Kelihan Banjar Dinas '
                . ($data['nama_banjar'] ?: '-')
                . ' Nomor : '
                . ($data['nomor_surat_banjar'] ?: '-')
                . ' tanggal, '
                . ($data['tanggal_surat_banjar'] ?: '-')
                . ', menerangkan dengan sebenarnya bahwa :',
            '1. Nama' => '1. Nama : ' . ($data['nama'] ?: '-'),
            'Tempat / Tanggal lahir' => 'Tempat / Tanggal lahir : ' . ($data['tempat_tanggal_lahir'] ?: '-'),
            'Kebangsaan' => 'Kebangsaan : ' . ($data['kebangsaan'] ?: '-'),
            'Agama' => 'Agama : ' . ($data['agama'] ?: '-'),
            'Jenis Kelamin' => 'Jenis Kelamin : ' . ($data['jenis_kelamin'] ?: '-'),
            'Pekerjaan' => 'Pekerjaan : ' . ($data['pekerjaan'] ?: '-'),
            'Nomor KTP' => 'Nomor KTP : ' . ($data['nomor_ktp'] ?: '-'),
            '2. Maksud dan Tujuan' => '2. Maksud dan Tujuan : ' . ($data['maksud_tujuan'] ?: '-'),
            '3. Keterangan lain' => '3. Keterangan lain : ' . ($data['keterangan_lain'] ?: '-'),
            'I KETUT SUMARDA' => $data['nama_ttd'] ?: '-',
        ];
    }

    private function replaceParagraphText(string $xml, string $needle, string $replacement, bool $removeNextContinuation = false): string
    {
        $done = false;
        $skipNext = false;

        return preg_replace_callback('/<w:p\b[\s\S]*?<\/w:p>/', function ($matches) use ($needle, $replacement, $removeNextContinuation, &$done, &$skipNext) {
            $paragraph = $matches[0];
            $plain = html_entity_decode(strip_tags($paragraph), ENT_QUOTES | ENT_XML1, 'UTF-8');
            $plain = trim((string) preg_replace('/\s+/', ' ', $plain));

            if ($skipNext) {
                $skipNext = false;
                if ($plain !== '' && !str_contains($plain, ':') && !str_starts_with($plain, '2.')) {
                    return '';
                }
            }

            if ($done) {
                return $paragraph;
            }

            if (!str_contains($plain, $needle)) {
                return $paragraph;
            }

            $done = true;
            $skipNext = $removeNextContinuation;
            return $this->buildParagraph($paragraph, $replacement);
        }, $xml);
    }

    private function replaceLastParagraphText(string $xml, string $needle, string $replacement): string
    {
        if (!preg_match_all('/<w:p\b[\s\S]*?<\/w:p>/', $xml, $matches, PREG_OFFSET_CAPTURE)) {
            return $xml;
        }

        for ($i = count($matches[0]) - 1; $i >= 0; $i--) {
            $paragraph = $matches[0][$i][0];
            $plain = html_entity_decode(strip_tags($paragraph), ENT_QUOTES | ENT_XML1, 'UTF-8');
            $plain = trim((string) preg_replace('/\s+/', ' ', $plain));

            if (!str_contains($plain, $needle)) {
                continue;
            }

            $offset = $matches[0][$i][1];
            return substr_replace($xml, $this->buildParagraph($paragraph, $replacement), $offset, strlen($paragraph));
        }

        return $xml;
    }

    private function buildParagraph(string $sourceParagraph, string $text): string
    {
        preg_match('/<w:pPr\b[\s\S]*?<\/w:pPr>/', $sourceParagraph, $properties);
        $propertiesXml = $properties[0] ?? '';
        $safeText = htmlspecialchars($text, ENT_XML1 | ENT_COMPAT, 'UTF-8');

        return '<w:p>' . $propertiesXml . '<w:r><w:t xml:space="preserve">' . $safeText . '</w:t></w:r></w:p>';
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
