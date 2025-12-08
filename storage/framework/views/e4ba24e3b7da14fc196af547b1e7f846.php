<section>
    <header>
        <h5 class="fw-medium"><?php echo e(__('Update Password')); ?></h5>
        <p class="small text-secondary"><?php echo e(__('Ensure your account is using a long, random password to stay secure.')); ?></p>
    </header>

    <form method="post" action="<?php echo e(route('password.update')); ?>" class="mt-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label"><?php echo e(__('Current Password')); ?></label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label"><?php echo e(__('New Password')); ?></label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
            <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label"><?php echo e(__('Confirm Password')); ?></label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            <?php $__errorArgs = ['password_confirmation', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i><?php echo e(__('Save')); ?>

            </button>

            <?php if(session('status') === 'password-updated'): ?>
                <p class="small text-success mb-0"><?php echo e(__('Saved.')); ?></p>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>