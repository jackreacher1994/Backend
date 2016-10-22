@extends('admin.layout.master')

@section('title')
Sửa loại cài đặt
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
		<h1 class="page-header">Sửa loại cài đặt</h1>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-8 col-lg-7 ">
		{!! Form::model($type,['method' => 'PATCH', 'class' => 'form-horizontal', 'route' => ['SettingController.updateType', $type->id]]) !!}
			<div class="form-group">
				<label for="parent_id" class="col-xs-12 col-sm-3 control-label no-padding-right">Thuộc nhóm</label>
				<div class="col-xs-12 col-sm-9">
					<select id="parent_id" name="parent_id" class="form-control">
						<?php 
                            $old = old('parent_id');
                            if($old != null)
                                group_select($groups, $old);
                            else 
                                group_select($groups, $type->parent_id);
                        ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="typeSettingKey" class="col-xs-12 col-sm-3 control-label no-padding-right">Key</label>
				<div class="col-xs-12 col-sm-9">
					<input name="key" class="form-control" type="text" id="typeSettingKey" value="{{ old('key') ? old('key') : $type->key }}">
					@if ($errors->has('key'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('key') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="form-group">
				<label for="typeSettingName" class="col-xs-12 col-sm-3 control-label no-padding-right">Name</label>
				<div class="col-xs-12 col-sm-9">
					<input name="name" class="form-control" type="text" id="typeSettingName" value="{{ old('name') ? old('name') : $type->name }}">
					@if ($errors->has('name'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('name') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="form-group">
				<label for="typeSettingDescription" class="col-xs-12 col-sm-3 control-label no-padding-right">Description</label>
				<div class="col-xs-12 col-sm-9">
					<textarea name="description" class="form-control" cols="30" rows="6" id="typeSettingDescription" >{{ old('description') ? old('description') : $type->description }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="typeSettingOrder" class="col-xs-12 col-sm-3 control-label no-padding-right">Order</label>
				<div class="col-xs-12 col-sm-9">
					<input name="order" class="form-control" type="number" id="typeSettingOrder" value="{{ old('order') ? old('order') : $type->order }}">
					@if ($errors->has('order'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('order') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="center">
				<a href="{{ url('setting/type') }}" class="btn btn-cancel"><i class="fa fa-close"></i> Hủy</a>&nbsp;&nbsp;
			    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Lưu &amp; Đóng</button>
				@can('SettingController.destroyType')
			    &nbsp;&nbsp;
		    	<a onclick='return confirm("Bạn có chắc chắn muốn xóa?")' href="{{ url('setting/type/destroy/'.$type->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Xóa</a>
		    	@endcan
		    </div>
		{!! Form::close() !!}
	</div>
</div>
<!-- /.row -->
@endsection