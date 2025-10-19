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
                Takım Düzenle: <?php echo e($team->name); ?>

            </h2>
            <a href="<?php echo e(route('group-leader.teams.show', $team)); ?>" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                ← Geri Dön
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="<?php echo e(route('group-leader.teams.update', $team)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

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
                                value="<?php echo e(old('name', $team->name)); ?>" 
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
                                rows="4"><?php echo e(old('description', $team->description)); ?></textarea>
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
                                    <option value="<?php echo e($leader->id); ?>" <?php echo e(old('leader_id', $team->leader_id) == $leader->id ? 'selected' : ''); ?>>
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

                        <!-- Aktif Durumu -->
                        <div class="mb-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1"
                                    class="w-4 h-4 rounded"
                                    <?php echo e(old('is_active', $team->is_active) ? 'checked' : ''); ?>>
                                <span class="ml-3 text-gray-700 dark:text-gray-300 font-medium">
                                    Aktif
                                </span>
                            </label>
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
                                <?php
                                    $selectedPersonelEmails = $team->personels->map(fn($tp) => $tp->personel->email)->toArray();
                                ?>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if(!in_array($user->email, $selectedPersonelEmails)): ?>
                                        <div class="flex items-center p-3 border-b dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 user-item" data-search="<?php echo e(strtolower($user->name . ' ' . $user->email)); ?>">
                                            <input type="checkbox" name="personel_ids[]" value="user_<?php echo e($user->id); ?>" class="mr-3 w-4 h-4" id="user_<?php echo e($user->id); ?>">
                                            <label for="user_<?php echo e($user->id); ?>" class="cursor-pointer flex-1 text-gray-800 dark:text-gray-200">
                                                <div class="font-semibold"><?php echo e($user->name); ?></div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($user->email); ?></div>
                                            </label>
                                        </div>
                                    <?php endif; ?>
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
                            <a href="<?php echo e(route('group-leader.teams.show', $team)); ?>" 
                                style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                                İptal
                            </a>
                            <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer;">
                                Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Takım Üyeleri -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Takım Üyeleri (<?php echo e($team->personels()->count()); ?>)
                    </h3>

                    <?php if($team->personels()->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Ad Soyad</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">E-mail</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Telefon</th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">İşe Alım Türü</th>
                                        <th class="text-center py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $team->personels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                                    <?php echo e($tp->personel->full_name); ?>

                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                <?php echo e($tp->personel->email ?? '-'); ?>

                                            </td>
                                            <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                <?php echo e($tp->personel->phone ?? '-'); ?>

                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                                    <?php if($tp->personel->employment_type === 'full_time'): ?>
                                                        bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                                    <?php elseif($tp->personel->employment_type === 'part_time'): ?>
                                                        bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                    <?php else: ?>
                                                        bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                                                    <?php endif; ?>
                                                ">
                                                    <?php switch($tp->personel->employment_type):
                                                        case ('full_time'): ?>
                                                            Tam Zamanlı
                                                            <?php break; ?>
                                                        <?php case ('part_time'): ?>
                                                            Yarı Zamanlı
                                                            <?php break; ?>
                                                        <?php default: ?>
                                                            Belirsiz
                                                    <?php endswitch; ?>
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <form action="<?php echo e(route('group-leader.teams.remove-personel', [$team, $tp])); ?>" method="POST" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 font-medium"
                                                        onclick="return confirm('Personeli takımdan çıkarmak istediğinize emin misiniz?')">
                                                        Çıkar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Henüz takımda personel bulunmamaktadır.</p>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH /Users/eymenozcan/el-bar---/resources/views/group-leader/teams/edit.blade.php ENDPATH**/ ?>