<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTV2Ztz7uNKx5W4ZwFxFc00k6QjBgT_2y8A6w&s" type="image/x-icon">
    <title><?php echo e($title); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo e(url('/assets/css/custom.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
      
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@latest/dist/turbo.es2017-esm.min.js"></script>
</head>

<body class="min-h-screen">
    <div>
        <div class="flex">
            <!-- Sidebar -->
            <aside class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full md:translate-x-0 bg-white border-r border-gray-200" id="sidebar" aria-label="Sidebar">
                <div class="flex flex-col h-full p-4 overflow-y-auto">
                    <!-- Sidebar Header -->
                    <div class="py-3 px-5">
                        <a data-turbo="false" href="<?php echo e($link); ?>" class="flex items-center gap-2 font-bold text-lg font-headline">
                            <i data-lucide="hard-hat" class="h-6 w-6 text-[#468B97]"></i>
                            <span>SIPIL PRAKTIKUM</span>
                        </a>
                    </div>
                    <!-- Sidebar Content -->
                    <div class="flex-1">
                        <ul class="space-y-2">
                            <li>
                                <a href="/" class="flex items-center py-3 px-5 text-gray-900 rounded-lg hover:bg-[#E0E8E9]">
                                    <i data-lucide="house" class="w-5 h-5 text-gray-500"></i>

                                    <span class="ml-3">Homepage</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e($link); ?>" class="<?php echo e(request()->is($link) ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                            <?php if($roleName == 'SuperAdmin'): ?>
                            <li>
                                <a href="<?php echo e($link); ?>/user-management" class="<?php echo e(request()->is($link . '/user-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="users" class="w-5 h-5"></i>
                                    <span class="ml-3">Pengguna</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e($link); ?>/payment-management" class="<?php echo e(request()->is($link . '/payment-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                    <span class="ml-3">Pembayaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e($link); ?>/courses-management" class="<?php echo e(request()->is($link . '/courses-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="book-open" class="w-5 h-5"></i>
                                    <span class="ml-3">Praktikum</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e($link); ?>/schedule-management" class="<?php echo e(request()->is($link . '/schedule-management') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> flex items-center py-3 px-5 rounded-lg">
                                    <i data-lucide="book-text" class="w-5 h-5"></i>
                                    <span class="ml-3">Jadwal</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- Main Content -->
            <div class="flex-1 md:ml-64">
                <!-- Header -->
                <header class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 bg-white/80 border-b border-gray-200 backdrop-blur-sm sm:px-6">
                    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 text-gray-500 rounded-lg md:hidden hover:bg-[#E0E8E9]">
                        <i data-lucide="panel-left"></i>
                    </button>
                    <div class="w-full flex justify-end px-4 sm:px-6">
                        <?php if(!empty($profilePicture)): ?>
                        <div class="font-medium text-gray-600 cursor-pointer" id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start">
                            <img src="<?php echo e(url('file.php?file=user-pictures/' . $profilePicture)); ?>" alt="<?php echo e($fullName); ?>" class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
                        </div>
                        <?php else: ?>
                        <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
                            <span class="font-medium text-gray-600 cursor-pointer" id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start"><?php echo e($initials); ?></span>
                        </div>
                        <?php endif; ?>

                        <div id="userDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-auto">
                            <div class="px-4 py-3 text-sm text-gray-900">
                                <div><?php echo e($fullName); ?></div>
                                <div class="font-medium truncate" id="email"><?php echo e($email); ?></div>
                            </div>
                            <ul class="p-2 space-y-1 text-sm text-gray-700" aria-labelledby="avatarButton">
                                <li>
                                    <a href="<?php echo e($link); ?>" class="<?php echo e(request()->is($link) ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> block px-4 py-2 rounded-md">Dashboard</a>
                                </li>
                                <li>
                                    <a href="<?php echo e($link); ?>/profile" class="<?php echo e(request()->is($link . '/profile') ? 'bg-[#468B97] text-white' : 'hover:bg-[#E0E8E9] text-gray-900'); ?> block px-4 py-2 rounded-md">Profile</a>
                                </li>
                            </ul>
                            <div class="p-2">
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-500 hover:text-white rounded-md">Log Out</a>
                            </div>
                        </div>
                    </div>
                </header>

                <?php echo $__env->make('notification.notification', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <!-- Main -->
                
                    <?php echo $__env->yieldContent('dashboard-content'); ?>
                
                
            </div>
        </div>
    </div>


    <!-- Flowbite & Lucide Icons -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php echo $__env->make('dashboard.layouts.script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script>
        function reinitUI() {
            if (window.initFlowbite) initFlowbite();
            if (window.lucide) lucide.createIcons();
            initAll(); // panggil init ulang semua fungsi UI termasuk skeleton & preview
            showFlashNotification(); // panggil notifikasi
        }
    
        function initAll() {
            // PAGE PROFILE
            initSkeleton("profile-content-skeleton", "profile-content");
            initSubmitLoader('loaderData', 'submitData');
            initSubmitLoader('loaderPhoto', 'submitPhoto');
            initImagePreview("avatarInput", "avatar-container", "submitPhoto");
            
            // PAGE HOME
            initSkeleton("home-content-skeleton", "home-content");
            
            // PAGE USER
            initSkeleton("user-management-skeleton", "user-management-content");
            initSubmitLoader('loaderCreateUser', 'submitCreateUser');
            initSubmitLoader('loaderUpdateUser', 'submitUpdateUser');
            initSubmitLoader('loaderDeleteUser', 'submitDeleteUser');
            initSubmitLoader('loaderSearchUser', 'submitSearchUser', 'contentLoader');
            initSubmitLoader('loaderPrevUser', 'submitPrevUser', 'contentLoader');
            initSubmitLoader('loaderNextUser', 'submitNextUser', 'contentLoader');


            // PAGE SCHEDULE
            initSubmitLoader('loaderCreateCourse', 'submitCreateCourse');
            initSubmitLoader('loaderUpdateCourse', 'submitUpdateCourse');
            initSubmitLoader('loaderDeleteCourse', 'submitDeleteCourse');
        }
    
        function showFlashNotification() {
            const toasts = ['alert-2', 'alert-3', 'alert-4'];
            toasts.forEach(toastId => {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.remove('opacity-0', 'translate-y-4');
                    toast.classList.add('opacity-100', 'translate-y-0');
                    setTimeout(() => {
                        toast.classList.remove('opacity-100', 'translate-y-0');
                        toast.classList.add('opacity-0', 'translate-y-4');
                        toast.addEventListener('transitionend', () => {
                            toast.style.display = 'none';
                        }, { once: true });
                    }, 10000);
                    const closeButton = toast.querySelector('[data-dismiss-target="#' + toastId + '"]');
                    if (closeButton) {
                        closeButton.addEventListener('click', () => {
                            toast.classList.remove('opacity-100', 'translate-y-0');
                            toast.classList.add('opacity-0', 'translate-y-4');
                            toast.addEventListener('transitionend', () => {
                                toast.style.display = 'none';
                            }, { once: true });
                        });
                    }
                }
            });
        }
    
        document.addEventListener("DOMContentLoaded", reinitUI);
        document.addEventListener("turbo:load", reinitUI);
        document.addEventListener("turbo:frame-load", reinitUI);
    </script>
</body>

</html>
<?php /**PATH /home/user/php-praktikum-sipil/resources/Views/dashboard/layouts/layout.blade.php ENDPATH**/ ?>