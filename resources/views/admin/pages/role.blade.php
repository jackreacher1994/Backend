@extends('admin.layout.master')

@section('title')
Quản lý phân quyền
@stop

@section('css')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<style type="text/css">
  /*  bhoechie tab */
  div.bhoechie-tab-container{
    z-index: 10;
    background-color: #ffffff;
    padding: 0 !important;
    border-radius: 4px;
    -moz-border-radius: 4px;
    border:1px solid #ddd;
    margin-top: 20px;
    margin-left: 50px;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
    -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    background-clip: padding-box;
    opacity: 0.97;
    filter: alpha(opacity=97);
  }
  div.bhoechie-tab-menu{
    padding-right: 0;
    padding-left: 0;
    padding-bottom: 0;
    max-height: 400px;
  }
  div.bhoechie-tab-menu div.list-group{
    width: 90%;
    margin-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group>a{
    margin-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group>a .glyphicon,
  div.bhoechie-tab-menu div.list-group>a .fa {
    color: #5A55A3;
  }
  div.bhoechie-tab-menu div.list-group>a:first-child{
    border-top-right-radius: 0;
    -moz-border-top-right-radius: 0;
  }
  div.bhoechie-tab-menu div.list-group>a:last-child{
    border-bottom-right-radius: 0;
    -moz-border-bottom-right-radius: 0;
  }
  div.bhoechie-tab-menu div.list-group>a.active,
  div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
  div.bhoechie-tab-menu div.list-group>a.active .fa{
    background-color: #5A55A3;
    background-image: #5A55A3;
    color: #ffffff;
  }
  div.bhoechie-tab-menu div.list-group>a.active:after{
    content: '';
    position: absolute;
    left: 100%;
    top: 50%;
    margin-top: -13px;
    border-left: 0;
    border-bottom: 13px solid transparent;
    border-top: 13px solid transparent;
    border-left: 10px solid #5A55A3;
  }

  div.bhoechie-tab-content{
    background-color: #ffffff;
    /* border: 1px solid #eeeeee; */
    padding-left: 20px;
    padding-top: 10px;
  }

  div.bhoechie-tab div.bhoechie-tab-content:not(.active){
    display: none;
  }

  /*tree*/
  .acidjs-css3-treeview,
  .acidjs-css3-treeview *
  {
    padding: 0;
    margin: 0;
    list-style: none;
  }

  .acidjs-css3-treeview label[for]::before
  {
    content: "\25b6";
    display: inline-block;
    margin:0;
    width: 13px;
    height: 13px;
    vertical-align: top;
    text-align: center;
    color: red;
    font-size: 15px;
    line-height: 13px;
  }
  .acidjs-css3-treeview label span::before{
    content: "\25b6";
    display: inline-block;
    margin: 2px 0 0;
    width: 13px;
    height: 13px;
    vertical-align: top;
    text-align: center;
    color: red;
    font-size: 8px;
    line-height: 13px;
  }
  .acidjs-css3-treeview li ul
  {
    margin: 0 0 0 22px;
  }

  .acidjs-css3-treeview *
  {
    vertical-align: middle;
  }

  .acidjs-css3-treeview
  {
    font-size: 14px;
    border: 1px solid #f2f2f2;
    max-height:400px; 
    max-width:400px; 
    padding:20px; 
    background:#fff; 
    border-radius:3px; 
    box-shadow:2px 2px 3px rgba(0,0,0,.1);
  }

  .acidjs-css3-treeview li
  {
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  .acidjs-css3-treeview input[type="checkbox"]
  {
    display: none;
  }

  .acidjs-css3-treeview label
  {
    cursor: pointer;
  }

  .acidjs-css3-treeview label[for]::before
  {
    -webkit-transform: translatex(-24px);
    -moz-transform: translatex(-24px);
    -ms-transform: translatex(-24px);
    -o-transform: translatex(-24px);
    transform: translatex(-24px);
  }

  .acidjs-css3-treeview label span::before
  {
    -webkit-transform: translatex(16px);
    -moz-transform: translatex(16px);
    -ms-transform: translatex(16px);
    -o-transform: translatex(16px);
    transform: translatex(16px);
  }

.acidjs-css3-treeview input[type="checkbox"][id]:checked ~ label[for]::before
{
    content: "\25bc";
  }

  .acidjs-css3-treeview input[type="checkbox"][id]:not(:checked) ~ ul
  {
    display: none;
  }

  .acidjs-css3-treeview label:not([for])
  {
    margin: 0 8px 0 10px;
  }

  .acidjs-css3-treeview label span::before
  {
    content: "";
    border: solid 1px #1375b3;
    color: #1375b3;
    opacity: .50;
  }

  .acidjs-css3-treeview label input:checked + span::before
  {
    content: "\2714";
    box-shadow: 0 0 2px rgba(0, 0, 0, .25) inset;
    opacity: 1;
  }

</style>
<!-- custom scrollbar CSS -->
<link rel="stylesheet" href="http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css">
@endsection

@section('content')
<div class="row" style="margin-bottom: 100px">
  <div class="cotaniner" style="margin-top: 20px;
  margin-left: 50px;">
    @can('RoleController.store')
    <button class="btn btn-primary open-add-role-modal">Thêm role mới</button>
    @endcan
    @can('RoleController.synchronousPermissions')
    <a onclick='return confirm("Bạn có chắc chắn thực hiện?")' id="syncPermissions"><button class="btn btn-primary ">Đồng bộ quyền</button></a>
    @endcan
  </div>

  <div class="col-lg-offset-3 col-lg-6" id="roleAlert">
  @if (Session::has('flash_message'))
      <div id="flash_message" class="text-center alert alert-{!! Session::get('message_level') !!}"><i class="icon fa fa-{!! Session::get('message_icon') !!}"></i> 
      {!! Session::get('flash_message') !!}
      </div>
  @endif
  </div>

  <!-- Add role modal -->
  <div class="modal fade" id="roleAddModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="roleAddModalTitle">Thêm role</h4>
        </div>

        <form id="roleAddForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Tên role</label>:
              <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="" id="name">
              <div id="errorRoleName">
              </div>
            </div>
          </div>
        </form>

        <div class="modal-footer">
          <button id="btn-reset-role" class="btn btn-default">Xóa trắng</button>
          <button class="btn" id="btn-add-role">Thêm</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End modal -->

  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab-container">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
      <div class="list-group ">
        @foreach ($roles as $role)
        <a href="{{ $role->id }}" value="{{ $role->name }}" class="list-group-item text-center 
        @if(Session::has('selectedRole'))
        {{ Session::get('selectedRole') == $role->name ? 'active' : '' }}
        @else
        {{ $selectedRole == $role->name ? 'active' : '' }}
        @endif
        ">
          <h4 class="fa fa-user"></h4><br/>
          <span id="rolename{{$role->id}}">{{ $role->name }}</span>
        </a>
        @endforeach
      </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
    <?php $temp = 0;?>
      @foreach ($roles as $role)
      <div id='{{$role->id}}' class="bhoechie-tab-content
      @if(Session::has('selectedRole'))
      {{ Session::get('selectedRole') == $role->name ? 'active' : '' }}
      @else
      {{ $selectedRole == $role->name ? 'active' : '' }}
      @endif
      ">
        <div class="col-sm-8">
          <div class="acidjs-css3-treeview">
            <ul>
              <li>
                 <input type="checkbox" id="node-<?php echo $temp;?>" checked="checked" /><label><input type="checkbox" /><span class="all_cb"></span></label><label style="margin-left: 5px;" for="node-<?php echo $temp;?>">Tất cả</label>
                <ul>
                <?php $temp++;
                $temp1 = 0; 
               ?>
                 @foreach($permissions as $permission)
              
                 @if ($permission_childs = DB::table('permissions')->where('parent_id','=',$permission->id)->get())
                 <li>
                    <input type="checkbox" id="node-<?php echo $temp;?>-<?php echo $temp1;?>"  checked="checked"/><label><input type="checkbox" id = '{{$permission->name}}'/><span class="role_cb"></span></label>
                    <label for="node-<?php echo $temp;?>-<?php echo $temp1;?>">{{$permission->label}}</label>
                      <?php $temp1++; ?>
                   <ul>
                     @foreach($permission_childs as $permission_child)
                     
                     <li class="role_li">
                      <?php 
                       
                      $check=DB::table('permission_role')->where('role_id','=',$role->id)->where('permission_id','=',$permission_child->id)->first();
                      if($check){
                        $check = 'checked';
                      }
                      ?>

                       <label><input type = "checkbox" class="check_permission" <?php echo $check; ?> value='{{$permission_child->id}}' id ='{{$permission_child->name}}'/><span></span></label>

                      <label >{{$permission_child->label}}</label>
                    </li>
                    @endforeach
                  </ul>
                </li>
                @endif
                @endforeach 
              </ul>

            </li>
          </ul>
        </div>
      </div>
      <div class="col-sm-4"> 
        <div class="sidebar-search">
          <div class="input-group custom-search-form">
            <input type="text" class="form-control search_role" role="{{$role->id}}" placeholder="Tìm kiếm...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        
        </div>
        <br>
        <button  value='{{$role->id}}' class="btn btn-primary updater-permission">Cập nhật quyền</button>
        <a href="{{url('/role/destroy/'.$role->id)}}" onclick="return confirm('Bạn có chắn chắn muốn xóa?')" style="margin-top: 10px;display: block;"><button  class="btn btn-primary updater-permission">Xóa role {{$role->name}}</button></a>
      </div>
    </div>
    @endforeach              
  </div>
</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
      e.preventDefault();
      $(this).siblings('a.active').removeClass("active");
      $(this).addClass("active");
      var index = $(this).index();
      $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
      $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('#roleAddModal').on('hidden.bs.modal', function(){
      $(this).find('form')[0].reset();
      $('#closeErrorRoleName').click();
    });

    $('.open-add-role-modal').on('click', function () {
      $('#roleAlert').empty();
      $('#btn-reset-role').click(function(){
        $('#roleAddModal').find('form')[0].reset();
        $('#closeErrorRoleName').click();
      });
      $('#roleAddModal').modal('show');
    });

    var baseUrl = $('meta[name="base_url"]').attr('content');
    var roleUrl = baseUrl+"/role";

        //Create new role
        $("#btn-add-role").click(function (e) {
          $('#closeErrorRoleName').click();

          formmodified = 0;
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          })

          e.preventDefault(); 

          var formData = {
            name: $('#name').val(),
          }

          var type = "POST";
          var add_role_url = roleUrl + '/add';

          $.ajax({
            type: type,
            url: add_role_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
              $('#roleAddModal').modal('hide');
              $('#roleAlert').append('<div class="text-center alert alert-'+data.message_level+'"><i class="icon fa fa-'+data.message_icon+'"></i> '+data.flash_message+'</div>');
              location.reload();
            },
            error: function (data) {
              var errors = data.responseJSON;
              if (errors.name){
                $('#errorRoleName').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorRoleName" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.name+'</div>');
              }
            }
          });
        });
      });
    </script>
    <!-- Tree checkbox -->
    <script type="text/javascript">
      $(".acidjs-css3-treeview").delegate("label input:checkbox", "change", function() {
        var checkbox = $(this),
        nestedList = checkbox.parent().next().next(),
        selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");
        if(checkbox.is(":checked")) {
          return selectNestedListCheckbox.prop("checked", true);
        }
        selectNestedListCheckbox.prop("checked", false);
      });
    </script>
    <script src="http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script>
      (function($){
        $(window).load(function(){
          /* initialize scrollbar */
          $(".acidjs-css3-treeview").mCustomScrollbar({
            mouseWheelPixels: 80,
            theme:"dark-3",
            autoHideScrollbar: true,
            scrollButtons:{enable:true}
          });
          /* insert twitter widget js in window load fn */
          !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        });
      })(jQuery);
    </script>
    <script>
      (function($){
        $(window).load(function(){
          /* initialize scrollbar */
          $(".bhoechie-tab-menu").mCustomScrollbar({
            mouseWheelPixels: 80,
            autoDraggerLength: true,
            theme:"dark-3",autoHideScrollbar: true,
            scrollButtons:{enable:true}
          });
          /* insert twitter widget js in window load fn */
          !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        });
      })(jQuery);
    </script>

    <!-- Sync permissions -->
    <script type="text/javascript">
    $('#syncPermissions').click(function() {
      var selectedRole = $('.list-group-item.active').attr('value');
      location.href = 'synchronous/'+selectedRole;
    });
    </script>

    <!-- Update permission -->
    <script type="text/javascript">
      $('.updater-permission').click(function(){
        var baseUrl = $('meta[name="base_url"]').attr('content');
        var role = $(this).val();
        var string = role;
        $('#'+role+' input.check_permission:checkbox:checked').each(function () {
          var val = $(this).val();
          string = string + ',';
          string = string + val;
        });
        $.ajax({
          type: 'get',
          url: baseUrl+'/updatePermission',
          data: { 'data': string },
          dataType: 'json',
          success: function (data) {
            $('#roleAlert').append('<div class="text-center alert alert-'+data.message_level+'"><i class="icon fa fa-'+data.message_icon+'"></i> '+data.flash_message+'</div>');
            location.reload();
          },
          error: function (data) {
            // $('#roleAlert').append('<div class="text-center alert alert-danger"><i class="icon fa fa-ban"></i> Đã xảy ra lỗi, vui lòng thử lại!</div>');
            // location.reload();
            toastr.success('Đã xảy ra lỗi, vui lòng thử lại!', 'Cập nhật quyền!');
          }
        });
    });
    </script>

     <script type="text/javascript">
      $("div.alert").delay(3000).slideUp();
    </script>

    <!-- Search role -->
    <script type="text/javascript">
     $(".search_role").on("input", function() {
      var e = $(this).val();
      var role_id= $(this).attr('role');
      $('.all_cb').attr("style", "display: none");
      $('.role_cb').attr("style", "display: none");

      console.log(e);

      if ("" != e.trim()) {
        var t = $('#'+role_id).find('.role_li');

        t.each(function() {
          var t = $(this), n = !1;

          permission_name = t.find(".permission_name");
          if(bodauTiengViet($(this).text()).indexOf(bodauTiengViet(e)) > 0){
           t.attr("style", "display: block");
         }else{
          t.attr("style", "display: none");
        }
            }) // end each t
      } else {
       $('.all_cb').attr("style", "display: block");
       $('.role_cb').attr("style", "display: block");
       var t = $('#'+role_id).find('.role_li');
       t.each(function() {
        $(this).attr("style", "display: block")
      })
     }
   });
     function bodauTiengViet(str) {  
      str= str.toLowerCase();  
      str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
      str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
      str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
      str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
      str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
      str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
      str= str.replace(/đ/g,"d");  
      return str;  
    }
  </script>
@endsection