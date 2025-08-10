@extends('dashboard.layouts.layout')
@section('dashboard-content')
    <main class="p-4 sm:p-6">
        {{-- SKELETON PROFILE --}}
        <div id="profile-content-skeleton">
            <div class="mb-8">
                <h1 class="text-2xl font-headline font-bold text-[#468B97]">Profil Saya</h1>
                <p class="text-gray-600">Kelola informasi akun dan data diri Anda.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="md:col-span-1">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="p-6 border-b">
                            <h2 class="font-headline text-lg font-bold text-[#468B97]">Foto Profil</h2>
                        </div>
                        <div class="p-6 flex flex-col items-center gap-4">
                            <div class="w-32 h-32 rounded-full bg-gray-200"></div>
                            <div class="w-32 h-10 bg-gray-200 rounded"></div>
                            <div class="w-32 h-10 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="p-6 border-b">
                            <h2 class="font-headline text-lg font-bold text-[#468B97]">Informasi Data Diri</h2>
                        </div>
                        <div class="p-6 space-y-8 px-4">
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="w-24 h-4 bg-gray-200"></div>
                                <div class="w-full h-10 bg-gray-200 rounded"></div>
                            </div>
                            <div class="w-28 h-10 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PROFILE --}}
        <div id="profile-content" class="hidden">
            <div class="mb-8">
                <h1 class="text-2xl font-headline font-bold text-[#468B97]">Profil Saya</h1>
                <p class="text-gray-600">Kelola informasi akun dan data diri Anda.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="md:col-span-1">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="p-6 border-b">
                            <h2 class="font-headline text-lg font-bold text-[#468B97]">Foto Profil</h2>
                        </div>
                        <form id="formPhoto" action="/dashboard/praktikan/profile/update/photo/{{ $uid }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="p-6 flex flex-col items-center gap-4">
                                <label for="avatarInput" class="relative w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center cursor-pointer" id="avatar-container">
                                    @if(!empty($profilePicture))
                                    <span>
                                        <img src="{{ url('file.php?file=user-pictures/' . $profilePicture) }}" alt="{{ $fullName }}" class="w-32 h-32 rounded-full object-cover">
                                    </span>
                                    @else
                                    <span class="text-[#468B97] text-xl font-bold">{{ $initials }}</span>
                                    @endif
                                </label>

                                <!-- Ini tombol "Ganti Foto" berupa div -->
                                <div onclick="document.getElementById('avatarInput').click()" class="cursor-pointer text-[#468B97] font-bold hover:underline">
                                    Ganti Foto
                                </div>

                                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" />

                                <button type="submit" id="submitUpdatePhoto" data-submit-loader data-loader="#loaderUpdatePhoto" class="flex gap-1 items-center justify-center text-white bg-[#468B97] px-4 py-2 rounded-md hover:bg-[#468B97]/20 hover:text-[#468B97] border border-[#468B97] hover:border-[#468B97]">
                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderUpdatePhoto"></i>
                                    Update Foto Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="p-6 border-b">
                            <h2 class="font-headline text-lg font-bold text-[#468B97]">Informasi Data Diri</h2>
                        </div>
                        <div class="p-6">
                            <form data-spa action="/dashboard/praktikan/profile/update/data/{{ $uid }}" method="POST" class="space-y-8 px-4">
                                @csrf
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-medium text-[#468B97]">Nama Lengkap</label>
                                    <input value="{{ $fullName }}" type="text" id="name" name="name" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Nama Anda" />
                                </div>

                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-medium text-[#468B97]">Nomor Telepon</label>
                                    <input value="{{ $phone }}" type="text" id="phone" name="phone" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Nomor telepon aktif" />
                                </div>

                                <div class="space-y-2">
                                    <label for="fakultas" class="block text-sm font-medium text-[#468B97]">Fakultas</label>
                                    <select name="fakultas" id="fakultas" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                                        @foreach($fakultases as $fakultas)
                                        <option value="{{ $fakultas['kode'] }}" {{ $fakultas['kode']==$fakultasData ? 'selected' : '' }}>{{ $fakultas['kode'] }} | {{ $fakultas['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="prodi" class="block text-sm font-medium text-[#468B97]">Prodi</label>
                                    <select name="prodi" id="prodi" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                                        @foreach($prodis as $prodi)
                                        <option value="{{ $prodi['nama'] }}" {{ $prodi['nama']==$prodiData ? 'selected' : '' }}>{{ $prodi['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="nomorKampus" class="block text-sm font-medium text-[#468B97]">NIM / NPM</label>
                                    <input name="nomorKampus" value="{{ $nomorKampus }}" id="nomorKampus" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="NIM / NPM" />
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium text-[#468B97]">Email</label>
                                    <input name="email" value="{{ $email }}" id="email" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Alamat email" />
                                </div>

                                <div class="space-y-2">
                                    <label for="posisi" class="block text-sm font-medium text-[#468B97]">Posisi</label>
                                    <input name="posisi" value="{{ $posisi }}" id="posisi" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Posisi" />
                                </div>

                                <div class="space-y-2">
                                    <label for="gender" class="block text-sm font-medium text-[#468B97]">Gender</label>
                                    <select name="gender" id="gender" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                                        <option value="Laki-laki" {{ $gender=='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $gender=='Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-medium text-[#468B97]">Password</label>
                                    <input type="password" id="password" name="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Password Baru" />
                                </div>

                                <div class="space-y-2">
                                    <label for="confirmPassword" class="block text-sm font-medium text-[#468B97]">Confirm Password</label>
                                    <input type="password" id="confirmPassword" name="confirmPassword" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Password Baru" />
                                </div>

                                <button type="submit" name="UpdateData" id="submitData" class="flex gap-1 items-center justify-center text-white bg-[#468B97] px-4 py-2 rounded-md hover:bg-[#468B97]/20 hover:text-[#468B97] border border-[#468B97] hover:border-[#468B97]">
                                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderData"></i>
                                    Update Data Profil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection