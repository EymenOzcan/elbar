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
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <?php echo e($team->name); ?>

                </h2>
                <?php if($team->description): ?>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><?php echo e($team->description); ?></p>
                <?php endif; ?>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.teams.edit', $team)); ?>" style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    Düzenle
                </a>
                <a href="<?php echo e(route('admin.teams.index')); ?>" style="background-color: #4b5563; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    Geri
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mesajlar -->
            <?php if($message = Session::get('success')): ?>
                <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900 p-4">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200"><?php echo e($message); ?></p>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Ekip Bilgileri -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Durum</p>
                        <?php if($team->is_active): ?>
                            <span style="background-color: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span style="background-color: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                Pasif
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Ekip Lideri</p>
                        <?php if($team->leader): ?>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100"><?php echo e($team->leader->name); ?></p>
                        <?php else: ?>
                            <p class="text-lg font-semibold text-gray-500 dark:text-gray-400">Atanmamış</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Personel Sayısı</p>
                        <h3 style="color: #3b82f6; font-size: 2.25rem; font-weight: bold; margin-top: 0.5rem;">
                            <?php echo e($team->personels->count()); ?>

                        </h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Oluşturulma</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100"><?php echo e($team->created_at->format('d.m.Y')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Ekip Personeli -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ekip Personeli</h3>
                    
                    <?php if($team->personels->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Personel Adı</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Telefon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Çalışan Tipi</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlem</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php $__currentLoopData = $team->personels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamPersonel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <strong class="text-gray-900 dark:text-gray-100"><?php echo e($teamPersonel->personel->full_name); ?></strong>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <?php echo e($teamPersonel->personel->email ?? '-'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <?php echo e($teamPersonel->personel->phone ?? '-'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-block px-2 py-1 text-xs rounded <?php echo e($teamPersonel->personel->employment_type === 'primli' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'); ?>">
                                                    <?php echo e(ucfirst($teamPersonel->personel->employment_type)); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="<?php echo e(route('admin.teams.remove-personel', [$team, $teamPersonel])); ?>" method="POST" class="inline" onsubmit="return confirm('Personeli çıkarmak istediğinize emin misiniz?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" style="color: #ef4444;" class="hover:opacity-75">Çıkar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="rounded-md bg-blue-50 dark:bg-blue-900 p-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                Bu ekipte henüz personel bulunmamaktadır.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH /Users/eymenozcan/el-bar---/resources/views/admin/teams/show.blade.php ENDPATH**/ ?>