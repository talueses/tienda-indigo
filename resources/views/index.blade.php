@extends('layouts.front', ['subtitle' => 'Inicio'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.slides', ['id' => 'slide-main', 'slides' => $sliders ])
<div class="container-fluid">
  <div class="row align-items-center">
    <div class="col-lg-6 img-cont-full r16-9">
      <img src="{{ url($img_tienda) }}" class="img-fluid ele" alt="">
    </div>
    <div class="col-lg-6 prev-element prev-tienda">
      <h3 class="simple-title"><a href="{{ route('home.tienda') }}">Tienda</a></h3>
      <div class="row justify-content-center align-items-start">
        @foreach($prev_shop as $product)
        <div class="col-lg-3 prev-tienda-item">
          <div class="w-100 img-cont-full r1-1">
            @if(!$product->img)
              <a href="{{ url('producto/'.$product->slug) }}">
                <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="{{ $product->nombre }}">
              </a>
            @else
              <a href="{{ url('producto/'.$product->slug) }}">
                <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded" alt="{{ $product->nombre }}">
              </a>
            @endif
          </div>
          <p class="footing-name">{{ $product->nombre }}</p>
        </div>
        @endforeach
      </div>
    </div>


    <div class="col-lg-6 prev-element prev-artistas">
      <h3 class="simple-title"><a href="{{ route('home.artistas') }}">Artistas</a></h3>
      <div class="row justify-content-center">
        @foreach($prev_artist as $artist)
        <div class="col-lg-3 prev-artistas-item">
          <div class="w-100 img-cont-full r1-1">
            @if(!$artist->img)
              <a href="{{ url('artista/'.$artist->slug) }}">
                <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="{{ $artist->nombre }}">
              </a>
            @else
              <a href="{{ url('artista/'.$artist->slug) }}">
                <img src="{{ url('uploads/artists', $artist->img) }}" class="img-fluid rounded" alt="{{ $artist->nombre }}">
              </a>
            @endif
          </div>
          <p class="footing-name">{{ $artist->nombres.' '.$artist->apellidos }}</p>
        </div>
        @endforeach
      </div>
    </div>
    <div class="col-lg-6 img-cont-full r16-9">
      <img src="{{ url($img_artistas) }}" class="img-fluid" alt="">
    </div>



    @if ($prev_event)
    <div class="col-lg-6 img-cont-full r16-9">
      <img src="{{ url('/uploads/exhibitions', $prev_event->img) }}" class="img-fluid" alt="">
    </div>
    <div class="col-lg-6 prev-element prev-eventos">

      <h3 class="simple-title"><a href="{{ route('home.eventos') }}">Eventos</a></h3>

      <div class="row justify-content-center">
        <div class="col-lg-9 prev-eventos-item">
          <h4>{{ strftime('%A %d de %B', strtotime($prev_event->fecha_inicio)).' - '.date("g:i a", strtotime($prev_event->hora)) }}</h4>
          <h4>{{ $prev_event->titulo }}</h4>

        </div>
      </div>

    </div>
    @endif


  </div>
</div>
@include('partials.banner')
@include('partials.feedinsta' , ['feed' => $feed_insta])

@include('partials.modal-newsletter')
@endsection
