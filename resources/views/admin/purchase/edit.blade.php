@extends('admin.layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>添加管理员</h5>
        </div>
        <div class="ibox-content">
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
            <a href="{{route('purchases.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 商品列表</button></a>
            <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            <form class="form-horizontal m-t-md" action="{{ route('purchases.update',$purchase->id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{method_field('PATCH')}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品名称：</label>
                    <div class="input-group col-sm-2">
                        <input type="text" class="form-control" name="name" value="{{$purchase->name}}" required data-msg-required="请输入产品名称">
                        @if ($errors->has('name'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品尺寸：</label>
                    <div class="input-group col-sm-2">
                        <input type="text" class="form-control" name="size" value="{{$purchase->size}}" required data-msg-required="请输入产品尺寸">
                        @if ($errors->has('size'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('size')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品厚度：</label>
                    <div class="input-group col-sm-2">
                        <input type="text" class="form-control" name="thickness" value="{{$purchase->thickness}}" required data-msg-required="请输入产品厚度">
                        @if ($errors->has('texture'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('thickness')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品材质：</label>
                    <div class="input-group col-sm-2">
                        <input type="text" class="form-control" name="texture" value="{{$purchase->texture}}" required data-msg-required="请输入产品材质">
                        @if ($errors->has('texture'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('texture')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品分类：</label>
                    <div class="col-sm-2">
                        <select name="category" class="form-control">
                            @foreach($categoryTree as $k=>$item)
                                <option value="{{$item['id']}}" @if ($purchase->category == $item['id']) selected @endif>{{$item['_name']}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('category')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品图片：</label>
                    <div class="input-group col-sm-2">
                        <input type="file" class="form-control" name="image">
                        @if ($errors->has('image'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('image')}}</span>
                        @endif
                        <span class="view picview ">
                           <img id="thumbnail-avatar" class="thumbnail img-responsive" src="{{$purchase->image}}" width="100" height="100">
                        </span>
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">产品状态：</label>
                    <div class="input-group col-sm-1">
                        <select class="form-control" name="status">
                            <option value="0" @if($purchase->status == 0) selected="selected" @endif>下架</option>
                            <option value="1" @if($purchase->status == 1) selected="selected" @endif>正常</option>
                            <option value="2" @if($purchase->status == 2) selected="selected" @endif>其他</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('status')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">产品状态：</label>
                    <div class="input-group col-sm-9">
                        <!-- 加载编辑器的容器 -->
                        <script id="container" name="details" type="text/plain">@php
                                echo $purchase->details;
                            @endphp</script>
                        <!-- 配置文件 -->
                        <script type="text/javascript" src="{{loadEdition('/ueditor/ueditor.config.js')}}"></script>
                        <!-- 编辑器源码文件 -->
                        <script type="text/javascript" src="{{loadEdition('/ueditor/ueditor.all.js')}}"></script>
                        <!-- 实例化编辑器 -->
                        <script type="text/javascript">
                            var ue = UE.getEditor('container',{
                                allowDivTransToP: false
                            });
                            ue.ready(function(){
                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                            });
                        </script>
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
            </form>
        </div>
    </div>
</div>
@endsection