@extends('layouts.front', ['subtitle'=>$obra->nombre])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=> 'obra', 'img'=> url('uploads/artists',$obra->artista->img_portada)]])
<div class="container contenido obra">
  <div class="row">


    <div class="col-md-12">
      <nav aria-label="breadcrumb" style="font-size: 14px;">
        <ol class="breadcrumb bg-transparent mb-0 pl-0">
          <li class="breadcrumb-item"><a href="{{ route('home.artistas') }}">Artistas</a></li>
          <li class="breadcrumb-item"> <a href="{{ route('home.artista.detail', $obra->artista->slug) }}">{{ ucfirst(strtolower($obra->artista->nombres)).' '.ucfirst(strtolower($obra->artista->apellidos)) }}</a></li>
          <li class="breadcrumb-item active" aria-current="page"> {{ $obra->nombre }} </li>
        </ol>
      </nav>
    </div>


    <div class="col-12 mb-4 text-center">
      <h4 class="heading-name">{{ $obra->artista->nombres.' '.$obra->artista->apellidos }}</h4>
    </div>

    <div class="col-12 mt-4">
      <div class="row justify-content-around align-items-start">
        <div class="col-md-5 img-cont-full r1-1 text-center">
          <img src="{{ url('uploads/artworks', $obra->img) }}" class="img-fluid rounded" alt="{{ $obra->nombre }}">
        </div>

        <div class="col-md-6">
          <ul class="list-unstyled p-0 m-0 mt-2">
            <li class="feature d-block mr-4">
              <h3>{{ $obra->nombre }}</h3>
              <p> {{ $obra->desc }}</p>
            </li>
            @if($obra->categoria->nombre)
            <li class="feature mr-4">
              <h5 class="subtitle text-info" style="font-size: 1.1em;font-weight: 500;margin-bottom: 2px;">Categoría:</h5>
              <p>{{ $obra->categoria->nombre }}</p>
            </li>
            @endif
            @if($obra->anio)
            <li class="feature mr-4">
              <h5 class="subtitle text-info">Año:</h5>
              <p>{{ $obra->anio }}</p>
            </li>
            @endif
            @if($obra->tamano)
            <li class="feature mr-4">
              <h5 class="subtitle text-info">Dimensiones:</h5>
              <ul class="list-unstyled p-0">
                @if(isset($alto))<li class=""><span class="mr-2 text-bold">altura:</span>{{$alto.'cm'}}</li>@endif
                @if(isset($ancho))<li class=""><span class="mr-2 text-bold">largo:</span>{{$ancho.'cm'}}</li>@endif
                @if(isset($largo))<li class=""><span class="mr-2 text-bold">ancho:</span>{{$largo.'cm'}}</li>@endif

              </ul>
            </li>
            @endif

            @if($obra->peso)
            <li class="feature mr-4">
              <h5 class="subtitle text-info">Peso:</h5>
              <p>{{ $obra->peso.' Kg.' }}</p>
            </li>
            @endif
            @if( !$obra->materiales->isEmpty() )
            <li class="feature mr-4">
              <h5 class="subtitle text-info">Materiales:</h5>
              <ul class="list-unstyled p-0">
                @foreach($obra->materiales as $material)
                <li class="">{{ $material->nombre }}</li>
                @endforeach
              </ul>
            </li>
            @endif
          </ul>

          @if(isset($producto_tienda))
          <div class="disponible-tienda mt-5">
              <b>Producto disponible en tienda:</b> <br>
              <a href="{{ route('home.tienda.producto', $producto_tienda) }}" class="btn btn-outline-secondary black linear mt-2">Ver en tienda</a>
          </div>
          @endif

        </div>

        @if(!empty($obra->galeria_img))
        <div class="col-12 mt-4">
          <div class="row">
            @foreach($obra->galeria_img as $img)
            <div class="col-md-2">
              <div class="w-100 img-cont-full r1-1">
                <img src='{{ url("uploads/artworks/shop", trim(str_replace("\"","",$img))) }}' class="img-fluid rounded img-thumbnail" alt="{{ $obra->nombre }}">
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
