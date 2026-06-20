@extends('layouts.guest')
@section('title', 'Statistik Historis')
@section('content')
<div class="min-h-screen bg-background">
    <section class="border-b border-border bg-surface">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
            <div class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-3 py-1 text-xs font-semibold text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg> {{ $yearSpan }}
            </div>
            <h1 class="mt-4 font-display text-3xl font-bold sm:text-4xl">Proyeksi Statistik Historis</h1>
            <p class="mt-2 max-w-2xl text-sm text-muted-foreground">
                Agregasi otomatis dari basis data PMG: rata-rata, minimum, maksimum, dan standar deviasi parameter iklim Kalimantan Barat.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Temperature --}}
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <div class="font-display text-lg font-bold">Suhu Udara</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-4xl font-bold text-primary">{{ number_format($tempAvg, 1) }}</span>
                    <span class="text-sm text-muted-foreground">°C rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ number_format($tempMin, 1) }}°C</div>
                    </div>
                    <div class="border-l border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ number_format($tempMax, 1) }}°C</div>
                    </div>
                    <div class="col-span-2 border-t border-border pt-3">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Fluktuasi (Std Dev)</div>
                        <div class="mt-0.5 flex items-baseline justify-center gap-1.5">
                            <span class="text-base font-bold text-warning">{{ number_format($tempStddev, 1) }}°C</span>
                        </div>
                        <div class="mt-1 text-[10px] text-muted-foreground/70">*Angka kecil = stabil, angka besar = fluktuatif</div>
                    </div>
                </div>
            </div>
            
            {{-- Humidity --}}
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <div class="font-display text-lg font-bold">Kelembapan</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-4xl font-bold text-primary">{{ number_format($humidityAvg, 0) }}</span>
                    <span class="text-sm text-muted-foreground">% rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ number_format($humidityMin, 0) }}%</div>
                    </div>
                    <div class="border-l border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ number_format($humidityMax, 0) }}%</div>
                    </div>
                    <div class="col-span-2 border-t border-border pt-3">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Fluktuasi (Std Dev)</div>
                        <div class="mt-0.5 flex items-baseline justify-center gap-1.5">
                            <span class="text-base font-bold text-warning">{{ number_format($humidityStddev, 1) }}%</span>
                        </div>
                        <div class="mt-1 text-[10px] text-muted-foreground/70">*Angka kecil = stabil, angka besar = fluktuatif</div>
                    </div>
                </div>
            </div>
            
            {{-- Rainfall --}}
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <div class="font-display text-lg font-bold">Curah Hujan</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-4xl font-bold text-primary">{{ number_format($rainfallAvg, 1) }}</span>
                    <span class="text-sm text-muted-foreground">mm rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ number_format($rainfallMin, 1) }}mm</div>
                    </div>
                    <div class="border-l border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ number_format($rainfallMax, 1) }}mm</div>
                    </div>
                    <div class="col-span-2 border-t border-border pt-3">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Fluktuasi (Std Dev)</div>
                        <div class="mt-0.5 flex items-baseline justify-center gap-1.5">
                            <span class="text-base font-bold text-warning">{{ number_format($rainfallStddev, 1) }}mm</span>
                        </div>
                        <div class="mt-1 text-[10px] text-muted-foreground/70">*Angka kecil = stabil, angka besar = ekstrem</div>
                    </div>
                </div>
            </div>

            {{-- Wind Speed --}}
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <div class="font-display text-lg font-bold">Kecepatan Angin</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-4xl font-bold text-primary">{{ number_format($windAvg, 1) }}</span>
                    <span class="text-sm text-muted-foreground">km/j rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ number_format($windMin, 1) }}km/j</div>
                    </div>
                    <div class="border-l border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ number_format($windMax, 1) }}km/j</div>
                    </div>
                    <div class="col-span-2 border-t border-border pt-3">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Fluktuasi (Std Dev)</div>
                        <div class="mt-0.5 flex items-baseline justify-center gap-1.5">
                            <span class="text-base font-bold text-warning">{{ number_format($windStddev, 1) }}km/j</span>
                        </div>
                        <div class="mt-1 text-[10px] text-muted-foreground/70">*Angka kecil = stabil, angka besar = ekstrem</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rainfall chart --}}
        <div class="mt-8 rounded-xl border border-border bg-card p-6 shadow-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-display text-lg font-bold">Curah Hujan Bulanan</h2>
                    <p class="text-xs text-muted-foreground">Rata-rata curah hujan bulanan, satuan mm</p>
                </div>
            </div>
            
            @php
                $historicalMax = !empty($rainData) ? max($rainData) : 0;
                $forecastMax = (isset($forecastRainData) && !empty($forecastRainData)) ? max($forecastRainData) : 0;
                $maxRain = max($historicalMax, $forecastMax);
                $maxRain = $maxRain > 0 ? $maxRain : 1; // absolute fallback
                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            @endphp
            
            <div class="mt-6 flex h-56 items-end gap-2">
                @foreach($rainData as $index => $v)
                    <div class="group flex h-full flex-1 flex-col items-center gap-2">
                        <div class="relative w-full flex-1">
                            <div
                                class="absolute bottom-0 w-full rounded-t-md bg-gradient-sky transition group-hover:opacity-80"
                                style="height: {{ ($v / $maxRain) * 100 }}%;"
                                title="{{ $v }} mm"
                            ></div>
                        </div>
                        <div class="text-[10px] text-muted-foreground">{{ $months[$index] }}</div>
                    </div>
                @endforeach
                
                {{-- Forecast Data --}}
                @if(isset($forecastRainData) && count($forecastRainData) > 0)
                    <div class="my-auto h-4/5 w-px border-l-2 border-dashed border-border mx-1"></div>
                    @foreach($forecastRainData as $index => $v)
                        <div class="group flex h-full flex-1 flex-col items-center gap-2 opacity-80">
                            <div class="relative w-full flex-1">
                                <div
                                    class="absolute bottom-0 w-full rounded-t-md border-2 border-dashed border-primary bg-primary/20 transition group-hover:opacity-80"
                                    style="height: {{ ($v / $maxRain) * 100 }}%;"
                                    title="Prediksi: {{ $v }} mm"
                                ></div>
                            </div>
                            <div class="text-[10px] font-semibold text-primary">{{ $forecastMonths[$index] ?? 'Bulan ' . ($index+1) }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
