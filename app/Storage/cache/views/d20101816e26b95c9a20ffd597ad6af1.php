<?php $__env->startSection('dashboard-content'); ?>
<main class="p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="font-headline text-2xl font-bold text-[#468B97]">Manajemen Praktikum</h1>
            <p class="text-sm text-gray-600">Kelola praktikum yang tersedia dan setujui pendaftaran dari praktikan.</p>
        </div>
        <button class="flex items-center gap-2 bg-[#468B97] text-white px-4 py-2 rounded-lg hover:bg-[#3a6f7a] focus:ring-4 focus:ring-[#468B97] focus:ring-opacity-50" data-modal-target="create-modal" data-modal-toggle="create-modal">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            Tambah Praktikum
        </button>
    </div>

    <div id="create-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">
                        Tambah Praktikum
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="create-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" action="/dashboard/superadmin/courses-management/create" method="POST">
                    <?php echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf_token'] . '">'; ?>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="code" class="block mb-2 text-sm font-medium text-gray-900">Kode</label>
                            <input id="code" type="text" name="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5" placeholder="Kode Praktikum">
                        </div>
                        <div class="col-span-2">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
                            <input id="title" type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5" placeholder="Judul Praktikum">
                        </div>
                        <div class="col-span-2">
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                            <input id="date" type="Date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                        </div>
                        <div class="col-span-2">
                            <label for="creator" class="block mb-2 text-sm font-medium text-gray-900">Creator</label>
                            <select name="creator" id="creator" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                <?php $__currentLoopData = $userSuperAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user['uid']); ?>" <?php echo e($user['full_name'] === $fullName ? 'selected' : ''); ?>><?php echo e($user['full_name'] . ' | ' . $user['posisi']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi praktikum"></textarea>
                        </div>
                    </div>
                    <button id="submitCreateCourse" type="submit" class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateCourse"></i>
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Accordion -->
    <div id="accordion-collapse" data-accordion="collapse" class="space-y-4">
        <?php $__currentLoopData = $coursesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-md mb-4">
                <h2 id="accordion-collapse-heading-<?php echo e($course['uid']); ?>">

                    <button type="button" class="flex items-center justify-between w-full p-4 bg-white text-gray-700 hover:bg-gray-50 aria-expanded:bg-[#468B97] aria-expanded:text-white" data-accordion-target="#accordion-collapse-body-<?php echo e($course['uid']); ?>" aria-expanded="false" aria-controls="accordion-collapse-body-<?php echo e($course['uid']); ?>">
                        <div class="text-left">
                            <p class="font-semibold"><?php echo e($course['title_course']); ?></p>
                            <p class="text-sm">Tanggal: <?php echo e(date('d-m-Y', strtotime($course['date_course']))); ?> | Kode: <?php echo e($course['code_course']); ?></p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1">
                                <span class="text-sm">0 Pendaftar</span>
                                <span class="text-sm mx-1">|</span>
                                <span class="text-sm">0 Diterima</span>
                            </div>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </div>
                    </button>
                </h2>
                <div id="accordion-collapse-body-<?php echo e($course['uid']); ?>" class="hidden" aria-labelledby="accordion-collapse-heading-<?php echo e($course['uid']); ?>">
                    <div class="bg-gray-50 p-4 border-t border-gray-200">
                        <div class="space-y-3">
                            <div>
                                <h4 class="font-semibold text-sm text-[#468B97]">Koordinator Praktikum</h4>
                                <p class="text-xs text-gray-500 mt-1"><?php echo e($course['user_fullName']); ?></p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-[#468B97]">Deskripsi</h4>
                                <p class="text-xs text-gray-500 mt-1"><?php echo e($course['description_course']); ?></p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-[#468B97]">Catatan Pendaftar</h4>
                                <p class="text-xs text-gray-500 mt-1">Tidak ada pendaftar</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-[#468B97]">Paraf & Status</h4>
                                <div class="mt-2 border border-gray-200 rounded-md overflow-hidden">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="bg-[#468B97] text-white">
                                                <th class="p-2 text-left">Nama Praktikan</th>
                                                <th class="p-2 text-left">NPM</th>
                                                <th class="p-2 text-left">Status</th>
                                                <th class="p-2 text-left">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="p-2 text-center text-sm text-gray-500 py-4">Belum ada pendaftar.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button class="border border-[#468B97] text-[#468B97] py-1 px-3 rounded text-sm flex items-center hover:bg-[#468B97]/10 transition-colors" data-modal-target="update-modal-<?php echo e($course['uid']); ?>" data-modal-toggle="update-modal-<?php echo e($course['uid']); ?>">
                                    <i data-lucide="edit" class="h-4 w-4 mr-1"></i> Edit
                                </button>
                                <button class="bg-red-500 text-white py-1 px-3 rounded text-sm flex items-center hover:bg-red-600 transition-colors" data-modal-target="delete-modal-<?php echo e($course['uid']); ?>" data-modal-toggle="delete-modal-<?php echo e($course['uid']); ?>">
                                    <i data-lucide="trash" class="h-4 w-4 mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    

    
    <?php $__currentLoopData = $coursesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <div id="update-modal-<?php echo e($course['uid']); ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">
                            Edit Praktikum
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="update-modal-<?php echo e($course['uid']); ?>">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form class="p-4 md:p-5" action="/dashboard/superadmin/courses-management/update/<?php echo e($course['uid']); ?>" method="POST">
                        <?php echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf_token'] . '">'; ?>
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="code" class="block mb-2 text-sm font-medium text-gray-900">Kode</label>
                                <input value="<?php echo e($course['code_course']); ?>" id="code" type="text" name="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5" placeholder="Kode Praktikum">
                            </div>
                            <div class="col-span-2">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
                                <input value="<?php echo e($course['title_course']); ?>" id="title" type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5" placeholder="Judul Praktikum">
                            </div>
                            <div class="col-span-2">
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                                <input value="<?php echo e($course['date_course']); ?>" id="date" type="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                            </div>
                            <div class="col-span-2">
                                <label for="creator" class="block mb-2 text-sm font-medium text-gray-900">Creator</label>
                                <select name="creator" id="creator" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5">
                                    <?php $__currentLoopData = $userSuperAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user['uid']); ?>" <?php echo e($user['uid'] === $course['uid_creator_course'] ? 'selected' : ''); ?>><?php echo e($user['full_name'] . ' | ' . $user['posisi']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi praktikum"><?php echo e($course['description_course']); ?></textarea>
                            </div>
                        </div>
                        <button id="submitUpdateCourse" type="submit" class="text-white inline-flex items-center bg-[#468B97] hover:bg-[#3a6f7a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderUpdateCourse"></i>
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>

        
        <div id="delete-modal-<?php echo e($course['uid']); ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="delete-modal-<?php echo e($course['uid']); ?>">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <form action="/dashboard/superadmin/courses-management/delete/<?php echo e($course['uid']); ?>" method="POST">
                            <?php echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf_token'] . '">'; ?>
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-sm font-normal text-gray-500">Apakah Anda yakin ingin menghapus praktikum <span class="font-semibold text-gray-900"><?php echo e($course['title_course']); ?></span>? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua pendaftaran terkait.</h3>
                            <input type="hidden" name="uid" value="<?php echo e($course['uid']); ?>">
                            <input id="title" type="text" name="title" class="my-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97]-600 focus:border-[#468B97]-600 block w-full p-2.5" placeholder="<?php echo e($course['title_course']); ?>">
                            <button id="submitDeleteCourse" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderDeleteCourse"></i>
                                Hapus
                            </button>
                            <button data-modal-toggle="delete-modal-<?php echo e($course['uid']); ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/user/php-praktikum-sipil/resources/Views/dashboard/superadmin/courses.blade.php ENDPATH**/ ?>