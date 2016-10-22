@extends('layouts.app')
@section('title')
Đặt mật khẩu
@endsection
@section('content')
<div class="pen-title">
    Đây là lần đầu tiên bạn đăng nhập bằng tài khoản mạng xã hội này. Hãy đặt mật khẩu cho tài khoản.
</div>

<div class="module form-module">
    <div class="toggle">
    </div>

    <div class="form">
        <h2>Đặt mật khẩu</h2>
        <form method="post" action="{{ url('/set-password') }}">
          <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
          <input type="password" name="password" placeholder="Mật khẩu..."/>
          @if ($errors->has('password'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('password') }}</strong>
          </div>
          @endif
           <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu..."/>
          @if ($errors->has('password_confirmation'))
          <div class="alert alert-danger">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
          </div>
          @endif
          <button type="submit">Tiếp tục</button>
        </form>
    </div>

    <div class="cta"><a href="{{ url('login') }}">Về trang đăng nhập</a>
    </div>
</div>
@endsection