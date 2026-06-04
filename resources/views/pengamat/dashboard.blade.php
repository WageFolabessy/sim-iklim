@extends('layouts.app')

@section('title', 'Dasbor Pengamat')
@section('page-title', 'Dasbor')

@section('content')
<div class="space-y-8">

    {{-- Welcome banner --}}
    <section class="relative overflow-hidden bg-linear-to-br from-sky-600 to-cyan-600 rounded-2xl p-8 text-white shadow-md">
        {{-- Decorative blobs --}}
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute -bottom-12 -left-6 w-40 h-40 bg-white/5 rounded-full blur-xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative">
            <p class="text-sky-100 text-sm font-medium mb-1">BMKG Stasiun Klimatologi Kalimantan Barat</p>
            <h1 class="text-2xl md:text-3xl font-bold leading-tight mb-2">
                Selamat Datang,<br>{{ auth()->user()->name }}
            </h1>
            <p class="text-sky-100 text-sm max-w-md">
                Gunakan panel ini untuk mencatat dan memantau data iklim harian Anda.
                Data yang Anda input akan tersedia secara publik dan real-time.
            </p>
        </div>
    </section>

    {{-- Quick stats strip --}}
    <section aria-labelledby="quick-stats" class="grid sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Hari Ini</p>
            <p class="text-2xl font-bold text-gray-900">{{ now()->translatedFormat('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-900">{{ now()->translatedFormat('F Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Peran</p>
            <p class="text-2xl font-bold text-sky-600 capitalize">{{ auth()->user()->role->value }}</p>
        </div>
    </section>

    {{-- CTA card --}}
    <section aria-labelledby="cta-heading">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex flex-col md:flex-row items-center gap-6 p-8">

                {{-- Icon --}}
                <div class="shrink-0 flex items-center justify-center bg-sky-50 rounded-2xl w-20 h-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                {{-- Text --}}
                <div class="flex-1 text-center md:text-left">
                    <h2 id="cta-heading" class="text-xl font-bold text-gray-900 mb-1">
                        Input Data Iklim Hari Ini
                    </h2>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Catat suhu, kelembapan, dan curah hujan hasil pengamatan hari ini.
                        Data akan langsung tersedia di portal publik.
                    </p>
                </div>

                {{-- CTA button --}}
                <div class="shrink-0">
                    <a
                        href="{{ route('pengamat.climate-records.index') }}"
                        class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold px-6 py-3 rounded-xl shadow-sm transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Input Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Info strip --}}
    <section class="bg-sky-50 border border-sky-100 rounded-2xl px-6 py-4 flex items-start gap-3 text-sm text-sky-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-sky-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        </svg>
        <p>
            Data yang Anda inputkan akan tersedia secara publik melalui
            <a href="{{ route('climate-data') }}" target="_blank" class="font-semibold underline hover:text-sky-600">Portal Data Iklim</a>
            dan akan diperbarui secara langsung di portal publik.
        </p>
    </section>

</div>
@endsection
