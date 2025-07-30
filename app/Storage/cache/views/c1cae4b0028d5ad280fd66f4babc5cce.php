<!DOCTYPE html>
<html lang="id">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
        <title>Register - Civil Praktikum Manager</title>
        
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="<?php echo e(url('/assets/css/custom.css')); ?>">
        
        <script src="https://unpkg.com/lucide@latest"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    </head>
    
    <body class="bg-background flex min-h-screen items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="p-6 text-center">
            <div class="mb-4 flex justify-center">
                <a href="/" class="flex items-center gap-2 font-bold text-xl font-headline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-hard-hat h-7 w-7 text-[#468B97]">
                        <path d="M10 10V5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5"></path>
                        <path d="M14 6a6 6 0 0 1 6 6v3"></path>
                        <path d="M4 15v-3a6 6 0 0 1 6-6"></path>
                        <rect x="2" y="15" width="20" height="4" rx="1"></rect>
                    </svg>
                    <span class="font-headline">Civil Praktikum Manager</span>
                </a>
            </div>
            <h1 class="font-headline text-2xl font-bold">Buat Akun Baru</h1>
            <p class="text-gray-500 mt-1">Isi formulir di bawah ini untuk memulai.</p>

        </div>
        <div class="p-6">
            <div>
                <?php echo $__env->make('notification.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <form class="grid gap-4" action="/register/auth" method="POST">
                <?php echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf_token'] . '">'; ?>
                <div class="grid gap-2">
                    <label for="npm" class="text-sm font-medium">NPM (Nomor Pokok Mahasiswa)</label>
                    <input name="npm" id="npm" type="text" placeholder="06.2024.1.07780"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="full-name" class="text-sm font-medium">Nama Lengkap</label>
                    <input name="full-name" id="full-name" type="text" placeholder="Ahmad Pratama"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="phone" class="text-sm font-medium">Nomor Telepon</label>
                    <input name="phone" id="phone" type="text" placeholder="081234567890"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input name="email" id="email" type="email" placeholder="ahmad.pratama@universitas.ac.id"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input name="password" id="password" type="password" placeholder="••••••••"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <div class="grid gap-2">
                    <label for="password-confirm" class="text-sm font-medium">Password Confirm</label>
                    <input name="password-confirm" id="password-confirm" type="password" placeholder="••••••••"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#468B97]" />
                </div>
                <button type="submit" name="registerUser" id="buttonRegister"
                    class="w-full flex items-center justify-center bg-[#468B97] text-white rounded-md py-2 hover:bg-[#3a6f7a] transition-colors">
                    <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderRegister"></i>
                    Register
                </button>
            </form>
            <div class="mt-4 text-center text-sm">
                <span>
                    Sudah punya akun? <a href="/login" class="underline text-[#468B97]">Login</a>
                </span>
                <br>
                <span>
                    <a href="/" class="underline text-[#468B97]">kembali ke beranda</a>
                </span>
            </div>
        </div>
    </div>

    <?php echo $__env->make('dashboard.layouts.script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
            initSubmitLoader('loaderRegister', 'buttonRegister');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
<?php /**PATH /home/user/php-praktikum-sipil/resources/Views/auth/register.blade.php ENDPATH**/ ?>