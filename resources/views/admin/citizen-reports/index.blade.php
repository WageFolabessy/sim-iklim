@extends('layouts.app')

@section('title', 'Moderasi Laporan Warga')
@section('page-title', 'Moderasi & Peringatan')

@section('content')
<div class="space-y-8">

    {{-- Page header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Panel Admin</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola laporan warga dan siaran peringatan cuaca ekstrem.</p>
    </div>

    {{-- Weather alert trigger card --}}
    <section aria-labelledby="alert-heading">
        <div class="bg-white rounded-2xl shadow-sm border border-orange-100 ring-1 ring-orange-200">
            <div class="px-6 py-5 border-b border-orange-100 flex items-center gap-3">
                <div class="bg-orange-100 rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div>
                    <h2 id="alert-heading" class="font-semibold text-gray-900">Trigger Peringatan Dini Cuaca Ekstrem</h2>
                    <p class="text-xs text-orange-600 mt-0.5">Pesan peringatan akan muncul secara instan di layar seluruh warga yang sedang mengakses portal.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mx-6 mt-6 mb-2 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mx-6 mt-6 mb-2 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.weather-alerts.trigger') }}" class="p-6" novalidate>
                @csrf

                <div class="mb-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Judul Peringatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400',
                            'border-red-400 bg-red-50' => $errors->has('title'),
                            'border-gray-300' => !$errors->has('title'),
                        ])
                        placeholder="Contoh: Peringatan Dini Cuaca Ekstrem Kalbar"
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Level Bahaya <span class="text-red-500">*</span>
                        </label>
                        <select id="level" name="level" required
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400',
                                'border-red-400 bg-red-50' => $errors->has('level'),
                                'border-gray-300' => !$errors->has('level'),
                            ])
                        >
                            <option value="">Pilih Level...</option>
                            <option value="waspada" {{ old('level') == 'waspada' ? 'selected' : '' }}>Waspada (Kuning)</option>
                            <option value="siaga" {{ old('level') == 'siaga' ? 'selected' : '' }}>Siaga (Oranye)</option>
                            <option value="awas" {{ old('level') == 'awas' ? 'selected' : '' }}>Awas (Merah)</option>
                        </select>
                        @error('level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Cakupan Area <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="area" name="area" value="{{ old('area') }}" required
                            @class([
                                'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400',
                                'border-red-400 bg-red-50' => $errors->has('area'),
                                'border-gray-300' => !$errors->has('area'),
                            ])
                            placeholder="Contoh: Pontianak, Kubu Raya"
                        >
                        @error('area')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Pesan Peringatan <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="body"
                        name="body"
                        rows="3"
                        required
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none',
                            'border-red-400 bg-red-50' => $errors->has('body'),
                            'border-gray-300' => !$errors->has('body'),
                        ])
                        placeholder="Contoh: Peringatan cuaca ekstrem — Waspada hujan lebat dan angin kencang dalam 6 jam ke depan."
                    >{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 active:bg-orange-800 text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm transition-colors cursor-pointer"
                        onclick="return confirm('Siaran peringatan akan dikirim ke semua pengguna. Lanjutkan?')"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-5.395a23.962 23.962 0 0 0-1.014-5.395" />
                        </svg>
                        Siarkan Peringatan
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Citizen reports moderation card --}}
    <section aria-labelledby="reports-heading">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h2 id="reports-heading" class="font-semibold text-gray-800">Moderasi Laporan Warga</h2>
                <span class="text-xs text-gray-400">{{ $reports->total() }} laporan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Pelapor</th>
                            <th class="px-6 py-3">Lokasi</th>
                            <th class="px-6 py-3">Jenis Anomali</th>
                            <th class="px-6 py-3">Dikirim</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $report->reporter_name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 max-w-[180px] truncate">
                                    {{ $report->location }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $anomalyLabels = [
                                            'flood'      => ['label' => 'Banjir',        'class' => 'bg-blue-50 text-blue-700'],
                                            'drought'    => ['label' => 'Kekeringan',     'class' => 'bg-yellow-50 text-yellow-700'],
                                            'strong_wind'=> ['label' => 'Angin Kencang',  'class' => 'bg-purple-50 text-purple-700'],
                                            'other'      => ['label' => 'Lainnya',        'class' => 'bg-gray-100 text-gray-600'],
                                        ];
                                        $anomaly = $anomalyLabels[$report->anomaly_type->value] ?? ['label' => $report->anomaly_type->value, 'class' => 'bg-gray-100 text-gray-600'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $anomaly['class'] }}">
                                        {{ $anomaly['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                                    {{ $report->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'pending'   => 'bg-yellow-50 text-yellow-700',
                                            'published' => 'bg-green-50 text-green-700',
                                            'rejected'  => 'bg-red-50 text-red-700',
                                        ];
                                        $statusLabel = [
                                            'pending'   => 'Menunggu',
                                            'published' => 'Diterbitkan',
                                            'rejected'  => 'Ditolak',
                                        ];
                                        $cfg = $statusConfig[$report->status->value] ?? 'bg-gray-100 text-gray-600';
                                        $lbl = $statusLabel[$report->status->value] ?? $report->status->value;
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cfg }}">
                                        {{ $lbl }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="{{ route('admin.citizen-reports.update-status', $report) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select
                                            name="status"
                                            aria-label="Ubah status laporan {{ $report->id }}"
                                            onchange="this.form.submit()"
                                            class="rounded-lg border border-gray-300 text-xs px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer"
                                        >
                                            <option value="pending"   {{ $report->status->value === 'pending'   ? 'selected' : '' }}>Menunggu</option>
                                            <option value="published" {{ $report->status->value === 'published' ? 'selected' : '' }}>Terbitkan</option>
                                            <option value="rejected"  {{ $report->status->value === 'rejected'  ? 'selected' : '' }}>Tolak</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada laporan dari warga.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reports->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </section>

</div>
@endsection
