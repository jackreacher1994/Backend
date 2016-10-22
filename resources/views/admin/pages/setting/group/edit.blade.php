@extends('admin.layout.master')

@section('title')
Sửa nhóm cài đặt
@endsection
@section('css')
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
<style type="text/css">
.btn-cancel{
background-color: #abbac3!important;
border-color: #abbac3;
color: #fff;
}
.center{
	    text-align: center!important;
}
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sửa nhóm cài đặt</h1>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-8 col-lg-7 ">
		{!! Form::model($group,['method' => 'PATCH', 'class' => 'form-horizontal', 'route' => ['SettingController.updateGroup', $group->id]]) !!}
			<div class="form-group">
				<label for="groupSettingKey" class="col-xs-12 col-sm-3 control-label no-padding-right">Key</label>
				<div class="col-xs-12 col-sm-9">
					<input name="key" class="form-control" type="text" id="groupSettingKey" value="{{ old('key') ? old('key') : $group->key }}">
					@if ($errors->has('key'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('key') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="form-group">
				<label for="groupSettingName" class="col-xs-12 col-sm-3 control-label no-padding-right">Name</label>
				<div class="col-xs-12 col-sm-9">
					<input name="name" class="form-control" type="text" id="groupSettingName" value="{{ old('name') ? old('name') : $group->name }}">
					@if ($errors->has('name'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('name') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="form-group">
				<label for="groupSettingDescription" class="col-xs-12 col-sm-3 control-label no-padding-right">Description</label>
				<div class="col-xs-12 col-sm-9">
					<textarea name="description" class="form-control" cols="30" rows="6" id="groupSettingDescription" >{{ old('description') ? old('description') : $group->description }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="groupSettingOrder" class="col-xs-12 col-sm-3 control-label no-padding-right">Order</label>
				<div class="col-xs-12 col-sm-9">
					<input name="order" class="form-control" type="number" id="groupSettingOrder" value="{{ old('order') ? old('order') : $group->order }}">
					@if ($errors->has('order'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('order') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="center">
				<a href="{{ url('setting/group') }}" class="btn btn-cancel"><i class="fa fa-close"></i> Hủy</a>&nbsp;&nbsp;
			    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Lưu &amp; Đóng</button>
			    @can('SettingController.destroyGroup')
			    &nbsp;&nbsp;
		    	<a onclick='return confirm("Bạn có chắc chắn muốn xóa?")' href="{{ url('setting/group/destroy/'.$group->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Xóa</a>
		    	@endcan
		    </div>
		    </div>
		{!! Form::close() !!}
	</div>
</div>
<!-- /.row -->
@endsection