<x-app-layout>
    <x-slot name="title">Tambah Transaksi Keuangan - Desa Maket</x-slot>

    <div class="min-h-screen bg-gray-100 flex">

        <!-- SIDEBAR -->
        @include('admin.partials.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-10">
            <div class="max-w-2xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-semibold text-gray-800">Tambah Transaksi Baru</h1>
                        <p class="text-gray-500">Masukkan data pendapatan atau belanja desa</p>
                    </div>
                    <a href="{{ route('admin.keuangan') }}" class="px-5 py-2 border border-gray-300 rounded-xl hover:bg-gray-50">← Kembali</a>
                </div>

                <!-- ERROR MESSAGE LARAVEL -->
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border border-red-400 text-red-700 px-6 py-5 rounded-2xl">
                        <h4 class="font-semibold mb-3">❌ Ada kesalahan:</h4>
                        <ul class="list-disc pl-6 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.keuangan.store') }}" method="POST" class="bg-white rounded-3xl shadow p-8">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi <span class="text-red-500">*</span></label>
                            <select name="jenis" required class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-orange-500">
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="pendapatan" {{ old('jenis') == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                                <option value="belanja" {{ old('jenis') == 'belanja' ? 'selected' : '' }}>Belanja</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-orange-500">
                            @error('tanggal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Uraian / Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="uraian" value="{{ old('uraian') }}" required
                               class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-orange-500"
                               placeholder="Contoh: Bantuan Alat Tani dari Provinsi">
                        @error('uraian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="1"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-orange-500">
                        @error('jumlah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="4" class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:outline-none focus:border-orange-500">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="submit" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-4 rounded-2xl font-medium transition">
                            💾 Simpan Transaksi
                        </button>
                        <a href="{{ route('admin.keuangan') }}" class="flex-1 border border-gray-300 hover:bg-gray-50 py-4 rounded-2xl text-center font-medium">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
