@extends('adminlte::page')
@section('title', '小米商城后台管理')
@section('content_header')
    <h1>权限管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">权限管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">权限修改</font></font>
        </li>
    </ol>
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">权限修改</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="/power/update" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="menu_id" value="{{$menuData['menu_id']}}">
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">权限名称</font></font></label>
                    <input type="text" class="form-control" name="menu_name" value="{{$menuData['menu_name']}}" placeholder="menuName">
                </div>
                <!-- <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">权限类型</font></font></label>
                    <select name="is_menu" id="">
                        <option value="{{menuData['']}}">菜单</option>
                        <option value="0">按钮</option>
                    </select>
                    <input type="text" class="form-control" name="menu_name" value="{{$menuData['menu_name']}}" placeholder="menuName">
                </div> -->
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
