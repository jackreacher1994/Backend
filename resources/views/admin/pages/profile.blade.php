@extends('admin.layout.master')

@section('title')
Hồ sơ của bạn
@stop

@section('css')
<link href="{{ url('public/admin/plugins/fileinput/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css" />

<script src="{{ url('public/admin/plugins/fileinput/js/plugins/canvas-to-blob.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/admin/plugins/fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/admin/plugins/fileinput/js/fileinput_locale_LANG.js') }}"></script>

<style type="text/css">
	.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Hồ sơ của bạn</h1>
    </div>
    <!-- /.col-lg-12 -->

	<div class="col-lg-offset-3 col-lg-6">
    @if (Session::has('flash_message'))
        <div id="flash_message" class="text-center alert alert-{!! Session::get('message_level') !!}"><i class="icon fa fa-{!! Session::get('message_icon') !!}"></i> 
        {!! Session::get('flash_message') !!}
        </div>
    @endif
    </div>

    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ route('Not.UserController.profile.update') }}">
      {!! csrf_field() !!}
      <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Tên</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="first_name">Họ tên (bắt buộc):</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" name="fullname" id="fullname" placeholder="" value="{{ old('fullname') ? old('fullname') : Auth::user()->fullname  }}">
	      	@if ($errors->has('fullname'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('fullname') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Thông tin liên hệ</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="email">Địa chỉ email (bắt buộc):</label>
	    <div class="col-md-6">
	      <input type="email" class="form-control" name="email" id="email" placeholder="" value="{{ Auth::user()->email }}" disabled="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="phone">Số điện thoại:</label>
	    <div class="col-md-6">
	      <input type="text" class="form-control" name="phone" id="phone" placeholder="" value="{{ old('phone') ? old('phone') : Auth::user()->phone  }}">
	        @if ($errors->has('phone'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('phone') }}</strong>
	        </div>
	        @endif
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="address">Địa chỉ:</label>
	    <div class="col-md-6">
	      <textarea class="form-control" name="address" id="address">{{ old('address') ? old('address') : Auth::user()->address  }}</textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Giới thiệu bản thân</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="bio">Tiểu sử:</label>
	    <div class="col-md-6">
	      <textarea class="form-control" name="bio" id="bio">{{ old('bio') ? old('bio') : Auth::user()->bio  }}</textarea>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="avatar">Ảnh hồ sơ:</label>
	    <div class="col-md-6">
		    <div class="kv-avatar center-block" style="width:200px">
		      	<input type="file" class="form-control file-loading" name="avatar" id="avatar">

		      	@if(!empty(Auth::user()->avatar))
			      	@if(strpos(Auth::user()->avatar, 'https') !== false)
					<img style="width: 170px; height: 170px;" src="{{ asset(Auth::user()->avatar) }}">
					@else
					<img style="width: 170px; height: 170px;" src="{{ asset('public/upload/avatar/'.Auth::user()->avatar) }}">
					@endif
					<input type="hidden" name="current_avatar" value="{{ Auth::user()->avatar }}">
				@endif
		    </div>

			@if ($errors->has('avatar'))
	        <div class="alert alert-danger fade in">
	        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
	        <strong>{{ $errors->first('avatar') }}</strong>
	        </div>
	        @endif

	      	<!-- The fileinput plugin initialization -->
	        <script type="text/javascript">
	            $("#avatar").fileinput({
	                overwriteInitial: true,
	                showClose: true,
	                showCaption: false,
	                browseLabel: 'Chọn ảnh hồ sơ',
	                browseIcon: '',
	                defaultPreviewContent: '<img src="{{ url('public/admin/plugins/fileinput/img/default_avatar_male.jpg') }}" alt="Ảnh hồ sơ" style="width:160px">',
	                layoutTemplates: {main2: '{preview} <div class="text-center">{browse}</div>'},
	            });
	        </script>
	    </div>
	  </div>
	  <div class="form-group">
	    <h3 class="col-md-offset-3 col-md-6">Thông tin tài khoản</h3>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="role">Role:</label>
	    <div class="col-md-6">
	    <ul>
	      @foreach ($roles as $role)
			<li>{{ $role->name }}</li>
	      @endforeach
	    </ul>
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="role">Đăng nhập gần nhất:</label>
	    <div class="col-md-6">
	    	{{ Auth::user()->last_login->format('H:i d/m/Y') }} ({!!
                        \Carbon\Carbon::createFromTimeStamp(strtotime(Auth::user()->last_login))->diffForHumans()
                    !!})
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="role">Thời điểm tài khoản được tạo:</label>
	    <div class="col-md-6">
	    	{{ Auth::user()->created_at->format('H:i d/m/Y') }}
	    </div>
	  </div>
	  <div class="form-group">
	    <label class="control-label col-md-3" for="session">Phiên đăng nhập:</label>
	    <div class="col-md-6">
	      <button class="btn btn-default" disabled="true">Đăng xuất khỏi những nơi khác</button>
	      <p><i>Bạn mới đăng nhập ở một nơi.</i></p>
	    </div>
	  </div>
	  <div class="form-group"> 
	    <div class="col-md-offset-5 col-md-4">
	      <button type="submit" class="btn btn-primary btn-lg">Cập nhật hồ sơ</button>
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