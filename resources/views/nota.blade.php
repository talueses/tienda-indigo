@extends('layouts.front', ['subtitle'=> $nota->titulo])
@section('contenido')
@include('partials.banner', ['brand'=> ['name'=>'nota','img'=> url('uploads/notes',$nota->img)]])
<div class="container contenido">
  <div class="row">
    <div class="col-md-8">

      <nav aria-label="breadcrumb" style="font-size: 14px;">
        <ol class="breadcrumb bg-transparent mb-0 pl-0">
          <li class="breadcrumb-item"><a href="{{ route('home.notas') }}">Notas</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $nota->titulo }}</li>
        </ol>
      </nav>


      @if ($nota->img)
      <div class="img-cont-full r16-9 mb-3">
        <a data-fancybox="gallery" href="{{ url('uploads/notes', $nota->img) }}">
          <img src="{{ url('uploads/notes', $nota->img) }}" class="img-fluid" alt="{{ $nota->titulo }}">
        </a>
      </div>
      @endif

      <div class="col-12 my-2 pl-0">
        <p class="m-0 d-flex align-items-center"><i class="far fa-clock mr-2 text-secondary"></i> <small>{{ $created_at }}</small></p>
      </div>

      <div class="col-12 p-0">
        <h2 class="dark-t event-detail-title">{{ $nota->titulo }}</h2>
        <h3 class="dark-t event-detail-title mb-4">{{ strtoupper($nota->fuente) }}</h3>

        {!! $nota->desc !!}

      </div>
    </div>
    <div class="col-md-4">


      @if($nota->galeria_img)
      <div class="col-12 my-4">
        <div class="row">
          @foreach($nota->galeria_img as $img)
          <div class="col-md-6 mb-4">
            <div class="w-100 img-cont-full r1-1">
              <a data-fancybox="gallery" href='{{ url("uploads/notes/shop", trim(str_replace("\"","",$img))) }}'>
                <img src='{{ url("uploads/notes/shop", trim(str_replace("\"","",$img))) }}' class="img-fluid" alt="{{ $nota->nombre }}">
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
