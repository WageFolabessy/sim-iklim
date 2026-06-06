@extends('layouts.guest')
@section('title', 'Peringatan Dini')
@section('content')
<div class="min-h-screen bg-background">
    <section class="border-b border-border bg-surface">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
            @if($alerts->count() > 0)
            <div class="inline-flex items-center gap-2 rounded-full border border-destructive/30 bg-destructive/10 px-3 py-1 text-xs font-semibold text-destructive">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg> {{ $alerts->count() }} peringatan aktif
            </div>
            @else
            <div class="inline-flex items-center gap-2 rounded-full border border-success/30 bg-success/10 px-3 py-1 text-xs font-semibold text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg> Kondisi Aman
            </div>
            @endif
            <h1 class="mt-4 font-display text-3xl font-bold sm:text-4xl">Peringatan Dini Cuaca Ekstrem</h1>
            <p class="mt-2 max-w-2xl text-sm text-muted-foreground">
                Diterbitkan dan diperbarui langsung oleh tim PMG Kalbar. Notifikasi peringatan akan muncul otomatis di perangkat Anda.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl space-y-4 px-4 py-12 sm:px-6">
        @forelse($alerts as $a)
            <article class="overflow-hidden rounded-xl border bg-card shadow-card {{ $a->level === 'bahaya' ? 'border-destructive/40' : ($a->level === 'waspada' ? 'border-warning/50' : 'border-info/40') }}">
                <div class="h-1.5 {{ $a->level === 'bahaya' ? 'bg-destructive' : ($a->level === 'waspada' ? 'bg-warning' : 'bg-info') }}"></div>
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider {{ $a->level === 'bahaya' ? 'bg-destructive/15 text-destructive' : ($a->level === 'waspada' ? 'bg-warning/20 text-warning-foreground' : 'bg-info/15 text-info') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg> {{ $a->level }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-xs text-muted-foreground"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg> {{ $a->area }} </span>
                        <span class="inline-flex items-center gap-1 text-xs text-muted-foreground"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $a->created_at->diffForHumans() }}</span>
                    </div>
                    <h2 class="mt-3 font-display text-xl font-bold">{{ $a->title }}</h2>
                    <p class="mt-2 text-sm text-foreground/80">{{ $a->body }}</p>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-border bg-card p-8 text-center text-sm text-muted-foreground">
                Tidak ada peringatan cuaca ekstrem saat ini.
            </div>
        @endforelse
    </section>
</div>
@endsection
