@php
    $settings = null;
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('settings_desa')) {
            $settings = \App\Models\SettingsDesa::query()->first();
        }
    } catch (\Throwable $e) {
        $settings = null;
    }
    $aktif = (bool) ($settings?->popup_aktif ?? false);
    $judul = (string) ($settings?->popup_judul ?? '');
    $isi = (string) ($settings?->popup_isi ?? '');
@endphp

@if(request()->routeIs('dashboard') && $aktif && (trim($judul) !== '' || trim($isi) !== ''))
    <div
        x-data="{ open: true }"
        x-cloak
        x-on:keydown.escape.window="open = false"
        x-init="
            document.body.classList.add('overflow-hidden');
            $watch('open', value => {
                if (!value) {
                    document.body.classList.remove('overflow-hidden');
                    window.dispatchEvent(new CustomEvent('popup-kebijakan:closed'));
                }
            });
        "
        data-popup-kebijakan
    >
        <template x-teleport="body">
            <div
                x-show="open"
                class="fixed inset-0 z-[2147483647] flex items-center justify-center p-4 sm:p-6"
                role="dialog"
                aria-modal="true"
                aria-labelledby="popup-kebijakan-title"
            >
                <div
                    class="absolute inset-0 bg-black/60"
                    x-show="open"
                    x-transition.opacity.duration.200ms
                    x-on:click="open = false"
                ></div>

                <div
                    class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden"
                    x-show="open"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                    x-on:click.stop
                >
                    <div class="px-6 py-5 sm:px-8 border-b flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h2 id="popup-kebijakan-title" class="text-lg sm:text-xl font-bold text-gray-900 truncate">
                                {{ trim($judul) !== '' ? $judul : 'Informasi' }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">Ditampilkan otomatis saat membuka dashboard.</p>
                        </div>

                        <button
                            type="button"
                            class="shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700"
                            aria-label="Tutup popup"
                            x-on:click="open = false"
                        >
                            ?
                        </button>
                    </div>

                    <div class="px-6 py-6 sm:px-8 sm:py-7">
                        <div class="max-h-[65vh] overflow-auto pr-1">
                            <div class="prose prose-gray max-w-none">
                                @if(trim($isi) !== '')
                                    {!! nl2br(e($isi)) !!}
                                @else
                                    <p class="text-gray-600">Konten popup belum diisi.</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button
                                type="button"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold"
                                x-on:click="open = false"
                            >
                                Saya Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endif
