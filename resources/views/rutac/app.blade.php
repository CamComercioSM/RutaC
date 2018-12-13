<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::secure('dist/css/AdminLTE.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::secure('dist/css/skins/_all-skins.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link href="{{ URL::secure('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::secure('dist/img/rutac-icon.png') }}">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('style')
</head>
<body class="hold-transition skin-black-light sidebar-mini fixed">
<div class="wrapper">
        <div class="capa">
            <div class="loader"> </div>
            <h2 style="color:#fff"> Espere un momento...</h2>
        </div>
    
        <header class="main-header">
            @include('rutac.includes.header')
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        
        <aside class="main-sidebar">
            @include('rutac.includes.left-aside')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="col-xs-12" style="margin-top: 5px;">
                @if(session("message_success"))
                    <div class="alert alert-success " role="alert">
                         {{session("message_success")}}
                    </div>
                @endif
                @if(session("message_error"))
                    <div class="alert alert-danger " role="alert">
                        <i class="fa fa-danger"></i> {{session("message_error")}}
                    </div>
                @endif
            </div>
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            @include('rutac.includes.footer')
        </footer>
    
    
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ URL::secure('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::secure('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ URL::secure('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::secure('dist/js/adminlte.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ URL::secure('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ URL::secure('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ URL::secure('dist/js/demo.js') }}"></script>    

<script src="{{ asset('dist/js/apiSicam.js') }}"></script>

@yield('footer')

</body>
</html>
