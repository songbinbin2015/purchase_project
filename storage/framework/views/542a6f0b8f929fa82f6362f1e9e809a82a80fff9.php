
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>权限列表</h5>
        </div>
        <div class="ibox-content">
            <a href="<?php echo e(route('categorys.create')); ?>" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加分类</button></a>
            <table class="table table-striped table-bordered table-hover m-t-md">
                <thead>
                    <tr>
                        <th>分类名称</th>
                        <th>分类等级</th>
                        <th>分类路径</th>
                        <th class="text-center" width="250">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item['_name']); ?></td>
                        <td>
                            <?php if($item['_level'] == 1): ?>
                                一级分类
                            <?php elseif($item['_level'] == 2): ?>
                                二级分类
                            <?php elseif($item['_level'] == 3): ?>
                                三级分类
                            <?php elseif($item['_level'] == 4): ?>
                                四级分类
                            <?php else: ?>
                                <?php echo e($item['_level']); ?>级分类
                            <?php endif; ?>
                        <td><?php echo e($item['path']); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('categorys.edit',$item['id'])); ?>">
                                <button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 修改</button>
                            </a>
                            <form class="form-common" action="<?php echo e(route('categorys.destroy',$item['id'])); ?>" method="post">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('DELETE')); ?>

                                <button class="btn btn-danger btn-xs"  type="submit" onclick="return confirm('删除分类会相应的删除子类？');"><i class="fa fa-trash-o"></i> 删除</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>