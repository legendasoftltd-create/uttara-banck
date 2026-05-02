<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                 <?php if(check_page_permission('admin_manage')): ?>
                    <div class="col-md-3 mt-5 mb-3">
                        <div class="card text-dark mb-3">
                            <div class="dsh-box-style">
                                <a href="<?php echo e(route('admin.new.user')); ?>" class="add-new"><i class="ti-plus"></i></a>
                                <div class="icon">
                                    <i class="ti-user"></i>
                                </div>
                                <div class="content">
                                    <span class="total"><?php echo e($total_admin); ?></span>
                                    <h4 class="title"><?php echo e(__('Total Admin')); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(check_page_permission_by_string('News Manage')): ?>
                    <div class="col-md-3 mt-md-5 mb-3">
                        <div class="card text-dark  mb-3">
                            <div class="dsh-box-style">
                                <a href="<?php echo e(route('admin.news.new')); ?>" class="add-new"><i class="ti-plus"></i></a>
                                <div class="icon">
                                    <i class="ti-comments"></i>
                                </div>
                                <div class="content">
                                    <span class="total"><?php echo e($blog_count); ?></span>
                                    <h4 class="title"><?php echo e(__('Total News')); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php endif; ?>
                    
                    <?php if(check_page_permission_by_string('Products Manage') && !empty(get_static_option('product_module_status'))): ?>
                    <div class="col-md-3 mt-md-5 mb-3">
                        <div class="card text-dark  mb-3">
                            <div class="dsh-box-style">
                                <a href="<?php echo e(route('admin.products.new')); ?>" class="add-new"><i class="ti-plus"></i></a>
                                <div class="icon">
                                    <i class="ti-package"></i>
                                </div>
                                <div class="content">
                                    <span class="total"><?php echo e($total_products); ?></span>
                                    <h4 class="title"><?php echo e(__('Total Products')); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php endif; ?>
                    <?php if(check_page_permission_by_string('Services')): ?>
                    <div class="col-md-3 mt-md-5 mb-3">
                        <div class="card text-dark  mb-3">
                            <div class="dsh-box-style">
                                <a href="<?php echo e(route('admin.services.new')); ?>" class="add-new"><i class="ti-plus"></i></a>
                                <div class="icon">
                                    <i class="ti-blackboard"></i>
                                </div>
                                <div class="content">
                                    <span class="total"><?php echo e($total_services); ?></span>
                                    <h4 class="title"><?php echo e(__('Total Services')); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                     
                    
                </div>
            </div>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/admin-home.blade.php ENDPATH**/ ?>