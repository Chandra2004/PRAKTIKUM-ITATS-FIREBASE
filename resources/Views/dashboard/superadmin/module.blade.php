@extends('dashboard.layouts.layout')
@section('dashboard-content')
<main class="flex-1 p-4 sm:p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-headline">Pengaturan Jadwal</h1>
            <p class="text-muted-foreground">Buat dan kelola jadwal praktikum untuk semua modul dan kelompok.</p>
        </div>
        <button data-modal-target="addScheduleModal" data-modal-toggle="addScheduleModal" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
            <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
            Tambah Jadwal
        </button>
    </div>

    <!-- Schedule List -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-bold font-headline">Daftar Sesi per Praktikum</h2>
                <p class="text-muted-foreground text-sm">Semua jadwal yang sudah ada, dikelompokkan berdasarkan mata kuliah praktikum.</p>
            </div>
            <div class="p-6">
                <div id="scheduleAccordion" data-accordion="collapse">
                    <?php
                    // Define event data
                    $events = [
                        '2025-07-07' => [
                            [
                                'id' => 1,
                                'course_code' => 'MEK001',
                                'course' => 'Praktikum Mekanika Tanah',
                                'title' => 'Modul 1: Uji Konsolidasi',
                                'date' => '2025-07-07',
                                'time' => '13:00',
                                'location' => 'Lab. Mekanika Tanah'
                            ]
                        ],
                        '2025-07-15' => [
                            [
                                'id' => 2,
                                'course_code' => 'GEO001',
                                'course' => 'Praktikum Geoteknik',
                                'title' => 'Modul 2: Analisis Tanah',
                                'date' => '2025-07-15',
                                'time' => '09:00',
                                'location' => 'Lab. Geoteknik'
                            ],
                            [
                                'id' => 6,
                                'course_code' => 'PEM001',
                                'course' => 'Praktikum Pemrograman Dasar',
                                'title' => 'Modul 1: Pengenalan Python',
                                'date' => '2025-07-15',
                                'time' => '08:00',
                                'location' => 'Lab. Komputer A'
                            ]
                        ],
                        '2025-07-10' => [
                            [
                                'id' => 3,
                                'course_code' => 'STR001',
                                'course' => 'Praktikum Struktur',
                                'title' => 'Modul 3: Uji Kekuatan',
                                'date' => '2025-07-10',
                                'time' => '14:00',
                                'location' => 'Lab. Struktur'
                            ]
                        ],
                        '2025-07-22' => [
                            [
                                'id' => 4,
                                'course_code' => 'MAT001',
                                'course' => 'Praktikum Material',
                                'title' => 'Modul 4: Pengujian Material',
                                'date' => '2025-07-22',
                                'time' => '10:00',
                                'location' => 'Lab. Material'
                            ]
                        ],
                        '2025-07-28' => [
                            [
                                'id' => 5,
                                'course_code' => 'GEO001',
                                'course' => 'Praktikum Geoteknik',
                                'title' => 'Modul 5: Simulasi Geoteknik',
                                'date' => '2025-07-28',
                                'time' => '11:00',
                                'location' => 'Lab. Geoteknik'
                            ]
                        ]
                    ];

                    // Group events by course_code
                    $courses = [];
                    foreach ($events as $date => $eventList) {
                        foreach ($eventList as $event) {
                            $courses[$event['course_code']][] = $event;
                        }
                    }

                    // Render accordion for each course
                    foreach ($courses as $courseCode => $courseEvents) {
                        $courseName = $courseEvents[0]['course'];
                        $sessionCount = count($courseEvents);
                    ?>
                    <div class="accordion-item border-b border-gray-200">
                        <h2 class="accordion-header" id="heading-<?php echo htmlspecialchars($courseCode); ?>">
                            <button class="flex justify-between rounded-md w-full p-4 bg-white text-gray-700 hover:bg-gray-50 aria-expanded:bg-[#468B97] aria-expanded:text-white" type="button" data-accordion-target="#collapse-<?php echo htmlspecialchars($courseCode); ?>" aria-expanded="false" aria-controls="collapse-<?php echo htmlspecialchars($courseCode); ?>">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="book-open" class="h-5 w-5"></i>
                                    <span class="font-headline"><?php echo htmlspecialchars($courseName); ?></span>
                                    <span class="text-sm font-normal">(<?php echo $sessionCount; ?> sesi)</span>
                                </div>
                                <div>
                                    <i data-lucide="chevron-down" class="h-5 w-5"></i>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo htmlspecialchars($courseCode); ?>" class="accordion-collapse hidden" aria-labelledby="heading-<?php echo htmlspecialchars($courseCode); ?>" data-accordion="collapse">
                            <div class="accordion-body py-4 px-5 space-y-3 pl-4">
                                <?php foreach ($courseEvents as $event) {
                                        $dateObj = new DateTime($event['date']);
                                        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        $formattedDate = sprintf('%s, %d %s %d', $days[$dateObj->format('w')], $dateObj->format('j'), $months[$dateObj->format('n') - 1], $dateObj->format('Y'));
                                    ?>
                                <div class="flex items-start justify-between gap-4 rounded-lg border p-4">
                                    <div>
                                        <h4 class="font-semibold"><?php echo htmlspecialchars($event['title']); ?></h4>
                                        <div class="mt-1 flex flex-col items-start gap-x-4 gap-y-1 text-sm text-gray-500 sm:flex-row sm:items-center">
                                            <span class="font-medium text-gray-900"><?php echo htmlspecialchars($formattedDate); ?></span>
                                            <span class="flex items-center gap-1.5">
                                                <i data-lucide="clock" class="h-4 w-4"></i> <?php echo htmlspecialchars($event['time']); ?>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i data-lucide="map-pin" class="h-4 w-4"></i> <?php echo htmlspecialchars($event['location']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-shrink-0 gap-1">
                                        <button class="text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" data-modal-target="editScheduleModal" data-modal-toggle="editScheduleModal" data-schedule-id="<?php echo $event['id']; ?>">
                                            <i data-lucide="edit" class="h-4 w-4"></i>
                                        </button>
                                        <button class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" data-modal-target="deleteModal" data-modal-toggle="deleteModal" data-schedule-id="<?php echo $event['id']; ?>" data-schedule-title="<?php echo htmlspecialchars($event['title']); ?>">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

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
                        <h2 id="monthYear" class="text-2xl font-bold"></h2>
                        <button id="nextMonth" class="nav-btn text-[#468B97] text-2xl" type="button" aria-label="Bulan Berikutnya">
                            <svg class="w-6 h-6 text-[#468B97]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4" />
                            </svg>
                        </button>
                    </div>
                    <table class="calendar-table w-full">
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

                <!-- Event Modal -->
                <div id="eventModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-60 flex items-center justify-center">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <div class="flex items-start justify-between p-4 border-b rounded-t">
                                <h3 id="modalTitle" class="text-xl font-semibold text-gray-900 font-headline"></h3>
                                <button type="button" id="closeModalX" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="eventModal">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="sr-only">Tutup modal</span>
                                </button>
                            </div>
                            <div class="p-6 grid gap-4">
                                <p class="text-gray-600">Berikut adalah semua sesi praktikum yang dijadwalkan pada tanggal ini.</p>
                                <div id="modalEventList" class="space-y-4">
                                    <!-- Events will be dynamically inserted here -->
                                </div>
                                <button data-modal-target="addScheduleModal" data-modal-toggle="addScheduleModal" type="button" class="w-full inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
                                    <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
                                    Tambah Jadwal
                                </button>
                                <button type="button" id="closeModalButton" class="w-full text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900" data-modal-hide="eventModal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add Schedule Modal -->
<div id="addScheduleModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <form id="addScheduleForm" action="/add-schedule" method="POST">
                @csrf
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Sesi Baru</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="addScheduleModal">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <label for="addCourseCode" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                        <select id="addCourseCode" name="course_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                            <option value="">Pilih praktikum</option>
                            <option value="PEM001">Praktikum Pemrograman Dasar</option>
                            <option value="PEM002">Praktikum Pemrograman Lanjut</option>
                            <option value="JAR001">Praktikum Jaringan Komputer</option>
                            <option value="MEK001">Praktikum Mekanika Tanah</option>
                            <option value="GEO001">Praktikum Geoteknik</option>
                            <option value="STR001">Praktikum Struktur</option>
                            <option value="MAT001">Praktikum Material</option>
                        </select>
                    </div>
                    <div>
                        <label for="addTitle" class="block mb-2 text-sm font-medium text-gray-900">Judul Sesi/Modul</label>
                        <input type="text" id="addTitle" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Modul 1: Uji Kuat Tekan">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="addDate" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                            <input type="date" id="addDate" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                        </div>
                        <div>
                            <label for="addTime" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                            <input type="time" id="addTime" name="time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                        </div>
                    </div>
                    <div>
                        <label for="addLocation" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                        <input type="text" id="addLocation" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Lab. Uji Bahan Gedung A">
                    </div>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button type="button" data-modal-hide="addScheduleModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                    <button type="submit" class="ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div id="editScheduleModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <form id="editScheduleForm" action="/edit-schedule" method="POST">
                @csrf
                <input type="hidden" name="schedule_id" id="editScheduleId">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Sesi Jadwal</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="editScheduleModal">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <label for="editCourseCode" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                        <select id="editCourseCode" name="course_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                            <option value="PEM001">Praktikum Pemrograman Dasar</option>
                            <option value="PEM002">Praktikum Pemrograman Lanjut</option>
                            <option value="JAR001">Praktikum Jaringan Komputer</option>
                            <option value="MEK001">Praktikum Mekanika Tanah</option>
                            <option value="GEO001">Praktikum Geoteknik</option>
                            <option value="STR001">Praktikum Struktur</option>
                            <option value="MAT001">Praktikum Material</option>
                        </select>
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
                    <button type="button" data-modal-hide="editScheduleModal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                    <button type="submit" class="ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <form id="deleteScheduleForm" action="/delete-schedule" method="POST">
                @csrf
                <input type="hidden" name="schedule_id" id="deleteScheduleId">
                <div class="p-4 md:p-5 text-center">
                    <i data-lucide="alert-triangle" class="mx-auto mb-4 h-12 w-12 text-red-500"></i>
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah Anda yakin ingin menghapus jadwal <span id="scheduleToDeleteTitle" class="font-semibold"></span>? Tindakan ini tidak dapat dibatalkan.</h3>
                    <div class="flex justify-center space-x-4">
                        <button data-modal-hide="deleteModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'
        , 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const shortDays = ['Mi', 'Se', 'Se', 'Ra', 'Ka', 'Ju', 'Sa'];

    let currentDate = new Date();
    const today = new Date();

    // Event data from PHP
    const events = <?php echo json_encode($events); ?>;

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        const isCurrentMonth = today.getFullYear() === year && today.getMonth() === month;
        const todayDate = today.getDate();

        // Calculate previous and next month dates
        const prevMonthLastDate = new Date(year, month, 0).getDate();
        const totalCells = 42; // 6 rows * 7 columns

        document.getElementById('monthYear').textContent = `${months[month]} ${year}`;
        const tbody = document.getElementById('calendarBody');
        tbody.innerHTML = '';

        let row = document.createElement('tr');
        let cellCount = 0;

        // Previous month dates
        for (let i = firstDay - 1; i >= 0; i--) {
            const date = prevMonthLastDate - i;
            const dateStr = `${month === 0 ? year - 1 : year}-${String(month === 0 ? 12 : month).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
            const cell = document.createElement('td');
            cell.textContent = date;
            cell.classList.add('p-3', 'text-center', 'relative', 'cursor-pointer', 'rounded-lg', 'hover:bg-gray-200/60', 'opacity-30');
            if (events[dateStr]) {
                cell.classList.add('event');
                const badge = document.createElement('div');
                badge.classList.add('absolute', 'top-2', 'right-2', 'w-2', 'h-2', 'bg-red-500', 'rounded-full');
                cell.appendChild(badge);
            }
            cell.onclick = () => showModal(dateStr, date);
            row.appendChild(cell);
            cellCount++;
        }

        // Current month dates
        for (let date = 1; date <= lastDate; date++) {
            if (row.children.length === 7) {
                tbody.appendChild(row);
                row = document.createElement('tr');
            }
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
            const cell = document.createElement('td');
            cell.textContent = date;
            cell.classList.add('p-3', 'text-center', 'relative', 'cursor-pointer', 'rounded-lg', 'hover:bg-gray-200/60');
            if (events[dateStr]) {
                cell.classList.add('event');
                const badge = document.createElement('div');
                badge.classList.add('absolute', 'top-2', 'right-2', 'w-2', 'h-2', 'bg-red-500', 'rounded-full');
                cell.appendChild(badge);
            }
            if (isCurrentMonth && date === todayDate) {
                cell.classList.add('today', 'bg-[#468B97]', 'text-white', 'font-semibold', 'hover:bg-[#468B97]');
            }
            cell.onclick = () => showModal(dateStr, date);
            row.appendChild(cell);
            cellCount++;
        }

        // Next month dates
        for (let date = 1; cellCount < totalCells; date++) {
            if (row.children.length === 7) {
                tbody.appendChild(row);
                row = document.createElement('tr');
            }
            const dateStr = `${month === 11 ? year + 1 : year}-${String(month === 11 ? 1 : month + 2).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
            const cell = document.createElement('td');
            cell.textContent = date;
            cell.classList.add('p-3', 'text-center', 'relative', 'cursor-pointer', 'rounded-lg', 'hover:bg-gray-200/60', 'opacity-30');
            if (events[dateStr]) {
                cell.classList.add('event');
                const badge = document.createElement('div');
                badge.classList.add('absolute', 'top-2', 'right-2', 'w-2', 'h-2', 'bg-red-500', 'rounded-full');
                cell.appendChild(badge);
            }
            cell.onclick = () => showModal(dateStr, date);
            row.appendChild(cell);
            cellCount++;
        }

        tbody.appendChild(row);
    }

    function showModal(dateStr, date) {
        const modalTitle = document.getElementById('modalTitle');
        const modalEventList = document.getElementById('modalEventList');
        const modalDate = new Date(dateStr);
        modalTitle.textContent = `Jadwal untuk ${days[modalDate.getDay()]}, ${date} ${months[modalDate.getMonth()]} ${modalDate.getFullYear()}`;
        const eventData = events[dateStr] || [];
        modalEventList.innerHTML = eventData.map(event => `
            <div class="flex justify-between p-4 rounded-md border border-[#468B97]/10 relative">
                <div class="w-full pr-10">
                    <div>
                        <p class="text-gray-900 font-medium">${event.title}</p>
                        <p class="text-sm text-gray-500">${event.course}</p>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide text-gray-600 lucide-clock h-4 w-4"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <div class="text-gray-600">${event.time}</div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide text-gray-600 lucide-map-pin h-4 w-4"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <div class="text-gray-600">${event.location}</div>
                        </div>
                    </div>
                </div>
                <button type="button" class="absolute top-2 right-2 flex items-center gap-1 py-2 px-4 rounded-md border border-[#468B97]/10 hover:bg-[#FEE500]" data-modal-target="editScheduleModal" data-modal-toggle="editScheduleModal" data-schedule-id="${event.id}">
                    Edit
                </button>
            </div>
    `).join('');
        const modal = new Modal(document.getElementById('eventModal'));
        modal.show();
    }

    function closeModal() {
        const modal = new Modal(document.getElementById('eventModal'));
        modal.hide();
    }

    // Handle edit and delete button clicks
    document.querySelectorAll('[data-modal-target="editScheduleModal"]').forEach(button => {
        button.addEventListener('click', () => {
            const scheduleId = button.getAttribute('data-schedule-id');
            document.getElementById('editScheduleId').value = scheduleId;
            // Populate form fields
            for (const dateStr in events) {
                const event = events[dateStr].find(e => e.id == scheduleId);
                if (event) {
                    document.getElementById('editCourseCode').value = event.course_code;
                    document.getElementById('editTitle').value = event.title;
                    document.getElementById('editDate').value = event.date;
                    document.getElementById('editTime').value = event.time;
                    document.getElementById('editLocation').value = event.location;
                    break;
                }
            }
        });
    });

    document.querySelectorAll('[data-modal-target="deleteModal"]').forEach(button => {
        button.addEventListener('click', () => {
            const scheduleId = button.getAttribute('data-schedule-id');
            const scheduleTitle = button.getAttribute('data-schedule-title');
            document.getElementById('deleteScheduleId').value = scheduleId;
            document.getElementById('scheduleToDeleteTitle').textContent = scheduleTitle;
        });
    });

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    document.getElementById('closeModalX').addEventListener('click', closeModal);
    document.getElementById('closeModalButton').addEventListener('click', closeModal);

    document.getElementById('eventModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('eventModal')) {
            closeModal();
        }
    });

    renderCalendar();

</script>
@endsection
