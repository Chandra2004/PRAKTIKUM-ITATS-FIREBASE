@extends('dashboard.layouts.layout')

@section('dashboard-content')
<main class="p-4 sm:p-6">
    <!-- Page Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold text-[#468B97] font-space-grotesk">Verifikasi Pembayaran</h1>
        <p class="mt-1 text-sm text-gray-600">Tinjau, setujui, atau tolak bukti pembayaran yang diunggah oleh praktikan.</p>
    </div>

    <!-- Tabs -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6" data-tabs-toggle="#payment-tabs" role="tablist">
            <ul class="flex flex-wrap gap-4 text-sm font-medium text-center">
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 rounded-md bg-white text-[#468B97] border border-[#468B97] font-space-grotesk" id="pending-tab" data-tabs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                        Menunggu Persetujuan
                        <span class="ml-2 text-[#FEE500]">3</span>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 rounded-md bg-white text-[#468B97] border border-[#468B97] font-space-grotesk" id="approved-tab" data-tabs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">
                        Riwayat Disetujui   
                        <span class="ml-2 text-green-500">4</span>
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-flex items-center px-4 py-2 rounded-md bg-white text-[#468B97] border border-[#468B97] font-space-grotesk" id="rejected-tab" data-tabs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="false">
                        Riwayat Ditolak
                        <span class="ml-2 text-red-500">2</span>
                    </button>
                </li>
            </ul>
        </div>

        <div id="payment-tabs">
            <!-- Pending Tab -->
            <div class="tab-content" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Pembayaran Menunggu Persetujuan</h3>
                        <p class="mt-1 text-sm text-gray-600">Sistem akan otomatis memindai kode referensi pada bukti pembayaran.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Praktikan</th>
                                    <th scope="col" class="px-6 py-3">No. Kwitansi (Hasil OCR)</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receipts as $receipt)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $receipt['Diterima_dari'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $receipt['NPM'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-sm">{{ $receipt['No_Kwitansi'] }}</td>
                                        <td class="px-6 py-4 text-right flex justify-end space-x-1">
                                            <button data-modal-target="payment-modal-{{ $receipt['No_Kwitansi'] }}" data-modal-toggle="payment-modal-{{ $receipt['No_Kwitansi'] }}" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full" type="button">
                                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                                <span class="sr-only">Lihat File</span>
                                            </button>
                                            <button class="p-2 text-red-500 hover:bg-red-50 hover:text-red-600 rounded-full">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                                <span class="sr-only">Tolak</span>
                                            </button>
                                            <button class="p-2 text-green-500 hover:bg-green-50 hover:text-green-600 rounded-full">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                                <span class="sr-only">Setujui Manual</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <div id="payment-modal-{{ $receipt['No_Kwitansi'] }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow">
                                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                                    <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Bukti Pembayaran: {{ $receipt['Diterima_dari'] }}</h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="payment-modal-{{ $receipt['No_Kwitansi'] }}">
                                                        <i data-lucide="x" class="w-4 h-4"></i>
                                                        <span class="sr-only">Tutup modal</span>
                                                    </button>
                                                </div>
                                                <div class="p-4 md:p-5">
                                                    <img src="https://via.placeholder.com/300" alt="Bukti dari John Doe" class="rounded mdi w-full" />
                                                    <div class="mt-4 rounded-md border p-4 bg-gray-50">
                                                        <h4 class="font-semibold mb-2 text-[#468B97]">Detail Hasil Pindaian AI</h4>
                                                        <div class="grid grid-cols-[max-content_1fr] gap-x-4 gap-y-1 text-sm">
                                                            <span class="text-gray-500">No. Kwitansi:</span>
                                                            <span class="font-mono">{{ $receipt['No_Kwitansi'] }}</span>
                                                            <span class="text-gray-500">Diterima dari:</span>
                                                            <span>{{ $receipt['Diterima_dari'] }}</span>
                                                            <span class="text-gray-500">NPM:</span>
                                                            <span class="font-mono">{{ $receipt['NPM'] }}</span>
                                                            <span class="text-gray-500">Untuk Pembayaran:</span>
                                                            <span>{{ $receipt['Untuk_Pembayaran'] }}</span>
                                                            <span class="text-gray-500">Jumlah:</span>
                                                            <span class="font-mono">{{ $receipt['Jumlah'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Approved Tab -->
            <div class="tab-content hidden" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Riwayat Pembayaran Disetujui</h3>
                        <p class="mt-1 text-sm text-gray-600">Daftar semua pembayaran yang telah berhasil diverifikasi.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Praktikan</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Unggah</th>
                                    <th scope="col" class="px-6 py-3">No. Kwitansi</th>
                                    <th scope="col" class="px-6 py-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">Jane Smith</div>
                                        <div class="text-xs text-gray-500">0987654321</div>
                                    </td>
                                    <td class="px-6 py-4">18 Juli 2025</td>
                                    <td class="px-6 py-4 font-mono text-sm">REC987654</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 border border-green-200 rounded">
                                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Disetujui
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rejected Tab -->
            <div class="tab-content hidden" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Riwayat Pembayaran Ditolak</h3>
                        <p class="mt-1 text-sm text-gray-600">Daftar semua pembayaran yang ditolak. Praktikan akan diminta untuk mengunggah ulang.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Praktikan</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Unggah</th>
                                    <th scope="col" class="px-6 py-3">No. Kwitansi</th>
                                    <th scope="col" class="px-6 py-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">Alice Johnson</div>
                                        <div class="text-xs text-gray-500">1122334455</div>
                                    </td>
                                    <td class="px-6 py-4">17 Juli 2025</td>
                                    <td class="px-6 py-4 font-mono text-sm">-</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 border border-red-200 rounded">
                                            <i data-lucide="ban" class="w-3 h-3 mr-1"></i> Ditolak
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
