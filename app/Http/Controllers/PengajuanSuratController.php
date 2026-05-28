<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Services\SuratDomisiliTemplateService;
use App\Services\SuratUsahaTemplateService;

class PengajuanSuratController extends Controller
{
    private const JENIS_DOMISILI = 'Surat Keterangan Domisili';
    private const JENIS_USAHA = 'Surat Keterangan Usaha';
    private const JENIS_TEMPLATE_SURAT = [
        self::JENIS_DOMISILI,
        self::JENIS_USAHA,
    ];
    private const FIELD_PEMOHON_DOMISILI = [
        'tempat_lahir',
        'tanggal_lahir',
        'kebangsaan',
        'agama',
        'jenis_kelamin',
        'pekerjaan',
        'keterangan_lain',
    ];

    private const FIELD_ADMIN_DOMISILI = [
        'nomor_surat',
        'nama_pejabat',
        'jabatan_pejabat',
        'nama_banjar',
        'nomor_surat_banjar',
        'tanggal_surat_banjar',
        'tanggal_surat',
        'jabatan_ttd',
        'nama_ttd',
    ];

    private function routePrefix(): string
    {
        return request()->routeIs('kepala.*') ? 'kepala' : 'admin';
    }

    private function validatePengajuanSurat(Request $request): array
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'jenis_surat' => 'required|string|max:100',
            'keperluan' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'detail_surat' => 'nullable|array',
            'detail_surat.tempat_lahir' => 'required_if:jenis_surat,' . self::JENIS_DOMISILI . ',' . self::JENIS_USAHA . '|nullable|string|max:100',
            'detail_surat.tanggal_lahir' => 'required_if:jenis_surat,' . self::JENIS_DOMISILI . ',' . self::JENIS_USAHA . '|nullable|date',
            'detail_surat.kebangsaan' => 'required_if:jenis_surat,' . self::JENIS_DOMISILI . ',' . self::JENIS_USAHA . '|nullable|string|max:100',
            'detail_surat.agama' => 'required_if:jenis_surat,' . self::JENIS_DOMISILI . ',' . self::JENIS_USAHA . '|nullable|string|max:50',
            'detail_surat.jenis_kelamin' => 'required_if:jenis_surat,' . self::JENIS_DOMISILI . ',' . self::JENIS_USAHA . '|nullable|string|max:20',
            'detail_surat.pekerjaan' => 'required_if:jenis_surat,' . self::JENIS_DOMISILI . ',' . self::JENIS_USAHA . '|nullable|string|max:100',
            'detail_surat.keterangan_lain' => 'nullable|string|max:255',
        ]);

        $detail = $validated['detail_surat'] ?? [];
        $validated['detail_surat'] = collect($detail)
            ->only(self::FIELD_PEMOHON_DOMISILI)
            ->filter(fn ($value) => !is_null($value) && $value !== '')
            ->all();

        return $validated;
    }

    private function administrasiSuratBelumLengkap(PengajuanSurat $surat): array
    {
        if (!in_array($surat->jenis_surat, self::JENIS_TEMPLATE_SURAT, true)) {
            return [];
        }

        $detail = $surat->detail_surat ?? [];

        return collect(self::FIELD_ADMIN_DOMISILI)
            ->filter(fn ($field) => empty($detail[$field]))
            ->values()
            ->all();
    }

    /**
     * Tampilkan daftar semua pengajuan surat (ADMIN)
     */
    public function index()
    {
        $isKepala = request()->routeIs('kepala.*');
        $statusOptions = $isKepala ? [
            PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA,
            PengajuanSurat::STATUS_DISETUJUI_KEPALA,
            PengajuanSurat::STATUS_DITOLAK_KEPALA,
            PengajuanSurat::STATUS_DISETUJUI,
            PengajuanSurat::STATUS_DITOLAK,
        ] : [
            PengajuanSurat::STATUS_MENUNGGU,
            PengajuanSurat::STATUS_DIPROSES,
            PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA,
            PengajuanSurat::STATUS_DISETUJUI_KEPALA,
            PengajuanSurat::STATUS_DITOLAK_KEPALA,
            PengajuanSurat::STATUS_DISETUJUI,
            PengajuanSurat::STATUS_DITOLAK,
        ];
        $filters = request()->only(['q', 'status', 'date_from', 'date_to']);
        $query = PengajuanSurat::query();

        if ($isKepala) {
            $query->whereIn('status', [
                PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA,
                PengajuanSurat::STATUS_DISETUJUI_KEPALA,
                PengajuanSurat::STATUS_DITOLAK_KEPALA,
                PengajuanSurat::STATUS_DISETUJUI,
                PengajuanSurat::STATUS_DITOLAK,
            ]);
        }

        if (!empty($filters['q'])) {
            $keyword = trim((string) $filters['q']);
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('nik', 'like', '%' . $keyword . '%')
                    ->orWhere('jenis_surat', 'like', '%' . $keyword . '%');
            });
        }

        if (!empty($filters['status']) && in_array($filters['status'], $statusOptions, true)) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $pengajuan = $query->latest()->paginate(15)->withQueryString();
        $suratBaruCount = PengajuanSurat::where('status', PengajuanSurat::STATUS_MENUNGGU)->count();
        $suratMenungguKepalaCount = PengajuanSurat::where('status', PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA)->count();
        $suratPerluFinalisasiCount = PengajuanSurat::where('status', PengajuanSurat::STATUS_DISETUJUI_KEPALA)->count();
        $suratDitolakKepalaCount = PengajuanSurat::where('status', PengajuanSurat::STATUS_DITOLAK_KEPALA)->count();
        $notifikasiSuratCount = $isKepala ? $suratMenungguKepalaCount : $suratBaruCount;

        return view('admin.pengajuan-surat.index', compact(
            'pengajuan',
            'filters',
            'statusOptions',
            'suratBaruCount',
            'suratMenungguKepalaCount',
            'suratPerluFinalisasiCount',
            'suratDitolakKepalaCount',
            'notifikasiSuratCount'
        ));
    }

    /**
     * Form create (sebenarnya nanti untuk masyarakat,
     * tapi sementara kita biarkan dulu)
     */
    public function create()
    {
        return view('admin.pengajuan-surat.create');
    }

    /**
     * Simpan pengajuan baru (status otomatis MENUNGGU)
     */
    public function store(Request $request)
    {
        $validated = $this->validatePengajuanSurat($request);

        PengajuanSurat::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'detail_surat' => $validated['detail_surat'] ?? [],
            'status' => PengajuanSurat::STATUS_MENUNGGU,
        ]);

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil ditambahkan.');
    }

    /**
     * Simpan pengajuan surat oleh masyarakat dari dashboard masyarakat.
     */
    public function storeMasyarakat(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'masyarakat') {
            abort(403);
        }

        $validated = $this->validatePengajuanSurat($request);

        PengajuanSurat::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'detail_surat' => $validated['detail_surat'] ?? [],
            'status' => PengajuanSurat::STATUS_MENUNGGU,
        ]);

        return redirect()
            ->route('dashboard.masyarakat', ['tab' => 'pengajuan'])
            ->with('success', 'Pengajuan surat berhasil dikirim. Silakan pantau di menu Status Pengajuan Surat.');
    }

    /**
     * Detail pengajuan (admin baca isi sebelum verifikasi)
     */
    public function show($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        return view('admin.pengajuan-surat.show', compact('surat'));
    }

    private function templateService(PengajuanSurat $surat): SuratDomisiliTemplateService|SuratUsahaTemplateService
    {
        return $surat->jenis_surat === self::JENIS_USAHA
            ? app(SuratUsahaTemplateService::class)
            : app(SuratDomisiliTemplateService::class);
    }

    private function previewView(PengajuanSurat $surat): string
    {
        return $surat->jenis_surat === self::JENIS_USAHA
            ? 'surat.usaha-preview'
            : 'surat.domisili-preview';
    }

    private function downloadSlug(PengajuanSurat $surat): string
    {
        $prefix = $surat->jenis_surat === self::JENIS_USAHA
            ? 'surat-keterangan-usaha-'
            : 'surat-keterangan-domisili-';

        return \Illuminate\Support\Str::slug($prefix . $surat->nama . '-' . $surat->id);
    }

    public function previewMasyarakat($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'masyarakat') {
            abort(403);
        }

        $surat = PengajuanSurat::findOrFail($id);
        $user = auth()->user();
        $isOwner = !empty($user->nik) ? $surat->nik === $user->nik : $surat->nama === $user->name;

        if (!$isOwner) {
            abort(403);
        }

        if ($surat->status !== PengajuanSurat::STATUS_DISETUJUI || $this->administrasiSuratBelumLengkap($surat)) {
            abort(403);
        }

        $template = $this->templateService($surat);

        return view($this->previewView($surat), [
            'surat' => $surat,
            'data' => $template->viewData($surat),
            'printMode' => false,
        ]);
    }

    public function previewSurat($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $template = $this->templateService($surat);

        return view($this->previewView($surat), [
            'surat' => $surat,
            'data' => $template->viewData($surat),
            'printMode' => false,
        ]);
    }

    public function downloadSurat($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        if ($surat->status !== PengajuanSurat::STATUS_DISETUJUI) {
            return redirect()->route($this->routePrefix() . '.pengajuan-surat.show', $surat->id)
                ->with('error', 'Surat hanya bisa diunduh setelah finalisasi admin.');
        }

        if ($this->administrasiSuratBelumLengkap($surat)) {
            return redirect()->route($this->routePrefix() . '.pengajuan-surat.show', $surat->id)
                ->with('error', 'Lengkapi data administrasi surat terlebih dahulu sebelum mengunduh draft.');
        }

        $template = $this->templateService($surat);
        $generated = $template->generateDocx($surat);

        return response()
            ->download($generated['path'], $generated['filename'])
            ->deleteFileAfterSend(true);
    }

    public function downloadPdf($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        if ($surat->status !== PengajuanSurat::STATUS_DISETUJUI) {
            return redirect()->route($this->routePrefix() . '.pengajuan-surat.show', $surat->id)
                ->with('error', 'PDF hanya bisa diunduh setelah finalisasi admin.');
        }

        if ($this->administrasiSuratBelumLengkap($surat)) {
            return redirect()->route($this->routePrefix() . '.pengajuan-surat.show', $surat->id)
                ->with('error', 'Lengkapi data administrasi surat terlebih dahulu sebelum mengunduh PDF.');
        }

        $template = $this->templateService($surat);

        return $template->generatePdf($surat)
            ->download($this->downloadSlug($surat) . '.pdf');
    }

    public function updateAdministrasi(Request $request, $id)
    {
        if (!request()->routeIs('admin.*')) {
            abort(403);
        }

        $surat = PengajuanSurat::findOrFail($id);

        $validated = $request->validate([
            'detail_surat' => 'required|array',
            'detail_surat.nomor_surat' => 'required|string|max:100',
            'detail_surat.nama_pejabat' => 'required|string|max:150',
            'detail_surat.jabatan_pejabat' => 'required|string|max:150',
            'detail_surat.nama_banjar' => 'required|string|max:150',
            'detail_surat.nomor_surat_banjar' => 'required|string|max:100',
            'detail_surat.tanggal_surat_banjar' => 'required|date',
            'detail_surat.tanggal_surat' => 'required|date',
            'detail_surat.jabatan_ttd' => 'required|string|max:150',
            'detail_surat.nama_ttd' => 'required|string|max:150',
        ]);

        $detailAdmin = collect($validated['detail_surat'])
            ->only(self::FIELD_ADMIN_DOMISILI)
            ->filter(fn ($value) => !is_null($value) && $value !== '')
            ->all();

        $surat->detail_surat = array_merge($surat->detail_surat ?? [], $detailAdmin);
        if ($surat->status === PengajuanSurat::STATUS_MENUNGGU) {
            $surat->status = PengajuanSurat::STATUS_DIPROSES;
        }
        $surat->save();

        return redirect()->route('admin.pengajuan-surat.show', $surat->id)
            ->with('success', 'Data administrasi surat berhasil disimpan.');
    }

    /**
     * Edit (opsional)
     */
    public function edit($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        return view('admin.pengajuan-surat.edit', compact('surat'));
    }

    /**
     * Update (opsional)
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validatePengajuanSurat($request);

        $surat = PengajuanSurat::findOrFail($id);
        $detailSurat = array_merge($surat->detail_surat ?? [], $validated['detail_surat'] ?? []);

        $surat->update([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
            'detail_surat' => $detailSurat,
        ]);

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil diupdate.');
    }

    /**
     * Hapus pengajuan
     */
    public function destroy($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->delete();

        return redirect()->route($this->routePrefix() . '.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil dihapus.');
    }

    // =====================================================
    // 🔥 FITUR VERIFIKASI ADMIN
    // =====================================================

    /**
     * Admin menyetujui pengajuan
     */
    public function setujui($id)
    {
        $surat = PengajuanSurat::findOrFail($id);

        if (request()->routeIs('kepala.*')) {
            if ($surat->status !== PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA) {
                return redirect()->route('kepala.pengajuan-surat.show', $surat->id)
                    ->with('error', 'Pengajuan ini belum berada pada tahap validasi kepala desa.');
            }

            $surat->status = PengajuanSurat::STATUS_DISETUJUI_KEPALA;
            $surat->save();

            return redirect()->route('kepala.pengajuan-surat.index')
                ->with('success', 'Pengajuan surat berhasil disetujui kepala desa dan dikirim kembali ke admin.');
        }

        if ($surat->status === PengajuanSurat::STATUS_DISETUJUI_KEPALA) {
            $surat->status = PengajuanSurat::STATUS_DISETUJUI;
            $surat->save();

            return redirect()->route('admin.pengajuan-surat.index')
                ->with('success', 'Pengajuan surat berhasil difinalisasi.');
        }

        if (!in_array($surat->status, [PengajuanSurat::STATUS_MENUNGGU, PengajuanSurat::STATUS_DIPROSES, PengajuanSurat::STATUS_DITOLAK_KEPALA], true)) {
            return redirect()->route('admin.pengajuan-surat.show', $surat->id)
                ->with('error', 'Status pengajuan belum bisa diajukan ke kepala desa.');
        }

        if ($this->administrasiSuratBelumLengkap($surat)) {
            return redirect()->route('admin.pengajuan-surat.show', $surat->id)
                ->with('error', 'Lengkapi data administrasi surat terlebih dahulu sebelum mengajukan ke kepala desa.');
        }

        $surat->status = PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA;
        $surat->save();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil diajukan ke kepala desa.');
    }

    /**
     * Admin menolak pengajuan
     */
    public function tolak(Request $request, $id)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:1000',
        ], [
            'keterangan.required' => 'Keterangan penolakan wajib diisi.',
        ]);

        $surat = PengajuanSurat::findOrFail($id);
        $keterangan = trim($validated['keterangan']);

        if (request()->routeIs('kepala.*')) {
            if ($surat->status !== PengajuanSurat::STATUS_DIAJUKAN_KE_KEPALA) {
                return redirect()->route('kepala.pengajuan-surat.show', $surat->id)
                    ->with('error', 'Pengajuan ini belum berada pada tahap validasi kepala desa.');
            }

            $surat->status = PengajuanSurat::STATUS_DITOLAK_KEPALA;
            $surat->keterangan = 'Ditolak Kepala Desa: ' . $keterangan;
            $surat->save();

            return redirect()->route('kepala.pengajuan-surat.index')
                ->with('success', 'Pengajuan surat ditolak kepala desa dan dikirim kembali ke admin.');
        }

        $surat->status = PengajuanSurat::STATUS_DITOLAK;
        $surat->keterangan = 'Ditolak Admin: ' . $keterangan;
        $surat->save();

        return redirect()->route('admin.pengajuan-surat.index')
            ->with('success', 'Pengajuan surat berhasil ditolak.');
    }
}
