<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Usaha</title>
    <style>
        @page { size: A4; margin: 0; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f3f4f6; color: #000; font-family: "Times New Roman", serif; }
        .toolbar { max-width: 794px; margin: 18px auto 10px; display: flex; justify-content: flex-end; gap: 8px; font-family: Arial, sans-serif; }
        .toolbar button, .toolbar a { border: 1px solid #ddd; background: #fff; padding: 8px 12px; border-radius: 8px; color: #111; text-decoration: none; font-size: 13px; }
        .paper { width: 794px; min-height: 1123px; margin: 0 auto 24px; background: #fff; padding: 142px 92px 72px 92px; font-size: 13.3px; line-height: 1.2; position: relative; }
        .kop { position: absolute; top: 56px; left: 92px; right: 92px; text-align: center; }
        .kop img { width: 100%; max-height: 92px; object-fit: contain; }
        .title { text-align: center; margin-top: 18px; margin-bottom: 18px; }
        .title .main { font-weight: bold; text-decoration: underline; font-size: 16px; }
        .row { display: grid; grid-template-columns: 185px 1fr; margin: 1px 0; }
        .row.person { grid-template-columns: 32px 185px 1fr; }
        .paragraph { text-align: justify; margin: 12px 0; }
        .signature { width: 280px; margin-left: auto; text-align: center; margin-top: 20px; }
        .signature .space { height: 72px; }
        .bold { font-weight: bold; }
        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .paper { margin: 0; box-shadow: none; width: 210mm; min-height: 297mm; }
        }
    </style>
</head>
<body>
@empty($printMode)
    <div class="toolbar">
        <button type="button" onclick="window.print()">Cetak</button>
        <a href="{{ url()->previous() }}">Kembali</a>
    </div>
@endempty

<main class="paper">
    <div class="kop">
        <img src="{{ !empty($printMode) ? public_path('storage/surat-templates/kop-domisili.jpeg') : asset('storage/surat-templates/kop-domisili.jpeg') }}" alt="Kop Surat">
    </div>

    <section class="title">
        <div class="main">SURAT KETERANGAN USAHA</div>
        <div>NOMOR : {{ $data['nomor_surat'] ?: '-' }}</div>
    </section>

    <p class="paragraph">Yang bertanda tangan di bawah ini :</p>
    <div class="row"><span>Nama</span><span>: {{ $data['nama_pejabat'] ?: '-' }}</span></div>
    <div class="row"><span>Jabatan</span><span>: {{ $data['jabatan_pejabat'] ?: '-' }}</span></div>

    <p class="paragraph">
        Yang juga berdasarkan Surat Keterangan dari Kelihan Banjar Dinas {{ $data['nama_banjar'] ?: '-' }}
        Nomor : {{ $data['nomor_surat_banjar'] ?: '-' }} tanggal {{ $data['tanggal_surat_banjar'] ?: '-' }}, menerangkan dengan sebenarnya bahwa:
    </p>

    <div class="row person"><span>1.</span><span>Nama</span><span>: {{ $data['nama'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Tempat / Tanggal lahir</span><span>: {{ $data['tempat_tanggal_lahir'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Kebangsaan</span><span>: {{ $data['kebangsaan'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Agama</span><span>: {{ $data['agama'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Jenis Kelamin</span><span>: {{ $data['jenis_kelamin'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Pekerjaan</span><span>: {{ $data['pekerjaan'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Nomor KTP</span><span>: {{ $data['nomor_ktp'] ?: '-' }}</span></div>
    <div class="row person"><span></span><span>Alamat</span><span>: {{ $data['alamat'] ?: '-' }}</span></div>

    <div class="row person" style="margin-top: 12px;"><span>2.</span><span>Maksud dan Tujuan</span><span>: {{ $data['maksud_tujuan'] ?: '-' }}</span></div>
    <div class="row person"><span>3.</span><span>Keterangan lain</span><span>: {{ $data['keterangan_lain'] ?: '-' }}</span></div>

    <p class="paragraph">
        Demikian surat keterangan ini kami buat dengan sebenarnya untuk dapat dipergunakan apabila diperlukan
        dengan mengingat sumpah jabatan kami.
    </p>

    <section class="signature">
        <div>Buruan, {{ $data['tanggal_surat'] ?: '-' }}</div>
        <div class="bold">{{ $data['jabatan_ttd'] ?: '-' }}</div>
        <div class="space"></div>
        <div class="bold">{{ $data['nama_ttd'] ?: '-' }}</div>
    </section>
</main>
</body>
</html>
