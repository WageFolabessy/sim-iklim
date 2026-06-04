@extends('layouts.guest')

@section('title', 'Data Iklim')
@section('description', 'Data suhu, kelembapan, dan curah hujan dari stasiun BMKG Kalimantan Barat.')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

    {{-- Page header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Data Iklim</h1>
        <p class="text-gray-500 mt-2 text-sm">
            Rekaman suhu, kelembapan, dan curah hujan terverifikasi oleh petugas BMKG Stasiun Klimatologi Kalimantan Barat.
        </p>
    </div>

    {{-- Statistical Projection Section --}}
    @if ($stats && $stats->avg_temperature !== null)
    <section aria-labelledby="stats-heading">
        <div class="mb-4 flex items-center gap-3">
            <div class="bg-sky-100 rounded-lg p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
            </div>
            <div>
                <h2 id="stats-heading" class="font-semibold text-gray-900">
                    Proyeksi Statistik Bulan {{ now()->translatedFormat('F Y') }}
                </h2>
                <p class="text-xs text-gray-400">Berdasarkan data historis 5 tahun terakhir pada bulan yang sama</p>
            </div>
        </div>

        <div class="grid sm:grid-cols-3 gap-5">

            {{-- Suhu card --}}
            <article class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-orange-100 text-orange-600 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2.25m-4.5 2.625a4.5 4.5 0 1 0 9 0V9A4.5 4.5 0 0 0 7.5 13.875Z" />
                        </svg>
                    </span>
                    <h3 class="text-sm font-semibold text-gray-700">Suhu Udara</h3>
                </div>
                <p class="text-4xl font-bold text-gray-900 tracking-tight">
                    {{ number_format($stats->avg_temperature, 1) }}
                    <span class="text-lg font-normal text-gray-500">°C</span>
                </p>
                <p class="text-xs text-sky-600 font-medium mt-1 mb-4">Rata-rata historis</p>

                <dl class="grid grid-cols-3 gap-2 text-center border-t border-gray-100 pt-4">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Min</dt>
                        <dd class="text-sm font-semibold text-blue-600">{{ number_format($stats->min_temperature, 1) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Maks</dt>
                        <dd class="text-sm font-semibold text-red-500">{{ number_format($stats->max_temperature, 1) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">±&nbsp;Simpangan</dt>
                        <dd class="text-sm font-semibold text-gray-600">{{ number_format($stats->stddev_temperature, 2) }}</dd>
                    </div>
                </dl>
            </article>

            {{-- Kelembapan card --}}
            <article class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-sky-100 text-sky-600 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.2 5.4-6 8.4-6 12a6 6 0 0 0 12 0c0-3.6-4.8-6.6-6-12Z" />
                        </svg>
                    </span>
                    <h3 class="text-sm font-semibold text-gray-700">Kelembapan</h3>
                </div>
                <p class="text-4xl font-bold text-gray-900 tracking-tight">
                    {{ number_format($stats->avg_humidity, 1) }}
                    <span class="text-lg font-normal text-gray-500">%</span>
                </p>
                <p class="text-xs text-sky-600 font-medium mt-1 mb-4">Rata-rata historis</p>

                <dl class="grid grid-cols-3 gap-2 text-center border-t border-gray-100 pt-4">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Min</dt>
                        <dd class="text-sm font-semibold text-blue-600">{{ number_format($stats->min_humidity, 1) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Maks</dt>
                        <dd class="text-sm font-semibold text-red-500">{{ number_format($stats->max_humidity, 1) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">±&nbsp;Simpangan</dt>
                        <dd class="text-sm font-semibold text-gray-600">{{ number_format($stats->stddev_humidity, 2) }}</dd>
                    </div>
                </dl>
            </article>

            {{-- Curah Hujan card --}}
            <article class="bg-white rounded-2xl border border-sky-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-blue-100 text-blue-600 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                        </svg>
                    </span>
                    <h3 class="text-sm font-semibold text-gray-700">Curah Hujan</h3>
                </div>
                <p class="text-4xl font-bold text-gray-900 tracking-tight">
                    {{ number_format($stats->avg_rainfall, 1) }}
                    <span class="text-lg font-normal text-gray-500">mm</span>
                </p>
                <p class="text-xs text-sky-600 font-medium mt-1 mb-4">Rata-rata historis</p>

                <dl class="grid grid-cols-3 gap-2 text-center border-t border-gray-100 pt-4">
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Min</dt>
                        <dd class="text-sm font-semibold text-blue-600">{{ number_format($stats->min_rainfall, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">Maks</dt>
                        <dd class="text-sm font-semibold text-red-500">{{ number_format($stats->max_rainfall, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 mb-0.5">±&nbsp;Simpangan</dt>
                        <dd class="text-sm font-semibold text-gray-600">{{ number_format($stats->stddev_rainfall, 2) }}</dd>
                    </div>
                </dl>
            </article>

        </div>
    </section>
    @endif

    {{-- Table card --}}
    <section aria-labelledby="records-heading">
        <div class="bg-white rounded-2xl shadow-md border border-gray-100">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 id="records-heading" class="font-semibold text-gray-800">Rekaman Data Iklim</h2>
                <span class="text-xs text-gray-400">{{ $records->total() }} data ditemukan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-right">Suhu (°C)</th>
                            <th class="px-6 py-3 text-right">Kelembapan (%)</th>
                            <th class="px-6 py-3 text-right">Curah Hujan (mm)</th>
                            <th class="px-6 py-3">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($records as $record)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                    {{ $record->recorded_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-gray-900 whitespace-nowrap">
                                    {{ number_format($record->temperature, 1) }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-700 whitespace-nowrap">
                                    {{ $record->humidity }}
                                </td>
                                <td class="px-6 py-4 text-right text-gray-700 whitespace-nowrap">
                                    {{ number_format($record->rainfall, 2) }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                    {{ $record->user->name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada data iklim yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($records->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </section>

</section>
@endsection
