<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="base_url" content="{{ URL::to('/') }}">
    <meta name="_token" content="{!! csrf_token() !!}" />

    <title>
        @section('title')
        @show
    </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('public/admin/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{asset('public/admin/dist/css/timeline.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('public/admin/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{asset('public/admin/bower_components/morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

    <!-- Bo dau tren URL sau khi dang nhap bang Facebook -->
    <script>
        if (window.location.hash && window.location.hash == '#_=_') {
            if (window.history && history.pushState) {
                window.history.pushState("", document.title, window.location.pathname);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                var scroll = {
                    top: document.body.scrollTop,
                    left: document.body.scrollLeft
                };
                window.location.hash = '';
                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scroll.top;
                document.body.scrollLeft = scroll.left;
            }
        }
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('css')
    </head>

    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                @include('admin.includes.header')
                @include('admin.includes.sidebar')
            </nav>
            <div id="page-wrapper" style="height: 100%;">
                <div>
                    @if (Session::has('changePasswordMessage'))
                        <div class="text-center alert alert-danger">
                        {!! Session::get('changePasswordMessage') !!}
                        </div>
                    @endif
                </div>
               @yield('content')
           </div>
           
       </div>
       <!-- /#wrapper -->

       <!-- Bootstrap Core JavaScript -->
       <script src="{{asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

       <!-- Metis Menu Plugin JavaScript -->
       <script src="{{asset('public/admin/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

       <!-- Custom Theme JavaScript -->
       <script src="{{asset('public/admin/dist/js/sb-admin-2.js')}}"></script>
       @yield('js')
   </body>

   </html>
