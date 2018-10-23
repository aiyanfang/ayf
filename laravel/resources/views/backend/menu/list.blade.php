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
            <font style="vertical-align: inherit;">权限列表</font></font>
        </li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
@stop

@section('content')
    <div class="box box-primary">
    <div class="box-header with-border">
    <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">权限列表</font></font></h3>
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
        <a href="{{asset('menu/insert')}}" class="label label-primary">添加权限</a>
    </div>
    <table class="table table-hover table-striped">
        <tr align="center">
            <td>菜单ID</td>
            <td>菜单名称</td>
            <td>父级菜单</td>
            <td>菜单级别</td>
            <td>操作</td>
        </tr>
        @foreach ($powerData as $key => $value)
            <tr align="center">
                <td>{{$value['menu_id']}}</td>
                <td><?php $count = substr_count($value['path'],'-'); echo str_repeat('|--',$count);?>{{$value['menu_name']}}</td>
                <td>
                    @foreach($powerData as $key => $val)
                        <?php if ($value['pid'] == $val['menu_id']) {?>{{$val['menu_name']}}<?php }?>
                    @endforeach
                </td>
                <td>{{$value['path']}}</td>
                <td>
                    <a href="/power/delete?id={{$value['menu_id']}}" class="label label-success">删除</a> 
                    <a href="/power/update?id={{$value['menu_id']}}" class="label label-warning">修改</a>
                </td>
            </tr>
            
        @endforeach

    </table>
    </div>
@stop

