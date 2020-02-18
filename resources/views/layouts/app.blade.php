<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> DGAC | Calendario</title>
    <link rel="shortcut icon" href="/images/logo_solo.ico">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/calendario.css')}}" rel="stylesheet" >

    @yield('scripts')

</head>

<!-- <header class="header black-bg">
 <div class="top-menu">
    <ul class="nav pull-left top-menu">

    </ul>
 </div>

</header> -->


<body>
    <div id="app">
        <nav class="nav pull-left top-menu black-bg">
            <div class="container row">
              <div class="">
              <a rel="nofollow">
                <img src="images/logo_solo.png" style="margin:5px 10px 0px 0; widht:38px; height:38px;" class="logoMPF" title="Ministerio Público Fiscal | Procuración General de la Nación">
              </a>
              </div>
              <div>
                 <a class="logo"> <span>DGAC</span> | Calendario</a>
              </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container">
            @yield('content')
          </div>
        </main>
    </div>
</body>

<footer class="site-footer">
            <div class="row">
                <div class="col-lg-4 text-right" style="margin-top:4px;">
                    <img src="images/logoTrans.png" style="height: 80px;" id="logoFooter" title="Dirección General de Análisis Criminal y Planificación Estratégica de la Persecución Penal">
                </div>
                <div class="col-lg-5 text-center footerDireccion">
                    <ul>
                        <li>AYUDA DE INFORMÁTICA</li>
                        <li><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; (011) 4338-4338 | <i class="fa fa-phone" aria-hidden="true"></i>&nbsp; VoIP 4338 | <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; soporte@mpf.gov.ar</li>
                    </ul>
                </div>
                <div class="col-lg-3 text-center footerDireccion">
                    <ul>
                        <li>SUGERENCIAS</li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; dac@mpf.gov.ar</li>
                    </ul>
                </div>
            </div>
</footer>
</html>
