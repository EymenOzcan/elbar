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
                <?php echo e(__('Takımlarım')); ?>

            </h2>
            <a href="<?php echo e(route('group-leader.teams.create')); ?>" style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                + Yeni Takım
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <?php if($teams->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100"><?php echo e($team->name); ?></h3>
                                        <?php if($team->description): ?>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo e(Str::limit($team->description, 100)); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        <?php if($team->is_active): ?>
                                            bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                        <?php else: ?>
                                            bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                        <?php endif; ?>
                                    ">
                                        <?php echo e($team->is_active ? 'Aktif' : 'Pasif'); ?>

                                    </span>
                                </div>

                                <div class="space-y-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                                    <?php if($team->leader): ?>
                                        <div><strong>Takım Lideri:</strong> <?php echo e($team->leader->name); ?></div>
                                    <?php endif; ?>
                                    <div><strong>Personel Sayısı:</strong> <?php echo e($team->personels_count); ?></div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="<?php echo e(route('group-leader.teams.show', $team)); ?>" 
                                        class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium text-sm">
                                        Görüntüle
                                    </a>
                                    <a href="<?php echo e(route('group-leader.teams.edit', $team)); ?>" 
                                        class="flex-1 text-center px-3 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium text-sm">
                                        Düzenle
                                    </a>
                                    <form action="<?php echo e(route('group-leader.teams.destroy', $team)); ?>" method="POST" style="flex: 1;" onsubmit="return confirm('Takımı silmek istediğinize emin misiniz?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium text-sm">
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <?php echo e($teams->links()); ?>

                </div>
            <?php else: ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Henüz herhangi bir takım oluşturmamışsınız.</p>
                        <a href="<?php echo e(route('group-leader.teams.create')); ?>" 
                            style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none;">
                            Yeni Takım Oluştur
                        </a>
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
<?php /**PATH /Users/eymenozcan/el-bar---/resources/views/group-leader/teams/index.blade.php ENDPATH**/ ?>