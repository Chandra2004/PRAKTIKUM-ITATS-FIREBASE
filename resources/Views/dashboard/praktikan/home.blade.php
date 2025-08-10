@extends('dashboard.layouts.layout')
@section('dashboard-content')
    <main class="p-4 sm:p-6">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="font-headline text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
            <p class="text-[#6B7280]">Selamat datang, Praktikan! Berikut adalah alur dan jadwal praktikum Anda.</p>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Calendar Section -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="font-headline text-xl font-semibold flex items-center gap-2">
                            <i data-lucide="calendar" class="w-6 h-6 text-[#468B97]"></i>
                            Kalender Jadwal
                        </h2>
                        <p class="text-[#6B7280] text-sm mt-1">
                            Tanggal yang ditandai memiliki jadwal praktikum. Klik untuk melihat detail.
                        </p>
                    </div>
                    <div class="p-6">
                        <!-- Flowbite Calendar -->
                        <div id="calendar" class="w-full">
                            <div class="relative">
                                <div class="flowbite-datepicker" data-date="08/09/2025"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Sessions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        <h2 class="font-headline text-xl font-semibold">Sesi Akan Datang</h2>
                        <p class="text-[#6B7280] text-sm mt-1">Jadwal praktikum Anda berikutnya.</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Sample Session -->
                        <div class="flex gap-4 p-4 rounded-lg border bg-white hover:bg-[#F3F4F6] transition-colors">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#468B97] text-white">
                                <i data-lucide="beaker" class="h-6 w-6"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold">Praktikum Fisika Dasar</h4>
                                <p class="text-sm text-[#6B7280]">Senin, 11 Agustus 2025</p>
                                <div class="mt-1 flex flex-col sm:flex-row sm:items-center sm:gap-4 text-sm text-[#6B7280]">
                                    <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                    <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="h-4 w-4"></i> Lab Fisika 101</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-[#6B7280] text-center p-4">Tidak ada jadwal akan datang.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alur Praktikum -->
        <div class="space-y-4">
            <h2 class="font-headline text-2xl font-bold tracking-tight">Alur Praktikum</h2>
            <!-- Step Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 transition-all border-[#468B97] ring-1 ring-primary">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 sm:p-6 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg border bg-white shadow-sm">
                            <i data-lucide="circle-dot" class="h-6 w-6 text-[#468B97] animate-pulse"></i>
                        </div>
                        <div>
                            <p class="font-headline text-lg font-semibold">Pembayaran</p>
                            <p class="text-sm text-[#6B7280]">Lengkapi pembayaran untuk memulai praktikum.</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-4 sm:w-auto">
                        <span class="hidden sm:block px-2.5 py-0.5 text-sm font-medium rounded border bg-[#FEE500] text-[#FEE500]-foreground">Dalam Proses</span>
                        <a href="/payment" class="btn btn-primary w-full sm:w-auto flex items-center gap-2">
                            Lanjutkan
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Tambahkan langkah lain sesuai kebutuhan -->
        </div>
    </main>
    <!-- Modal -->
    <div id="day-detail-modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-headline text-lg font-semibold">Jadwal untuk Senin, 11 Agustus 2025</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body max-h-[60vh] overflow-y-auto">
                    <p class="text-[#6B7280] text-sm mb-4">Berikut adalah semua sesi praktikum yang dijadwalkan pada tanggal ini.</p>
                    <div class="space-y-4">
                        <div class="p-3 rounded-md border flex justify-between items-start gap-2">
                            <div>
                                <p class="font-semibold">Praktikum Fisika Dasar</p>
                                <p class="text-sm text-[#6B7280]">Fisika Dasar I</p>
                                <div class="flex items-center gap-4 text-sm mt-1 text-[#6B7280]">
                                    <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                    <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="h-4 w-4"></i> Lab Fisika 101</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

