<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ruta C</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('bower_components/dist/css/bootstrap.min.css') }}">--}}    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('dist/img/rutac-icon.png') }}">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>
    
        body{
            background: #33cc99;
            color:#fff;
            font-family: 'Open Sans', sans-serif;
            max-height:700px;
            overflow: hidden;
        }
        .c{
            text-align: center;
            display: block;
            position: relative;
            width:80%;
            margin:100px auto;
        }
        ._404{
            font-size: 220px;
            position: relative;
            display: inline-block;
            z-index: 2;
            height: 250px;
            letter-spacing: 15px;
        }
        ._1{
            text-align:center;
            display:block;
            position:relative;
            letter-spacing: 12px;
            font-size: 4em;
            line-height: 80%;
        }
        ._2{
            text-align:center;
            display:block;
            position: relative;
            font-size: 20px;
        }
        .text{
            font-size: 70px;
            text-align: center;
            position: relative;
            display: inline-block;
            margin: 19px 0px 0px 0px;
            /* top: 256.301px; */
            z-index: 3;
            width: 100%;
            line-height: 1.2em;
            display: inline-block;
        }
       

        .btn{
            background-color: rgb( 255, 255, 255 );
            position: relative;
            display: inline-block;
            width: 358px;
            padding: 5px;
            z-index: 5;
            font-size: 25px;
            margin:0 auto;
            color:#33cc99;
            text-decoration: none;
            margin-right: 10px
        }
        .right{
            float:right;
            width:60%;
        }
        
        hr{
            padding: 0;
            border: none;
            border-top: 5px solid #fff;
            color: #fff;
            text-align: center;
            margin: 0px auto;
            width: 420px;
            height:10px;
            z-index: -10;
        }
        
        hr:after {
            content: "\2022";
            display: inline-block;
            position: relative;
            top: -0.75em;
            font-size: 2em;
            padding: 0 0.2em;
            background: #33cc99;
        }
        
        .cloud {
            width: 350px; height: 120px;

            background: #FFF;
            background: linear-gradient(top, #FFF 100%);
            background: -webkit-linear-gradient(top, #FFF 100%);
            background: -moz-linear-gradient(top, #FFF 100%);
            background: -ms-linear-gradient(top, #FFF 100%);
            background: -o-linear-gradient(top, #FFF 100%);

            border-radius: 100px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;

            position: absolute;
            margin: 120px auto 20px;
            z-index:-1;
            transition: ease 1s;
        }

        .cloud:after, .cloud:before {
            content: '';
            position: absolute;
            background: #FFF;
            z-index: -1
        }

        .cloud:after {
            width: 100px; height: 100px;
            top: -50px; left: 50px;

            border-radius: 100px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
        }

        .cloud:before {
            width: 180px; height: 180px;
            top: -90px; right: 50px;

            border-radius: 200px;
            -webkit-border-radius: 200px;
            -moz-border-radius: 200px;
        }
        
        .x1 {
            top:-50px;
            left:100px;
            -webkit-transform: scale(0.3);
            -moz-transform: scale(0.3);
            transform: scale(0.3);
            opacity: 0.9;
            -webkit-animation: moveclouds 15s linear infinite;
            -moz-animation: moveclouds 15s linear infinite;
            -o-animation: moveclouds 15s linear infinite;
        }
        
        .x1_5{
            top:-80px;
            left:250px;
            -webkit-transform: scale(0.3);
            -moz-transform: scale(0.3);
            transform: scale(0.3);
            -webkit-animation: moveclouds 17s linear infinite;
            -moz-animation: moveclouds 17s linear infinite;
            -o-animation: moveclouds 17s linear infinite; 
        }

        .x2 {
            left: 250px;
            top:30px;
            -webkit-transform: scale(0.6);
            -moz-transform: scale(0.6);
            transform: scale(0.6);
            opacity: 0.6; 
            -webkit-animation: moveclouds 25s linear infinite;
            -moz-animation: moveclouds 25s linear infinite;
            -o-animation: moveclouds 25s linear infinite;
        }

        .x3 {
            left: 250px; bottom: -70px;

            -webkit-transform: scale(0.6);
            -moz-transform: scale(0.6);
            transform: scale(0.6);
            opacity: 0.8; 

            -webkit-animation: moveclouds 25s linear infinite;
            -moz-animation: moveclouds 25s linear infinite;
            -o-animation: moveclouds 25s linear infinite;
        }

        .x4 {
            left: 470px; botttom: 20px;

            -webkit-transform: scale(0.75);
            -moz-transform: scale(0.75);
            transform: scale(0.75);
            opacity: 0.75;

            -webkit-animation: moveclouds 18s linear infinite;
            -moz-animation: moveclouds 18s linear infinite;
            -o-animation: moveclouds 18s linear infinite;
        }

        .x5 {
            left: 200px; top: 300px;

            -webkit-transform: scale(0.5);
            -moz-transform: scale(0.5);
            transform: scale(0.5);
            opacity: 0.8; 

            -webkit-animation: moveclouds 20s linear infinite;
            -moz-animation: moveclouds 20s linear infinite;
            -o-animation: moveclouds 20s linear infinite;
        }

        @-webkit-keyframes moveclouds {
            0% {margin-left: 1000px;}
            100% {margin-left: -1000px;}
        }
        @-moz-keyframes moveclouds {
            0% {margin-left: 1000px;}
            100% {margin-left: -1000px;}
        }
        @-o-keyframes moveclouds {
            0% {margin-left: 1000px;}
            100% {margin-left: -1000px;}
        }

    </style>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Inicio Sesión</a></li>
                            <li><a href="{{ url('/registro') }}">Registro</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar Sesión
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div id="clouds">
            <div class="cloud x1"></div>
            <div class="cloud x1_5"></div>
            <div class="cloud x2"></div>
            <div class="cloud x3"></div>
            <div class="cloud x4"></div>
            <div class="cloud x5"></div>
        </div>
        <div class='c'>
            <div class='_404'>500</div>
            <hr>
            <div class='_1'>Lo Sentimos,</div>
            <div class='_2'>ha ocurrido un error, intente nuevamente.</div>
            <a class='btn' href='{{ action("HomeController@index") }}'>Regresar</a>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
        $(function () {
            $('.select2').select2({
                placeholder: 'Seleccione una opción'
            })
        });
    </script>

    @yield('footer')
</body>
</html>
