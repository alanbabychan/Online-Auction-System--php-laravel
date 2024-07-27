

<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row justify-content-center">
            <div class="col-md-12">

                <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="cover__image">
                            <img src="<?php echo e(asset($item->thumbnail)); ?>" alt="">

                            <div class="cover__profile">
                                <img src="<?php echo e(asset($item->thumbnail)); ?>" alt="">
                            </div>

                            <div class="cover__desc">
                                <h5 class="card-title item-title"><?php echo e($item->name); ?></h5>
                                <h4><?php echo e($item->description); ?></h4>
                                <div class="dates d-flex justify-content-end">
                                    Start - <?php echo e(date('d/m/Y H:i', strtotime($item->created_at))); ?> <br>
                                    Ends - <?php echo e(date('d/m/Y H:i', strtotime($item->expires_at))); ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-white pt-4 pl-4 pr-4 pb-4" style="margin-top: 150px">
            <div class="col-lg-12">
                <?php if(!lastBidder($item)): ?>
                    <div class="form-wrapper">
                        <form id="bidForm" action="<?php echo e(route('submitBid', $item->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="bid">
                                    <b class="d-block mb-0">Enter your bid amount</b>
                                    <small class="d-block text-muted mt-0 mb-3">Minimal bid amount is <?php echo e($item->minimal_bid); ?></small>
                                    <input type="number" class="form-control" id="bid" name="bid">
                                </label>
                            </div>
                        </form>
                        <form id="autoBidForm" action="<?php echo e(route('autobid', $item->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                        </form>
                        <div class="d-flex mb-4">
                            <button class="btn btn-primary btn-smaller mr-2" onclick="document.querySelector('#bidForm').submit()">Submit Bid</button>
                            <button class="btn btn-primary btn-smaller" onclick="document.querySelector('#autoBidForm').submit()"><?php echo e($item->autoBid()->where('user_id', auth()->user()->id)->count() > 0 ? 'Disable AutoBid' : 'Enable AutoBid'); ?></button>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-danger">
                        Cannot bid at the moment,
                        You already are the last bidder !
                    </p>
                <?php endif; ?>

                <table class="table table-condensed table-bordered table-striped">
                    <thead>
                    <th>ID</th>
                    <th>Bidder Name</th>
                    <th>Bid Amount</th>
                    <th>Date/Time</th>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter => $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(++$counter); ?></td>
                            <td><?php echo e($bid->user->name); ?></td>
                            <td><?php echo e($bid->bid_amount); ?></td>
                            <td><?php echo e($bid->created_at->diffForHumans()); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-center" colspan="4"><b>No bids submitted for this item</b></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Praveen\Auction\auction-laravel\resources\views/details.blade.php ENDPATH**/ ?>