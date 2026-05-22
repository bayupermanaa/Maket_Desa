<x-app-layout>
    <x-slot name="title">Laporan & Statistik - Desa Maket</x-slot>
    @php($routePrefix = request()->routeIs('kepala.*') ? 'kepala' : 'admin')

    <div class="min-h-screen bg-gray-100 flex">
        @include('admin.partials.sidebar')

        <div class="p-6 md:p-8 w-full">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <h1 class="text-3xl font-semibold text-gray-900 mb-1">Laporan & Statistik</h1>
                <p class="text-sm text-gray-600 mb-6">Ringkasan data utama untuk monitoring administrasi desa.</p>

                <form method="GET" action="{{ route($routePrefix . '.laporan-statistik.index') }}" class="mb-6 flex flex-wrap items-end gap-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ $dari }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ $sampai }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Terapkan Filter</button>
                    <a href="{{ route($routePrefix . '.laporan-statistik.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm">Reset</a>
                    <a href="{{ route($routePrefix . '.laporan-statistik.export.excel', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">Export Excel</a>
                    <a href="{{ route($routePrefix . '.laporan-statistik.export.pdf', request()->query()) }}" target="_blank" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm">Export PDF</a>
                </form>

                <p class="text-sm text-gray-600 mb-6">Periode laporan: <span class="font-medium">{{ $periodeLabel }}</span></p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Total Penduduk</p>
                        <p class="text-2xl font-semibold">{{ number_format($totalPenduduk) }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Penduduk Aktif</p>
                        <p class="text-2xl font-semibold text-green-600">{{ number_format($pendudukAktif) }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Penduduk Nonaktif</p>
                        <p class="text-2xl font-semibold text-red-600">{{ number_format($pendudukNonaktif) }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-sm text-gray-500">Saldo Keuangan</p>
                        <p class="text-2xl font-semibold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="border border-gray-200 rounded-xl p-4">
                        <h2 class="font-semibold mb-3">Komposisi Penduduk</h2>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span>Laki-laki</span><span>{{ number_format($pendudukLaki) }}</span></div>
                            <div class="flex justify-between"><span>Perempuan</span><span>{{ number_format($pendudukPerempuan) }}</span></div>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-xl p-4">
                        <h2 class="font-semibold mb-3">Ringkasan Keuangan</h2>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span>Total Pendapatan</span><span>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span></div>
                            <div class="flex justify-between"><span>Total Belanja</span><span>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="border border-gray-200 rounded-xl p-4">
                        <h2 class="font-semibold mb-3">Status Pengajuan Surat</h2>
                        <div class="space-y-2 text-sm">
                            @forelse($suratByStatus as $status => $total)
                                <div class="flex justify-between"><span>{{ $status }}</span><span>{{ number_format($total) }}</span></div>
                            @empty
                                <p class="text-gray-500">Belum ada data pengajuan surat.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-xl p-4">
                        <h2 class="font-semibold mb-3">Status Pengaduan</h2>
                        <div class="space-y-2 text-sm">
                            @forelse($pengaduanByStatus as $status => $total)
                                <div class="flex justify-between"><span>{{ $status }}</span><span>{{ number_format($total) }}</span></div>
                            @empty
                                <p class="text-gray-500">Belum ada data pengaduan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-xl p-4">
                    <h2 class="font-semibold mb-3">Tren 6 Bulan Terakhir</h2>
                    <div class="h-72 mb-4">
                        <canvas id="trenLaporanChart"></canvas>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-3 py-2 text-left">Bulan</th>
                                    <th class="border border-gray-300 px-3 py-2 text-left">Pengajuan Surat</th>
                                    <th class="border border-gray-300 px-3 py-2 text-left">Pengaduan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bulanLabels as $index => $label)
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2">{{ $label }}</td>
                                        <td class="border border-gray-300 px-3 py-2">{{ $suratBulanan[$index] ?? 0 }}</td>
                                        <td class="border border-gray-300 px-3 py-2">{{ $pengaduanBulanan[$index] ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('trenLaporanChart');
            if (!canvas) return;

            const labels = @json($bulanLabels);
            const suratData = @json($suratBulanan);
            const pengaduanData = @json($pengaduanBulanan);

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pengajuan Surat',
                            data: suratData,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37,99,235,0.10)',
                            tension: 0.3,
                            fill: true,
                        },
                        {
                            label: 'Pengaduan',
                            data: pengaduanData,
                            borderColor: '#ea580c',
                            backgroundColor: 'rgba(234,88,12,0.08)',
                            tension: 0.3,
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>



