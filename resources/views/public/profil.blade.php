@extends('layouts.guest')

@section('title', 'Profil Instansi')
@section('description', 'Profil Stasiun Klimatologi Kelas II Kalimantan Barat. Mewujudkan BMKG yang handal, tanggap dan mampu dalam rangka mendukung keselamatan masyarakat.')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-hero py-16 sm:py-24">
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.15) 0, transparent 40%), radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1) 0, transparent 50%)"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-white">
        <h1 class="font-display text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">
            Profil Instansi
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-white/90">
            Stasiun Klimatologi Kelas II Kalimantan Barat
        </p>
    </div>
</section>

{{-- KETERANGAN UMUM --}}
<section class="py-16 bg-background">
    <div class="mx-auto max-w-4xl px-4 sm:px-6">
        <div class="prose prose-slate prose-lg dark:prose-invert text-muted-foreground mx-auto text-justify leading-relaxed">
            <p>
                <strong>Stasiun Klimatologi Kalimantan Barat</strong> merupakan Unit Pelaksana Teknis di lingkungan Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) yang berada di bawah dan bertanggung jawab kepada Kepala BMKG.
            </p>
            <p class="mt-4">
                Dalam melaksanakan tugas dan fungsinya secara administratif dibina oleh Sekretaris Utama dan secara teknis operasional dibina oleh Deputi Bidang Klimatologi. Kami bertugas melaksanakan pengamatan, pengelolaan data, pelayanan informasi, jasa klimatologi, dan pemeliharaan alat klimatologi di Provinsi Kalimantan Barat.
            </p>
        </div>
    </div>
</section>

{{-- VISI MISI --}}
<section class="py-16 bg-surface border-y border-border">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="grid gap-8 md:grid-cols-2 md:gap-12">
            
            {{-- VISI --}}
            <div class="rounded-2xl border border-border bg-card p-8 shadow-card">
                <div class="flex items-center gap-4 mb-6">
                    <div class="grid h-16 w-16 place-items-center rounded-2xl bg-primary/10 text-primary shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <h2 class="font-display text-2xl font-bold text-foreground">Visi Kami</h2>
                </div>
                <p class="text-muted-foreground leading-relaxed text-sm">
                    Mewujudkan BMKG yang handal, tanggap dan mampu dalam rangka mendukung keselamatan masyarakat serta keberhasilan pembangunan nasional, dan berperan aktif di tingkat Internasional.
                </p>
            </div>

            {{-- MISI --}}
            <div class="rounded-2xl border border-border bg-card p-8 shadow-card">
                <div class="flex items-center gap-4 mb-6">
                    <div class="grid h-16 w-16 place-items-center rounded-2xl bg-secondary text-foreground shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h2 class="font-display text-2xl font-bold text-foreground">Misi Kami</h2>
                </div>
                <ul class="space-y-4 text-muted-foreground text-sm">
                    <li class="flex items-start gap-3">
                        <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary/10 text-primary font-bold text-xs mt-0.5">1</span>
                        <span class="leading-relaxed">Mengamati dan memahami fenomena meteorologi, klimatologi, kualitas udara dan geofisika.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary/10 text-primary font-bold text-xs mt-0.5">2</span>
                        <span class="leading-relaxed">Menyediakan data, informasi dan jasa meteorologi, klimatologi, kualitas udara dan geofisika yang handal dan terpercaya.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary/10 text-primary font-bold text-xs mt-0.5">3</span>
                        <span class="leading-relaxed">Mengkoordinasikan dan memfasilitasi kegiatan di bidang meteorologi, klimatologi, kualitas udara dan geofisika.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary/10 text-primary font-bold text-xs mt-0.5">4</span>
                        <span class="leading-relaxed">Berpartisipasi aktif dalam kegiatan internasional di Bidang meteorologi, klimatologi, kualitas udara dan geofisika.</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- TUGAS & TANGGUNG JAWAB --}}
<section class="py-16 bg-background">
    <div class="mx-auto max-w-5xl px-4 sm:px-6">
        <div class="text-center mb-12">
            <h2 class="font-display text-2xl font-bold sm:text-3xl text-foreground">Struktur & Tanggung Jawab</h2>
            <p class="mt-3 text-sm text-muted-foreground max-w-2xl mx-auto">
                Tugas dan tanggung jawab menjadi elemen penting dalam menjalankan fungsi organisasi secara efektif dan bersinergi.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
            
            <div class="rounded-xl border border-border bg-card p-6 shadow-sm hover:shadow-md transition">
                <div class="inline-flex items-center justify-center rounded-lg bg-secondary p-3 text-foreground mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="font-display text-lg font-bold text-foreground mb-2">Kepala Stasiun</h3>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Bertanggung jawab memimpin dan mengelola seluruh aktivitas dan operasional di Stasiun Klimatologi BMKG Kalimantan Barat.
                </p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-sm hover:shadow-md transition">
                <div class="inline-flex items-center justify-center rounded-lg bg-secondary p-3 text-foreground mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <h3 class="font-display text-lg font-bold text-foreground mb-2">Sub Bagian Tata Usaha</h3>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Melakukan urusan ketatausahaan, kepegawaian, keuangan, rumah tangga, penyusunan program kerja, dan pembuatan laporan stasiun.
                </p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-sm hover:shadow-md transition sm:col-span-2 md:col-span-1">
                <div class="inline-flex items-center justify-center rounded-lg bg-secondary p-3 text-foreground mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <h3 class="font-display text-lg font-bold text-foreground mb-2">Kelompok Fungsional</h3>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Memberikan pelayanan teknis fungsional sesuai keahlian. Termasuk Jabatan Pengamat Meteorologi dan Geofisika (PMG) dalam mengelola data iklim.
                </p>
            </div>

        </div>
    </div>
</section>

@endsection
