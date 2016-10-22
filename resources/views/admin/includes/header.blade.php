
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}"><img width="110" src="{{asset('public/admin/image/vnesport.png')}}"></a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{ url('profile') }}"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->fullname }}</a>
            </li>
            <li><a href="{{ url('password') }}"><i class="fa fa-key fa-fw"></i> Đổi mật khẩu</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->   
<!-- /.navbar-static-side -->
