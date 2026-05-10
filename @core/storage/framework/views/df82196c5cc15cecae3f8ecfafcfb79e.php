<?php
    $page_name = get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_name');
    $isCategoryPage = isset($current_category);
?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($page_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($page_name ?? 'Bank Downloads'); ?>

    <?php echo e(isset($current_category) ? ': ' . $current_category->title : (isset($current_subcategory) ? ': ' . $current_subcategory->title : '')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_tags')); ?>">
    <?php echo render_og_meta_image_by_attachment_id(
        get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_image'),
    ); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="bank-download-single-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="download-content">
                    <div class="breadcrumb mb-4">
                        <a href="<?php echo e(route('frontend.bank.downloads')); ?>"><?php echo app('translator')->get('bank_downloads'); ?></a>
                        <?php if($download->category): ?>
                            / <a href="<?php echo e(route('frontend.bank.downloads.category', ['id' => $download->category->id, 'slug' => $download->category->slug])); ?>"><?php echo e($download->category->title); ?></a>
                        <?php endif; ?>
                        <?php if($download->subcategory): ?>
                            / <a href="<?php echo e(route('frontend.bank.downloads.subcategory', ['id' => $download->subcategory->id, 'slug' => $download->subcategory->slug])); ?>"><?php echo e($download->subcategory->title); ?></a>
                        <?php endif; ?>
                        / <span><?php echo e($download->title); ?></span>
                    </div>

                    <h1 class="page-title"><?php echo e($download->title); ?></h1>

                    <div class="download-info">
                        <div class="info-item">
                            <small class="text-muted"><?php echo app('translator')->get('published'); ?>: <?php echo e(optional($download->publish_date)->format('M d, Y')); ?></small>
                        </div>
                        <?php if($download->category): ?>
                            <div class="info-item">
                                <small class="text-muted"><?php echo app('translator')->get('category'); ?>: 
                                    <a href="<?php echo e(route('frontend.bank.downloads.category', ['id' => $download->category->id, 'slug' => $download->category->slug])); ?>">
                                        <?php echo e($download->category->title); ?>

                                    </a>
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($download->description): ?>
                        <div class="download-description mt-4">
                            <h5><?php echo app('translator')->get('description'); ?></h5>
                            <p><?php echo e($download->description); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; ?>
                    
                    <?php if(count($files) > 0): ?>
                        <div class="download-files mt-5">
                            <h5><?php echo app('translator')->get('available_files'); ?></h5>
                            <div class="files-list">
                                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="file-item">
                                        <div class="file-info">
                                            <i class="icon-file"></i>
                                            <div class="file-details">
                                                <strong class="file-name"><?php echo e($file['original_name']); ?></strong>
                                                <?php if(isset($file['size'])): ?>
                                                    <small class="file-size text-muted"><?php echo e(formatBytes($file['size'])); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <a href="<?php echo e(asset('assets/uploads/bank-downloads/' . $file['name'])); ?>" 
                                           class="btn btn-primary btn-sm" 
                                           download="<?php echo e($file['original_name']); ?>">
                                            <i class="icon-download-alt"></i> <?php echo app('translator')->get('download'); ?>sdsads
                                        </a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <div class="share-section mt-5 pt-4 border-top">
                        <h6><?php echo app('translator')->get('share_this'); ?></h6>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('frontend.bank.downloads.single', $download->slug))); ?>" 
                               class="btn btn-sm btn-light" target="_blank">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(route('frontend.bank.downloads.single', $download->slug))); ?>&text=<?php echo e(urlencode($download->title)); ?>" 
                               class="btn btn-sm btn-light" target="_blank">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(urlencode(route('frontend.bank.downloads.single', $download->slug))); ?>" 
                               class="btn btn-sm btn-light" target="_blank">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">
                <?php if($related_downloads->count() > 0): ?>
                    <div class="related-downloads-widget">
                        <h5 class="widget-title"><?php echo app('translator')->get('related_downloads'); ?></h5>
                        <div class="related-list">
                            <?php $__currentLoopData = $related_downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="related-item">
                                    <a href="<?php echo e(route('frontend.bank.downloads.single', $related->slug)); ?>" class="related-link">
                                        <?php echo e($related->title); ?>

                                    </a>
                                    <small class="text-muted"><?php echo e(optional($related->publish_date)->format('M d, Y')); ?></small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="download-stats-widget mt-4">
                    <h6><?php echo app('translator')->get('file_information'); ?></h6>
                    <div class="stats-list">
                        <div class="stat-item">
                            <span><?php echo app('translator')->get('total_files'); ?></span>
                            <strong><?php echo e(count($files)); ?></strong>
                        </div>
                        <?php
                            $total_size = 0;
                            foreach($files as $file) {
                                $total_size += isset($file['size']) ? $file['size'] : 0;
                            }
                        ?>
                        <div class="stat-item">
                            <span><?php echo app('translator')->get('total_size'); ?></span>
                            <strong><?php echo e(formatBytes($total_size)); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bank-download-single-page {
    padding: 40px 0;
}

.breadcrumb {
    font-size: 14px;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.page-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #212529;
}

.download-info {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #dee2e6;
}

.info-item {
    flex: 1;
    min-width: 200px;
}

.download-description {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.download-description h5 {
    font-weight: 600;
    margin-bottom: 15px;
}

.download-files h5 {
    font-weight: 600;
    margin-bottom: 20px;
}

.files-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.file-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
}

.file-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-grow: 1;
}

.file-info i {
    font-size: 24px;
    color: #007bff;
}

.file-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.file-name {
    word-break: break-word;
}

.file-size {
    font-size: 12px;
}

.share-section h6 {
    font-weight: 600;
    margin-bottom: 15px;
}

.share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.related-downloads-widget,
.download-stats-widget {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.widget-title {
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #dee2e6;
}

.related-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.related-item {
    padding-bottom: 15px;
    border-bottom: 1px solid #dee2e6;
}

.related-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.related-link {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
}

.related-link:hover {
    text-decoration: underline;
}

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #dee2e6;
}

.stat-item span {
    color: #6c757d;
    font-size: 14px;
}

.stat-item strong {
    font-weight: 600;
    color: #212529;
}

.download-stats-widget h6 {
    font-weight: 600;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 24px;
    }

    .file-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .file-info {
        width: 100%;
    }
}
</style>

<?php if(!function_exists('formatBytes')): ?>
    <?php
    function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/bank-download/single.blade.php ENDPATH**/ ?>