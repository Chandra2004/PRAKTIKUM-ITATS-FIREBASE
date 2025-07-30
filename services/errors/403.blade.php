@extends('errors.layout.layout')

@section('content-error')
    <div class="error-number error-animation">403</div>

    <!-- Error Message -->
    <h1 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight mb-4">
        Akses Ditolak
    </h1>

    <p class="text-lg text-gray-600 mb-8">
        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
        Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
    </p>
@endsection