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
                Takım Lideri Paneli - Hoşgeldiniz <?php echo e(auth()->user()->name); ?>

            </h2>
            <?php if($team): ?>
                <a href="<?php echo e(route('team-leader.personel.index')); ?>" style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                    👥 Personel Yönetimi
                </a>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if($team): ?>
                <!-- Takım Bilgileri -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Yönettiğiniz Takım</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2"><?php echo e($team->name); ?></p>
                        <p class="text-gray-600 dark:text-gray-400 mb-4"><?php echo e($team->description ?: 'Açıklama belirtilmemiş'); ?></p>
                        
                        <?php if($team->groupLeader): ?>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Grup Lideri:</strong> <?php echo e($team->groupLeader->name); ?>

                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Takım İstatistikleri</h3>
                        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2"><?php echo e($stats['total_personels']); ?></p>
                        <p class="text-gray-600 dark:text-gray-400">personel bulunmaktadır</p>
                    </div>
                </div>

                <!-- Personeller -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Takım Personeli</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Yönettiğiniz personelleriniz aşağıda listelenmiştir</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Adı Soyadı</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Pozisyon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">İletişim</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $team->personels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamPersonel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                            <?php echo e($loop->iteration); ?>

                                        </td>
                                        <td class="px-6 py-4">
                                            <strong class="text-gray-900 dark:text-gray-100"><?php echo e($teamPersonel->personel->full_name); ?></strong>
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                            <?php echo e($teamPersonel->personel->translations->first()?->position ?? 'Belirtilmemiş'); ?>

                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                <?php if($teamPersonel->personel->email): ?>
                                                    <div><?php echo e($teamPersonel->personel->email); ?></div>
                                                <?php endif; ?>
                                                <?php if($teamPersonel->personel->phone): ?>
                                                    <div><?php echo e($teamPersonel->personel->phone); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Takımınızda henüz personel bulunmamaktadır.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Takım Ataması Yok</h3>
                    <p class="text-gray-600 dark:text-gray-400">Henüz size atanmış bir takım bulunmamaktadır. Lütfen yönetim ekibiyle iletişime geçiniz.</p>
                </div>
            <?php endif; ?>
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
<?php /**PATH /Users/eymenozcan/el-bar---/resources/views/team-leader/dashboard.blade.php ENDPATH**/ ?>