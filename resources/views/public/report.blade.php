@extends('layouts.guest')
@section('title', 'Lapor Cuaca')
@section('content')
<div class="min-h-screen bg-background">
    <section class="border-b border-border bg-gradient-hero">
        <div class="mx-auto max-w-7xl px-4 py-12 text-white sm:px-6">
            <h1 class="font-display text-3xl font-bold sm:text-4xl">Laporkan Cuaca di Sekitarmu</h1>
            <p class="mt-2 max-w-2xl text-sm text-white/80">
                Laporanmu langsung disiarkan ke warga lain dan dimoderasi oleh tim PMG. Bersama, kita membangun peta cuaca realtime Kalimantan Barat.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        <form method="POST" action="{{ route('citizen-reports.store') }}" novalidate class="rounded-2xl border border-border bg-card p-6 shadow-card sm:p-8"
              onsubmit="let btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.classList.add('opacity-70', 'cursor-not-allowed'); btn.innerHTML = '<svg class=\'animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg> Mengirim...';">
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
                <label for="location" class="text-sm font-semibold text-foreground">Lokasi kejadian <span class="text-destructive">*</span></label>
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
                <label for="reporter_name" class="text-sm font-semibold text-foreground">Nama (opsional)</label>
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
                <label for="description" class="text-sm font-semibold text-foreground">Deskripsi singkat <span class="text-destructive">*</span></label>
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
                class="cursor-pointer mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-semibold text-primary-foreground shadow-glow transition hover:opacity-90 sm:w-auto"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                Kirim Laporan
            </button>
            <p class="mt-4 text-xs text-muted-foreground">
                Dengan mengirim laporan, Anda menyetujui data lokasi dan deskripsi disiarkan ke pengguna lain setelah dimoderasi.
            </p>
        </form>
    </section>
</div>
@endsection
