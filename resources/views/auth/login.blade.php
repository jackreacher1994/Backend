@extends('layouts.app')
@section('title')
Đăng nhập
@endsection
@section('content')
<div class="pen-title">
    <h1>Trang BACKEND</h1>
  
</div>

<div class="module form-module">
    <div class="toggle"><i class="fa fa-arrow-left fa-arrow-right"></i>
        <div class="tooltiptext">Quên mật khẩu</div>
    </div>

    <div class="form">
        <h2>Đăng nhập</h2>
        <form method="post" action="{{ url('/login') }}">
          <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
          <input type="text" name="email" value="{{ old('email') }}" placeholder="Địa chỉ email..."/>
          @if ($errors->has('email'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('email') }}</strong>
          </div>
          @endif
          <input type="password" name="password" placeholder="Mật khẩu..."/>
          @if ($errors->has('password'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('password') }}</strong>
          </div>
          @endif
          <button type="submit">Tiếp tục</button>
          <br><br>
          <div class="text-center">
            <!-- <a class='btn btn-danger' href="#"><i class="fa fa-google-plus" style="width:16px; height:16px"></i></a>
            <a class='btn btn-primary' href="{{ url('auth/facebook') }}"><i class="fa fa-facebook" style="width:16px; height:16px"></i></a> -->
            <a class='btn btn-danger' href="{{ route('Not.AuthController.redirect', ['provider' => 'google']) }}"><i class="fa fa-google-plus" style="width:16px; height:16px"></i></a>
            <a class='btn btn-primary' href="{{ route('Not.AuthController.redirect', ['provider' => 'facebook']) }}"><i class="fa fa-facebook" style="width:16px; height:16px"></i></a>

            <a class='btn btn-info' href="#"><i class="fa fa-twitter" style="width:16px; height:16px"></i></a>
          </div>  
        </form>
    </div>

    <div class="form">
        <h2>Thiết lập lại mật khẩu</h2>
        <form>
          <input type="email" placeholder="Địa chỉ email..."/>
          <button>Nhận email</button>
        </form>
    </div>

    <div class="cta"><a href="#">Về trang FRONTEND</a>
    </div>
</div>
@endsection