@extends('layouts.app')

@section('title', $user->name . '的家')

@section('content')

<div class="row">
  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card">
      <img src="#" alt="{{ $user->name }}" class="card-img-top">

      <div class="card-body">
        <h5><strong>个人简介</strong></h5>
        <p>个人简介</p>
        <hr>
        <h5><strong>注册于</strong></h5>
        <p>1911\11\11</p>
      </div>
    </div>
  </div>

  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-body">
        <h1 class="mb-0" style="font-size: 22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>

    <hr>

    {{-- 用户发布的内容 --}}
    <div class="card">
      <div class="card-body">
        你看你马呢
      </div>
    </div>

  </div>
</div>

@endsection
