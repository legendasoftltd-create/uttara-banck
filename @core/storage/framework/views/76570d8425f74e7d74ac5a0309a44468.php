<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Branch, Sub-Branch & ATM List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Branch, Sub-Branch & ATM List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    

    <section class="location-section">
                <div class="container-fluid">
                <div class="empty-height-50"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center title-color">
                                FIND OUR LOCATIONS
                            </h2>
                            <div class="title-seperator">
                            </div>
                        </div>
                    </div>
                        <br>
                        <br>
                    <div class="tab-wrapper">
                    <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <button class="tab <?php echo e($key === 0 ? 'active' : ''); ?>" data-tab="<?php echo e($type); ?>">
                            <?php echo e(ucwords(str_replace('_',' ', $type))); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-lg-12">
                            <div class="alert alert-warning"><?php echo e(__('No locations found for the selected filters.')); ?></div>
                        </div>
                    <?php endif; ?>
                    </div>
                    <div class="location-grid">
                        <div class="map-area" id="mapFrame">
                        </div>

                        <div class="list-area">
                            <div class="search-boxs">
                                <input type="text" id="searchInputLocation" placeholder="Search...">
                            </div>
                            <div class="branch-list" id="branchList"></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php
            $locationData = $locationDirectory->groupBy('type')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'address' => $item->address,
                        'phone' => $item->mobile,
                        'email' => $item->email,
                        'division' => $item->division,
                        'district' => $item->district,
                        'upazila' => $item->upazila,
                        'map' => $item->map,
                        'latitude' => $item->latitude,
                        'longitude' => $item->longitude,
                        'query' => collect([
                            $item->name,
                            $item->address,
                            $item->upazila,
                            $item->district,
                            $item->division,
                            $item->email,
                            $item->mobile,
                            $item->routing_no
                        ])->filter()->implode(', '),
                    ];
                })->values();
            });
        ?>
<script>
    window.locationData = <?php echo json_encode($locationData, 15, 512) ?>;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/locations/index.blade.php ENDPATH**/ ?>