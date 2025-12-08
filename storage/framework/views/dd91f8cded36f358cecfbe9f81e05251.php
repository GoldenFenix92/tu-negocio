<section>
    <header>
        <h5 class="fw-medium"><?php echo e(__('Profile Information')); ?></h5>
        <p class="small text-secondary"><?php echo e(__("Update your account's profile information and email address.")); ?></p>
    </header>

    <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
        <?php echo csrf_field(); ?>
    </form>

    <form method="post" action="<?php echo e(route('profile.update')); ?>" class="mt-4" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <div class="mb-3">
            <label for="profile_picture" class="form-label"><?php echo e(__('Profile Picture')); ?></label>
            <div class="mb-2">
                <img src="<?php echo e($user->imageUrl()); ?>" alt="Profile Picture" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
            <input id="profile_picture" name="profile_picture" type="file" class="form-control" />
            <?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if($user->profile_picture): ?>
                <div class="form-check mt-2">
                    <input type="checkbox" name="remove_profile_picture" id="remove_profile_picture" class="form-check-input">
                    <label for="remove_profile_picture" class="form-check-label small text-danger"><?php echo e(__('Remove Profile Picture')); ?></label>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label"><?php echo e(__('Name')); ?></label>
            <input id="name" name="name" type="text" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required autofocus autocomplete="name" />
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
            <input id="email" name="email" type="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username" />
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()): ?>
                <div class="mt-2">
                    <p class="small">
                        <?php echo e(__('Your email address is unverified.')); ?>

                        <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-underline">
                            <?php echo e(__('Click here to re-send the verification email.')); ?>

                        </button>
                    </p>

                    <?php if(session('status') === 'verification-link-sent'): ?>
                        <p class="small text-success">
                            <?php echo e(__('A new verification link has been sent to your email address.')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i><?php echo e(__('Save')); ?>

            </button>

            <?php if(session('status') === 'profile-updated'): ?>
                <p class="small text-success mb-0"><?php echo e(__('Saved.')); ?></p>
            <?php endif; ?>
        </div>
    </form>
</section>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>