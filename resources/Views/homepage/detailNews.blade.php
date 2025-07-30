@extends('homepage.layout.layoutHome')
@section('content')
<div class="container mx-auto max-w-4xl px-4 md:px-6 py-12">
    <a href="/news" class="mb-8 inline-flex items-center gap-2 border border-gray-800 text-gray-800 px-4 py-2 rounded-md hover:bg-[#468B97] hover:border-[#468B97] hover:text-white transition-colors">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Beranda
    </a>

    <article>
        <div class="space-y-4">
            <h1 class="font-headline text-4xl md:text-5xl font-bold">
                {{ $item['title'] }}
            </h1>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-muted-foreground">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="h-4 w-4"></i>
                    <time datetime="2025-07-06">{{ $item['date'] }}</time>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="tag" class="h-4 w-4"></i>
                    <span class="bg-gray-300 text-[#468B97] text-sm font-medium px-2.5 py-0.5 rounded">{{ $item['category'] }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-6 prose prose-lg dark:prose-invert max-w-none">
                <p class="lead font-semibold text-gray-800">
                    Indonesia terus mempercepat pengembangan teknologi kecerdasan buatan untuk berbagai sektor.
                </p>
                <div class="mt-6 whitespace-pre-line text-gray-700">
                    {{ $item['excerpt'] }}
                </div>
            </div>
        </div>
    </article>
</div>
@endsection