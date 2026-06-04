@extends('layouts.guest')

@section('title', 'Data Iklim')
@section('description', 'Data suhu, kelembapan, dan curah hujan dari stasiun BMKG Kalimantan Barat.')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Data Iklim</h1>
        <p class="text-gray-500 mt-2 text-sm">
            Rekaman suhu, kelembapan, dan curah hujan terverifikasi oleh petugas BMKG Stasiun Klimatologi Kalimantan Barat.
        </p>
    </div>

    {{-- Table card --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100">

        {{-- Card header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">Rekaman Data Iklim</h2>
            <span class="text-xs text-gray-400">
                {{ $records->total() }} data ditemukan
            </span>
        </div>

        {{-- Responsive table wrapper --}}
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

        {{-- Pagination --}}
        @if ($records->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $records->links() }}
            </div>
        @endif
    </div>

</section>
@endsection
