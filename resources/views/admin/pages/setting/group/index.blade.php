@extends('admin.layout.master')

@section('title')
Quản lý nhóm cài đặt
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Nhóm cài đặt</h1>
	</div>
	<div class="col-lg-offset-3 col-lg-6">
    @if (Session::has('flash_message'))
        <div id="flash_message" class="text-center alert alert-{!! Session::get('message_level') !!}"><i class="icon fa fa-{!! Session::get('message_icon') !!}"></i> 
        {!! Session::get('flash_message') !!}
        </div>
    @endif
    </div>
	<div class="col-xs-12 no-padding-left no-padding-right">
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-lg-10">
				@can('SettingController.createGroup')
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/group/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Thêm nhóm</a>
				@endcan
				@can('SettingController.indexType')
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/type') }}">Quản lý loại</a>
				@endcan
				@can('SettingController.indexSetting')
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting') }}">Quản lý cài đặt</a>
				@endcan
			</div>
			<div class="col-xs-12 col-sm-12 col-lg-12" >		
				<form style="margin-top: 15px;" method="POST" action="{{ url('setting/group/updateAll') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div >
						<table id="groupSettingList" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								<tr>
									@can('SettingController.updateGroup')
									<th></th>
									@endcan
									<th>#</th>
									<th>Key</th>
									<th>Name</th>
									<th>Order</th>
								</tr>
							</thead>
							@if(count($groups))
								@if( Gate::allows('SettingController.updateAllGroup') )
									@if ( Gate::allows('SettingController.updateGroup') )
									<tfoot>
										<tr>
											<td colspan="5" rowspan="1">
												<button type="submit" id="" class="btn btn-info"><i class="fa fa-check"></i> Lưu</button>
											</td>
										</tr>
									</tfoot>
									@else
									<tfoot>
										<tr>
											<td colspan="4" rowspan="1">
												<button type="submit" id="" class="btn btn-info"><i class="fa fa-check"></i> Lưu</button>
											</td>
										</tr>
									</tfoot>
									@endif
								@endif
							@endif
							<tbody>
								@foreach($groups as $group)
								<tr>
									@can('SettingController.updateGroup')
									<td><a href="{{ url('setting/group/edit/'.$group->id) }}"><i class="fa fa-pencil"></i></a></td>
									@endcan
									<td></td>
									<td>
										<input type="text" class="form-control disabled" readonly="readonly" required="required" name="key[]" id="" value="{{ $group->key }}" placeholder="Key..."/>
									</td>
									<td>
										<textarea name="name[]" class="form-control" placeholder="Value..." style="word-wrap: break-word; width: 100%;" rows="2" cols="30" id="" required="required">{{ $group->name }}</textarea>
										<input type="hidden" name="id[]" value="{{ $group->id }}" />
									</td>
									<td>
										<input type="number" class="form-control" required="required" name="order[]" id="" value="{{ $group->order }}" placeholder="Order..."/>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</form>
			</div>
</div>
<!-- /.row -->
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		var groupSettingList = $('#groupSettingList').DataTable({
			columns: [
				@can('SettingController.updateGroup')
                {
                	"width": "3%",
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false
                },
                @endcan
                {
                	"width": "2%",
                	"name": "indexColumn",
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false
                },
                {
                	"width": "20%",
                    "visible": true, 
                    "searchable": true, 
                    "orderable": false
                },
                {
                	"width": "70%",
                    "visible": true, 
                    "searchable": true, 
                    "orderable": false
                },
                {
                	"width": "5%",
                    "visible": true, 
                    "searchable": true, 
                    "orderable": false
                }
            ],
            sorting: [],
            lengthMenu: [
                [10, 20, 50, -1],
                [ 10, 20, 50, 'Tất cả' ]
            ],
            language: {
                "emptyTable":     "Không có dữ liệu.",
                "info":           "Tổng: _TOTAL_ nhóm cài đặt.",
                "infoEmpty":      "Tổng: 0 nhóm cài đặt",
                "infoThousands":  ".",
                "lengthMenu":     "Hiện _MENU_ nhóm cài đặt",
                "loadingRecords": "Đang tải...",
                "processing":     "Đang xử lý...",
                "search":         "Tìm nhanh:",
                "searchPlaceholder": "Điền từ khóa...",
                "zeroRecords":    "Không tìm thấy nhóm cài đặt nào thỏa mãn.",
                "paginate": {
                    "sFirst":    "Đầu",
                    "sLast":     "Cuối",
                    "sNext":     "Sau",
                    "sPrevious": "Trước"
                },
                "infoFiltered":   "(Tìm kiếm từ _MAX_ nhóm cài đặt)"
            },
		});

		groupSettingList.on( 'order.dt search.dt', function () {
	        groupSettingList.column('indexColumn:name', {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        } );
	    } ).draw();
	} );

	$('#flash_message').delay(3000).slideUp();
</script>
<!-- DataTables -->
<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
@endsection