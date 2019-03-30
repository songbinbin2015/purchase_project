@extends('admin.layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>采购列表管理</h5>
        </div>
        <div class="ibox-content">
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
            <a href="{{route('purchases.create')}}" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加采购</button></a>
            <a href="" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 导入采购</button></a>
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
                        <th class="text-center" width="220">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases_array['data'] as $k=>$item)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['category']['name']}}</td>
                        <td>{{$item['size']}}</td>
                        <td>{{$item['thickness']}}</td>
                        <td>{{$item['texture']}}</td>
                        <td>@if ($item['status'] == 0) <span class="text-navy">下架</span>@elseif($item['status'] == 1) <span class="text-navy">正常</span>@else <span class="text-navy">其他</span>@endif</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{route('purchases.edit',$item['id'])}}">
                                    <button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 修改</button>
                                </a>
                                @if($item['status'] != 1)
                                    <a href="{{route('purchases.status',['status'=>1,'id'=>$item['id']])}}"><button class="btn btn-info btn-xs" type="button"><i class="fa fa-warning"></i> 恢复上架</button></a>
                                @else
                                    <a href="{{route('purchases.status',['status'=>2,'id'=>$item['id']])}}"><button class="btn btn-warning btn-xs" type="button"><i class="fa fa-warning"></i> 禁用</button></a>
                                @endif
                                <a href="{{route('purchases.delete',$item['id'])}}"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-trash-o"></i> 删除</button></a>
                            </div>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$purchases->links()}}
            </form>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
@endsection