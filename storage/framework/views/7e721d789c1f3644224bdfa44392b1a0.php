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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Takımım')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if($team): ?>
                <!-- Leave Team Action -->
                <div class="mb-6 flex justify-end">
                    <form method="POST" action="<?php echo e(route('personnel.team.leave')); ?>" class="inline" onsubmit="return confirm('Takımdan ayrılmak istediğinize emin misiniz?');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Takımdan Ayrıl
                        </button>
                    </form>
                </div>

                <!-- Team Information Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Team Name Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Takım Adı</div>
                        <div class="mt-2 text-xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($team->name); ?></div>
                    </div>

                    <!-- Team Leader Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Takım Lideri</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            <?php echo e($teamStats['team_leader']?->name ?? 'Atanmadı'); ?>

                        </div>
                    </div>

                    <!-- Group Leader Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Grup Lideri</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            <?php echo e($teamStats['group_leader']?->name ?? 'Atanmadı'); ?>

                        </div>
                    </div>

                    <!-- Total Colleagues Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-gray-600 dark:text-gray-400 text-sm font-medium">Takım Üyeleri</div>
                        <div class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400"><?php echo e($teamStats['total_colleagues']); ?></div>
                    </div>
                </div>

                <!-- Team Colleagues Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Takım Arkadaşları</h3>

                        <?php if($colleagues->count() > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Ad Soyad</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">E-mail</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">Telefon</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-700 dark:text-gray-300">İşe Alım Türü</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $colleagues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colleague): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <td class="py-3 px-4">
                                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                                        <?php echo e($colleague->name); ?> <?php echo e($colleague->surname); ?>

                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                    <?php echo e($colleague->email ?? '-'); ?>

                                                </td>
                                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                                    <?php echo e($colleague->phone ?? '-'); ?>

                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                                        <?php if($colleague->employment_type === 'full_time'): ?>
                                                            bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                                        <?php elseif($colleague->employment_type === 'part_time'): ?>
                                                            bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                        <?php else: ?>
                                                            bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300
                                                        <?php endif; ?>
                                                    ">
                                                        <?php switch($colleague->employment_type):
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
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Henüz başka takım arkadaşı bulunmamaktadır.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Team Description (if available) -->
                <?php if($team->description): ?>
                    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Takım Açıklaması</h3>
                        <p class="text-gray-700 dark:text-gray-300"><?php echo e($team->description); ?></p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- No Team Assigned -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="text-center">
                        <div class="text-gray-500 dark:text-gray-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Takım Bulunamadı</h3>
                        <p class="text-gray-600 dark:text-gray-400">Henüz herhangi bir takıma atanmamışsınız.</p>
                    </div>
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
<?php /**PATH /Users/eymenozcan/el-bar---/resources/views/personnel/dashboard.blade.php ENDPATH**/ ?>