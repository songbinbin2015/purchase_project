@extends('admin.layouts.layout')

@section('css')
<style>
    .animated{-webkit-animation-fill-mode: none;}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>添加分类</h5>
        </div>
        <div class="ibox-content">
            <a href="{{route('categorys.index')}}">
                <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 分类列表
                </button>
            </a>
            <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            <form class="form-horizontal m-t-md" action="{{route('categorys.store')}}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">上级分类：</label>
                    <div class="col-sm-2">
                        <select name="parent_id" class="form-control">
                            <option value="0">顶级分类</option>
                            @foreach($treer as $k=>$item)
                                <option value="{{$item['id']}}">{{$item['_name']}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('parent_id'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('parent_id')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类名称：</label>
                    <div class="col-sm-3">
                        <input type="text" name="name" value="{{old('name')}}" class="form-control" required data-msg-required="请输入分类名称">
                        @if ($errors->has('name'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类路径：</label>
                    <div class="col-sm-3">
                        <input type="text" name="path" value="{{old('path')}}" class="form-control">
                        @if ($errors->has('path'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('path')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">分类编码：</label>
                    <div class="col-sm-1">
                        <input type="text" name="code" value="{{old('code') ? old('code') : 255 }}" required class="form-control">
                        @if ($errors->has('code'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('code')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <div class="col-sm-12 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;保 存</button>
                        <button class="btn btn-white" type="reset"><i class="fa fa-repeat"></i> 重 置</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                {{csrf_field()}}
            </form>
        </div>
    </div>
</div>
<div id="functions" style="display: none;">
    @include('admin.rules.fonticon')
</div>
@section('footer-js')
<script>

    function showicon(){
        layer.open({
            type: 1,
            title:'点击选择图标',
            area: ['800px', '80%'], //宽高
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            content: $('#functions')
        });
    }

    $('.fontawesome-icon-list .fa-hover').find('a').click(function(){
        var str=$(this).text();
        $('#fonts').val( $.trim(str));
        layer.closeAll();
    })
</script>
@endsection
@endsection
