@extends('layouts.guest')
@section('title', 'Statistik Historis')
@section('content')
<div class="min-h-screen bg-background">
    <section class="border-b border-border bg-surface">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
            <div class="inline-flex items-center gap-2 rounded-full border border-border bg-card px-3 py-1 text-xs font-semibold text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg> Data 5 tahun terakhir
            </div>
            <h1 class="mt-4 font-display text-3xl font-bold sm:text-4xl">Proyeksi Statistik Historis</h1>
            <p class="mt-2 max-w-2xl text-sm text-muted-foreground">
                Agregasi otomatis dari basis data PMG: rata-rata, minimum, maksimum, dan standar deviasi parameter iklim Kalimantan Barat.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
        <div class="grid gap-4 sm:grid-cols-2">
            {{-- Temperature --}}
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <div class="flex items-center justify-between">
                    <div class="font-display text-lg font-bold">Suhu Udara</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-4xl font-bold text-primary">{{ isset($stats) ? number_format($stats->avg_temperature, 1) : '--' }}</span>
                    <span class="text-sm text-muted-foreground">°C rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ isset($stats) ? number_format($stats->min_temperature, 1) : '--' }}°C</div>
                    </div>
                    <div class="border-x border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ isset($stats) ? number_format($stats->max_temperature, 1) : '--' }}°C</div>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">σ</div>
                        <div class="mt-0.5 text-base font-bold text-foreground">{{ isset($stats) ? number_format($stats->stddev_temperature, 1) : '--' }}</div>
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
                    <span class="font-display text-4xl font-bold text-primary">{{ isset($stats) ? number_format($stats->avg_humidity, 0) : '--' }}</span>
                    <span class="text-sm text-muted-foreground">% rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ isset($stats) ? number_format($stats->min_humidity, 0) : '--' }}%</div>
                    </div>
                    <div class="border-x border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ isset($stats) ? number_format($stats->max_humidity, 0) : '--' }}%</div>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">σ</div>
                        <div class="mt-0.5 text-base font-bold text-foreground">{{ isset($stats) ? number_format($stats->stddev_humidity, 1) : '--' }}</div>
                    </div>
                </div>
            </div>
            
            {{-- Rainfall --}}
            <div class="rounded-xl border border-border bg-card p-6 shadow-card sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div class="font-display text-lg font-bold">Curah Hujan</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="font-display text-4xl font-bold text-primary">{{ isset($stats) ? number_format($stats->avg_rainfall, 1) : '--' }}</span>
                    <span class="text-sm text-muted-foreground">mm rata-rata</span>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-3 border-t border-border pt-4 text-center">
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Min</div>
                        <div class="mt-0.5 text-base font-bold text-info">{{ isset($stats) ? number_format($stats->min_rainfall, 1) : '--' }}mm</div>
                    </div>
                    <div class="border-x border-border">
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">Max</div>
                        <div class="mt-0.5 text-base font-bold text-destructive">{{ isset($stats) ? number_format($stats->max_rainfall, 1) : '--' }}mm</div>
                    </div>
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-muted-foreground">σ</div>
                        <div class="mt-0.5 text-base font-bold text-foreground">{{ isset($stats) ? number_format($stats->stddev_rainfall, 1) : '--' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rainfall chart --}}
        <div class="mt-8 rounded-xl border border-border bg-card p-6 shadow-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-display text-lg font-bold">Curah Hujan Bulanan</h2>
                    <p class="text-xs text-muted-foreground">Rata-rata 10 tahun, satuan mm</p>
                </div>
                <div class="inline-flex items-center gap-1.5 text-xs text-muted-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> 2015 – 2024
                </div>
            </div>
            
            @php
                $months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                $rainData = [184, 162, 220, 198, 174, 132, 108, 96, 148, 212, 256, 224];
                $maxRain = max($rainData);
            @endphp
            
            <div class="mt-6 flex h-56 items-end gap-2">
                @foreach($rainData as $index => $v)
                    <div class="group flex flex-1 flex-col items-center gap-2">
                        <div class="relative w-full flex-1">
                            <div
                                class="absolute bottom-0 w-full rounded-t-md bg-gradient-sky transition group-hover:opacity-80"
                                style="height: {{ ($v / $maxRain) * 100 }}%"
                                title="{{ $v }} mm"
                            ></div>
                        </div>
                        <div class="text-[10px] text-muted-foreground">{{ $months[$index] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection
