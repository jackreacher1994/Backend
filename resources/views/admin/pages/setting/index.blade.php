@extends('admin.layout.master')

@section('title')
Quản lý cài đặt
@endsection

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Cài đặt</h1>
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
				@can('SettingController.createSetting')
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Thêm cài đặt</a>
				@endcan
				@can('SettingController.indexType')
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/type') }}">Quản lý loại </a>
				@endcan
				@can('SettingController.indexGroup')
				<a class="btn btn-primary" style="margin-top:5px" href="{{ url('setting/group') }}">Quản lý nhóm </a>
				@endcan
				@can('SettingController.synchronousModules')
				<a class="btn btn-primary" style="margin-top:5px" onclick='return confirm("Bạn có chắc chắn thực hiện đồng bộ?")' id="syncModules">Đồng bộ module</a>
				@endcan
			</div>
			<div class="col-xs-12 col-sm-3 col-lg-2 form-group" style="padding-top:5px">
				<select class="form-control chosen-select" onchange="location = this.value;">
					@foreach($groups as $group)
					<option value="{{ url('setting/'.$group->id) }}" selectedGroup="{{ $group->id }}" class="list-group-item {{ $selectedGroup == $group->id ? 'choose' : '' }}" {{ $selectedGroup == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<ul class="nav nav-tabs padding-12 background-blue">
					@foreach($types as $type)
					<li class="
					@if(Session::has('selectedType'))
					{{ Session::get('selectedType') == $type->key ? 'active' : '' }}
					@else
					{{ $selectedType == $type->key ? 'active' : '' }}
					@endif
					"><a href="#tab_{{ $type->key }}" data-toggle="tab">{{ $type->name }}</a></li>
					@endforeach
				</ul>
				<div class="tab-content">
					@foreach($types as $type)
					<div class="tab-pane 
					@if(Session::has('selectedType'))
					{{ Session::get('selectedType') == $type->key ? 'active' : '' }}
					@else
					{{ $selectedType == $type->key ? 'active' : '' }}
					@endif
					" id="tab_{{ $type->key }}" value="{{ $type->key }}">
						<form style="margin-top: 15px;" method="POST" action="{{ url('setting/updateAll') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div >
								<table id="{{ $type->key }}List" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											@can('SettingController.updateSetting')
											<th></th>
											@endcan
											<th>#</th>
											<th>Key</th>
											<th>Value</th>
										</tr>
									</thead>
									@if(count($type->settings))
										@if( Gate::allows('SettingController.updateAllSetting') )
											@if ( Gate::allows('SettingController.updateSetting') )
											<tfoot>
												<tr>
													<th colspan="4" rowspan="1">
														<button type="submit" id="" class="btn btn-info"><i class="fa fa-check"></i> Lưu</button>
													</th>
												</tr>
											</tfoot>
											@else
											<tfoot>
												<tr>
													<th colspan="3" rowspan="1">
														<button type="submit" id="" class="btn btn-info"><i class="fa fa-check"></i> Lưu</button>
													</th>
												</tr>
											</tfoot>
											@endif
										@endif
									@endif
									<tbody>
										@foreach($type->settings as $setting)
										<tr>
											@can('SettingController.updateSetting')
											<td><a href="{{ url('setting/edit/'.$setting->id) }}"><i class="fa fa-pencil"></i></a></td>
											@endcan
											<td></td>
											<td>
												<input type="text" class="form-control disabled" readonly="readonly" required="required" name="key[]" id="" value="{{ $setting->key }}" placeholder="Key..."/>
											</td>
											<td>
												<textarea name="value[]" class="form-control" placeholder="Value..." style="word-wrap: break-word; width: 100%;" rows="2" cols="30" id="" required="required">{{ $setting->value }}</textarea>
												<input type="hidden" name="id[]" value="{{ $setting->id }}" />
											</td>
										</tr>	
										@endforeach
									</tbody>
								</table>
							</div>
						</form>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.row -->
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		// Lay ra mang cac id cua cac table
		var tables = $(".table").map(function(){
			return $(this).attr("id");
		}).get();
		
		// Lap voi tung table
		$.each(tables, function(key, table){
            var table = $('#'+table).DataTable({
            	// Phai co dong nay de dam bao do rong cua cac cot khong bi ve 0 khi an table di
            	autoWidth: false,
				columns: [
					@can('SettingController.updateSetting')
	                {
	                	"width": "2%",
	                    "visible": true, 
	                    "searchable": false, 
	                    "orderable": false
	                },
	                @endcan
	                {
	                	"width": "2%",
	                	"name": "indexColumn",
	                	//"className": "dt-center",
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
	                "info":           "Tổng: _TOTAL_ cài đặt.",
	                "infoEmpty":      "Tổng: 0 cài đặt",
	                "infoThousands":  ".",
	                "lengthMenu":     "Hiện _MENU_ cài đặt",
	                "loadingRecords": "Đang tải...",
	                "processing":     "Đang xử lý...",
	                "search":         "Tìm nhanh:",
	                "searchPlaceholder": "Điền từ khóa...",
	                "zeroRecords":    "Không tìm thấy cài đặt nào thỏa mãn.",
	                "paginate": {
	                    "sFirst":    "Đầu",
	                    "sLast":     "Cuối",
	                    "sNext":     "Sau",
	                    "sPrevious": "Trước"
	                },
	                "infoFiltered":   "(Tìm kiếm từ _MAX_ cài đặt)"
	            },
			});

			table.on( 'order.dt search.dt', function () {
		        table.column('indexColumn:name', {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
		            cell.innerHTML = i+1;
		        } );
		    } ).draw();
        });
	});
	
	$('#flash_message').delay(3000).slideUp();

	var baseUrl = $('meta[name="base_url"]').attr('content');

	$('#syncModules').click(function() {
      var selectedGroup = $('.list-group-item.choose').attr('selectedGroup');
      var selectedType = $('.tab-pane.active').attr('value');
      if(selectedType === undefined)
      	location.href = baseUrl+'/setting/synchronous/'+selectedGroup;
      else
      	location.href = baseUrl+'/setting/synchronous/'+selectedGroup+'/'+selectedType;
    });
</script>
<!-- DataTables -->
<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
@endsection