@extends('admin.layouts.layout')
@section('content')
{{--<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-warning alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            系统权限菜单，非专业技术人员请勿修改、增加、删除等操作。
        </div>
    </div>
</div>--}}
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>权限列表</h5>
        </div>
        <div class="ibox-content">
            <a href="{{route('categorys.create')}}" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加分类</button></a>
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
                @foreach($categorys as $k=>$item)
                    <tr>
                        <td>{{$item['_name']}}</td>
                        <td>
                            @if($item['_level'] == 1)
                                一级分类
                            @elseif($item['_level'] == 2)
                                二级分类
                            @elseif($item['_level'] == 3)
                                三级分类
                            @elseif($item['_level'] == 4)
                                四级分类
                            @else
                                {{$item['_level']}}级分类
                            @endif
                        <td>{{$item['path']}}</td>
                        <td class="text-center">
                            <a href="{{route('categorys.edit',$item['id'])}}">
                                <button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 修改</button>
                            </a>
                            <form class="form-common" action="{{route('categorys.destroy',$item['id'])}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger btn-xs"  type="submit" onclick="return confirm('删除分类会相应的删除子类？');"><i class="fa fa-trash-o"></i> 删除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection