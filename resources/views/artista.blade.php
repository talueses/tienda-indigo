@extends('layouts.front', ['subtitle'=> $artista->nombres])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=>'Artista','img'=>url('uploads/artists',$artista->img_portada)]])
<div class="container contenido">
  <div class="row justify-content-around">


    <div class="col-md-12">
      <nav aria-label="breadcrumb" style="font-size: 14px;">
        <ol class="breadcrumb bg-transparent mb-0 pl-0">
          <li class="breadcrumb-item"><a href="{{ route('home.artistas') }}">Artistas</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(strtolower($artista->nombres)).' '.ucfirst(strtolower($artista->apellidos)) }}</li>
        </ol>
      </nav>
    </div>
    <div class="col-md-4">
      <div class="img-cont-full r1-1">
        <img src="{{ url('uploads/artists', $artista->img) }}" class="img-fluid rounded" alt="">
      </div>
      <p class="mt-4 text-center text-dark">{{ $artista->pais.' / '.$artista->ciudad }}</p>
    </div>
    <div class="col-md-8 details">
      <h3>{{ $artista->nombres.' '.$artista->apellidos }}</h3>

      <ul class="list-inline p-0 list-unstyled m-0">
        @foreach( $artista->obras->groupBy('categoria.nombre') as $key => $value )
        <li class="list-inline-item text-bold">{{ $key }}</li>
        @endforeach
      </ul>
      <p class="mt-2"></p>

      <div class="bio mb-4">
          {!! $artista->bio !!}
      </div>

      <div class="row">

        @if ($artista->estudios != "<p><br></p>" && !empty($artista->estudios))
        <div class="col-md-4 item-detail">
          <h4 style="font-size: 1.2rem;">Estudios</h4>
          {!! $artista->estudios !!}
        </div>
        @endif

        @if ($artista->muestras != "<p><br></p>" && !empty($artista->muestras))
        <div class="col-md-4 item-detail">
          <h4 style="font-size: 1.2rem;">Muestras</h4>
          {!! $artista->muestras !!}
        </div>
        @endif

        @if ($artista->premios != "<p><br></p>" && !empty($artista->premios))
        <div class="col-md-4 item-detail">
          <h4 style="font-size: 1.2rem;">Premios</h4>
          {!! $artista->premios !!}
        </div>
        @endif

      </div>

    </div>

    @if (!$artista->obras->isEmpty())
    <div class="col-12 col-lg-12 obras mt-4">
      <div class="row prev-tienda">
        <div class="col-12 text-left mb-4">
          <h4 class="text-uppercase block-title font-weight-bold">obras representativas</h4>
        </div>
        @foreach($artista->obras as $obra)
        <a href="{{ route('home.obra.detail', $obra->slug) }}" class="col-lg-2 prev-tienda-item mb-3">
          <div class="w-100 img-cont-full r1-1">
            <img src="{{ url('uploads/artworks', $obra->img) }}" class="img-fluid rounded border" alt="">
          </div>
          <p class="footing-name">{{ $obra->nombre }}</p>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</div>
@endsection
