<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Yeni Takım Oluştur
            </h2>
            <a href="<?php echo e(route('group-leader.teams.index')); ?>" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                ← Geri Dön
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="<?php echo e(route('group-leader.teams.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- Takım Adı -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Takım Adı *
                            </label>
                            <input type="text" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="name" 
                                name="name" 
                                placeholder="Örn: Pazarlama Takımı" 
                                value="<?php echo e(old('name')); ?>" 
                                required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Açıklama -->
                        <div class="mb-6">
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Açıklama
                            </label>
                            <textarea 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="description" 
                                name="description" 
                                rows="4" 
                                placeholder="Takım hakkında bilgi girin..."><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Takım Lideri -->
                        <div class="mb-6">
                            <label for="leader_id" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Takım Lideri
                            </label>
                            <select 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md <?php $__errorArgs = ['leader_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="leader_id" 
                                name="leader_id">
                                <option value="">-- Seçiniz --</option>
                                <?php $__currentLoopData = $teamLeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leader): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($leader->id); ?>" <?php echo e(old('leader_id') == $leader->id ? 'selected' : ''); ?>>
                                        <?php echo e($leader->name); ?> (<?php echo e($leader->email); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['leader_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Personel Seçimi -->
                        <div class="mb-6">
                            <label for="search" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                👥 Personel Ara
                            </label>
                            <input 
                                type="text" 
                                id="search_input" 
                                placeholder="Ad veya email ile ara..." 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                            
                            <div id="results" class="border rounded-md dark:bg-gray-900 dark:border-gray-700 max-h-64 overflow-y-auto">
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="flex items-center p-3 border-b dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 user-item" data-search="<?php echo e(strtolower($user->name . ' ' . $user->email)); ?>">
                                        <input type="checkbox" name="personel_ids[]" value="user_<?php echo e($user->id); ?>" class="mr-3 w-4 h-4" id="user_<?php echo e($user->id); ?>" <?php echo e(in_array('user_' . $user->id, old('personel_ids', [])) ? 'checked' : ''); ?>>
                                        <label for="user_<?php echo e($user->id); ?>" class="cursor-pointer flex-1 text-gray-800 dark:text-gray-200">
                                            <div class="font-semibold"><?php echo e($user->name); ?></div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($user->email); ?></div>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="p-3 text-gray-500 dark:text-gray-400">Kullanıcı bulunmamaktadır.</p>
                                <?php endif; ?>
                            </div>
                            <?php $__errorArgs = ['personel_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Butonlar -->
                        <div class="flex justify-end gap-2">
                            <a href="<?php echo e(route('group-leader.teams.index')); ?>" 
                                style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                                İptal
                            </a>
                            <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer;">
                                Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search_input').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('#results > div.user-item').forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/eymenozcan/el-bar---/resources/views/group-leader/teams/create.blade.php ENDPATH**/ ?>