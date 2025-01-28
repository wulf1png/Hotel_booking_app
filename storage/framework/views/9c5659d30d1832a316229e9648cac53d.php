<h1>Текущие бронирования</h1>
<?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p>Номер: <?php echo e($booking->id); ?> | Гость: <?php echo e($booking->guest_name); ?></p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<a href="/">Назад</a>
<?php /**PATH C:\Users\Wulf.png\hotel_booking\resources\views/bookings.blade.php ENDPATH**/ ?>