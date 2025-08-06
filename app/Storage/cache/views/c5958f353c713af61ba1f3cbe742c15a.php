<?php $__env->startSection('dashboard-content'); ?>
<main class="flex-1 p-4 sm:p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-bold text-[#468B97]">Manajemen Modul</h1>
            <p class="text-sm text-gray-600">Buat dan kelola modul praktikum untuk semua kelompok.</p>
        </div>
        <button data-modal-target="create-module-modal" data-modal-toggle="create-module-modal" type="button" class="inline-flex items-center justify-center rounded-md bg-[#468B97] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#468B97]/90">
            <i data-lucide="plus-circle" class="mr-2 h-4 w-4"></i>
            Tambah Modul
        </button>
    </div>

    
    <div id="create-module-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <form action="/dashboard/superadmin/module-management/create" method="POST">
                    <?php echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf_token'] . '">'; ?>
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-[#468B97]">Tambah Sesi Baru</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-module-modal">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <label for="course" class="block mb-2 text-sm font-medium text-gray-900">Praktikum</label>
                            <select id="course" name="course" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                                <option value="" disabled>Pilih praktikum</option>
                                <?php $__currentLoopData = $coursesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course['uid']); ?>"><?php echo e($course['title_course']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Modul</label>
                            <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Modul 1: Uji Kuat Tekan">
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
                            <div>
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                                <input type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5">
                            </div>
                            <div>
                                <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                                <input type="text" id="location" name="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#468B97] focus:border-[#468B97] block w-full p-2.5" placeholder="Contoh: Lab. Uji Bahan Gedung A">
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi modul"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                        <button type="button" data-modal-hide="create-module-modal" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                        <button id="submitCreateModule" data-submit-loader data-loader="#loaderCreateModule" type="submit" class="flex items-center justify-center gap-2 ms-3 text-white bg-[#468B97] hover:bg-[#468B97]/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" aria-label="Simpan sesi baru">
                            <i data-lucide="loader-2" class="h-4 w-4 mr-2 hidden animate-spin" id="loaderCreateModule" aria-hidden="true"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-bold font-headline">Daftar Modul per Praktikum</h2>
                <p class="text-muted-foreground text-sm">Semua Modul yang sudah ada, dikelompokkan berdasarkan mata kuliah praktikum.</p>
            </div>
            <div class="p-6">
                <div id="accordion-collapse" data-accordion="collapse" class="space-y-4">
                    <?php $__currentLoopData = $coursesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="accordion-item border-b pb-2 border-gray-200">
                            <h2 id="accordion-collapse-heading-<?php echo e($course['uid']); ?>" class="mb-2">
                                <button type="button" class="flex items-center justify-between w-full p-4 bg-white text-gray-700 hover:bg-gray-50 aria-expanded:bg-[#468B97] aria-expanded:text-white rounded-lg" 
                                        data-accordion-target="#accordion-collapse-body-<?php echo e($course['uid']); ?>" 
                                        aria-expanded="false" 
                                        aria-controls="accordion-collapse-body-<?php echo e($course['uid']); ?>">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="book-open" class="h-5 w-5"></i>
                                        <span class="font-headline"><?php echo e($course['title_course']); ?></span>
                                        <span class="text-sm font-normal">(<?php echo e($course['uid']); ?> sesi)</span>
                                    </div>
                                    <div>
                                        <i data-lucide="chevron-down" class="h-5 w-5"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="accordion-collapse-body-<?php echo e($course['uid']); ?>" class="hidden" aria-labelledby="accordion-collapse-heading-<?php echo e($course['uid']); ?>">
                                <?php $__currentLoopData = $modulesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($module['course'] === $course['title_course']): ?>
                                        <div class="flex items-start justify-between gap-4 rounded-lg border p-4 mb-2">
                                            <div>
                                                <h4 class="font-semibold"><?php echo e($module['title']); ?></h4>
                                                <div class="mt-1 flex flex-col items-start gap-x-4 gap-y-1 text-sm text-gray-500 sm:flex-row sm:items-center">
                                                    <span class="font-medium text-gray-900"><?php echo e($module['date']); ?></span>
                                                    <span class="flex items-center gap-1.5">
                                                        <i data-lucide="clock" class="h-4 w-4"></i> <?php echo e($module['time']); ?>

                                                    </span>
                                                    <span class="flex items-center gap-1.5">
                                                        <i data-lucide="map-pin" class="h-4 w-4"></i> <?php echo e($module['location']); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex flex-shrink-0 gap-1">
                                                <button class="text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" 
                                                        data-modal-target="modal-edit-module-<?php echo e($module['uid']); ?>" 
                                                        data-modal-toggle="modal-edit-module-<?php echo e($module['uid']); ?>" 
                                                        data-schedule-id="<?php echo e($module['id']); ?>">
                                                    <i data-lucide="edit" class="h-4 w-4"></i>
                                                </button>
                                                <button class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center" 
                                                        data-modal-target="deleteModal" 
                                                        data-modal-toggle="deleteModal" 
                                                        data-schedule-id="<?php echo e($module['id']); ?>" 
                                                        data-schedule-title="<?php echo e($module['title']); ?>">
                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    








                    
                </div>
            </div>
        </div>
    </div>





















































































    <!-- Schedule List -->
    

    

</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/user/php-praktikum-sipil/resources/Views/dashboard/superadmin/module.blade.php ENDPATH**/ ?>