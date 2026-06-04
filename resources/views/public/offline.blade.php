@extends('layouts.guest')
@section('title', 'Anda Sedang Offline')
@section('content')
<div class="flex min-h-[70vh] flex-col items-center justify-center bg-background px-4 text-center">
    <div class="mb-6 grid h-24 w-24 place-items-center rounded-full bg-muted text-muted-foreground">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10"><path d="m2 2 20 20"/><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg>
    </div>
    <h1 class="font-display text-2xl font-bold sm:text-3xl">Anda Sedang Offline</h1>
    <p class="mx-auto mt-4 max-w-md text-sm text-muted-foreground">
        Koneksi jaringan terputus. Sistem akan otomatis memuat ulang saat sinyal kembali, atau Anda dapat melihat halaman yang telah tersimpan di perangkat Anda.
    </p>
    <button onclick="window.location.reload()" class="mt-8 inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground shadow-glow transition hover:opacity-90">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
        Coba Lagi
    </button>
</div>
@endsection
