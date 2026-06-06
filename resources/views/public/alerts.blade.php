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
                Diterbitkan dan diperbarui langsung oleh tim PMG Kalbar. Aktifkan notifikasi untuk menerima peringatan secara realtime.
            </p>
            <button id="btn-subscribe-push" class="mt-5 inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-primary-foreground shadow-glow hover:opacity-90 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg> Aktifkan Notifikasi
            </button>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btn-subscribe-push');
    
    if (!btn) return;

    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        btn.textContent = 'Push Tidak Didukung';
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        return;
    }

    function urlB64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    btn.addEventListener('click', async () => {
        try {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                alert('Izin notifikasi ditolak.');
                return;
            }

            const swReg = await navigator.serviceWorker.ready;
            
            // Unsubscribe existing if any, to avoid key mismatch errors (optional but good practice)
            let existingSub = await swReg.pushManager.getSubscription();
            if (existingSub) {
                 // Try to unsubscribe or we just let it override
            }

            const subscription = await swReg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlB64ToUint8Array("{{ $vapidPublicKey }}")
            });

            const res = await fetch('{{ route('push.subscribe') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(subscription)
            });

            if (!res.ok) {
                throw new Error('Gagal menyimpan subscription ke server');
            }

            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Notifikasi Aktif';
            btn.classList.remove('bg-primary');
            btn.classList.add('bg-success', 'text-success-foreground');
            btn.disabled = true;

        } catch (error) {
            console.error('Push subscription failed:', error);
            alert('Gagal mengaktifkan notifikasi: ' + error.message);
        }
    });

    async function checkSubscriptionStatus() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            return;
        }
        
        try {
            const swReg = await navigator.serviceWorker.ready;
            const subscription = await swReg.pushManager.getSubscription();
            
            if (subscription && btn) {
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Notifikasi Aktif';
                btn.classList.remove('bg-primary');
                btn.classList.add('bg-success', 'text-success-foreground');
                btn.disabled = true;
            }
        } catch (error) {
            console.error('Failed to check push subscription status:', error);
        }
    }

    checkSubscriptionStatus();
});
</script>
@endsection
