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
    <meta name="description"
        content="<?php echo e(get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_tags')); ?>">
    <?php echo render_og_meta_image_by_attachment_id(
        get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_image'),
    ); ?>

<?php $__env->stopSection(); ?>

<?php
    if (!function_exists('bank_download_first_file')) {
        function bank_download_first_file($download)
        {
            $files = is_array($download->files) ? $download->files : [];
            return count($files) ? $files[0] : null;
        }
    }
?>

<?php $__env->startSection('content'); ?>
    <section class="bank-downloads-page padding-top-60 padding-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?php if($isCategoryPage): ?>
                        <div id="scroll-down"></div>
                        <div class="empty-height-50"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center title-color">
                                    <?php echo e($current_category->title); ?>

                                </h2>
                                <div class="title-seperator"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div id="scroll-down"></div>
                        <div class="empty-height-50"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center title-color">
                                    <?php echo e($page_title ?? 'Important Downloads'); ?>

                                </h2>
                                <div class="title-seperator"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($isCategoryPage): ?>
                <div class="download-pages">
                    <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center"
                        style="border-collapse: collapse; max-width:1230px;">
                        <thead>
                            <tr bgcolor="#008649">
                                <th class="text-center">
                                    <font color="#ffffff"><b>Sl No.</b></font>
                                </th>
                                <th width="70%" class="text-center">
                                    <font color="#ffffff"><b>Title</b></font>
                                </th>
                                <th class="text-center">
                                    <font color="#ffffff"><b>View</b></font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <tr class="dropdown-parent" data-dropdown="<?php echo e($current_category->id); ?>">
                                    <td class="text-center"><?php echo e(1); ?></td>
                                    <td><?php echo e($current_category->title); ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-view dropdown-toggle-parent" href="#" data-toggle="modal"
                                            data-target="#exampleModalCenter">View</a>
                                    </td>
                                </tr>
                                <?php $__currentLoopData = $current_category->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download_key => $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; ?>
                                    <?php $file = $files[0] ?? null; ?>
                                    <tr class=" dropdown-child" data-parent="<?php echo e($current_category->id); ?>">
                                        <td class="text-center"><?php echo e($download_key + 1); ?></td>
                                        <td><?php echo e($download->title); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                data-title="<?php echo e($download->title); ?>"
                                                data-file="<?php echo e($file ? asset('assets/uploads/bank-downloads/' . $file['name']) : ''); ?>">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $current_category->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory_key => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="dropdown-child dropdown-parent" data-parent="<?php echo e($current_category->id); ?>"
                                        data-dropdown="s-<?php echo e($subcategory_key); ?>">
                                        <td class="text-center"></td>
                                        <td><?php echo e($subcategory->title); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-view dropdown-toggle-parent" href="#">View</a>
                                            
                                        </td>
                                    </tr>

                                    <?php $__currentLoopData = $subcategory->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sdownload_key => $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; ?>
                                        <?php $file = $files[0] ?? null; ?>
                                        <tr class="dropdown-child" data-parent="s-<?php echo e($subcategory_key); ?>">
                                            <td class="text-center"><?php echo e($sdownload_key + 1); ?></td>
                                            <td><?php echo e($download->title); ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                    data-title="<?php echo e($download->title); ?>"
                                                    data-file="<?php echo e($file ? asset('assets/uploads/bank-downloads/' . $file['name']) : ''); ?>">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <br><br>
                <div class="row">
                    <div class="col-md-12">
                         <a class="btn btn-secoundary btn-block" href="<?php echo e(route('frontend.bank.downloads')); ?>">View All Downloads</a>
                    </div>
                </div>
                
            <?php else: ?>  
                <div class="download-pages">
                    <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center"
                        style="border-collapse: collapse; max-width:1230px;">
                        <thead>
                            <tr bgcolor="#008649">
                                <th class="text-center">
                                    <font color="#ffffff"><b>Sl No.</b></font>
                                </th>
                                <th width="70%" class="text-center">
                                    <font color="#ffffff"><b>Title</b></font>
                                </th>
                                <th class="text-center">
                                    <font color="#ffffff"><b>View</b></font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="dropdown-parent" data-dropdown="<?php echo e($key); ?>">
                                    <td class="text-center"><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($category->title); ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-view dropdown-toggle-parent" href="#" data-toggle="modal"
                                            data-target="#exampleModalCenter">View</a>
                                    </td>
                                </tr>
                                <?php $__currentLoopData = $category->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download_key => $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; ?>
                                    <?php $file = $files[0] ?? null; ?>
                                    <tr class=" dropdown-child" data-parent="<?php echo e($key); ?>">
                                        <td class="text-center"><?php echo e($download_key + 1); ?></td>
                                        <td><?php echo e($download->title); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                data-title="<?php echo e($download->title); ?>"
                                                data-file="<?php echo e($file ? asset('assets/uploads/bank-downloads/' . $file['name']) : ''); ?>">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $category->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory_key => $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="dropdown-child dropdown-parent" data-parent="<?php echo e($key); ?>"
                                        data-dropdown="s-<?php echo e($subcategory_key); ?>">
                                        <td class="text-center"></td>
                                        <td><?php echo e($subcategory->title); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-view dropdown-toggle-parent" href="#">View</a>
                                            
                                        </td>
                                    </tr>

                                    <?php $__currentLoopData = $subcategory->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sdownload_key => $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; ?>
                                        <?php $file = $files[0] ?? null; ?>
                                        <tr class="dropdown-child" data-parent="s-<?php echo e($subcategory_key); ?>">
                                            <td class="text-center"><?php echo e($sdownload_key + 1); ?></td>
                                            <td><?php echo e($download->title); ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter"
                                                    data-title="<?php echo e($download->title); ?>"
                                                    data-file="<?php echo e($file ? asset('assets/uploads/bank-downloads/' . $file['name']) : ''); ?>">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" style="overflow-y: scroll !important;">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;">
            <div class="modal-content" style="background-color: #FFF; max-width: 991px; width: 100%; margin: 0 auto;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/bank-download/index.blade.php ENDPATH**/ ?>