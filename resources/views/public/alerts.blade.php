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

            <div class="mt-8 flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-foreground mr-2">Filter Level:</span>
                <a href="{{ route('peringatan') }}"
                   class="inline-flex items-center rounded-full border px-4 py-1.5 text-xs font-semibold transition-colors
                   {{ !request()->has('level') ? 'bg-primary border-primary text-primary-foreground shadow-glow' : 'bg-background border-border text-muted-foreground hover:border-primary/50 hover:text-foreground' }}">
                    Semua
                </a>
                <a href="{{ route('peringatan', ['level' => 'info']) }}"
                   class="inline-flex items-center rounded-full border px-4 py-1.5 text-xs font-semibold transition-colors
                   {{ request('level') === 'info' ? 'bg-info/20 border-info text-info shadow-sm' : 'bg-background border-border text-muted-foreground hover:border-info/50 hover:text-foreground' }}">
                    Info
                </a>
                <a href="{{ route('peringatan', ['level' => 'waspada']) }}"
                   class="inline-flex items-center rounded-full border px-4 py-1.5 text-xs font-semibold transition-colors
                   {{ request('level') === 'waspada' ? 'bg-warning/20 border-warning text-warning-foreground shadow-sm' : 'bg-background border-border text-muted-foreground hover:border-warning/50 hover:text-foreground' }}">
                    Waspada
                </a>
                <a href="{{ route('peringatan', ['level' => 'bahaya']) }}"
                   class="inline-flex items-center rounded-full border px-4 py-1.5 text-xs font-semibold transition-colors
                   {{ request('level') === 'bahaya' ? 'bg-destructive/20 border-destructive text-destructive shadow-sm' : 'bg-background border-border text-muted-foreground hover:border-destructive/50 hover:text-foreground' }}">
                    Bahaya
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl space-y-4 px-4 py-12 sm:px-6">
        {{-- Unsubscribe Push Notification UI --}}
        <div id="unsubscribe-container" class="hidden mb-6 items-center justify-between rounded-xl border border-border bg-card p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-full bg-primary/10 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-foreground">Notifikasi Aktif</h3>
                    <p class="text-xs text-muted-foreground">Anda menerima peringatan instan.</p>
                </div>
            </div>
            <button id="btn-unsubscribe" onclick="unsubscribePush()" class="inline-flex items-center gap-2 rounded-lg border border-border bg-background px-3 py-1.5 text-xs font-semibold text-muted-foreground transition-colors hover:bg-destructive/10 hover:text-destructive hover:border-destructive/30">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M18.36 6.64A9 9 0 0 1 20.77 15"/><path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"/><path d="M12 2v4"/><path d="m2 2 20 20"/></svg>
                Berhenti
            </button>
        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;

            try {
                const swReg = await navigator.serviceWorker.ready;
                const subscription = await swReg.pushManager.getSubscription();

                if (subscription) {
                    const container = document.getElementById('unsubscribe-container');
                    container.classList.remove('hidden');
                    container.classList.add('flex');
                }
            } catch (error) {
                console.error('Error checking subscription:', error);
            }
        });

        async function unsubscribePush() {
            const btn = document.getElementById('btn-unsubscribe');
            btn.disabled = true;
            btn.innerHTML = 'Memproses...';

            try {
                const swReg = await navigator.serviceWorker.ready;
                const subscription = await swReg.pushManager.getSubscription();

                if (subscription) {
                    // Delete from backend
                    await fetch('/push-unsubscribe', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ endpoint: subscription.endpoint })
                    });

                    // Unsubscribe from browser
                    await subscription.unsubscribe();

                    // Hide the UI
                    const container = document.getElementById('unsubscribe-container');
                    container.classList.add('hidden');
                    container.classList.remove('flex');
                }
            } catch (error) {
                console.error('Error unsubscribing:', error);
                alert('Gagal berhenti berlangganan. Coba lagi.');
                btn.disabled = false;
                btn.innerHTML = 'Berhenti';
            }
        }
    </script>
</div>
@endsection
