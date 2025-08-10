@extends('dashboard.layouts.layout')
@section('dashboard-content')
<main class="flex-1 p-4 sm:p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-bold text-[#468B97]">Manajemen Modul</h1>
            <p class="text-sm text-gray-600">Buat dan kelola modul praktikum untuk semua kelompok.</p>
        </div>
        <button data-modal-target="create-module-modal" data-modal-toggle="create-module-modal" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
            <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
            Tambah Modul
        </button>
    </div>

    {{-- ADD MODULE MODAL --}}
    <div id="create-module-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <form id="create-module-form" action="/dashboard/superadmin/module-management/create" method="POST">
                    @csrf
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-module-modal">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                            <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                <option value="" disabled>Pilih praktikum</option>
                                @foreach($coursesList as $course)
                                <option value="{{ $course['uid'] }}">{{ $course['title_course'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Modul</label>
                            <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Modul 1: Uji Kuat Tekan">
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                            <div>
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                <input type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                            </div>
                            <div>
                                <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                                <input type="text" id="location" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Lab. Uji Bahan Gedung A">
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi modul"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                        <button type="button" data-modal-hide="create-module-modal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                        <button id="submitCreateModule" data-submit-loader data-loader="#loaderCreateModule" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Simpan sesi baru">
                            <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateModule" aria-hidden="true"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:gap-3 lg:grid-cols-2">
        {{-- CALENDAR --}}
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-bold font-headline">Kalender Jadwal</h2>
                    <p class="text-muted-foreground text-sm">Klik pada tanggal untuk melihat detail atau menambah jadwal baru.</p>
                </div>
                <div class="p-6">
                    <div class="bg-white rounded-md p-7">
                        <div class="calendar-header flex items-center justify-between mb-6">
                            <button id="prevMonth" class="nav-btn text-[#468B97] text-2xl" type="button" aria-label="Bulan Sebelumnya">
                                <svg class="w-6 h-6 text-[#468B97]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14 8-4 4 4 4" />
                                </svg>
                            </button>
                            <h2 id="monthYear" class="text-2xl font-bold font-headline"></h2>
                            <button id="nextMonth" class="nav-btn text-[#468B97] text-2xl" type="button" aria-label="Bulan Berikutnya">
                                <svg class="w-6 h-6 text-[#468B97]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                                </svg>
                            </button>
                        </div>
                        <table class="calendar-table w-full border-separate border-spacing-1">
                            <thead>
                                <tr>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">S</th>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">M</th>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">T</th>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">W</th>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">T</th>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">F</th>
                                    <th class="p-3 text-sm font-semibold text-[#468B97] uppercase">S</th>
                                </tr>
                            </thead>
                            <tbody id="calendarBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- LIST MODULE --}}
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-bold font-headline">Daftar Modul per Praktikum</h2>
                    <p class="text-muted-foreground text-sm">Semua Modul yang sudah ada, dikelompokkan berdasarkan mata kuliah praktikum.</p>
                </div>
                <div class="p-6">
                    <div id="accordion-collapse" data-accordion="collapse" class="space-y-4">
                        @foreach($coursesList as $course)
                            @php
                                $moduleCount = count(array_filter($modulesList, fn($module) => $module['course_uid_module'] == $course['uid']));
                            @endphp
                            <div class="accordion-item border-b pb-2 border-gray-200">
                                <h2 id="accordion-collapse-heading-{{ $course['uid'] }}" class="mb-2">
                                    <button type="button" class="flex items-center justify-between w-full p-4 bg-white text-gray-700 hover:bg-gray-50 aria-expanded:bg-[#468B97] aria-expanded:text-white rounded-lg" 
                                            data-accordion-target="#accordion-collapse-body-{{ $course['uid'] }}" 
                                            aria-expanded="false" 
                                            aria-controls="accordion-collapse-body-{{ $course['uid'] }}">
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="book-open" class="h-5 w-5"></i>
                                            <span class="font-headline">{{ $course['title_course'] }}</span>
                                            <span class="text-sm font-normal">({{ $moduleCount }} modul)</span>
                                        </div>
                                        <div>
                                            <i data-lucide="chevron-down" class="h-5 w-5"></i>
                                        </div>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-{{ $course['uid'] }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $course['uid'] }}">
                                    @if($moduleCount === 0)
                                        <div class="text-center">
                                            <div class="p-4 text-gray-500 text-center">Belum ada modul untuk praktikum ini.</div>
                                            <button data-modal-target="create-module-modal-{{ $course['uid'] }}" data-modal-toggle="create-module-modal-{{ $course['uid'] }}" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
                                                <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                                                Tambah Modul {{ $course['title_course'] }}
                                            </button>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            @foreach($modulesList as $module)
                                                @if($module['course_uid_module'] === $course['uid'])
                                                    <div class="text-left flex items-start justify-between gap-4 rounded-lg border p-4 mb-2">
                                                        <div>
                                                            <h4 class="font-semibold">{{ $module['title_module'] }}</h4>
                                                            <div class="mt-1 flex flex-col items-start gap-x-4 gap-y-1 text-sm text-gray-500 sm:flex-row sm:items-center">
                                                                <span class="flex items-center gap-1 5">
                                                                    <i data-lucide="calendar" class="h-4 w-4"></i>
                                                                    {{ date('d-m-Y', strtotime($module['date_module'])) }}
                                                                </span>
                                                                <span class="flex items-center gap-1.5">
                                                                    <i data-lucide="map-pin" class="h-4 w-4"></i> {{ $module['location_module'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-shrink-0 gap-1">
                                                            <button class="text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" 
                                                                    data-modal-target="update-module-modal-{{ $module['uid'] }}" 
                                                                    data-modal-toggle="update-module-modal-{{ $module['uid'] }}" 
                                                                    data-schedule-id="{{ $module['id'] }}">
                                                                <i data-lucide="edit" class="h-4 w-4"></i>
                                                            </button>
                                                            <button class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" 
                                                                    data-modal-target="delete-module-modal-{{ $module['uid'] }}" 
                                                                    data-modal-toggle="delete-module-modal-{{ $module['uid'] }}" 
                                                                    data-schedule-id="{{ $module['id'] }}" 
                                                                    data-schedule-title="{{ $module['title_module'] }}">
                                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <button data-modal-target="create-module-modal-{{ $course['uid'] }}" data-modal-toggle="create-module-modal-{{ $course['uid'] }}" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
                                                <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                                                Tambah Modul {{ $course['title_course'] }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
    
                            {{-- ADD MODULE MODAL ON LIST --}}
                            <div id="create-module-modal-{{ $course['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <form action="/dashboard/superadmin/module-management/create" method="POST">
                                            @csrf
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-module-modal-{{ $course['uid'] }}">
                                                    <i data-lucide="x" class="w-4 h-4"></i>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <div class="p-4 md:p-5 space-y-4">
                                                <div>
                                                    <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                                                    <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                                        <option value="{{ $course['uid'] }}">{{ $course['title_course'] }}</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Modul</label>
                                                    <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Modul 1: Uji Kuat Tekan">
                                                </div>
                                                <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                                    <div>
                                                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                                        <input type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                                    </div>
                                                    <div>
                                                        <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                                                        <input type="text" id="location" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Lab. Uji Bahan Gedung A">
                                                    </div>
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                                    <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi modul"></textarea>
                                                </div>
                                            </div>
                                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                                <button type="button" data-modal-hide="create-module-modal-{{ $course['uid'] }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                                                <button id="submitCreateModule-{{ $course['uid'] }}" data-submit-loader data-loader="#loaderCreateModule-{{ $course['uid'] }}" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Simpan sesi baru">
                                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateModule-{{ $course['uid'] }}" aria-hidden="true"></i>
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
    </div>

    {{-- DETAIL DATE MODAL --}}
    <div id="detailDate"></div>

    <script>
        function Calendar() {
            const modulesList = @json($modulesList); // kirim seluruh modul
            const moduleDates = modulesList.map(m => m.date_module); // hanya ambil tanggalnya
        
            const form = document.getElementById('create-module-form');
            const dateInput = form.querySelector('#date');
        
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
        
            let currentDate = new Date();
            const today = new Date();
        
            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const firstDay = new Date(year, month, 1).getDay();
                const lastDate = new Date(year, month + 1, 0).getDate();
                const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;
                const todayDate = today.getDate();
        
                const prevMonthLastDate = new Date(year, month, 0).getDate();
                const totalCells = 42;
        
                document.getElementById('monthYear').textContent = `${months[month]} ${year}`;
                const tbody = document.getElementById('calendarBody');
                tbody.innerHTML = '';
                document.getElementById('detailDate').innerHTML = ''; // hapus modal lama
        
                let row = document.createElement('tr');
                let cellCount = 0;
        
                // Previous month dates
                for (let i = firstDay - 1; i >= 0; i--) {
                    const date = prevMonthLastDate - i;
                    const cell = document.createElement('td');
                    cell.textContent = date;
                    cell.classList.add('p-3', 'text-center', 'relative', 'rounded-lg', 'text-gray-400', 'opacity-50');
                    row.appendChild(cell);
                    cellCount++;
                }
        
                // Current month dates
                for (let date = 1; date <= lastDate; date++) {
                    if (row.children.length === 7) {
                        tbody.appendChild(row);
                        row = document.createElement('tr');
                    }
        
                    const cell = document.createElement('td');
                    cell.classList.add('cursor-pointer', 'p-3', 'text-center', 'relative', 'rounded-lg', 'hover:bg-gray-200/60');
        
                    const yearStr = year.toString();
                    const monthStr = (month + 1).toString().padStart(2, '0');
                    const dayStr = date.toString().padStart(2, '0');
                    const formattedDate = `${yearStr}-${monthStr}-${dayStr}`;
        
                    const spanDate = document.createElement('span');
                    spanDate.textContent = date;
                    cell.appendChild(spanDate);
        
                    // Jika ada modul di tanggal ini
                    const matchedModules = modulesList.filter(m => m.date_module === formattedDate);
                    if (matchedModules.length > 0) {
                        // Tambah dot merah
                        const dot = document.createElement('span');
                        dot.classList.add('absolute', 'top-2', 'right-2', 'w-2', 'h-2', 'bg-red-500', 'rounded-full');
                        cell.appendChild(dot);
        
                        // Buat modal ID unik per tanggal
                        const modalId = `detail-module-modal-${formattedDate}`;
                        cell.setAttribute('data-modal-target', modalId);
                        cell.setAttribute('data-modal-toggle', modalId);
        
                        // Bangun HTML modal untuk tanggal ini
                        let modalHTML = `
                            <div id="${modalId}" tabindex="-1" aria-hidden="true" 
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 
                                        justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                            <h3 class="text-xl font-semibold text-[#468B97]">
                                                Modul untuk ${dayStr}-${monthStr}-${yearStr}
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="${modalId}">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5 space-y-4">`;

                        // Loop semua modul yang cocok dengan tanggal ini
                        matchedModules.forEach(module => {
                            modalHTML += `
                                <div class="p-3 rounded border mb-2">
                                    <div>
                                        <p class="text-gray-900 font-medium">${module.title_module}</p>
                                        <p class="text-sm text-gray-500">${module.course_title}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide text-gray-600 lucide-clock h-4 w-4"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            <div class="text-gray-600">${module.date_module}</div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide text-gray-600 lucide-map-pin h-4 w-4"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                            <div class="text-gray-600">${module.location_module}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
        
                        modalHTML += `
                                        </div>
                                    </div>
                                </div>
                            </div>`;
        
                        document.getElementById('detailDate').insertAdjacentHTML('beforeend', modalHTML);
                    }
        
                    // Highlight hari ini
                    if (isCurrentMonth && date === todayDate) {
                        cell.classList.add('today');
                    }
        
                    // Set input date saat diklik
                    cell.addEventListener('click', () => {
                        dateInput.value = formattedDate;
                    });
        
                    row.appendChild(cell);
                    cellCount++;
                }
        
                // Next month dates
                for (let date = 1; cellCount < totalCells; date++) {
                    if (row.children.length === 7) {
                        tbody.appendChild(row);
                        row = document.createElement('tr');
                    }
                    const cell = document.createElement('td');
                    cell.textContent = date;
                    cell.classList.add('p-3', 'text-center', 'relative', 'rounded-lg', 'text-gray-400', 'opacity-50');
                    row.appendChild(cell);
                    cellCount++;
                }
        
                if (row.children.length > 0) {
                    tbody.appendChild(row);
                }
        
                // Re-init Flowbite supaya modal berfungsi
                if (typeof initFlowbite === 'function') {
                    initFlowbite();
                }
            }
        
            document.getElementById('prevMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
        
            document.getElementById('nextMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });
        
            renderCalendar();
        }
        
        document.addEventListener("DOMContentLoaded", Calendar);
        document.addEventListener("turbo:load", Calendar);
        document.addEventListener("turbo:frame-load", Calendar);
    </script>
    

    @foreach($modulesList as $module)
        {{-- EDIT MODULE MODAL --}}
        <div id="update-module-modal-{{ $module['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <form action="/dashboard/superadmin/module-management/update/{{ $module['uid'] }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="update-module-modal-{{ $module['uid'] }}">
                                <i data-lucide="x" class="w-4 h-4"></i>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <div>
                                <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                                <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                    <option value="" disabled>Pilih praktikum</option>
                                    @foreach($coursesList as $course)
                                    <option value="{{ $course['uid'] }}" {{ $course['uid'] == $module['course_uid_module'] ? 'selected' : '' }}>{{ $course['title_course'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Modul</label>
                                <input value="{{ $module['title_module'] }}" type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Modul 1: Uji Kuat Tekan">
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                                <div>
                                    <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                    <input value="{{ $module['date_module'] }}" type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                </div>
                                <div>
                                    <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                                    <input value="{{ $module['location_module'] }}" type="text" id="location" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Lab. Uji Bahan Gedung A">
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi modul">{{ $module['description_module'] }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="button" data-modal-hide="update-module-modal-{{ $module['uid'] }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                            <button id="submitUpdateModule-{{ $module['uid'] }}" data-submit-loader data-loader="#loaderUpdateModule-{{ $module['uid'] }}" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Simpan sesi baru">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderUpdateModule-{{ $module['uid'] }}" aria-hidden="true"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- DELETE MODULE MODAL --}}
        <div id="delete-module-modal-{{ $module['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="p-4 md:p-5 text-center">
                        <form action="/dashboard/superadmin/module-management/delete/{{ $module['uid'] }}" method="POST">
                            @csrf
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-sm font-normal text-gray-500">Apakah Anda yakin ingin menghapus <span class="font-semibold text-gray-900">{{ $module['title_module'] }}</span>? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua informasi terkait.</h3>
                            <button id="submitDeleteModule-{{ $module['uid'] }}" data-submit-loader data-loader="#loaderDeleteModule-{{ $module['uid'] }}" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderDeleteModule-{{ $module['uid'] }}"></i>
                                Hapus
                            </button>
                            <button data-modal-toggle="delete-module-modal-{{ $module['uid'] }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach





















































































    <!-- Schedule List -->
    

    {{-- @foreach($modules as $module)
        <!-- Edit Schedule Modal -->
        <div id="modal-edit-module-{{ $module['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <form id="editScheduleForm" action="/edit-schedule" method="POST">
                        @csrf
                        <input type="hidden" name="schedule_id" id="editScheduleId">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">Edit Modul</h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-edit-module-{{ $module['uid'] }}">
                                <i data-lucide="x" class="w-4 h-4"></i>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 space-y-4">
                            <div>
                                <label for="editCourseCode" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                                <div>
                                    <label for="addCourseCode" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                                    <select id="addCourseCode" name="course_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                        <option value="" disabled>Pilih praktikum</option>
                                        @foreach($coursesList as $course)
                                        <option value="{{ $course['uid'] }}">{{ $course['title_course'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="editTitle" class="block mb-2 text-sm font-medium text-gray-900">Judul Sesi/Modul</label>
                                <input type="text" id="editTitle" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Modul 1: Uji Kuat Tekan">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="editDate" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                    <input type="date" id="editDate" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                </div>
                                <div>
                                    <label for="editTime" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                                    <input type="time" id="editTime" name="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                </div>
                            </div>
                            <div>
                                <label for="editLocation" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                                <input type="text" id="editLocation" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Lab. Uji Bahan Gedung A">
                            </div>
                        </div>
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button type="button" data-modal-hide="modal-edit-module-{{ $module['uid'] }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                            <button type="submit" class="ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    @endforeach --}}

</main>
@endsection
