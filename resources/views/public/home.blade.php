@extends('layouts.guest')

@section('title', 'Beranda')
@section('description', 'Informasi iklim terkini dan laporan cuaca dari warga Kalimantan Barat.')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-hero">
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.15) 0, transparent 40%), radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1) 0, transparent 50%)"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:py-20">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_1fr] lg:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium text-white backdrop-blur">
                    <span class="grid h-1.5 w-1.5 place-items-center rounded-full bg-success"></span>
                    Sistem aktif · Diperbarui {{ date('H:i') }}
                </div>
                <h1 class="mt-5 font-display text-4xl font-bold leading-[1.05] text-white text-balance sm:text-5xl lg:text-6xl">
                    Iklim Kalimantan Barat,<br />dalam genggaman warga.
                </h1>
                <p class="mt-5 max-w-xl text-base text-white/85 sm:text-lg">
                    Data resmi PMG untuk petani, nelayan, dan masyarakat. Pantau cuaca terkini, dapatkan peringatan dini, dan laporkan kondisi di sekitarmu.
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#lapor" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-primary shadow-glow transition hover:bg-white/95">
                        Kirim Laporan Cuaca
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('climate-data') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/30 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        Lihat Data Iklim
                    </a>
                </div>
                <div class="mt-8 flex flex-wrap gap-x-6 gap-y-2 text-xs text-white/75">
                    <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M5 13a10 10 0 0 1 14 0"/><path d="M8.5 16.5a5 5 0 0 1 7 0"/><path d="M2 8.82a15 15 0 0 1 20 0"/><line x1="12" x2="12.01" y1="20" y2="20"/></svg> Bisa diakses offline</span>
                    <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg> Push notification</span>
                    <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Install ke layar utama</span>
                </div>
            </div>

            {{-- Current climate card --}}
            <div class="rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur-md shadow-glow">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs uppercase tracking-wider text-white/70">Kondisi Saat Ini</div>
                        <div class="mt-1 text-lg font-semibold text-white">
                            {{ $latestRecord ? 'Kalimantan Barat' : 'Belum ada data' }}
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 animate-pulse text-success"><circle cx="12" cy="12" r="2"/><path d="M4.93 19.07a10 10 0 0 1 0-14.14"/><path d="M7.76 16.24a6 6 0 0 1 0-8.48"/><path d="M16.24 7.76a6 6 0 0 1 0 8.48"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-3">
                    <div class="font-display text-7xl font-bold text-white">{{ isset($latestRecord) ? number_format($latestRecord->temperature, 1) : '--' }}°</div>
                    <div class="pb-2 text-sm text-white/80">Suhu Udara</div>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-2.5">
                    <div class="rounded-xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <div class="flex items-center gap-2 text-xs font-medium text-white/80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 22a5 5 0 0 0 5-5c0-2-5-10-5-10S7 15 7 17a5 5 0 0 0 5 5Z"/></svg> Kelembapan
                        </div>
                        <div class="mt-2 flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-white">{{ $latestRecord->humidity ?? '--' }}</span>
                            <span class="text-sm text-white/70">%</span>
                        </div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <div class="flex items-center gap-2 text-xs font-medium text-white/80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M16 14v6"/><path d="M8 14v6"/><path d="M12 16v6"/></svg> Curah Hujan
                        </div>
                        <div class="mt-2 flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-white">{{ isset($latestRecord) ? number_format($latestRecord->rainfall, 1) : '--' }}</span>
                            <span class="text-sm text-white/70">mm</span>
                        </div>
                        <div class="mt-1 text-[11px] text-white/60">24 jam terakhir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAPORKAN CUACA --}}
<section id="lapor" class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
    <div class="mb-8 text-center sm:text-left text-foreground">
        <h2 class="font-display text-2xl font-bold sm:text-3xl">Lapor Cuaca Warga</h2>
        <p class="mt-2 text-sm text-muted-foreground">
            Laporan Anda sangat berarti bagi warga Kalimantan Barat.
        </p>
    </div>

    <form method="POST" action="{{ route('citizen-reports.store') }}" novalidate class="rounded-2xl border border-border bg-card p-6 shadow-card sm:p-8">
        @csrf

        {{-- Anomaly Type (Radio Cards) --}}
        <div>
            <label class="text-sm font-semibold text-foreground">Jenis anomali cuaca <span class="text-destructive">*</span></label>
            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-4">
                {{-- Banjir --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="anomaly_type" value="flood" class="peer sr-only" {{ old('anomaly_type') === 'flood' ? 'checked' : '' }} required>
                    <div class="flex flex-col items-center gap-2 rounded-xl border border-border bg-background p-4 text-xs font-semibold text-muted-foreground transition peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:shadow-glow hover:border-primary/40 hover:text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/></svg>
                        Banjir
                    </div>
                </label>
                {{-- Kekeringan --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="anomaly_type" value="drought" class="peer sr-only" {{ old('anomaly_type') === 'drought' ? 'checked' : '' }}>
                    <div class="flex flex-col items-center gap-2 rounded-xl border border-border bg-background p-4 text-xs font-semibold text-muted-foreground transition peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:shadow-glow hover:border-primary/40 hover:text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                        Kekeringan
                    </div>
                </label>
                {{-- Angin Kencang --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="anomaly_type" value="strong_wind" class="peer sr-only" {{ old('anomaly_type') === 'strong_wind' ? 'checked' : '' }}>
                    <div class="flex flex-col items-center gap-2 rounded-xl border border-border bg-background p-4 text-xs font-semibold text-muted-foreground transition peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:shadow-glow hover:border-primary/40 hover:text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg>
                        Angin Kencang
                    </div>
                </label>
                {{-- Hujan Lebat (other) --}}
                <label class="cursor-pointer relative">
                    <input type="radio" name="anomaly_type" value="other" class="peer sr-only" {{ old('anomaly_type') === 'other' ? 'checked' : '' }}>
                    <div class="flex flex-col items-center gap-2 rounded-xl border border-border bg-background p-4 text-xs font-semibold text-muted-foreground transition peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:shadow-glow hover:border-primary/40 hover:text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M16 14v6"/><path d="M8 14v6"/><path d="M12 16v6"/></svg>
                        Hujan Lebat
                    </div>
                </label>
            </div>
            @error('anomaly_type')
                <div class="mt-1.5 text-xs text-destructive">{{ $message }}</div>
            @enderror
        </div>

        {{-- Lokasi --}}
        <div class="mt-6">
            <label htmlFor="location" class="text-sm font-semibold text-foreground">Lokasi kejadian <span class="text-destructive">*</span></label>
            <div class="relative mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                <input
                    id="location"
                    name="location"
                    value="{{ old('location') }}"
                    required
                    placeholder="Contoh: Jl. Adisucipto Km 8, Sungai Raya"
                    @class([
                        'w-full rounded-lg border bg-background py-2.5 pl-10 pr-3 text-sm placeholder:text-muted-foreground/70 focus:outline-none focus:ring-2 focus:ring-ring/30 transition',
                        'border-destructive focus:border-destructive' => $errors->has('location'),
                        'border-input focus:border-primary' => !$errors->has('location'),
                    ])
                />
            </div>
            @error('location')
                <div class="mt-1.5 text-xs text-destructive">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nama --}}
        <div class="mt-6">
            <label htmlFor="reporter_name" class="text-sm font-semibold text-foreground">Nama (opsional)</label>
            <input
                id="reporter_name"
                name="reporter_name"
                value="{{ old('reporter_name') }}"
                placeholder="Nama atau biarkan kosong untuk anonim"
                @class([
                    'mt-2 w-full rounded-lg border bg-background px-3 py-2.5 text-sm placeholder:text-muted-foreground/70 focus:outline-none focus:ring-2 focus:ring-ring/30 transition',
                    'border-destructive focus:border-destructive' => $errors->has('reporter_name'),
                    'border-input focus:border-primary' => !$errors->has('reporter_name'),
                ])
            />
            @error('reporter_name')
                <div class="mt-1.5 text-xs text-destructive">{{ $message }}</div>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mt-6">
            <label htmlFor="description" class="text-sm font-semibold text-foreground">Deskripsi singkat <span class="text-destructive">*</span></label>
            <textarea
                id="description"
                name="description"
                required
                rows="4"
                maxlength="500"
                placeholder="Ceritakan kondisi yang kamu lihat: ketinggian air, durasi hujan, dampak, dll."
                @class([
                    'mt-2 w-full resize-none rounded-lg border bg-background px-3 py-2.5 text-sm placeholder:text-muted-foreground/70 focus:outline-none focus:ring-2 focus:ring-ring/30 transition',
                    'border-destructive focus:border-destructive' => $errors->has('description'),
                    'border-input focus:border-primary' => !$errors->has('description'),
                ])
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="mt-1.5 text-xs text-destructive">{{ $message }}</div>
            @else
                <div class="mt-1 text-right text-[11px] text-muted-foreground">Maks 500 karakter</div>
            @enderror
        </div>

        <button
            type="submit"
            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground shadow-glow transition hover:opacity-90 sm:w-auto"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
            Kirim Laporan
        </button>
        <p class="mt-4 text-xs text-muted-foreground">
            Dengan mengirim laporan, Anda menyetujui data lokasi dan deskripsi disiarkan ke pengguna lain setelah dimoderasi.
        </p>
    </form>
</section>

@endsection
