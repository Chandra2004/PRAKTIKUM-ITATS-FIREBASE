@extends('homepage.layout.layoutHome')

@section('content')
<main class="flex-1 max">
    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 md:py-32">
        <div class="text-center mb-12">
            <h2 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight">Berita & Pengumuman</h2>
            <p class="mt-4 mx-auto text-base sm:text-lg text-gray-600">
                Ikuti terus informasi dan pembaruan terkini seputar kegiatan praktikum.
            </p>
        </div>

        <div class="grid gap-4 mt-8 md:p-8 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($news as $item)
            <article class="flex flex-col overflow-hidden bg-white border border-[#468B97]/50 rounded-xl shadow-soft transition-transform hover:scale-[1.02] hover:shadow-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $item['category'] }}</span>
                        <time datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                    </div>
                    <h3 class="font-headline text-xl pt-3 font-semibold">{{ $item['title'] }}</h3>
                </div>
                <div class="px-6 pb-6 flex-1">
                    <p class="text-gray-600">{{ $item['excerpt'] }}</p>
                </div>
                <div class="px-6 pb-6">
                    <a href="/news/{{ $item['category'] }}/{{ $item['id'] }}/{{ $item['slug'] }}" class="text-[#468B97] hover:underline flex items-center text-sm font-medium transition-colors" aria-label="Baca selengkapnya tentang {{ $item['title'] }}">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#468B97" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            <div class="flex flex-col items-center">
                <span class="text-sm text-gray-700">
                    Showing <span class="font-semibold text-gray-900">{{ $currentPage }}</span> to <span class="font-semibold text-gray-900">{{ $totalPages }}</span> of <span class="font-semibold text-gray-900">{{ $totalItems }}</span> Entries
                </span>
                <div class="inline-flex mt-2 xs:mt-0">
                    <a href="{{ url('/news/page/' . ($currentPage - 1)) }}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-gray-100 rounded-s hover:bg-[#468B97] hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                        </svg>
                        Prev
                    </a>
                    <a href="{{ url('/news/page/' . ($currentPage + 1)) }}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-gray-100 rounded-e hover:bg-[#468B97] hover:text-white">
                        Next
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection