@extends('layouts.front', ['subtitle'=> $evento->titulo])
@section('contenido')
@include('partials.banner', ['brand'=> ['name'=>'evento','img'=> url('uploads/exhibitions',$evento->img)]])
<div class="container contenido">
  <div class="row">
    <div class="col-md-8">

      <nav aria-label="breadcrumb" style="font-size: 14px;">
        <ol class="breadcrumb bg-transparent pt-0 mb-0 pl-0">
          <li class="breadcrumb-item"><a href="{{ route('home.eventos') }}">Eventos</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $evento->titulo }}</li>
        </ol>
      </nav>


      <div class="img-cont-full r16-9 mb-3">
        <a data-fancybox="gallery" href="{{ url('uploads/exhibitions', $evento->img) }}">
          <img src="{{ url('uploads/exhibitions', $evento->img) }}" class="img-fluid" alt="{{ $evento->titulo }}">
        </a>
      </div>


      <div class="col-12 p-0">
          <h2 class="dark-t event-detail-title">{{ strtoupper($evento->titulo) }}</h2>
          <h3 class="dark-t event-detail-title">{{ strtoupper($evento->artista) }}</h3>

          <div class="mb-4"></div>
          {!! $evento->desc !!}


      </div>
    </div>
    <div class="col-md-4">
      <div class="card no-br">
        <div class="card-header no-br bg-black">
          <h4 class="card-title mb-0 subtitle text-uppercase text-white" style="font-size:16px;">Detalles</h4>
        </div>
        <div class="card-body">
          <div class="row justify-content-start align-items-center">

            <div class="col-12 mb-2">
              <div class="row align-items-center justify-content-start">
                <div class="col-auto">
                  <i class="far fa-calendar-check text-secondary"></i>
                </div>
                <div class="col p-0">
                  <p class="m-0"><b>INAUGURACIÓN</b></p>
                </div>
              </div>
            </div>

            <!--div class="col-12 mb-2">
              <p class="mb-0"><b>INAUGURACIÓN:</b></p>
            </div-->

                <div class="col-12 my-2">
                  <p class="m-0 d-flex align-items-center"><strong>Día:</strong>&nbsp;&nbsp;{{ucwords(strftime('%A',strtotime($evento->fecha_inicio)))}}{{ strftime(' %e de %B', strtotime($evento->fecha_inicio)) }}</p>
                </div>

                <div class="col-12 my-2">
                  <p class="m-0 d-flex align-items-center"><i class="far fa-clock mr-3 text-secondary"></i> {{ date("g:i a", strtotime($evento->hora)) }}</p>
                </div>
                <div class="col-12 my-2">
                  <div class="row align-items-center justify-content-start">
                    <div class="col-auto">
                      <i class="fas fa-map-marker-alt text-secondary"></i>
                    </div>
                    <div class="col p-0">
                      <p class="m-0">{{ $evento->lugar.' - '.$evento->distrito }}</p>
                      <p class="m-0"><small class="text-muted">{{ $evento->direccion }}</small></p>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <p class="m-0 d-flex align-items-center"><i class="fas fa-ticket-alt mr-3 text-secondary"></i> {{ $evento->precio.' PEN' }}</p>
                </div>


            <div class="col-12 mt-4 mb-2">
              <p class="m-0"><b>DURACIÓN:</b> {{ strftime('Desde el %e de %B', strtotime($evento->fecha_inicio)) }} {{ strftime('hasta el %e de %B', strtotime($evento->fecha_fin)) }}</p>
            </div>

          </div>
        </div>

        <ul class="list-unstyled list-group list-group-flush">
          <li class="list-group-item"><div class="fb-share-button" data-href="{{ Request::url() }}" data-layout="button" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div></li>
        </ul>
      </div>

      @if($evento->galeria_img)
      <div class="col-12 my-4">
        <div class="row">
          @foreach($evento->galeria_img as $img)
          <div class="col-md-6 mb-4">
            <div class="w-100 img-cont-full r1-1">
              <a data-fancybox="gallery" href='{{ url("uploads/exhibitions/shop", trim(str_replace("\"","",$img))) }}'>
                <img src='{{ url("uploads/exhibitions/shop", trim(str_replace("\"","",$img))) }}' class="img-fluid" alt="{{ $evento->nombre }}">
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif
    </div>



  </div>
</div>
@endsection
