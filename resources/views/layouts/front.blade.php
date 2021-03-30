<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Galería Indigo - {{ $subtitle }}</title>
    <meta property="og:url"           content="{{ Request::url() }}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Galería Indigo - {{ $subtitle }}" />
    <meta property="og:description"   content="Arte y artesanía de los más prestigiosos artistas y artesanos peruanos. Hoy en día GALERÍA ÍNDIGO es considerado un espacio ideal para el deleite de los amantes del arte, diseño y creatividadPeruana, ya que alberga entre sus espacios el trabajo de cientos de prestigiosos artistas reunidos en un solo lugar." />
    <meta property="og:image"         content="{{ Request::root() }}/media/indigo_logo.png" />
    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/fontawesome-all.min.css') }}">
</head>
<body>
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.3"></script>
  <div id="progress_form" class="col-12 text-center"><i class="fa fa-spinner fa-spin fa-5x"></i>
    <h3 class="title2 mt-3">Cargando . . .</h3>
    <p>Por favor no recargue ni cierre esta p&aacute;gina.</p>
  </div>
  <!-- BEGIN Footer -->
  @include('layouts.header')
  <!-- END Footer -->
  <div class="clearheader"></div>
  <!--main section-->
  <section class="main-content">
    @yield('contenido')
  </section>
  <!--end main section-->

  <!-- BEGIN Footer -->
  @include('layouts.footer')
  <!-- END Footer -->

  <!-- BEGIN Modal -->
  @include('layouts.modal-news-letter')
  <!-- END Modal -->
  
  <!-- BEGIN Scripts -->
  @include('layouts.scripts')
  <!-- END Scripts -->
</body>
</html>
