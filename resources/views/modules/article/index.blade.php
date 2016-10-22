@extends('admin.layout.master')

@section('title')
Quản lý bài viết
@stop

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/css/dataTables.bootstrap.css') }}">
<!-- Datatables extensions -->
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/ColReorder/css/colReorder.dataTables.min.css') }}">
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/FixedColumns/css/fixedColumns.dataTables.min.css') }}">
<link rel="stylesheet" href="{{  url('public/admin/plugins/datatables/extensions/Select/css/select.dataTables.min.css') }}">
<style type="text/css">

</style>
<!-- CKEditor & CKFinder -->
<script src={{ url('public/admin/plugins/ckeditor/ckeditor.js') }}></script>
<script src={{ url('public/admin/plugins/ckfinder/ckfinder.js') }}></script>
<script type="text/javascript">
    var baseURL = "{!! url('/') !!}";
</script>
<script src={{ url('public/admin/plugins/func_ckfinder.js') }}></script>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
        <h1 class="page-header">Danh sách bài viết</h1>
    </div>

  <div class="col-lg-12">
    <div class="col-lg-6 col-lg-offset-3" id="articleAlert">
            
    </div>
  </div>

  <table class="table table-striped table-bordered table-hover" id="articleList">
      <thead>
        <tr>
          @can('ArticleController.destroy')
          <th></th>
          @endcan
          <th></th>
          <th>Tiêu đề</th>
          @if ( Gate::allows('ArticleController.show') | Gate::allows('ArticleController.edit') | Gate::allows('ArticleController.destroy') )
          <th>Thao tác</th>
          @endif
        </tr>
      </thead>
  </table>

  <!-- Modal -->
  <!-- View modal -->
  <div class="modal fade" id="articleViewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Xem bài viết</h4>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="col-lg-4" align="right"><strong>Tiêu đề</strong>   :</div>
            <div id="article_title" class="col-lg-8" align="left"></div>
            <br>
            <div class="col-lg-4" align="right"><strong>Nội dung</strong>   :</div>
            <div id="article_content" class="col-lg-8" align="left"></div>
            <br>
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
      
    </div>
  </div>

  <!-- Delete modal -->
  <div class="modal fade" id="articleDeleteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Xóa bài viết</h4>
        </div>
        <form>
        <div class="modal-body">
          <div class="text-center">
              <p>Xác nhận xóa (các) bài viết này?</p>
                <input type="hidden" id="article_id" name="article_id" value="">
            </div>
        </div>
        </form>
        <div class="modal-footer">
          <button class="btn btn-danger" id="btn-delete-article">Xóa</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Create and edit modal -->
  <div class="modal fade" id="articleCreateEditModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="articleCreateEditModalTitle"></h4>
        </div>
      
      <form id="articleCreateEditForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="title">Tiêu đề</label>:
            <input type="text" value="{{ old('title') }}" name="title" class="form-control" placeholder="" id="title">
            <div id="errorArticleTitle">
            </div>
          </div>
          <div class="form-group">
            <label for="name">Nội dung</label>:
            <textarea value="{{ old('content') }}" name="content" class="form-control" placeholder="" id="content"></textarea>
            <script type="text/javascript">ckeditor("content")</script>
            <div id="errorArticleContent">
            </div>
          </div>
        </div>
        </form>
      
      <div class="modal-footer">
        <button id="btn-reset-article" class="btn btn-default">Xóa</button>
          <button class="btn" id="btn-save-article"></button>
          <input type="hidden" id="article_id" name="article_id" value="">
        </div>
      </div>
    </div>
  </div>
  <!-- End modal -->
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var baseUrl = $('meta[name="base_url"]').attr('content');

        //l - length changing input control
        //f - filtering input
        //t - The table!
        //i - Table information summary
        //p - pagination control
        //r - processing display element
        var articleList = $('#articleList').DataTable({
            ajax: baseUrl+"/article/listArticle",
            columns: [
                @can('ArticleController.destroy')
                {
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false,
                    "className": "select-checkbox center",
                    "defaultContent": " ",
                    "title": "<input type='checkbox' id='selectAll'>"
                },
                @endcan
                { 
                    "visible": false, 
                    "searchable": false, 
                    "orderable": false,
                    "data": "id" 
                },
                { 
                    "visible": true, 
                    "searchable": true, 
                    "orderable": true,
                    "data": "title",
                    "name": "articleTitle"
                },
                @if ( Gate::allows('ArticleController.show') | Gate::allows('ArticleController.edit') | Gate::allows('ArticleController.destroy') )
                { 
                    "defaultContent": '@can('ArticleController.show')<button class="btn btn-success open-view-article-modal"><span class="glyphicon glyphicon-eye-open"></span></button>@endcan @can('ArticleController.update')<button class="btn btn-warning open-edit-article-modal"><span class="glyphicon glyphicon-pencil"></span></button>@endcan @can('ArticleController.destroy') <button class="btn btn-danger open-delete-article-modal"><span class="glyphicon glyphicon-trash"></span></button> @endcan', 
                    "visible": true, 
                    "searchable": false, 
                    "orderable": false,
                    "data": null
                }
                @endif
            ],
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 20, 50, -1],
                [ 'Mặc định', 'Hiện 20 bản ghi', 'Hiện 50 bản ghi', 'Hiện tất cả' ]
            ],
            select: {
                //style:    'os',
                style:    'multi',
                selector: 'td:first-child'
            },
            //Disable automatic sorting on the first column
            sorting: [],
            //order: [[ 0, 'asc' ]],
            language: {
                "emptyTable":     "Không có dữ liệu.",
                "info":           "Tổng: _TOTAL_ bài viết.",
                "infoEmpty":      "Tổng: 0 bài viết",
                "infoThousands":  ".",
                "lengthMenu":     "Hiện _MENU_ bài viết",
                "loadingRecords": "Đang tải...",
                "processing":     "Đang xử lý...",
                "search":         "Tìm nhanh:",
                "searchPlaceholder": "Điền từ khóa...",
                "zeroRecords":    "Không tìm thấy bài viết nào thỏa mãn.",
                "paginate": {
                    "sFirst":    "Đầu",
                    "sLast":     "Cuối",
                    "sNext":     "Sau",
                    "sPrevious": "Trước"
                },
                "infoFiltered":   "(Tìm kiếm từ _MAX_ bài viết)",
                select: {
                    rows: "",
                    @can('ArticleController.destroy')
                    rows: "Đã chọn: %d bài viết."
                    @endcan
                }
            },
            buttons: [
                @can('ArticleController.store')
                {
                    text: 'Thêm',
                    titleAttr: 'Thêm bài viết',
                    action: function (e) {
                        e.preventDefault();
                        $('#articleAlert').empty();
                        $('#btn-save-article').val("add");
                        $('#btn-save-article').addClass('bg-purple');
                        $('#articleCreateEditModalTitle').text("Thêm bài viết");
                        $('#btn-reset-article').text("Xóa trắng");
                        $('#btn-save-article').text("Thêm");
                        $('#btn-reset-article').click(function(){
                            CKEDITOR.instances['content'].setData('');
                            $('#articleCreateEditModal').find('form')[0].reset();
                            $('#closeErrorArticleTitle').click();
                            $('#closeErrorArticleContent').click();
                        });
                        $('#articleCreateEditModal').modal('show');
                    }
                },
                @endcan
                {
                    extend: 'excel',
                    text: 'Excel',
                    titleAttr: 'Xuất tệp Excel',
                    title: 'Danh sách bài viết',
                    exportOptions: {
                        columns: ["articleTitle:name"]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    titleAttr: 'Xuất tệp PDF',
                    title: 'Danh sách bài viết',
                    message: 'Tài liệu chỉ lưu hành nội bộ.',
                    exportOptions: {
                        columns: ["articleTitle:name"]
                    }
                },
                {
                    extend: 'print',
                    text: 'In',
                    titleAttr: 'In danh sách',
                    title: 'Danh sách bài viết',
                    exportOptions: {
                        columns: ["articleTitle:name"]
                    }
                },
                {
                    extend: 'pageLength',
                    text: 'Trên một trang',
                    titleAttr: 'Hiện số bài viết trên một trang'
                },
                // {
                //     extend: 'colvis',
                //     text: '<i class="fa fa-check-square-o"></i>',
                //     titleAttr: 'Chọn các cột muốn hiển thị',
                //     columns: [1, 2]
                // },
                // {
                //     text: '<i class="fa fa-close"></i>',
                //     titleAttr: 'Khôi phục thứ tự cột mặc định',
                //     action: function (e) {
                //         e.preventDefault();
                //         articleList.colReorder.reset();
                //     }
                // },
                {
                    text: 'Tải lại',
                    titleAttr: 'Tải lại danh sách',
                    action: function (e) {
                        articleList.ajax.reload(null, false);
                    }  
                },
                @can('ArticleController.destroy')
                // {
                //     text: 'Chọn tất cả',
                //     titleAttr: 'Chọn tất cả',
                //     action: function (e) {
                //         articleList.rows().select();
                //     }
                // },
                // {
                //     text: 'Chọn trang hiện tại',
                //     titleAttr: 'Chọn trang hiện tại',
                //     action: function (e) {
                //         articleList.rows().deselect();
                //         articleList.rows({page: 'current'}).select();
                //     }
                // },
                {
                    text: 'Bỏ chọn',
                    titleAttr: 'Bỏ chọn các hàng đã chọn',
                    action: function (e) {
                        articleList.rows().deselect();
                    },
                    enabled: false,
                    name: 'deselectAll'
                },
                {
                    text: 'Xóa',
                    titleAttr: 'Xóa (các) bản ghi đã chọn',
                    action: function (e) {
                        ids = '';
                        //Gộp id các bản ghi đã chọn thành 1 chuỗi, mỗi id cách nhau bởi dấu cách
                        articleList.rows({selected: true}).data().each(function (group, i) {
                            ids += ' ' + group.id;
                        });
                        deleteArticle(ids);
                    },
                    enabled: false,
                    name: 'destroyRecords'
                }
                @endcan
            ],
            // colReorder: {
            //     fixedColumnsLeft: 1,
            //     fixedColumnsRight: 1
            // }
        });

        $("#selectAll").change(function() {
            if(this.checked) {
                articleList.rows().select();
            } else {
                articleList.rows().deselect();
            }
        });

        //Nếu không có bản ghi nào được chọn thì disable các nút không cần thiết
        function en_dis_button() {
            var selectedRows = articleList.rows({selected: true}).count();
            if (selectedRows > 0) {
                articleList.button('deselectAll:name').enable();
                articleList.button('destroyRecords:name').enable();
            } else {
                articleList.button('deselectAll:name').disable();
                articleList.button('destroyRecords:name').disable();
            }
        }

        articleList.on('select', function () {
                    en_dis_button();
                })
                .on('deselect', function () {
                    en_dis_button();
                })
                .on('processing.dt', function () {
                    en_dis_button();
                });

        $('input.toggle-article').change(function() {
            var column = articleList.column( $(this).attr('value') );
            column.visible( ! column.visible() );
        });

        $('#articleCreateEditModal').on('hidden.bs.modal', function(){
            $(this).find('form')[0].reset();
            CKEDITOR.instances['content'].setData('');
            $('#closeErrorArticleTitle').click();
            $('#closeErrorArticleContent').click();
        });

        var articleUrl = baseUrl+"/article";

        //Display modal form for article viewing
        $('#articleList tbody').on('click', '.open-view-article-modal', function () {
            $('#articleAlert').empty();
            var row = $(this).closest("tr");
            var article = articleList.row(row).data();
            var article_id = article.id;
            $.get(articleUrl + '/show/' + article_id, function (data) {
                $('#article_title').html(data.title);
                $('#article_content').html(data.content);
                $('#articleViewModal').modal('show');
            }) 
        } );

        //Display modal form for article editing
        $('#articleList tbody').on('click', '.open-edit-article-modal', function () {
            $('#articleAlert').empty();
            var row = $(this).closest("tr");
            var article = articleList.row(row).data();
            var article_id = article.id;
            $.get(articleUrl + '/edit/' + article_id, function (data) {
                $('#article_id').val(data.id);
                $('#title').val(data.title);
                //$('#content').val(data.content);
                CKEDITOR.instances['content'].setData(data.content);
                $('#btn-save-article').val("update");
                $('#btn-save-article').addClass('btn-warning');
                $('#articleCreateEditModalTitle').text("Sửa bài viết");
                $('#btn-reset-article').text("Hoàn tác");
                $('#btn-save-article').text("Lưu");
                $('#btn-reset-article').click(function(){
                    $('#title').val(data.title);
                    //'#content').val(data.content);
                    CKEDITOR.instances['content'].setData(data.content);
                    $('#closeErrorArticleTitle').click();
                    $('#closeErrorArticleContent').click();
                });
                $('#articleCreateEditModal').modal('show');
            })
        } );

        //Create new article/update existing article
        $("#btn-save-article").click(function (e) {
            $('#closeErrorArticleTitle').click();
            $('#closeErrorArticleContent').click();

            formmodified = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            e.preventDefault(); 

            var formData = {
                title: $('#title').val(),
                //content: $('#content').val(),
                content: CKEDITOR.instances['content'].getData(),
            }

            //Used to determine the http verb to use [add=POST], [update=PATCH]
            var state = $('#btn-save-article').val();

            var article_id = $('#article_id').val();

            var type = "POST";
            var my_url = articleUrl + '/add';
            
            if (state == "update"){
                type = "PATCH";
                my_url = articleUrl + '/edit/' + article_id;
            }

            $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                $('#articleCreateEditModal').modal('hide');
                articleList.ajax.reload(null, false);
                $('#articleAlert').append('<div class="text-center alert alert-'+data.message_level+'"><button id="closeArticleAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
            },
            error: function (data) {
                var errors = data.responseJSON;
                if (errors.title){
                    $('#errorArticleTitle').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorArticleTitle" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.title+'</div>');
                }
                if (errors.content){
                    $('#errorArticleContent').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorArticleContent" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.content+'</div>');
                }
            }
            });
        });

        $('#articleList tbody').on('click', '.open-delete-article-modal', function () {
            var row = $(this).closest("tr");
            var article = articleList.row(row).data();
            var article_id = article.id;
            deleteArticle(article_id);
        } );

        //Display modal form for deleting article
        function deleteArticle(id) {
            $('#articleAlert').empty();
            $('#article_id').val(id);
            $('#articleDeleteModal').modal('show');
        }

        //Delete article
        $('#btn-delete-article').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var article_ids = $('#article_id').val();

            var formData = {
                ids: article_ids
            }

            $.ajax({
                type: "DELETE",
                url: articleUrl + '/destroy',
                data: formData,
                success: function (data) {
                    $('#articleDeleteModal').modal('hide');
                    articleList.ajax.reload(null, false);
                    $('#articleAlert').append('<div id="flash_message" class="text-center alert alert-'+data.message_level+'"><button id="closeArticleAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });
</script>
<!-- DataTables -->
<script src="{{  url('public/admin/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
<!-- Datatables extensions -->
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/buttons.print.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{  url('public/admin/specify/jszip.min.js') }}"></script>
<script src="{{  url('public/admin/specify/pdfmake.min.js') }}"></script>
<script src="{{  url('public/admin/specify/vfs_fonts.js') }}"></script>
<script src="{{  url('public/admin/specify/buttons.html5.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Button/js/buttons.html5.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js') }}"></script>
<script src="{{  url('public/admin/plugins/datatables/extensions/Select/js/dataTables.select.min.js') }}"></script>
@endsection