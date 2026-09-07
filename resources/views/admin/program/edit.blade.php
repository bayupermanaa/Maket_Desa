<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Edit Program Desa</h1>
            <a href="{{ route('admin.program.index') }}" class="px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50">Kembali</a>
        </div>

        <form method="POST" action="{{ route('admin.program.update', $program) }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow p-8 space-y-5">
            @csrf
            @method('PUT')
            @include('admin.program.partials.form', ['program' => $program])
        </form>
    </div>
</x-app-layout>
