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
            <font style="vertical-align: inherit;">管理员添加</font></font>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">管理员添加</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="insert" method="post">
            @csrf
            <input type="hidden" name="create_name" value="<?php $name = Session::get('userInfo'); echo $name['username']; ?>">
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">管理员名称</font></font></label>
                    <input type="text" class="form-control" name="username"  placeholder="Username" id="username">
                    <span id="username_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">密码</font></font></label>
                    <input type="password" class="form-control" name="password"  placeholder="Password" id="password">
                    <span id="password_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">电子邮件地址</font></font></label>
                    <input type="email" class="form-control" name="email"  placeholder="Enter email" id="email">
                    <span id="email_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">联系方式</font></font></label>
                    <input type="text" class="form-control" name="mobile"  placeholder="Mobile" id="mobile">
                    <span id="mobile_info"></span>
                </div>  
                <div class="form-group">
                  <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">分配角色</font></font></label>
                    <div class="checkbox" style="margin-left:20px;">
                        @foreach($roles as $key => $item)
                            <label>
                                <input type="checkbox" class="from-control" name="role[]" value="{{$item['role_id']}}">
                                {{$item['role_name']}}
                            </label>
                        @endforeach
                            <span id="role_info"></span>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button class="btn btn-primary" id="reset"  type="reset">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">重置</font></font>
                </button>
                <button type="submit" class="btn btn-primary" id="submit">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">提交</font></font>
                </button>
            </div>
        </form>
    </div>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>

    //   用户信息验证
    $(document).ready(function(){

        var checkUsername = '';
        var checkPassword = '';
        var checkEmail = '';
        var checkMobile = '';
        var check = ''; 

        //  用户名验证
        $("#username").blur(function(){
            var username = $(this).val();
            regular = /^[\u4E00-\u9FA5A-Za-z]{2,20}$/;
            if (username == '') {
                $('#username_info').text('用户名不能为空').css('color','red');$('#username').css('border-color','red');
                checkUsername = false;
            }else if (regular.test(username)) {
                $('#username_info').text("用户名验证成功").css('color','green');$('#username').css('border-color','green');
                $.ajax({
                    url:'userName',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','username':username},
                    success:function(msg){
                        if (msg == 2) {
                            // alert("用户名已存在");
                            $('#username_info').text('用户名已存在').css('color','red');$('#username').css('border-color','red');
                            checkUsername = false;
                        }else{
                            checkUsername = true;
                        }
                    },
                    error:function(msg){
                        alert("服务器繁忙");
                    }
                })
            }else{
                $("#username_info").text("用户名必须由汉字，字母组成").css('color','red');$('#username').css('border-color','red');
                checkUsername = false;
            }
        })
        
        //  密码验证
        $("#password").blur(function(){
            var password = $(this).val();
            regular = /^[a-z0-9A-Z]\w{5,17}$/;
            if (password == '') {
                $('#password_info').text('密码不能为空').css('color','red');$('#password').css('border-color','red');
                checkPassword = false;
            }else if (regular.test(password)) {
                $('#password_info').text('密码验证成功').css('color','green');$('#password').css('border-color','green');
                checkPassword = true;
            }else{
                $('#password_info').text('密码长度必须5-17位之间').css('color','red');$('#password').css('border-color','red');
                checkPassword = false;
            }
        })

        //  邮箱验证
        $("#email").blur(function(){
            var email = $(this).val();
            var regular = /^[A-Za-z0-9]+\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
            if (email == '') {
                $('#email_info').text('邮箱不能为空').css('color','red');$('#email').css('border-color','red');
                checkEmail = false;
            }else if (regular.test(email)) {
                $('#email_info').text("邮箱验证成功").css('color','green');$('#email').css('border-color','green');
                $.ajax({
                    url:'userName',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','email':email},
                    success:function(msg){
                        if (msg == 2) {
                            $('#email_info').text('邮箱已存在').css('color','red');$('#email').css('border-color','red');
                            checkEmail = false;
                        }else{
                            checkEmail = true;
                        }
                    },
                    error:function(msg){
                        alert("服务器繁忙");
                    }
                })
            }else{
                $("#email_info").text("邮箱格式不正确").css('color','red');$('#email').css('border-color','red');
                checkNick = false;
            }
        })

        //  手机号验证
        $("#mobile").blur(function(){
            var mobile = $(this).val();
            var regular = /^[1][34578]\d{9}$/;
            if (mobile == '') {
                $('#mobile_info').text('手机号不能为空').css('color','red');$('#mobile').css('border-color','red');
                return checkMobile = false;
            }else if (regular.test(mobile)) {
                $('#mobile_info').text('手机号验证成功').css('color','green');$('#mobile').css('border-color','green');
                $.ajax({
                    url:'userName',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','mobile':mobile},
                    success:function(msg){
                        if (msg == 2) {
                            $('#mobile_info').text('手机号已存在').css('color','red');$('#mobile').css('border-color','red');
                            checkMobile = false;
                        }else{
                            checkMobile = true;
                        }
                    },
                    error:function(msg){
                        alert("服务器繁忙");
                    }
                })
            }else{
                $('#mobile_info').text('验证失败').css('color','red');$('#mobile').css('border-color','red');
                checkMobile = false;
            }
            
        })
        
        // 多选框验证
        $("input[type='checkbox']").click(function(){
            var test = $("input[name='role[]']:checked");
            if (test.length == 0) {
                $('#role_info').text('请选择角色').css('color','red');$("input[type='checkbox']").css('border-color','red');
                check = false;
            }else{
                $('#role_info').text('角色已选').css('color','green');$("input[type='checkbox']").css('border-color','green');
                check = true;
            }
        })

        $('#reset').click(function () {
            checkUsername = false;
            checkPassword = false;
            checkEmail = false;
            check = false;
            checkMobile = false;
            $('#password_info').text('密码不能为空').css('color','red');$('#password').css('border-color','red')
            $('#username_info').text('管理员名称不能为空').css('color','red');$('#username').css('border-color','red');
            $('#role_info').text('请选择角色').css('color','red');$("input[type='checkbox']").css('border-color','red');
            $('#email_info').text('邮箱不能为空').css('color','red');$('#email').css('border-color','red')
            $('#mobile_info').text('手机号不能为空').css('color','red');$('#mobile').css('border-color','red');
        });

        // 表单提交
        $('#submit').click(function(){
            if(checkUsername && checkPassword && checkEmail && checkMobile && check){
                $('form').submit();
            }else{
                return false;
            }
        });

    });

    </script>
    @yield('js')
    <!-- script> console.log('Hi!'); </script> -->
@stop