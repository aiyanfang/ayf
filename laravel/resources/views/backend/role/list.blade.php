@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>角色管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">角色管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">角色列表</font></font>
        </li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
@stop

@section('content')
    <div class="box box-primary">
    <div class="box-header with-border">
    <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色列表</font></font></h3>
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
        <a href="{{asset('admin/insert')}}" class="label label-primary">添加角色</a>
    </div>
    <table class="table table-hover table-striped">
        <tr align="center">
            <td>角色ID</td>
            <td>角色名称</td>
            <td>操作</td>
        </tr>
        @foreach ($roleData as $key => $value)
        <tr align="center">
            <td>{{$value->role_id}}</td>
            <td>{{$value->role_name}}</td>
            <td>
                <a href="/role/delete?id={{$value->role_id}}" class="label label-success">删除</a> 
                <a href="/role/update?id={{$value->role_id}}" class="label label-warning">修改</a>
            </td>
        </tr>
        @endforeach
    </table>
     {{ $roleData->links() }}
    </div>
@stop

