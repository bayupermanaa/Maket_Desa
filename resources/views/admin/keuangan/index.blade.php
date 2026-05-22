<x-app-layout>
    <x-slot name="title">Keuangan Desa - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR -->
        @include('admin.partials.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800">Keuangan Desa</h1>
                    <p class="text-gray-500">Pengelolaan Anggaran Pendapatan dan Belanja Desa Tahun 2026</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.keuangan.create') }}" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-2xl flex items-center gap-2 font-medium">
                        + Tambah Transaksi Baru
                    </a>
                    <button onclick="window.location.reload()" class="px-6 py-3 border border-gray-300 hover:bg-gray-50 rounded-2xl flex items-center gap-2">
                        ↻ Refresh Data
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- RINGKASAN -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-white rounded-3xl p-6 shadow border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Saldo Kas Desa</p>
                            <p class="text-3xl font-bold text-emerald-600 mt-3">Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-3xl">💰</div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Total Pendapatan</p>
                            <p class="text-3xl font-bold text-blue-600 mt-3">Rp {{ number_format($total_pendapatan ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl">📥</div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Total Belanja</p>
                            <p class="text-3xl font-bold text-orange-600 mt-3">Rp {{ number_format($total_belanja ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-3xl">📤</div>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-6 shadow border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Saldo Akhir</p>
                            <p class="text-3xl font-bold {{ ($saldo ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-3">
                                Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-3xl">📊</div>
                    </div>
                </div>
            </div>

            <!-- TABEL RINGKASAN PER BULAN -->
<div class="bg-white rounded-3xl shadow p-8 mb-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-semibold text-lg">Ringkasan Pendapatan vs Belanja per Bulan Tahun 2026</h3>
        <span class="text-sm text-gray-500">Data per Bulan</span>
    </div>
    
    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-50">
                <th class="border p-4 text-left font-medium">Bulan</th>
                <th class="border p-4 text-right font-medium">Pendapatan</th>
                <th class="border p-4 text-right font-medium">Belanja</th>
                <th class="border p-4 text-right font-medium">Saldo Bulanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulanLabels as $index => $bulan)
            @php
                $pend = $pendapatanPerBulan[$index] ?? 0;
                $bel = $belanjaPerBulan[$index] ?? 0;
                $saldoBulan = $pend - $bel;
            @endphp
            <tr class="border-b hover:bg-gray-50">
                <td class="border p-4 font-medium">{{ $bulan }}</td>
                <td class="border p-4 text-right text-blue-600">
                    Rp {{ number_format($pend, 0, ',', '.') }}
                </td>
                <td class="border p-4 text-right text-orange-600">
                    Rp {{ number_format($bel, 0, ',', '.') }}
                </td>
                <td class="border p-4 text-right {{ $saldoBulan >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    Rp {{ number_format($saldoBulan, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

            <!-- TABEL -->
            <div class="bg-white rounded-3xl shadow overflow-hidden">
                <div class="px-8 py-5 border-b flex justify-between items-center">
                    <h3 class="font-semibold text-lg">Riwayat Transaksi Keuangan</h3>
                    <span class="text-sm text-gray-500">Total {{ $keuangans->count() ?? 0 }} transaksi</span>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-8 py-4 text-left">Tanggal</th>
                            <th class="px-8 py-4 text-left">Jenis</th>
                            <th class="px-8 py-4 text-left">Uraian</th>
                            <th class="px-8 py-4 text-left">Keterangan</th>
                            <th class="px-8 py-4 text-right">Jumlah</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @forelse($keuangans ?? [] as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-8 py-5">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="px-8 py-5">
                                <span class="{{ $item->jenis == 'pendapatan' ? 'text-green-600 font-medium' : 'text-red-600 font-medium' }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 font-medium">{{ $item->uraian }}</td>
                            <td class="px-8 py-5 text-gray-600">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-8 py-5 text-right font-semibold">
                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 text-center space-x-4">
                                <a href="{{ route('admin.keuangan.edit', $item) }}" class="text-blue-600 hover:text-blue-700">✏️</a>
                                <form action="{{ route('admin.keuangan.destroy', $item) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-20 text-gray-500">
                                Belum ada data transaksi keuangan<br>
                                <span class="text-sm mt-1 block">Klik tombol Tambah Transaksi Baru untuk memulai</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td colspan="4" class="px-8 py-4 text-right">Total Keseluruhan</td>
                            <td class="px-8 py-4 text-right text-emerald-600">
                                Rp {{ number_format(($total_pendapatan ?? 0) - ($total_belanja ?? 0), 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>
    </div>

</x-app-layout>
