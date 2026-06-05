@extends('layouts.app')

@section('title', 'Input Data Iklim')
@section('page-title', 'Input Data Iklim')

@section('content')
<div class="space-y-8">

    {{-- Page header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Data Iklim Harian</h1>
        <p class="text-gray-500 text-sm mt-1">Input dan riwayat data iklim yang Anda catat.</p>
    </div>

    {{-- Input card --}}
    <section aria-labelledby="input-heading">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 id="input-heading" class="font-semibold text-gray-800">Input Data Iklim Harian</h2>
                <p class="text-xs text-gray-400 mt-0.5">Isi semua kolom sesuai hasil pengamatan.</p>
            </div>

            <form method="POST" action="{{ route('pengamat.climate-records.store') }}" class="p-6" novalidate>
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">

                    {{-- Tanggal --}}
                    <div>
                        <label for="recorded_at" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Tanggal Pengamatan <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="recorded_at"
                            name="recorded_at"
                            value="{{ old('recorded_at', date('Y-m-d')) }}"
                            required
                            max="{{ date('Y-m-d') }}"
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                                'border-red-400 bg-red-50' => $errors->has('recorded_at'),
                                'border-gray-300' => !$errors->has('recorded_at'),
                            ])
                        >
                        @error('recorded_at')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Suhu --}}
                    <div>
                        <label for="temperature" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Suhu (°C) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="temperature"
                            name="temperature"
                            value="{{ old('temperature') }}"
                            step="0.01"
                            min="-10"
                            max="60"
                            required
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                                'border-red-400 bg-red-50' => $errors->has('temperature'),
                                'border-gray-300' => !$errors->has('temperature'),
                            ])
                            placeholder="mis. 28.50"
                        >
                        @error('temperature')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kelembapan --}}
                    <div>
                        <label for="humidity" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Kelembapan (%) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="humidity"
                            name="humidity"
                            value="{{ old('humidity') }}"
                            min="0"
                            max="100"
                            required
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                                'border-red-400 bg-red-50' => $errors->has('humidity'),
                                'border-gray-300' => !$errors->has('humidity'),
                            ])
                            placeholder="mis. 85"
                        >
                        @error('humidity')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Curah hujan --}}
                    <div>
                        <label for="rainfall" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Curah Hujan (mm) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="rainfall"
                            name="rainfall"
                            value="{{ old('rainfall') }}"
                            step="0.01"
                            min="0"
                            required
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                                'border-red-400 bg-red-50' => $errors->has('rainfall'),
                                'border-gray-300' => !$errors->has('rainfall'),
                            ])
                            placeholder="mis. 12.50"
                        >
                        @error('rainfall')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kecepatan Angin --}}
                    <div>
                        <label for="wind_speed" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Kecepatan Angin (km/j) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="wind_speed"
                            name="wind_speed"
                            value="{{ old('wind_speed') }}"
                            step="0.1"
                            min="0"
                            required
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                                'border-red-400 bg-red-50' => $errors->has('wind_speed'),
                                'border-gray-300' => !$errors->has('wind_speed'),
                            ])
                            placeholder="mis. 15.5"
                        >
                        @error('wind_speed')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="submit"
                        class="bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold px-8 py-2.5 rounded-xl shadow-sm transition-colors cursor-pointer"
                    >
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- History card --}}
    <section aria-labelledby="history-heading">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 id="history-heading" class="font-semibold text-gray-800">Riwayat Input Anda</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-right">Suhu (°C)</th>
                            <th class="px-6 py-3 text-right">Kelembapan (%)</th>
                            <th class="px-6 py-3 text-right">Curah Hujan (mm)</th>
                            <th class="px-6 py-3 text-right">Angin (km/j)</th>
                            <th class="px-6 py-3">Dicatat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($records as $record)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
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
                                <td class="px-6 py-4 text-right text-gray-700 whitespace-nowrap">
                                    {{ number_format($record->wind_speed, 1) }}
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                                    {{ $record->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada data yang Anda inputkan.
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

</div>
@endsection
