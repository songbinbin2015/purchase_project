
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>采购列表管理</h5>
        </div>
        <div class="ibox-content">
          
            <a href="<?php echo e(route('purchases.create')); ?>" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加采购</button></a>
            <a href="<?php echo e(route('purchases.import')); ?>" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 导入采购</button></a>
            <form method="post" action="" name="form">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                    <tr>
                        <th class="text-center" width="100">ID</th>
                        <th>产品名称</th>
                        <th>产品类别</th>
                        <th >产品尺寸</th>
                        <th >产品厚度</th>
                        <th >产品材质</th>
                        <th >产品状态</th>
                        <th class="text-center" width="250">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $purchases_array['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($item['name']); ?></td>
                        <td><?php echo e($item['category']['name']); ?></td>
                        <td><?php echo e($item['size']); ?></td>
                        <td><?php echo e($item['thickness']); ?></td>
                        <td><?php echo e($item['texture']); ?></td>
                        <td><?php if($item['status'] == 0): ?> <span class="text-navy">下架</span><?php elseif($item['status'] == 1): ?> <span class="text-navy">正常</span><?php else: ?> <span class="text-navy">其他</span><?php endif; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="<?php echo e(route('purchases.edit',$item['id'])); ?>">
                                    <button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 修改</button>
                                </a>
                                <?php if($item['status'] == 0): ?>
                                    <a href="<?php echo e(route('purchases.status',['status'=>1,'id'=>$item['id']])); ?>"><button class="btn btn-info btn-xs" type="button"><i class="fa fa-warning"></i> 上架</button></a>
                                <?php elseif($item['status'] == 1): ?>
                                <a href="<?php echo e(route('purchases.status',['status'=>0,'id'=>$item['id']])); ?>"><button class="btn btn-info btn-xs" type="button"><i class="fa fa-warning"></i> 下架</button></a>
                                    <?php else: ?>
                                    <a href="<?php echo e(route('purchases.status',['status'=>1,'id'=>$item['id']])); ?>"><button class="btn btn-warning btn-xs" type="button"><i class="fa fa-warning"></i> 恢复上架</button></a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('purchases.delete',$item['id'])); ?>" onclick="return confirm('删除后无法找回,请确认?');"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-trash-o" ></i> 删除</button></a>
                                <a href="<?php echo e(route('purchases.show',$item['id'])); ?>"><button class="btn btn-success" type="button"><i class="fa fa-trash-o" ></i>查看</button></a>
                            </div>
                        </td>
                    </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($purchases->links()); ?>

            </form>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>