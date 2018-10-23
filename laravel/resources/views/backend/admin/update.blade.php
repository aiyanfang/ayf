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
            <font style="vertical-align: inherit;">管理员修改</font></font>
        </li>
    </ol>
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">管理员修改</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="/admin/update" method="post">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="user_id" value="{{$updateData['user_id']}}">
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">管理员名称</font></font></label>
                    <input type="text" class="form-control" name="username" value="{{$updateData['username']}}" placeholder="Username" disabled="">
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">电子邮件地址</font></font></label>
                    <input type="email" class="form-control" name="email" value="{{$updateData['email']}}" placeholder="Enter email" disabled="">
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系方式</font></font></label>
                    <input type="text" class="form-control" name="mobile" value="{{$updateData['mobile']}}" placeholder="Mobile" disabled="">
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">密码</font></font></label>
                    <input type="password" class="form-control" name="password" value="{{$updateData['password']}}" placeholder="Password" disabled="">
                </div>
                <div class="form-group">
                  <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">状态</font></font></label>
                  <div class="radio" style="margin-left:20px;">
                    @if($updateData['is_super'] == 0)
                        <label><input type="radio" name="is_fweze" value="1" <?php if($updateData['is_freeze'] == 1){ echo "checked=''";}?>>可用</label>
                        <label><input type="radio" name="is_fweze"  value="0" <?php if($updateData['is_freeze'] == 0){ echo "checked=''";}?>>冻结</label>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">分配角色</font></font></label>
                    <div class="checkbox" style="margin-left:20px;">
                        @foreach($roles as $key => $item)
                            <label>
                                <input type="checkbox" class="from-control" name="roles[]" id="role" value="{{$item['role_id']}}" <?php if($item['role_id'] == $roleData['role_id']){ echo "checked=''";}?>>
                                {{$item['role_name']}}
                            </label>
                        @endforeach
                            <span id="r_info"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">当前管理员</font></font></label>
                    <input type="text" class="form-control" name="create_name" value="{{$updateData['create_name']}}" placeholder="Mobile" disabled="">
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
