@extends('dashboard.layouts.layout')
@section('dashboard-content')
    <main class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="font-headline text-2xl font-bold text-[#468B97]">Pemilihan Praktikum & Sesi</h1>
                <p class="text-sm text-gray-600">Pilih praktikum dan sesi waktu yang akan Anda ikuti semester ini. Anda dapat memilih lebih dari satu praktikum dengan jadwal sesi yang tidak bentrok.</p>
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {{-- 
            <div class="bg-white rounded-lg shadow-sm border-2 flex flex-col transition-all hover:border-[#468B97]">
                <div class="p-6 flex items-center justify-between">
                    <h2 class="font-['Space_Grotesk'] text-xl font-semibold">Praktikum Mekanika Tanah</h2>
                    <i data-lucide="book-copy" class="h-6 w-6 text-[#6B7280]"></i>
                </div>
                <div class="px-6 pb-6 flex-1 space-y-2">
                    <p class="text-[#6B7280] text-sm line-clamp-3">Praktikum Mekanika Tanah bertujuan untuk memperkenalkan konsep dasar sifat-sifat tanah yang relevan dalam desain fondasi, dinding penahan, dan struktur geoteknik lainnya. Peserta akan melakukan pengujian laboratorium untuk menentukan parameter tanah seperti kepadatan, kadar air, distribusi ukuran butir, dan kekuatan geser. Praktikum ini juga mencakup analisis stabilitas lereng dan kapasitas dukung tanah. Dengan pendekatan praktis, peserta akan belajar menerapkan teori mekanika tanah dalam studi kasus nyata, seperti analisis fondasi dangkal dan dalam, serta memahami pentingnya pengujian tanah untuk mencegah kegagalan struktur.</p>
                    <div class="flex flex-col lg:flex-row gap-2 items-start justify-start">
                        <div class="gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium bg-gray-100 border border-gray-400">
                            <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                            <span>3 Sesi Tersedia</span>
                        </div>
                        <div class="gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium border bg-[#DBEAFE] text-[#1E40AF] border-[#BFDBFE]">
                            <i data-lucide="clock-12" class="h-4 w-4 animate-spin"></i>
                            <span>Menunggu Persetujuan</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6 flex flex-col gap-2">
                    <div class="flex items-center justify-center gap-2 bg-[#468B97]/50 text-white px-4 py-2 rounded-lg">
                        <i data-lucide="clock-12" class="h-4 w-4 animate-spin"></i>
                        Menunggu Persetujuan
                    </div>
                    <button class="cursor-pointer flex items-center justify-center gap-2 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        <i data-lucide="x-circle" class="h-4 w-4"></i>
                        Batalkan Pendaftaran
                    </button>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border-2 flex flex-col transition-all hover:border-[#468B97]">
                <div class="p-6 flex items-center justify-between">
                    <h2 class="font-['Space_Grotesk'] text-xl font-semibold">Praktikum Mekanika Tanah</h2>
                    <i data-lucide="book-copy" class="h-6 w-6 text-[#6B7280]"></i>
                </div>
                <div class="px-6 pb-6 flex-1 space-y-2">
                    <p class="text-[#6B7280] text-sm line-clamp-3">Praktikum Mekanika Tanah bertujuan untuk memperkenalkan konsep dasar sifat-sifat tanah yang relevan dalam desain fondasi, dinding penahan, dan struktur geoteknik lainnya. Peserta akan melakukan pengujian laboratorium untuk menentukan parameter tanah seperti kepadatan, kadar air, distribusi ukuran butir, dan kekuatan geser. Praktikum ini juga mencakup analisis stabilitas lereng dan kapasitas dukung tanah. Dengan pendekatan praktis, peserta akan belajar menerapkan teori mekanika tanah dalam studi kasus nyata, seperti analisis fondasi dangkal dan dalam, serta memahami pentingnya pengujian tanah untuk mencegah kegagalan struktur.</p>
                    <div class="flex gap-2 items-start justify-start">
                        <div class="gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium bg-gray-100 border border-gray-400">
                            <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                            <span>3 Sesi Tersedia</span>
                        </div>
                        <div class="gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium border bg-[#DCFCE7] text-[#166534] border-[#BBF7D0]">
                            <i data-lucide="check" class="h-4 w-4"></i>
                            <span>Disetujui</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6 flex flex-col gap-2">
                    <div class="flex items-center justify-center gap-2 bg-[#166534]/80 text-white px-4 py-2 rounded-lg">
                        <i data-lucide="check-circle" class="h-4 w-4"></i>
                        <span>Telah Disetujui</span>
                    </div>
                    <p class="text-xs text-[#6B7280] text-center px-2">Pendaftaran yang telah disetujui tidak dapat dibatalkan. Hubungi SuperAdmin / Asisten untuk bantuan.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border-2 flex flex-col transition-all hover:border-[#468B97]">
                <div class="p-6 flex items-center justify-between">
                    <h2 class="font-['Space_Grotesk'] text-xl font-semibold">Praktikum Mekanika Tanah</h2>
                    <i data-lucide="book-copy" class="h-6 w-6 text-[#6B7280]"></i>
                </div>
                <div class="px-6 pb-6 flex-1 space-y-2">
                    <p class="text-[#6B7280] text-sm line-clamp-3">Praktikum Mekanika Tanah bertujuan untuk memperkenalkan konsep dasar sifat-sifat tanah yang relevan dalam desain fondasi, dinding penahan, dan struktur geoteknik lainnya. Peserta akan melakukan pengujian laboratorium untuk menentukan parameter tanah seperti kepadatan, kadar air, distribusi ukuran butir, dan kekuatan geser. Praktikum ini juga mencakup analisis stabilitas lereng dan kapasitas dukung tanah. Dengan pendekatan praktis, peserta akan belajar menerapkan teori mekanika tanah dalam studi kasus nyata, seperti analisis fondasi dangkal dan dalam, serta memahami pentingnya pengujian tanah untuk mencegah kegagalan struktur.</p>
                    <div class="flex gap-2 items-start justify-start">
                        <div class="gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium bg-gray-100 border border-gray-400">
                            <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                            <span>3 Sesi Tersedia</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 pb-6 flex flex-col gap-2">
                    <button type="button" data-modal-target="detail-course-modal" data-modal-toggle="detail-course-modal" class="flex items-center justify-center gap-2 bg-[#468B97] text-white px-4 py-2 rounded-lg">
                        <i data-lucide="send" class="h-4 w-4"></i>
                        <span>Lihat Sesi & Daftar</span>
                    </button>
                </div>
            </div>
            --}}
            
            @foreach($coursesList as $course)
                <div class="bg-white rounded-lg shadow-sm border-2 flex flex-col transition-all hover:border-[#468B97]">
                    <div class="p-6 flex items-center justify-between">
                        <h2 class="font-['Space_Grotesk'] text-xl font-semibold">{{ $course['title_course'] }}</h2>
                        <i data-lucide="book-copy" class="h-6 w-6 text-[#6B7280]"></i>
                    </div>
                    <div class="px-6 pb-6 flex-1 space-y-2">
                        <div class="course-description-container">
                            <p class="course-description text-[#6B7280] text-sm line-clamp-3">
                                {{ $course['description_course'] }}
                            </p>
                            <button class="toggle-button text-[#468B97] text-sm hover:underline focus:outline-none">
                                Read more
                            </button>
                        </div>
                          
                        <div class="flex gap-2 items-start justify-start">
                            <div class="gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium bg-gray-100 border border-gray-400">
                                <i data-lucide="calendar-clock" class="h-4 w-4"></i>
                                @php
                                    $sessionCount = count(array_filter($sessionsList, fn($session) => $session['course_uid_session'] == $course['uid']));
                                @endphp
                                <span>{{ $sessionCount }} Sesi Tersedia</span>
                            </div>
                            <div data-modal-target="detail-course-modal-{{ $course['uid'] }}" data-modal-toggle="detail-course-modal-{{ $course['uid'] }}" class="cursor-pointer gap-2 flex items-center justify-center px-3 py-1 rounded text-sm font-medium bg-gray-100 border border-gray-400">
                                <i data-lucide="external-link" class="h-4 w-4"></i>
                                @php
                                    $moduleCount = count(array_filter($modulesList, fn($module) => $module['course_uid_module'] == $course['uid']));
                                @endphp
                                <span>({{ $moduleCount }}) Lihat Modul</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <button type="button" data-modal-target="form-session-modal-{{ $course['uid'] }}" data-modal-toggle="form-session-modal-{{ $course['uid'] }}" class="flex items-center justify-center gap-2 bg-[#468B97] text-white px-4 py-2 rounded-lg">
                                <i data-lucide="send" class="h-4 w-4"></i>
                                <span>Lihat Sesi & Daftar</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
    {{-- 
    <div id="detail-course-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                    <h3 class="text-lg font-semibold text-[#468B97]" id="modalTitle">Pilih Sesi untuk Biologi Dasar</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="detail-course-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <p class="text-[#6B7280] text-sm mb-2">Pilih salah satu jadwal sesi di bawah ini untuk mendaftar. Pilihan sesi dengan waktu yang sama dengan praktikum lain tidak akan tersedia.</p>
                    <form action="">
                        @csrf
                        <div class="flex flex-col gap-2">
                            <label class="flex flex-col gap-2 rounded-lg border p-4 transition-all cursor-pointer hover:border-[#468B97] hover:bg-[#468B97]/25">
                                <div class="flex items-start gap-4">
                                    <input type="radio" name="session" value="session1" class="mt-1"/>
                                    <div class="flex-1">
                                        <p class="font-semibold">Sesi 1: Pengenalan Biologi Sel</p>
                                        <div class="text-sm text-[#6B7280] flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-x-4 gap-y-1 mt-1">
                                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                            <span class="flex items-center gap-1.5"><i data-lucide="users" class="h-4 w-4"></i> Kuota: 15 / 20</span>
                                            <span class="flex items-center gap-1.5 text-xs"><i data-lucide="clock" class="h-3 w-3"></i> Batas: 10/08/2025 23:59 WIB</span>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-not-allowed flex flex-col gap-2 rounded-lg border p-4 transition-all">
                                <div class="p-2 border border-red-600 bg-red-500 text-white rounded text-xs flex items-center gap-2">
                                    <i data-lucide="info" class="h-4 w-4"></i>
                                    <span>Kuota Penuh</span>
                                </div>
                                <div class="flex items-start gap-4 opacity-25">
                                    <input type="radio" name="session" value="session1" class="mt-1" disabled/>
                                    <div class="flex-1">
                                        <p class="font-semibold">Sesi 2: Genetika Dasar</p>
                                        <div class="text-sm text-[#6B7280] flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-x-4 gap-y-1 mt-1">
                                            <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                            <span class="flex items-center gap-1.5"><i data-lucide="users" class="h-4 w-4"></i> Kuota: 20 / 20</span>
                                            <span class="flex items-center gap-1.5 text-xs"><i data-lucide="clock" class="h-3 w-3"></i> Batas: 10/08/2025 23:59 WIB</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <button type="button" class="bg-[#468B97] text-white hover:bg-[#3a6f7a] flex items-center justify-center gap-2 w-full font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <i data-lucide="send" class="h-4 w-4"></i>
                                <span>Daftar ke Sesi Ini</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    --}}
    
    <script>
        document.querySelectorAll('.toggle-button').forEach(button => {
            button.addEventListener('click', () => {
                const container = button.closest('.course-description-container');
                const description = container.querySelector('.course-description');
        
                description.classList.toggle('line-clamp-3');
                button.textContent = description.classList.contains('line-clamp-3') ? 'Read more' : 'Read less';
            });
        });
    </script>

    @foreach ($coursesList as $course)
        <div id="detail-course-modal-{{ $course['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-lg max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                        <h3 class="text-lg font-semibold text-[#468B97]" id="modalTitle">Detail Modul: {{ $course['title_course'] }}</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="detail-course-modal-{{ $course['uid'] }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-col gap-2">
                            @php
                                $moduleCount = count(array_filter($modulesList, fn($module) => $module['course_uid_module'] == $course['uid']));
                            @endphp
                            @if($moduleCount > 0)
                                @foreach ($modulesList as $module)
                                    @if($module['course_uid_module'] == $course['uid'])
                                        <div class="text-left flex items-start justify-between gap-4 rounded-lg border p-4">
                                            <div>
                                                <h4 class="font-semibold">{{ $module['title_module'] }}</h4>
                                                <div class="text-sm text-gray-500">
                                                    <span class="flex items-center gap-1 5">
                                                        <i data-lucide="calendar" class="h-4 w-4"></i>
                                                        {{ date('d-m-Y', strtotime($module['date_module'])) }}
                                                    </span>
                                                    <span class="flex items-center gap-1.5">
                                                        <i data-lucide="map-pin" class="h-4 w-4"></i> {{ $module['location_module'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-sm text-gray-500 italic px-4 py-2 text-center">
                                    Tidak ada modul di praktikum ini.
                                </div>                        
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <div id="form-session-modal-{{ $course['uid'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                        <h3 class="text-lg font-semibold text-[#468B97]" id="modalTitle">Pilih Sesi untuk Biologi Dasar</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="form-session-modal-{{ $course['uid'] }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4">
                        <p class="text-[#6B7280] text-sm mb-2">Pilih salah satu jadwal sesi di bawah ini untuk mendaftar. Pilihan sesi dengan waktu yang sama dengan praktikum lain tidak akan tersedia.</p>
                        <form action="">
                            @csrf
                            <div class="flex flex-col gap-2">
                                {{-- 
                                <label class="flex flex-col gap-2 rounded-lg border p-4 transition-all cursor-pointer hover:border-[#468B97] hover:bg-[#468B97]/25">
                                    <div class="flex items-start gap-4">
                                        <input type="radio" name="session" value="session1" class="mt-1"/>
                                        <div class="flex-1">
                                            <p class="font-semibold">Sesi 1: Pengenalan Biologi Sel</p>
                                            <div class="text-sm text-[#6B7280] flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-x-4 gap-y-1 mt-1">
                                                <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                                <span class="flex items-center gap-1.5"><i data-lucide="users" class="h-4 w-4"></i> Kuota: 15 / 20</span>
                                                <span class="flex items-center gap-1.5 text-xs"><i data-lucide="clock" class="h-3 w-3"></i> Batas: 10/08/2025 23:59 WIB</span>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="cursor-not-allowed flex flex-col gap-2 rounded-lg border p-4 transition-all">
                                    <div class="p-2 border border-red-600 bg-red-500 text-white rounded text-xs flex items-center gap-2">
                                        <i data-lucide="info" class="h-4 w-4"></i>
                                        <span>Kuota Penuh</span>
                                    </div>
                                    <div class="flex items-start gap-4 opacity-25">
                                        <input type="radio" name="session" value="session1" class="mt-1" disabled/>
                                        <div class="flex-1">
                                            <p class="font-semibold">Sesi 2: Genetika Dasar</p>
                                            <div class="text-sm text-[#6B7280] flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-x-4 gap-y-1 mt-1">
                                                <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> 08:00 - 10:00</span>
                                                <span class="flex items-center gap-1.5"><i data-lucide="users" class="h-4 w-4"></i> Kuota: 20 / 20</span>
                                                <span class="flex items-center gap-1.5 text-xs"><i data-lucide="clock" class="h-3 w-3"></i> Batas: 10/08/2025 23:59 WIB</span>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                 --}}

                                @foreach ($sessionsList as $session)
                                    @if($session['course_uid_session'] == $course['uid'])
                                        <label class="flex flex-col gap-2 rounded-lg border p-4 transition-all cursor-pointer hover:border-[#468B97] hover:bg-[#468B97]/25">
                                            <div class="flex items-start gap-4">
                                                <input type="radio" name="session" value="session1" class="mt-1"/>
                                                <div class="flex-1">
                                                    <p class="font-semibold">{{ $session['title_session'] }}</p>
                                                    <div class="text-sm text-[#6B7280] flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-x-4 gap-y-1 mt-1">
                                                        <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i>{{ $session['time_start_session'] }} - {{ $session['time_end_session'] }}</span>
                                                        <span class="flex items-center gap-1.5"><i data-lucide="users" class="h-4 w-4"></i> Kuota: {{ $session['kuota_session'] }}</span>
                                                        <span class="flex items-center gap-1.5 text-xs"><i data-lucide="clock" class="h-3 w-3"></i> Batas: {{ date('H:i d-m-Y', strtotime($session['deadline_session'])) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endif
                                @endforeach
                                <button type="button" class="bg-[#468B97] text-white hover:bg-[#3a6f7a] flex items-center justify-center gap-2 w-full font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    <i data-lucide="send" class="h-4 w-4"></i>
                                    <span>Daftar ke Sesi Ini</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    @endforeach
@endsection