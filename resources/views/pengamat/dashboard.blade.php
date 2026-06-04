@extends('layouts.app')

@section('title', 'Dasbor Pengamat')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-gray-500 text-sm mt-1">Panel Pengamat — BMKG Stasiun Klimatologi Kalimantan Barat</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-gray-500 text-sm">Gunakan menu di atas untuk mengelola data iklim.</p>
    </div>
</div>
@endsection
