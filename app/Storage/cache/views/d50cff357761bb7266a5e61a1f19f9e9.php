

<?php $__env->startSection('content-error'); ?>
    <div class="error-number error-animation">500</div>
    <h1 class="font-headline text-3xl sm:text-4xl font-bold tracking-tight mb-4">
        Kesalahan Server
    </h1>
    <p class="text-lg text-gray-600 mb-8">
        Maaf, terjadi kesalahan pada server.
        Tim kami telah diberitahu dan sedang memperbaiki masalah ini.
    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/user/php-praktikum-sipil/services/errors/500.blade.php ENDPATH**/ ?>