@extends('homepage.layout.layoutHome')

@section('content')
@include('notification.notification')
<main class="flex-1">
    <section class="hero-section relative py-16 sm:py-24 md:py-32 flex items-center">
        <div class="slideshow-container">
            <div class="slideshow-image active"
                style="background-image: url('{{ url("assets/images/internal/background-1.png") }}')">
            </div>
            <div class="slideshow-image"
                style="background-image: url('{{ url("assets/images/internal/background-2.png") }}')">
            </div>
            <div class="slideshow-image"
                style="background-image: url('{{ url("assets/images/internal/background-3.png") }}')">
            </div>
        </div>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span
                class="inline-block mb-6 text-sm font-medium border border-white text-white rounded-full px-4 py-1.5 bg-[#468B97]">Selamat
                Datang di Portal Informasi Praktikum</span>
            <h1
                class="font-headline text-3xl sm:text-4xl md:text-5xl lg:text-9xlxl font-bold tracking-tight max-w-4xl mx-auto text-white">
                Laboratorium Teknik Sipil ITATS
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-base sm:text-lg md:text-xl text-gray-200 leading-relaxed">
                Welcome to Lab Sipil ITATS, keep chilling and always Looksmaxxing
            </p>
            <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:justify-center">
                <a href="{{ $link }}"
                    class="bg-[#468B97] text-white hover:bg-[#468B97]/90 px-6 py-3 rounded-lg text-lg font-medium transition-colors shadow-soft"
                    aria-label="Masuk ke dashboard">Masuk ke Dashboard</a>
                <a href="/register"
                    class="border border-white text-white hover:bg-[#468B97] px-6 py-3 rounded-lg text-lg font-medium transition-colors"
                    aria-label="Daftar akun baru">Daftar Akun Baru</a>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 md:py-32">
        <div class="text-center mb-12">
            <h2 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight">
                Berita & Pengumuman
            </h2>
            <p class="mt-4 mx-auto text-base sm:text-lg text-gray-600">
                Ikuti terus informasi dan pembaruan terkini seputar kegiatan praktikum.
            </p>
        </div>

        <div class="mt-4 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($news as $item)
            <article class="flex flex-col overflow-hidden bg-white border border-[#468B97]/50 rounded-xl shadow-soft transition-transform hover:scale-[1.02] hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span
                            class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $item['category'] }}</span>
                        <time datetime="2025-10-01">{{ $item['date'] }}</time>
                    </div>
                    <h3 class="font-headline text-xl pt-3 font-semibold">{{ $item['title'] }}</h3>
                </div>
                <div class="px-6 pb-6 flex-1">
                    <p class="text-gray-600">{{ $item['excerpt'] }}</p>
                </div>
                <div class="px-6 pb-6">
                    <a href="/news/{{ $item['category'] }}/{{ $item['id'] }}/{{ $item['slug'] }}"
                        class="text-[#468B97] hover:underline flex items-center text-sm font-medium transition-colors"
                        aria-label="Baca selengkapnya tentang Pendaftaran Jurnal Praktikum">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="#468B97" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="ml-2">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="/news" class="inline-flex items-center text-[#468B97] font-medium hover:underline">
                Lihat Semua Berita
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="#468B97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </section>

    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center mb-12">
            <h2 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight">
                Praktikum Tersedia
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-base sm:text-lg text-gray-600 leading-relaxed">
                Temukan praktikum yang sesuai dengan minat dan kebutuhan akademik Anda
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Tab Navigation -->
            <div class="flex flex-wrap gap-2 mb-8 justify-center">
                <button class="tab-button active px-4 py-2 rounded-lg font-medium bg-[#468B97] text-white"
                    data-tab="tab-1">Ilmu Ukur Tanah</button>
                <button class="tab-button px-4 py-2 rounded-lg font-medium bg-gray-100 text-gray-700"
                    data-tab="tab-2">Teknologi Beton</button>
                <button class="tab-button px-4 py-2 rounded-lg font-medium bg-gray-100 text-gray-700"
                    data-tab="tab-3">Kimia</button>
                <button class="tab-button px-4 py-2 rounded-lg font-medium bg-gray-100 text-gray-700"
                    data-tab="tab-4">Mekanika Tanah</button>
                <button class="tab-button px-4 py-2 rounded-lg font-medium bg-gray-100 text-gray-700"
                    data-tab="tab-5">Hidrolika</button>
                <button class="tab-button px-4 py-2 rounded-lg font-medium bg-gray-100 text-gray-700"
                    data-tab="tab-6">Bahan Jalan</button>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-xl shadow-soft p-6">
                <div id="tab-1" class="tab-content active">
                    <h3 class="font-headline text-2xl font-bold mb-4 text-center">Ilmu Ukur Tanah</h3>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="logo google" width="150px" class="mx-auto my-4">
                    <p class="text-gray-700 mb-4">
                        Praktikum Ilmu Ukur Tanah memberikan pemahaman dasar tentang teknik pengukuran dan pemetaan
                        tanah.
                        Mahasiswa akan mempelajari penggunaan alat ukur seperti theodolite, waterpass, dan GPS
                        geodesi.
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Praktikum semester ganjil yang tersedia untuk mahasiswa
                            mulai dari semester 3</p>
                    </div>
                </div>

                <div id="tab-2" class="tab-content hidden">
                    <h3 class="font-headline text-2xl font-bold mb-4 text-center">Teknologi Beton</h3>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="logo google" width="150px" class="mx-auto my-4">
                    <p class="text-gray-700 mb-4">
                        Praktikum ini fokus pada pengujian sifat fisik dan mekanik beton. Mahasiswa akan melakukan
                        pengujian slump test, kuat tekan, kuat tarik, dan analisis campuran beton sesuai standar
                        SNI.
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Praktikum semester ganjil yang tersedia untuk mahasiswa
                            mulai dari semester 5</p>
                    </div>
                </div>

                <div id="tab-3" class="tab-content hidden">
                    <h3 class="font-headline text-2xl font-bold mb-4 text-center">Kimia</h3>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="logo google" width="150px" class="mx-auto my-4">
                    <p class="text-gray-700 mb-4">
                        Praktikum Kimia Teknik Sipil mengajarkan analisis kimia material konstruksi. Topik meliputi
                        pengujian kualitas air, analisis tanah, dan pengujian korosi pada material logam.
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Praktikum semester ganjil yang tersedia untuk mahasiswa
                            mulai dari semester 3</p>
                    </div>
                </div>

                <div id="tab-4" class="tab-content hidden">
                    <h3 class="font-headline text-2xl font-bold mb-4 text-center">Mekanika Tanah</h3>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="logo google" width="150px" class="mx-auto my-4">
                    <p class="text-gray-700 mb-4">
                        Praktikum ini mempelajari sifat fisik dan mekanik tanah. Mahasiswa akan melakukan pengujian
                        kepadatan tanah, analisis saringan, batas Atterberg, dan pengujian kuat geser tanah.
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Praktikum semester ganjil yang tersedia untuk mahasiswa
                            mulai dari semester 5</p>
                    </div>
                </div>

                <div id="tab-5" class="tab-content hidden">
                    <h3 class="font-headline text-2xl font-bold mb-4 text-center">Hidrolika</h3>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="logo google" width="150px" class="mx-auto my-4">
                    <p class="text-gray-700 mb-4">
                        Praktikum Hidrolika fokus pada studi aliran fluida dalam sistem rekayasa. Mahasiswa akan
                        mempelajari karakteristik aliran pipa, saluran terbuka, dan pengujian model hidrolik.
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Praktikum semester ganjil yang tersedia untuk mahasiswa
                            mulai dari semester 5</p>
                    </div>
                </div>

                <div id="tab-6" class="tab-content hidden">
                    <h3 class="font-headline text-2xl font-bold mb-4 text-center">Bahan Jalan</h3>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="logo google" width="150px" class="mx-auto my-4">
                    <p class="text-gray-700 mb-4">
                        Praktikum ini membahas pengujian material perkerasan jalan. Mahasiswa akan mempelajari
                        pengujian Marshall, analisis gradasi agregat, dan pengujian sifat bitumen.
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Praktikum semester ganjil yang tersedia untuk mahasiswa
                            mulai dari semester 5</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection