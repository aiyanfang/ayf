@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>管理员管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">管理员管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">管理员列表</font></font>
        </li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
@stop

@section('content')
    <div class="box box-primary">
    <div class="box-header with-border">
    <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">管理员列表</font></font></h3>
    <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
            <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
    </div>
    <div class="mailbox-controls">
        <a href="{{asset('admin/insert')}}" class="label label-primary">添加管理员</a>
    </div>
    <table class="table table-hover table-striped">
        <tr align="center">
            <td></td>
            <td>商品名称</td>
            <td>商品描述</td>
            <td>分类名称</td>
            <td>商品价格</td>
            <td>出售价格</td>
            <td>商品图片</td>
            <td>操作</td>
        </tr>
        @foreach ($goodsData as $key => $value)
        <tr align="center">
            <td><input type="checkbox" name="" id=""></td>
            <td>{{$value->goods_name}}</td>
            <td>
                <?php $str = $value->goods_desc; if (strlen($str)>5) $str=substr($str,0,10) . '...'; echo $str;?>
            </td>
            <td>{{$value->goods_price}}</td>
            <td>{{$value->sell_price}}</td>
            <td><img src="goods/image/{{$value->goods_image}}" alt="" width="50px"></td>
            <td>
                <a href="" class="label label-success">删除</a> 
                <a href="/admin/update?id={{$value->user_id}}" class="label label-warning">修改</a>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $goodsData->links() }}
    </div>
@stop

