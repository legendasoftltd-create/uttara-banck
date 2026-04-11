
<!-- Start of popup window -->
<?php if(!empty(get_static_option('popup_enable_status') && !empty(get_static_option('popup_selected_' . $user_select_lang_slug . '_id')))): ?>
    <?php
        $popup_details = \App\PopupBuilder::get();
    ?>
    
    <div class="modal fade home-popup" id="whats-news-3" tabindex="-1" role="dialog" aria-labelledby="us1BillionModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content" style>
                <div class="skl-modal-body modal-body" style>
                    <span class="skl-modal-close-button_02 close" data-dismiss="modal" style="z-index: 999"
                        aria-label="Close">
                        <img src="https://www.legacy.bracbank.com/client_end/img/icon/skl-close.png" alt>
                    </span>
                    <div id="carouselExampleControls" class="carousel slide popup" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $popup_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($data->type == 'notice'): ?>
                                    <div class="carousel-item active">
                                        <div class="bg-white p-4 rounded shadow-sm news-card">
                                            <h4 class="news-title rounded"><?php echo e($data->title); ?></h4>
                                            <p class="news-desc"><?php echo e($data->description); ?></p>
                                        </div>
                                    </div>
                                <?php elseif($data->type == 'only_image'): ?>
                                    <div class="carousel-item">
                                        <?php
                                            $bolg_image_details = get_attachment_image_by_id($data->only_image, 'full');
                                        ?>
                                        <img class="d-block w-100 rounded" src="<?php echo e($bolg_image_details['img_url']); ?>" alt="slider 02">
                                    </div>
                                <?php elseif($data->type == 'promotion'): ?>
                                    <div class="carousel-item">
                                        <?php
                                            $bolg_image_details = get_attachment_image_by_id($data->only_image, 'full');
                                        ?>
                                        <img class="d-block w-100 rounded" src="<?php echo e($bolg_image_details['img_url']); ?>" alt="slider 02">
                                    </div>
                                <?php else: ?>
                                    <div class="carousel-item">
                                        <?php
                                            $bolg_image_details = get_attachment_image_by_id($data->only_image, 'full');
                                        ?>
                                        <img class="d-block w-100 rounded" src="<?php echo e($bolg_image_details['img_url']); ?>" alt="slider 02">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="prev-extended-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class=" next-extended-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--End of popup-->
<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/partials/popup.blade.php ENDPATH**/ ?>