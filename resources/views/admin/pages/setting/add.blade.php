@extends('admin.layout.master')

@section('title')
Thêm cài đặt
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
		<h1 class="page-header">Thêm cài đặt</h1>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-8 col-lg-7 ">
		<form class="form-horizontal" method="POST" action="{{ url('setting/create') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label for="type_id" class="col-xs-12 col-sm-3 control-label no-padding-right">Thuộc loại</label>
				<div class="col-xs-12 col-sm-9">
					<select id="type_id" name="type_id" class="form-control">
						<option value="">--Chọn loại cài đặt--</option>
						<?php type_select($groups, 0, "", old('parent_id')); ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="settingKey" class="col-xs-12 col-sm-3 control-label no-padding-right">Key</label>
				<div class="col-xs-12 col-sm-9">
					<input name="key" class="form-control" type="text" id="settingKey" value="{{ old('key') }}">
					@if ($errors->has('key'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('key') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="form-group">
				<label for="settingValue" class="col-xs-12 col-sm-3 control-label no-padding-right">Value</label>
				<div class="col-xs-12 col-sm-9">
					<input name="value" class="form-control" type="text" id="settingValue" value="{{ old('value') }}">
					@if ($errors->has('value'))
			        <div class="alert alert-danger fade in">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="Tắt">&times;</a>
			        <strong>{{ $errors->first('value') }}</strong>
			        </div>
			        @endif
				</div>
			</div>
			<div class="form-group">
				<label for="settingDescription" class="col-xs-12 col-sm-3 control-label no-padding-right">Description</label>
				<div class="col-xs-12 col-sm-9">
					<textarea name="description" class="form-control" cols="30" rows="6" id="settingDescription" >{{ old('description') }}</textarea>
				</div>
			</div>
			<div class="center">
		    <a href="{{ url('setting') }}" class="btn btn-cancel"><i class="fa fa-close"></i> Hủy</a>&nbsp;&nbsp;
		    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Thêm &amp; Đóng</button>  
		    </div>
		</form>
	</div>
</div>
<!-- /.row -->
@endsection