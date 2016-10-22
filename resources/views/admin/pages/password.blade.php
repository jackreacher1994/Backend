@extends('admin.layout.master')

@section('title')
Đổi mật khẩu
@stop

@section('css')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Đổi mật khẩu</h1>
    </div>
    <!-- /.col-lg-12 -->

	<div class="col-lg-12">
		<div class="col-lg-offset-3 col-lg-6">
	    @if (Session::has('flash_message'))
	        <div id="flash_message" class="text-center alert alert-{!! Session::get('message_level') !!}"><i class="icon fa fa-{!! Session::get('message_icon') !!}"></i> 
	        {!! Session::get('flash_message') !!}
	        </div>
	    @endif
	    </div>
    </div>

    <form class="form-horizontal" role="form" method="POST" action="{{ route('Not.UserController.password.update') }}">
      {!! csrf_field() !!}
      <div class="form-group">
	    <label class="control-label col-md-offset-1 col-md-3" for="old_password">Mật khẩu cũ:</label>
	    <div class="col-md-4">
	      <input type="password" class="form-control" name="old_password" id="old_password" placeholder="">
	        @if ($errors->has('old_password'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('old_password') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-offset-1 col-md-3" for="password">Mật khẩu mới:</label>
	    <div class="col-md-4">
	      <input type="password" class="form-control" name="password" id="password" placeholder="">
	        @if ($errors->has('password'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('password') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-offset-1 col-md-3" for="password_confirmation">Xác nhận mật khẩu:</label>
	    <div class="col-md-4">
	      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="">
	        @if ($errors->has('password_confirmation'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('password_confirmation') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group"> 
	    <div class="col-md-offset-5 col-md-4">
	      <button type="submit" class="btn btn-primary btn-lg">Đổi mật khẩu</button>
	    </div>
	  </div>
	</form>
</div>
<!-- /.row -->
@endsection

@section('js')
<script>
	$('#flash_message').delay(3000).slideUp();
</script>
@endsection