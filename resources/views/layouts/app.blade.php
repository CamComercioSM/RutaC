<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ruta C</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
{{--    <link rel="stylesheet" href="{{ URL::secure('bower_components/dist/css/bootstrap.min.css') }}">--}}    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::secure('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::secure('dist/css/AdminLTE.min.css') }}">
    
    <link rel="stylesheet" href="{{ URL::secure('plugins/iCheck/square/blue.css') }}">

    <link rel="stylesheet" href="{{ URL::secure('dist/css/skins/_all-skins.min.css') }}">

    <link rel="stylesheet" href="{{ URL::secure('bower_components/select2/dist/css/select2.min.css') }}">

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
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @yield('style')

<script data-ad-client="ca-pub-5163385221124664" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


</head>
<body class="hold-transition skin-black-light login-page layout-top-nav">
    <div class="wrapper">
        <div class="capa">
            <div class="loader"> </div>
            <h2 style="color:#fff"> Espere un momento...</h2>
        </div>
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
                                            Logout
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

        @yield('content')
    </div>

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

    <script src="{{ URL::secure('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ URL::secure('plugins/iCheck/icheck.min.js') }}"></script>
    
    <script src="{{ asset('dist/js/apiSicam.js') }}"></script>

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
        
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154856020-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-154856020-1'); 
</script>         

<script data-ad-client="ca-pub-5163385221124664" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        
    
</body>
</html>
