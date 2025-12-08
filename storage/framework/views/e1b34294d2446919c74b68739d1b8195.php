<section>
    <header>
        <h5 class="fw-medium text-danger"><?php echo e(__('Delete Account')); ?></h5>
        <p class="small text-secondary"><?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.')); ?></p>
    </header>

    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        <i class="bi bi-trash me-1"></i><?php echo e(__('Delete Account')); ?>

    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="<?php echo e(route('profile.destroy')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('delete'); ?>
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel"><?php echo e(__('Are you sure you want to delete your account?')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary"><?php echo e(__('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.')); ?></p>

                        <div class="mt-3">
                            <label for="delete_password" class="form-label"><?php echo e(__('Password')); ?></label>
                            <input id="delete_password" name="password" type="password" class="form-control" placeholder="<?php echo e(__('Password')); ?>" />
                            <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i><?php echo e(__('Delete Account')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>