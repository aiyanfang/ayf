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
            <td>管理员名称</td>
            <td>管理员邮箱</td>
            <td>管理员手机</td>
            <td>添加人</td>
            <td>超级管理员</td>
            <td>是否冻结</td>
            <td>最后登录时间</td>
            <td>操作</td>
        </tr>
        @foreach ($adminData as $key => $value)
        <tr align="center">
            <td><input type="checkbox" name="" id=""></td>
            <td>{{$value->username}}</td>
            <td>{{$value->email}}</td>
            <td>{{$value->mobile?:'此管理员手机号码未知'}}</td>
            <td>{{$value->create_name}}</td>
            <td>
                @if($value->is_super == 1)
                    <span class="label label-danger"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">超级管理员</font></font></span>
                @else
                    <span class="label label-success"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">普通管理员</font></font>
                    </span>
                @endif
            </td>
            <td>
                @if($value->is_freeze == 1)
                    <a href="" class="label label-success">可用</a>
                @else
                    <a href="" class="label label-danger">冻结</a>
               @endif
            </td>
            <td>{{date('Y-m-d H:i:s',$value->login_time)}}</td>
            <td>
                @if($value->is_super == 1)
                    <a href="" class="label label-primary">查看权限</a>
                @else
                    <a href="" class="label label-primary">查看权限</a>
                    <a href="/admin/delete?id={{$value->user_id}}" class="label label-success">删除</a> 
                    <a href="/admin/update?id={{$value->user_id}}" class="label label-warning">修改</a>
                @endif
            </td>
        </tr>
        @endforeach
    {{ $adminData->links() }}
    </table>
    </div>
@stop

