@extends('layouts.guest')

@section('title', 'Anda Sedang Offline')

@section('content')
<section class="flex-grow flex items-center justify-center min-h-[70vh] px-4">
    <div class="text-center max-w-md mx-auto">
        {{-- Wifi-slash icon --}}
        <div class="flex justify-center mb-6">
            <div class="bg-sky-50 rounded-full p-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M8.288 8.288A7.501 7.501 0 0 1 12 7.5c1.81 0 3.465.67 4.742 1.773M6.228 6.228A10.451 10.451 0 0 0 1.5 12c0 2.4.81 4.61 2.17 6.364M17.772 17.772A10.45 10.45 0 0 0 22.5 12c0-2.4-.81-4.61-2.17-6.364M10.5 10.5a3 3 0 0 0-1.184 5.768M12 12v.01" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-3">Anda Sedang Offline</h1>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Tidak dapat terhubung ke internet. Periksa koneksi jaringan Anda, lalu coba lagi.
        </p>

        <button
            onclick="window.location.reload()"
            class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white font-medium px-6 py-3 rounded-xl shadow-sm transition-colors cursor-pointer"
            aria-label="Muat ulang halaman"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            Coba Lagi
        </button>
    </div>
</section>
@endsection
