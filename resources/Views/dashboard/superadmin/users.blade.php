@extends('dashboard.layouts.layout')
@section('dashboard-content')
<main class="p-4 sm:p-6">
    <!-- Skeleton Page Header and Card -->
    <div id="user-management-skeleton">
        <!-- Skeleton Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="w-64 h-8 bg-gray-200 rounded animate-pulse"></div>
            <div class="w-96 h-4 bg-gray-200 rounded mt-2 animate-pulse"></div>
        </div>

        <!-- Skeleton Card -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between">
                    <div class="w-48 h-6 bg-gray-200 rounded animate-pulse"></div>
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0">
                        <div class="w-full sm:w-64 h-10 bg-gray-200 rounded-lg animate-pulse"></div>
                        <div class="w-36 h-10 bg-gray-200 rounded-lg animate-pulse"></div>
                    </div>
                </div>
                <div class="overflow-x-auto p-2">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    <div class="w-24 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center hidden sm:table-cell">
                                    <div class="w-24 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    <div class="w-24 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    <div class="w-24 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    <div class="w-24 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 5; $i++) <tr class="bg-white border-b">
                                <td class="px-6 py-4">
                                    <div class="w-32 h-4 bg-gray-200 rounded animate-pulse"></div>
                                    <div class="w-24 h-3 bg-gray-200 rounded mt-2 animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 hidden sm:table-cell text-center">
                                    <div class="w-48 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="w-24 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="w-20 h-4 bg-gray-200 rounded mx-auto animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 text-center flex justify-center space-x-1">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full animate-pulse"></div>
                                    <div class="w-8 h-8 bg-gray-200 rounded-full animate-pulse"></div>
                                    <div class="w-8 h-8 bg-gray-200 rounded-full animate-pulse"></div>
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                    <div class="px-4 py-5 sm:p-6 flex justify-between items-center">
                        <div class="w-32 h-4 bg-gray-200 rounded animate-pulse"></div>
                        <div class="flex space-x-2">
                            <div class="w-20 h-4 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-12 h-8 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-20 h-8 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-20 h-8 bg-gray-200 rounded animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actual Content -->
    <div id="user-management-content" class="hidden">
        <main class="p-4 sm:p-6">
            <!-- Page Header -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-2xl font-bold text-[#468B97] font-space-grotesk">Manajemen Pengguna</h1>
                <p class="mt-1 text-sm text-gray-600">Kelola data pengguna sistem, termasuk menambahkan, mengedit, dan menghapus pengguna.</p>
            </div>

            <!-- Card -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Daftar Pengguna</h2>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0">
                            <form data-turbo-frame="users-table" method="POST" action="/dashboard/superadmin/user-management" class="flex gap-2">
                                <input id="searchInput" name="search" type="text" placeholder="Cari data user..." class="px-4 py-2 border rounded-lg" value="{{ $search }}">
                                <input type="hidden" name="limit" value="{{ $limit }}">
                                <input type="hidden" name="page" value="1">
                                <button id="submitSearchUser" type="submit" class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderSearchUser"></i>
                                    Cari
                                </button>
                            </form>
                            <button data-modal-target="addModal" data-modal-toggle="addModal" class="flex items-center gap-2 bg-[#468B97] text-white px-4 py-2 rounded-lg hover:bg-[#3a6f7a] focus:ring-4 focus:ring-[#468B97] focus:ring-opacity-50">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                Tambah Pengguna
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-2">                 
                        <turbo-frame id="users-table">
                            <div class="relative">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-center border-r">Nama</th>
                                            <th scope="col" class="px-6 py-3 text-center border-r hidden sm:table-cell">Email</th>
                                            <th scope="col" class="px-6 py-3 text-center border-r">NPM</th>
                                            <th scope="col" class="px-6 py-3 text-center border-r">Role</th>
                                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        @foreach($users as $user)
                                        <tr class="bg-white border-b" data-role="{{ $user['role_name'] }}" data-name="{{ strtolower($user['full_name']) }}" data-email="{{ strtolower($user['email']) }}" data-npm="{{ $user['npm_nip'] }}">
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $user['full_name'] }}</div>
                                                <div class="text-xs text-gray-500">{{ $user['phone'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 hidden sm:table-cell text-center">{{ $user['email'] }}</td>
                                            <td class="px-6 py-4 font-mono text-sm text-center">{{ $user['npm_nip'] }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium badge-{{ $user['role_name'] }} rounded-md">{{ $user['role_name'] }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-center flex justify-center space-x-1">
                                                <button data-modal-target="editModal-{{ $user['phone'] }}" data-modal-toggle="editModal-{{ $user['phone'] }}" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full" type="button">
                                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                                    <span class="sr-only">Edit</span>
                                                </button>
                                                <button data-modal-target="resetPasswordModal-{{ $user['phone'] }}" data-modal-toggle="resetPasswordModal-{{ $user['phone'] }}" class="p-2 text-blue-500 hover:bg-blue-50 hover:text-blue-600 rounded-full" type="button">
                                                    <i data-lucide="key" class="w-4 h-4"></i>
                                                    <span class="sr-only">Reset Password</span>
                                                </button>
                                                <button data-modal-target="deleteModal-{{ $user['uid'] }}" data-modal-toggle="deleteModal-{{ $user['uid'] }}" class="p-2 text-red-500 hover:bg-red-50 hover:text-red-600 rounded-full" type="button">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    <span class="sr-only">Hapus</span>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div id="contentLoader" class="absolute inset-0 bg-white/80 flex items-center justify-center z-50">
                                    <i data-lucide="loader-2" class="h-10 w-10 animate-spin text-gray-500"></i>
                                </div>
                            </div>

                            <div id="paginationWrapper" class="px-4 py-5 sm:p-6 flex justify-between items-center">
                                <div id="pageInfo" class="text-sm text-gray-600">
                                    Halaman <span id="currentPage">{{ $currentPage }}</span> dari <span id="totalPages">{{ $totalPages }}</span>
                                </div>
                                <div class="flex space-x-2 items-center">
                                    <div>
                                        <form method="POST" data-turbo-frame="users-table" action="/dashboard/superadmin/user-management">
                                            <input type="hidden" name="search" value="{{ $search }}">
                                            <input type="hidden" name="page" value="1">
                                            <input class="text-center w-20 py-2 border rounded-lg" type="text" name="limit" value="{{ $limit }}">
                                            <span>baris</span>
                                        </form>
                                    </div>

                                    <form method="POST" data-turbo-frame="users-table" action="/dashboard/superadmin/user-management">
                                        <input type="hidden" name="search" value="{{ $search }}">
                                        <input type="hidden" name="limit" value="{{ $limit }}">
                                        <input type="hidden" name="page" value="{{ max(1, $currentPage - 1) }}">
                                        <button {{ $currentPage <= 1 ? 'disabled' : '' }} id="submitPrevUser" class="flex gap-2 items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-gray-100 rounded-md hover:bg-gray-300">
                                            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                                            </svg>
                                            Prev
                                            <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderPrevUser"></i>
                                        </button>
                                    </form>

                                    
                                    <form method="POST" data-turbo-frame="users-table" action="/dashboard/superadmin/user-management">
                                        <input type="hidden" name="search" value="{{ $search }}">
                                        <input type="hidden" name="limit" value="{{ $limit }}">
                                        <input type="hidden" name="page" value="{{ min($totalPages, $currentPage + 1) }}">
                                        <button {{ $currentPage >= $totalPages ? 'disabled' : '' }} id="submitNextUser" class="flex gap-2 items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-gray-100 rounded-md hover:bg-gray-300">
                                            <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderNextUser"></i>
                                            Next
                                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </turbo-frame>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Tambah Pengguna Modal -->
    <div id="addModal" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Tambah Pengguna Baru</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="addModal">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form action="/dashboard/superadmin/user-management/create/user" method="POST" class="mt-4">
                        @csrf
                        <div class="grid gap-4">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="npm" class="text-right">NPM</label>
                                <input name="npm" id="npm" type="text" placeholder="06.2024.1.07780" required class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="full-name" class="text-right">Nama Lengkap</label>
                                <input name="full-name" id="full-name" type="text" placeholder="Ahmad Pratama" required class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="phone" class="text-right">Nomor Telepon</label>
                                <input name="phone" id="phone" type="text" placeholder="081234567890" required class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="email" class="text-right">Email</label>
                                <input name="email" id="email" type="email" placeholder="ahmad.pratama@universitas.ac.id" required class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="add-role" class="text-right">Role</label>
                                <select id="add-role" name="role" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" required>
                                    @foreach($roles as $role)
                                    <option value="{{ $role['uid'] }}">{{ $role['role_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="password" class="text-right">Password</label>
                                <input name="password" id="password" type="password" placeholder="••••••••" required class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                            </div>
                            <div class="grid grid-cols-4 items-center gap-4">
                                <label for="password-confirm" class="text-right">Password Confirm</label>
                                <input name="password-confirm" id="password-confirm" type="password" placeholder="••••••••" required class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end gap-2">
                            <button type="button" data-modal-hide="addModal" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">Batal</button>
                            <button id="submitCreateUser" type="submit" name="registerUser" class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateUser"></i>
                                Tambah Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach($users as $user)
        <!-- Edit User Modal -->
        <div id="editModal-{{ $user['phone'] }}" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Edit Pengguna</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="editModal-{{ $user['phone'] }}">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span class="sr-only">Tutup modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5">
                        <form id="editUserForm-{{ $user['phone'] }}" action="/dashboard/superadmin/user/update" method="POST" class="mt-4">
                            @csrf
                            <div class="grid gap-4">
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="edit-name-{{ $user['phone'] }}" class="text-right">Nama</label>
                                    <input id="edit-name-{{ $user['phone'] }}" name="name" type="text" value="{{ $user['full_name'] }}" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" required />
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="edit-email-{{ $user['phone'] }}" class="text-right">Email</label>
                                    <input id="edit-email-{{ $user['phone'] }}" name="email" type="email" value="{{ $user['email'] }}" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" required />
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="edit-npm-{{ $user['phone'] }}" class="text-right">NPM</label>
                                    <input id="edit-npm-{{ $user['phone'] }}" name="npm" type="text" value="{{ $user['npm_nip'] }}" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="edit-role-{{ $user['phone'] }}" class="text-right">Role</label>
                                    <select id="edit-role-{{ $user['phone'] }}" name="role" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]">
                                        @foreach($roles as $role)
                                        <option value="{{ $role['uid'] }}" {{ $role['role_name'] == $user['role_name'] ? 'selected' : '' }}>{{ $role['role_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="edit-phone-{{ $user['phone'] }}" class="text-right">Nomor Telepon</label>
                                    <input id="edit-phone-{{ $user['phone'] }}" name="phone" type="tel" value="{{ $user['phone'] }}" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" />
                                </div>
                                <input type="hidden" name="phone" value="{{ $user['phone'] }}" />
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <button type="button" data-modal-hide="editModal-{{ $user['phone'] }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-[#468B97] text-white rounded-lg hover:bg-[#3a6f7a] focus:ring-4 focus:ring-[#468B97] focus:ring-opacity-50">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reset Password Modal -->
        <div id="resetPasswordModal-{{ $user['phone'] }}" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Reset Password</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="resetPasswordModal-{{ $user['phone'] }}">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span class="sr-only">Tutup modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-sm text-gray-600">Masukkan password baru untuk <span class="font-semibold">{{ $user['full_name'] }}</span>. Pengguna akan diminta menggunakan password ini saat login berikutnya.</p>
                        <form id="resetPasswordForm-{{ $user['phone'] }}" action="/dashboard/superadmin/user/reset-password" method="POST" class="mt-4">
                            @csrf
                            <div class="grid gap-4">
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="new-password-{{ $user['phone'] }}" class="text-right">Password Baru</label>
                                    <input id="new-password-{{ $user['phone'] }}" name="new_password" type="password" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" required />
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <label for="confirm-password-{{ $user['phone'] }}" class="text-right">Konfirmasi</label>
                                    <input id="confirm-password-{{ $user['phone'] }}" name="confirm_password" type="password" class="col-span-3 p-2 border border-gray-300 rounded-lg focus:ring-[#468B97] focus:border-[#468B97]" required />
                                </div>
                                <input type="hidden" name="phone" value="{{ $user['phone'] }}" />
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <button type="button" data-modal-hide="resetPasswordModal-{{ $user['phone'] }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-[#468B97] text-white rounded-lg hover:bg-[#3a6f7a] focus:ring-4 focus:ring-[#468B97] focus:ring-opacity-50">Simpan Password Baru</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div id="deleteModal-{{ $user['uid'] }}" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-[#468B97] font-space-grotesk">Konfirmasi Hapus Pengguna</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="deleteModal-{{ $user['uid'] }}">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span class="sr-only">Tutup modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5">
                        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus pengguna <span class="font-semibold">{{ $user['full_name'] . ' | ' . $user['uid'] }}</span>? Tindakan ini tidak dapat dibatalkan.</p>
                        <form id="deleteUserForm-{{ $user['phone'] }}" action="/dashboard/superadmin/user-management/delete/{{ $user['id'] }}/user/{{ $user['uid'] }}" method="POST" class="mt-4">
                            @csrf
                            <div class="mt-4 flex justify-end gap-2">
                                <button type="button" data-modal-hide="deleteModal-{{ $user['uid'] }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200">Batal</button>
                                <button type="submit" id="submitDeleteUser" class="flex items-center justify px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-500 focus:ring-opacity-50">
                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderDeleteUser"></i>
                                    Hapus Pengguna
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</main>
@endsection