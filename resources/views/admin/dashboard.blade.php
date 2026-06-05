@extends('layouts.app')

@section('title', 'Pusat Komando Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    {{-- Page header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pusat Komando Admin</h1>
        <p class="text-gray-500 text-sm mt-1">Ringkasan data sistem dan aktivitas.</p>
    </div>

    {{-- Quick stat cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center">
            <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Peringatan Aktif</span>
            <span class="mt-2 text-4xl font-bold text-red-600">{{ $activeAlerts }}</span>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center">
            <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Laporan Warga</span>
            <span class="mt-2 text-4xl font-bold text-blue-600">{{ $citizenReports }}</span>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center">
            <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Data Iklim</span>
            <span class="mt-2 text-4xl font-bold text-green-600">{{ $climateRecords }}</span>
        </div>
    </div>

    {{-- Data Pengamat Menunggu Validasi --}}
    <section>
        <h2 class="text-lg font-bold text-gray-900 mb-4">Data Pengamat Menunggu Validasi</h2>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">Waktu Rekam</th>
                            <th scope="col" class="px-6 py-4">Pengamat</th>
                            <th scope="col" class="px-6 py-4">Suhu (°C)</th>
                            <th scope="col" class="px-6 py-4">Kelembapan (%)</th>
                            <th scope="col" class="px-6 py-4">Hujan (mm)</th>
                            <th scope="col" class="px-6 py-4">Angin (km/j)</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRecords as $record)
                        <tr class="bg-white border-b border-gray-50 hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $record->recorded_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $record->user->name ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">{{ $record->temperature }}</td>
                            <td class="px-6 py-4">{{ $record->humidity }}</td>
                            <td class="px-6 py-4">{{ $record->rainfall }}</td>
                            <td class="px-6 py-4">{{ $record->wind_speed }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.climate-records.approve', $record->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><polyline points="20 6 9 17 4 12"/></svg>
                                        Validasi & Publikasikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data yang menunggu validasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $pendingRecords->links() }}
        </div>
    </section>
</div>
@endsection
