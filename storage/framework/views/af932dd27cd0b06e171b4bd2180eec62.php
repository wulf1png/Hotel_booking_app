<h1>Доступные номера</h1>
<?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p>Номер: <?php echo e($room->id); ?> | Описание: <?php echo e($room->description); ?></p>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<a href="/">Назад</a>
<?php /**PATH C:\Users\Wulf.png\hotel_booking\resources\views/rooms.blade.php ENDPATH**/ ?>