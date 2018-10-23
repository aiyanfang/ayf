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
            <font style="vertical-align: inherit;">角色修改</font></font>
        </li>
    </ol>
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色修改</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="/role/update" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="role_id" value="{{$roleData['role_id']}}">
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色名称</font></font></label>
                    <input type="text" class="form-control" name="role_name" value="{{$roleData['role_name']}}" placeholder="roleName">
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">提交</font></font></button>
            </div>
        </form>
    </div>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- script> console.log('Hi!'); </script> -->
@stop
