@extends('dashboard.layouts.layout')
@section('dashboard-content')
<main class="flex-1 p-4 sm:p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-bold text-[#468B97]">Manajemen Sesi</h1>
            <p class="text-sm text-gray-600">Buat dan kelola sesi-sesi waktu untuk setiap mata kuliah praktikum.</p>
        </div>
        <button data-modal-target="create-session-modal" data-modal-toggle="create-session-modal" type="button" class="flex items-center gap-2 bg-[#468B97] text-white px-4 py-2 rounded-lg hover:bg-[#3a6f7a] focus:ring-4 focus:ring-[#468B97] focus:ring-opacity-50" aria-label="Tambah sesi baru">
            <i data-lucide="plus-circle" class="mr-2 h-4 w-4" aria-hidden="true"></i>
            Tambah Sesi
        </button>
    </div>

    {{-- ADD SESSION MODAL --}}
    <div id="create-session-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <form action="/dashboard/superadmin/session-management/create" method="POST" id="create-session-form">
                    @csrf
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-session-modal" aria-label="Tutup modal">
                            <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                            <span class="sr-only">Tutup modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                            <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                <option disabled>Pilih praktikum</option>
                                @foreach($coursesList as $course)
                                <option value="{{ $course['uid'] }}">{{ $course['title_course'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Sesi</label>
                            <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Sesi Pagi/Siang/Sore/Malam" required>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                            <div>
                                <label for="waktuMulai" class="block mb-2 text-sm font-medium text-gray-900">Waktu Mulai</label>
                                <input type="time" id="waktuMulai" name="timeStart" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                            </div>
                            <div>
                                <label for="waktuSelesai" class="block mb-2 text-sm font-medium text-gray-900">Waktu Selesai</label>
                                <input type="time" id="waktuSelesai" name="timeEnd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                            <div>
                                <label for="kuota" class="block mb-2 text-sm font-medium text-gray-900">Kuota</label>
                                <input type="number" id="kuota" name="kuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: 20" min="1" required>
                            </div>
                            <div>
                                <label for="addDate" class="block mb-2 text-sm font-medium text-gray-900">Deadline Sesi</label>
                                <input type="datetime-local" id="addDate" name="deadline" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                        <button type="button" data-modal-hide="create-session-modal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" aria-label="Batalkan pembuatan sesi">Batal</button>
                        <button id="submitCreateSession" data-submit-loader data-loader="#loaderCreateSession" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Simpan sesi baru">
                            <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateSession" aria-hidden="true"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SESSION LIST --}}
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-bold font-headline">Daftar Sesi per Praktikum</h2>
                <p class="text-muted-foreground text-sm">Semua sesi yang sudah ada, dikelompokkan berdasarkan mata kuliah praktikum.</p>
            </div>
            <div class="p-6">
                <div id="accordion-collapse" data-accordion="collapse" class="space-y-4">
                    @foreach($coursesList as $course)
                        @php
                            $sessionCount = count(array_filter($sessionsList, fn($session) => $session['course_uid_session'] == $course['uid']));
                        @endphp
                        <div class="accordion-item border-b pb-2 border-gray-200">
                            <h2 id="accordion-collapse-heading-{{ $course['uid'] }}" class="mb-2">
                                <button type="button" class="flex items-center justify-between w-full p-4 bg-white text-gray-700 hover:bg-gray-50 aria-expanded:bg-[#468B97] aria-expanded:text-white rounded-lg" 
                                        data-accordion-target="#accordion-collapse-body-{{ $course['uid'] }}" 
                                        aria-expanded="false" 
                                        aria-controls="accordion-collapse-body-{{ $course['uid'] }}"
                                        aria-label="Buka daftar sesi untuk {{ $course['title_course'] }}">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="book-open" class="h-5 w-5" aria-hidden="true"></i>
                                        <span class="font-headline text-left">{{ $course['title_course'] }}</span>
                                        <span class="text-sm font-normal">({{ $sessionCount }} sesi)</span>
                                    </div>
                                    <div>
                                        <i data-lucide="chevron-down" class="h-5 w-5" aria-hidden="true"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="accordion-collapse-body-{{ $course['uid'] }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $course['uid'] }}">
                                @if($sessionCount === 0)
                                    <div class="text-center">
                                        <div class="p-4 text-gray-500 text-center">Belum ada Sesi untuk praktikum ini.</div>
                                        <button data-modal-target="create-session-modal-{{ $course['uid'] }}" data-modal-toggle="create-session-modal-{{ $course['uid'] }}" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
                                            <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                                            Tambah Sesi {{ $course['title_course'] }}
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center">
                                        @foreach($sessionsList as $session)
                                            @if($course['uid'] == $session['course_uid_session'])
                                                @php
                                                    $isActive = strtotime($session['deadline_session']) > time();
                                                @endphp
                                                <div class="text-left flex items-start justify-between gap-4 rounded-lg border p-4 mb-2">
                                                    <div>
                                                        <h4 class="font-semibold">{{ $session['title_session'] }}</h4>
                                                        <div class="mt-1 flex flex-col items-start gap-x-4 gap-y-1 text-sm text-gray-500 sm:flex-row sm:items-center">
                                                            <span class="flex items-center gap-1.5">
                                                                <i data-lucide="calendar-clock" class="h-4 w-4" aria-hidden="true"></i>
                                                                {{ date('H:i d-m-Y', strtotime($session['deadline_session'])) }}
                                                            </span>
                                                            <span class="flex items-center gap-1.5">
                                                                <i data-lucide="clock" class="h-4 w-4" aria-hidden="true"></i>
                                                                {{ $session['time_start_session'] . ' - ' . $session['time_end_session'] }}
                                                            </span>
                                                            <span class="flex items-center gap-1.5">
                                                                <i data-lucide="users" class="h-4 w-4" aria-hidden="true"></i>
                                                                Kuota: {{ $session['kuota_session'] }}
                                                            </span>
                                                            <span class="flex items-center gap-1.5">
                                                                <i data-lucide="check-circle" class="h-4 w-4 {{ $isActive ? 'text-green-500' : 'text-red-500' }}" aria-hidden="true"></i>
                                                                Status: {{ $isActive ? 'Aktif' : 'Kadaluarsa' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-shrink-0 gap-1">
                                                        <button class="text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" 
                                                                data-modal-target="modal-edit-session-{{ $session['uid'] }}" 
                                                                data-modal-toggle="modal-edit-session-{{ $session['uid'] }}" 
                                                                data-session-id="{{ $session['id'] }}"
                                                                aria-label="Edit sesi {{ $session['title_session'] }}">
                                                            <i data-lucide="edit" class="h-4 w-4" aria-hidden="true"></i>
                                                        </button>
                                                        <button class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" 
                                                                data-modal-target="delete-session-modal-{{ $session['uid'] }}" 
                                                                data-modal-toggle="delete-session-modal-{{ $session['uid'] }}" 
                                                                data-session-id="{{ $session['id'] }}" 
                                                                data-session-title="{{ $session['title_session'] }}"
                                                                aria-label="Hapus sesi {{ $session['title_session'] }}">
                                                            <i data-lucide="trash-2" class="h-4 w-4" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <button data-modal-target="create-session-modal-{{ $course['uid'] }}" data-modal-toggle="create-session-modal-{{ $course['uid'] }}" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
                                            <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                                            Tambah Sesi {{ $course['title_course'] }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ADD SESSION MODAL ON LIST --}}
                        <div id="create-session-modal-{{ $course['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <div class="relative bg-white rounded-lg shadow">
                                    <form action="/dashboard/superadmin/session-management/create" method="POST" id="create-session-form">
                                        @csrf
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                            <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-session-modal-{{ $course['uid'] }}" aria-label="Tutup modal">
                                                <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                                                <span class="sr-only">Tutup modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5 space-y-4">
                                            <div>
                                                <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                                                <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                                    <option disabled>Pilih praktikum</option>
                                                    <option value="{{ $course['uid'] }}">{{ $course['title_course'] }}</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Sesi</label>
                                                <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Sesi Pagi/Siang/Sore/Malam" required>
                                            </div>
                                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                                <div>
                                                    <label for="waktuMulai" class="block mb-2 text-sm font-medium text-gray-900">Waktu Mulai</label>
                                                    <input type="time" id="waktuMulai" name="timeStart" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                                </div>
                                                <div>
                                                    <label for="waktuSelesai" class="block mb-2 text-sm font-medium text-gray-900">Waktu Selesai</label>
                                                    <input type="time" id="waktuSelesai" name="timeEnd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                                <div>
                                                    <label for="kuota" class="block mb-2 text-sm font-medium text-gray-900">Kuota</label>
                                                    <input type="number" id="kuota" name="kuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: 20" min="1" required>
                                                </div>
                                                <div>
                                                    <label for="addDate" class="block mb-2 text-sm font-medium text-gray-900">Deadline Sesi</label>
                                                    <input type="datetime-local" id="addDate" name="deadline" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                            <button type="button" data-modal-hide="create-session-modal-{{ $course['uid'] }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" aria-label="Batalkan pembuatan sesi">Batal</button>
                                            <button id="submitCreateSession" data-submit-loader data-loader="#loaderCreateSession" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Simpan sesi baru">
                                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateSession" aria-hidden="true"></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @foreach($sessionsList as $session)
        {{-- EDIT SESSION MODAL --}}
        <div id="modal-edit-session-{{ $session['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <form action="/dashboard/superadmin/session-management/update/{{ $session['uid'] }}" method="POST" id="create-session-form">
                        @csrf
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-edit-session-{{ $session['uid'] }}" aria-label="Tutup modal">
                                <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
                                <span class="sr-only">Tutup modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <div>
                                <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                                <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                    @foreach($coursesList as $course)
                                        <option value="{{ $course['uid'] }}" {{ $course['uid'] == $session['course_uid_session'] ? 'selected' : '' }}>{{ $course['title_course'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Sesi</label>
                                <input value="{{ $session['title_session'] }}" type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Sesi Pagi/Siang/Sore/Malam" required>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                <div>
                                    <label for="waktuMulai" class="block mb-2 text-sm font-medium text-gray-900">Waktu Mulai</label>
                                    <input value="{{ $session['time_start_session'] }}" type="time" id="waktuMulai" name="timeStart" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                </div>
                                <div>
                                    <label for="waktuSelesai" class="block mb-2 text-sm font-medium text-gray-900">Waktu Selesai</label>
                                    <input value="{{ $session['time_end_session'] }}" type="time" id="waktuSelesai" name="timeEnd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                <div>
                                    <label for="kuota" class="block mb-2 text-sm font-medium text-gray-900">Kuota</label>
                                    <input value="{{ $session['kuota_session'] }}" type="number" id="kuota" name="kuota" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: 20" min="1" required>
                                </div>
                                <div>
                                    <label for="addDate" class="block mb-2 text-sm font-medium text-gray-900">Deadline Sesi</label>
                                    <input value="{{ $session['deadline_session'] }}" type="datetime-local" id="addDate" name="deadline" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" required>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="button" data-modal-hide="modal-edit-session-{{ $session['uid'] }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" aria-label="Batalkan update sesi">Batal</button>
                            <button id="submitUpdateSession-{{ $session['uid'] }}" data-submit-loader data-loader="#loaderUpdateSession-{{ $session['uid'] }}" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Update sesi baru">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderUpdateSession-{{ $session['uid'] }}" aria-hidden="true"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- DELETE SESSION MODAL --}}
        <div id="delete-session-modal-{{ $session['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="p-4 md:p-5 text-center">
                        <form action="/dashboard/superadmin/session-management/delete/{{ $session['uid'] }}" method="POST">
                            @csrf
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-sm font-normal text-gray-500">Apakah Anda yakin ingin menghapus <span class="font-semibold text-gray-900">{{ $session['title_session'] }}</span>? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua pendaftaran terkait.</h3>
                            <button id="submitDeleteSession-{{ $session['uid'] }}" data-submit-loader data-loader="#loaderDeleteSession-{{ $session['uid'] }}" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderDeleteSession-{{ $session['uid'] }}"></i>
                                Hapus
                            </button>
                            <button data-modal-toggle="delete-session-modal-{{ $session['uid'] }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</main>
@endsection