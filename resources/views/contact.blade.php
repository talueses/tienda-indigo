@extends('layouts.front', ['subtitle'=>'Contacto'])
@section('contenido')
@include('partials.banner')

<div class="container contenido">
  <div class="row">

    <div class="col-12">
      <p>Para más información o consultas complete el siguiente formulario:</p>
    </div>

    <div class="col-md-6 form-contact">
      <form action="{{ route('home.contact') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="nombre">Nombres</label>
          <input type="text" name="nombres" class="form-control {{$errors->has('nombres') ? 'border-danger' : ''}}" value="{{old('nombres')}}">

          @if($errors->has('nombres'))
            @foreach ($errors->get('nombres') as $message)
            <small class="form-text text-danger">{{$message}}</small>
            @endforeach
          @endif

        </div>
        <div class="form-group">
          <label for="correo">Correo</label>
          <input type="text" name="correo" class="form-control {{$errors->has('correo') ? 'border-danger' : ''}}" value="{{old('correo')}}">

          @if($errors->has('correo'))
            @foreach ($errors->get('correo') as $message)
            <small class="form-text text-danger">{{$message}}</small>
            @endforeach
          @endif
        </div>
        <div class="form-group">
          <label for="mensaje">Mensaje</label>
          <textarea name="mensaje" rows="3" cols="30" class="form-control {{$errors->has('mensaje') ? 'border-danger' : ''}}" value="{{old('mensaje')}}"></textarea>
          @if($errors->has('mensaje'))
            @foreach ($errors->get('mensaje') as $message)
            <small class="form-text text-danger">{{$message}}</small>
            @endforeach
          @endif
        </div>

        <div class="g-recaptcha" data-sitekey="6LeuN2kUAAAAAF5bg55CMnxslEYCCeEq61qcS5aq"></div>

        <div class="mb-3"></div>

        <div class="form-group">
          <button type="submit" class="btn btn-outline-secondary black linear">Enviar mensaje</button>
        </div>
      </form>
    </div>
<!-- 
    <div class="col-md-6 map-marker">
        <div id="g_maps_contact">
        <div id="map" style="width:100%;height:100%;"></div>
          <script type="text/javascript">
           function initMap() {
            var uluru = {lat: -12.0431805, lng: -77.0282364};
            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 13, center: uluru});
            var marker = new google.maps.Marker({position: uluru, map: map});
          }
          </script>
        </div>
    </div> -->
</div>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBYaD9zJPavbe_l7VyKJdCl5h-X3qlSyI&callback=initMap"></script> -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
