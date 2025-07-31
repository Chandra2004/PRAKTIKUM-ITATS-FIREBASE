

<?php $__env->startSection('content-error'); ?>
    <div class="error-number error-animation">403</div>

    <!-- Error Message -->
    <h1 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight mb-4">
        Akses Ditolak
    </h1>

    <p class="text-lg text-gray-600 mb-8">
        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
        Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
    </p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('errors.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/user/php-praktikum-sipil/services/errors/403.blade.php ENDPATH**/ ?>