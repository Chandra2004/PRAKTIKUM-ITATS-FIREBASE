@extends('dashboard.layouts.layout')
@section('dashboard-content')
<div id="home-content-skeleton">
    <div class="p-4 sm:p-6">
        <!-- Skeleton Page Header -->
        <div class="mb-6">
            <div class="w-64 h-8 bg-gray-200 rounded"></div>
            <div class="w-96 h-4 bg-gray-200 rounded mt-2"></div>
        </div>
        <!-- Skeleton Summary Cards -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <div class="w-24 h-4 bg-gray-200 rounded"></div>
                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                </div>
                <div class="p-4">
                    <div class="w-16 h-8 bg-gray-200 rounded"></div>
                    <div class="w-32 h-4 bg-gray-200 rounded mt-4"></div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <div class="w-24 h-4 bg-gray-200 rounded"></div>
                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                </div>
                <div class="p-4">
                    <div class="w-16 h-8 bg-gray-200 rounded"></div>
                    <div class="w-32 h-4 bg-gray-200 rounded mt-4"></div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <div class="w-24 h-4 bg-gray-200 rounded"></div>
                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                </div>
                <div class="p-4">
                    <div class="w-16 h-8 bg-gray-200 rounded"></div>
                    <div class="w-32 h-4 bg-gray-200 rounded mt-4"></div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <div class="w-24 h-4 bg-gray-200 rounded"></div>
                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                </div>
                <div class="p-4">
                    <div class="w-16 h-8 bg-gray-200 rounded"></div>
                    <div class="w-32 h-4 bg-gray-200 rounded mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="home-content" class="hidden">
    <main class="p-4 sm:p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold font-headline text-[#468B97]">Dashboard Super Admin</h1>
            <p class="mt-1 text-sm text-gray-600">Selamat datang, Super Admin! Kelola pengguna dan pengaturan sistem dari sini.</p>
        </div>
        <!-- Summary Cards -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card: Total Pengguna -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <h3 class="text-sm font-medium">Total Pengguna</h3>
                    <i data-lucide="users" class="h-6 w-6 text-gray-500"></i>
                </div>
                <div class="p-4">
                    <div class="text-2xl font-bold">{{ $totalUsers }}</div>
                    <a href="/dashboard/superadmin/user-management" class="inline-flex items-center pt-4 text-sm text-[#468B97] hover:text-[#FEE500]">
                        Kelola Pengguna
                        <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
            <!-- Card: Verifikasi Tertunda -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <h3 class="text-sm font-medium">Verifikasi Tertunda</h3>
                    <i data-lucide="credit-card" class="h-6 w-6 text-gray-500"></i>
                </div>
                <div class="p-4">
                    <div class="text-2xl font-bold">10</div>
                    <a href="/dashboard/superadmin/payment-management" class="inline-flex items-center pt-4 text-sm text-[#468B97] hover:text-[#FEE500]">
                        Verifikasi Pembayaran
                        <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
            <!-- Card: Persetujuan Praktikum -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <h3 class="text-sm font-medium">Persetujuan Praktikum</h3>
                    <i data-lucide="book-open" class="h-6 w-6 text-gray-500"></i>
                </div>
                <div class="p-4">
                    <div class="text-2xl font-bold">5</div>
                    <a href="/dashboard/superadmin/courses-management" class="inline-flex items-center pt-4 text-sm text-[#468B97] hover:text-[#FEE500]">
                        Kelola Praktikum
                        <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
            <!-- Card: Jadwal Global -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex flex-row items-center justify-between p-4 space-y-0 pb-2">
                    <h3 class="text-sm font-medium">Jadwal Global</h3>
                    <i data-lucide="calendar-clock" class="h-6 w-6 text-gray-500"></i>
                </div>
                <div class="p-4">
                    <div class="text-2xl font-bold">Atur</div>
                    <a href="/dashboard/superadmin/schedule-management" class="inline-flex items-center pt-4 text-sm text-[#468B97] hover:text-[#FEE500]">
                        Atur Jadwal
                        <i data-lucide="arrow-right" class="ml-2 h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection