<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <h1 class="latest text-center mb-5">Auction</h1>

                    <div class="row sort mb-3 d-flex align-items-center">
                        <div class="col-8">
                            <p class="pt-3 text-muted"><?php echo e(request('order') == 'asc' ? 'Sorted price from lower to higher' : 'Sorted price from higher to lower'); ?></p>
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            <form action="<?php echo e(route('dashboard')); ?>" method="GET">
                                <input type="hidden" name="order"
                                       value="<?php echo e(request('order') == 'desc' ? 'asc' : 'desc'); ?>">
                                <?php if(request('page')): ?>
                                    <input type="hidden" name="page" value="<?php echo e(request('page')); ?>">
                                <?php endif; ?>
                                <?php if(request('search_term')): ?>
                                    <input type="hidden" name="search_term" value="<?php echo e(request('search_term')); ?>">
                                <?php endif; ?>
                                <button class="btn-transparent" type="submit">
                                    Price &nbsp;
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                         class="bi bi-filter" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                              d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                <div class="row items-row">
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-5">
                            <div class="card">
                                <img class="card-img-top item-thumbnail" src="<?php echo e(asset($item->thumbnail)); ?>"
                                     alt="<?php echo e($item->name); ?>">
                                <div class="card-body">
                                    <h5 class="card-title item-title"><?php echo e($item->name); ?></h5>
                                    <p class="text-muted mb-0">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd"
                                                        d="M5.443 1.991a60.17 60.17 0 0 0-2.725.802.454.454 0 0 0-.315.366C1.87 7.056 3.1 9.9 4.567 11.773c.736.94 1.533 1.636 2.197 2.093.333.228.626.394.857.5.116.053.21.089.282.11A.73.73 0 0 0 8 14.5c.007-.001.038-.005.097-.023.072-.022.166-.058.282-.111.23-.106.525-.272.857-.5a10.197 10.197 0 0 0 2.197-2.093C12.9 9.9 14.13 7.056 13.597 3.159a.454.454 0 0 0-.315-.366c-.626-.2-1.682-.526-2.725-.802C9.491 1.71 8.51 1.5 8 1.5c-.51 0-1.49.21-2.557.491zm-.256-.966C6.23.749 7.337.5 8 .5c.662 0 1.77.249 2.813.525a61.09 61.09 0 0 1 2.772.815c.528.168.926.623 1.003 1.184.573 4.197-.756 7.307-2.367 9.365a11.191 11.191 0 0 1-2.418 2.3 6.942 6.942 0 0 1-1.007.586c-.27.124-.558.225-.796.225s-.526-.101-.796-.225a6.908 6.908 0 0 1-1.007-.586 11.192 11.192 0 0 1-2.417-2.3C2.167 10.331.839 7.221 1.412 3.024A1.454 1.454 0 0 1 2.415 1.84a61.11 61.11 0 0 1 2.772-.815z"/>
                                                  <path fill-rule="evenodd"
                                                        d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                            </span>
                                        <span>Min Bid: <?php echo e($item->minimal_bid); ?></span>
                                    </p>
                                    <p class="text-muted">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                            </span>
                                        <span>
                                                Total Bids: <?php echo e($item->bids()->count()); ?>

                                            </span>
                                    </p>
                                    <a href="<?php echo e(route('item.show', ['item' => $item->id])); ?>"
                                       class="w-100 btn btn-primary">Bid
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <h1 class="w-100 text-danger mt-5 text-center">:( No Items Found</h1>
                    <?php endif; ?>
                </div>

                    <?php echo e($items->appends(request()->except('page'))->links()); ?>

            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Mini Project\auction-laravel\resources\views/home.blade.php ENDPATH**/ ?>