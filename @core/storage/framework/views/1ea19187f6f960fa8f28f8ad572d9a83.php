$(document).on('click','#submit',function () {
    $(this).addClass("disabled")
    $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> <?php echo e(__("Submitting")); ?>');
});<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/components/btn/submit.blade.php ENDPATH**/ ?>