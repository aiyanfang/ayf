@extends('adminlte::page')
@section('content_header')
<html>
  <link rel="stylesheet" type="text/css" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
</html> 
<div class="box-body table-responsive no-padding">
    <table class="table table-hover">
      <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>商品描述</th>
        <th>商品展示</th>
        <th>商品状态</th>
      </tr>
       @foreach($goods as $key => $value)
        <tr>
          <td>{{$value['goods_id']}}</td>
          <td>{{$value['goods_name']}}</td>
          <td>{{$value['goods_desc']}}</td>
          <td><img src="/goods/image/{{$value['goods_image']}}" alt="" width="45"></td>
          <td><span class="label label-success">Approved</span></td>
        </tr>
      @endforeach
      </table>
      {{ $goods->links() }}
</div>
@endsection