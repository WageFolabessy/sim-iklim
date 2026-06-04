@extends('layouts.guest')

@section('title', 'Beranda')
@section('description', 'Informasi iklim terkini dan laporan cuaca dari warga Kalimantan Barat.')

@section('content')

{{-- Hero Section --}}
<div class="min-h-[calc(100vh-4rem)] flex flex-col">
    <section class="flex-1 flex flex-col justify-center pb-12 md:pb-16 bg-linear-to-br from-sky-700 via-sky-600 to-cyan-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-3xl">
            <span class="inline-block bg-white/20 text-white text-xs font-semibold uppercase tracking-widest px-3 py-1 rounded-full mb-5">
                BMKG Stasiun Klimatologi Kalimantan Barat
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-5">
                Sistem Informasi<br>Monitoring Iklim<br>
                <span class="text-cyan-200">Kalimantan Barat</span>
            </h1>
            <p class="text-sky-100 text-lg leading-relaxed mb-8 max-w-2xl">
                Pantau data suhu, kelembapan, dan curah hujan terkini dari stasiun BMKG.
                Laporkan anomali cuaca di sekitar Anda untuk membantu pemantauan iklim regional.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('climate-data') }}"
                    class="w-full sm:w-auto text-center bg-white text-sky-700 font-semibold px-6 py-3 rounded-xl shadow-sm hover:bg-sky-50 transition-colors">
                    Lihat Data Iklim
                </a>
                <a href="#lapor"
                    class="w-full sm:w-auto text-center bg-white/20 hover:bg-white/30 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                    Laporkan Cuaca
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Stats strip --}}
<section class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-y-8 gap-x-4 p-6 sm:p-8">
        <div class="flex flex-col items-center text-center">
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-sky-700">24/7</h3>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">Pemantauan Real-time</p>
        </div>
        <div class="flex flex-col items-center text-center">
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-sky-700">Akurat</h3>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">Data Terverifikasi BMKG</p>
        </div>
        <div class="flex flex-col items-center text-center">
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-sky-700">Gratis</h3>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">Akses Publik Terbuka</p>
        </div>
        <div class="flex flex-col items-center text-center">
            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-sky-700">Aplikasi Praktis</h3>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">Simpan di layar utama HP Anda untuk akses cepat.</p>
        </div>
    </div>
</section>
</div>

{{-- Citizen Report Form --}}
<section id="lapor" class="bg-gray-50 py-16 scroll-mt-24">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900">Laporkan Anomali Cuaca</h2>
            <p class="text-gray-500 mt-2 text-sm">
                Bantu BMKG memantau kondisi cuaca dengan melaporkan kejadian di sekitar Anda.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
            <form method="POST" action="{{ route('citizen-reports.store') }}" novalidate>
                @csrf

                {{-- Reporter name (optional) --}}
                <div class="mb-5">
                    <label for="reporter_name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Pelapor <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input
                        type="text"
                        id="reporter_name"
                        name="reporter_name"
                        value="{{ old('reporter_name') }}"
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                            'border-red-400 bg-red-50' => $errors->has('reporter_name'),
                            'border-gray-300' => !$errors->has('reporter_name'),
                        ])
                        placeholder="Nama Anda (boleh dikosongkan)"
                    >
                    @error('reporter_name')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-5">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Lokasi Kejadian <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        required
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                            'border-red-400 bg-red-50' => $errors->has('location'),
                            'border-gray-300' => !$errors->has('location'),
                        ])
                        placeholder="Contoh: Pontianak Selatan, Jl. Ahmad Yani"
                    >
                    @error('location')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Anomaly type --}}
                <div class="mb-5">
                    <label for="anomaly_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Jenis Anomali <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="anomaly_type"
                        name="anomaly_type"
                        required
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500',
                            'border-red-400 bg-red-50' => $errors->has('anomaly_type'),
                            'border-gray-300 bg-white' => !$errors->has('anomaly_type'),
                        ])
                    >
                        <option value="" disabled {{ old('anomaly_type') ? '' : 'selected' }}>-- Pilih jenis anomali --</option>
                        <option value="flood" {{ old('anomaly_type') === 'flood' ? 'selected' : '' }}>Banjir</option>
                        <option value="drought" {{ old('anomaly_type') === 'drought' ? 'selected' : '' }}>Kekeringan</option>
                        <option value="strong_wind" {{ old('anomaly_type') === 'strong_wind' ? 'selected' : '' }}>Angin Kencang</option>
                        <option value="other" {{ old('anomaly_type') === 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('anomaly_type')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-7">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Deskripsi Kejadian <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        required
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none',
                            'border-red-400 bg-red-50' => $errors->has('description'),
                            'border-gray-300' => !$errors->has('description'),
                        ])
                        placeholder="Ceritakan kondisi cuaca yang Anda alami secara singkat..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold py-3 rounded-xl shadow-sm transition-colors cursor-pointer"
                >
                    Kirim Laporan
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
