@extends('layouts.front', ['subtitle'=>'Eventos'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=>'Eventos', 'img'=> asset('media/banner.jpg')]])
<div class="container contenido">
  <div class="row justify-content-around">
    <div class="col-md-9">
      @foreach( $eventos as $evento )

      <div class="card event-item mb-5">
        <div class="card-body img-cont-full r16-9" style="max-height:463px;">
          <a href="{{ route('home.evento.detail', $evento->slug) }}">
            <img src="{{ url('uploads/exhibitions',$evento->img) }}" style="/*object-position:center;*/" class="img-fluid" alt="{{ $evento->titulo }}">
          </a>
        </div>
        <div class="card-footer py-4">
          <div class="row justify-content-between align-items-end">

            <div class="col-md-5">
              <h5 class="dark-t event-detail-title"><a href="{{ route('home.evento.detail', $evento->slug) }}" class="text-dark">{{ strtoupper($evento->titulo) }}</a></h5>
              <h6 class="dark-t event-detail-title mb-0">{{ ($evento->artista) }}</h6>
            </div>

            <div class="col-md-7">
              <p class="float-md-right mb-0" style="color: #545454;">
                <i class="fas fa-map-marker-alt"></i> {{ $evento->lugar }} ({{ $evento->direccion }}, {{ $evento->distrito }})
                <br>

                <i class="far fa-calendar-check"></i> {{ strftime('Desde el %e de %B', strtotime($evento->fecha_inicio)) }} {{ strftime('hasta el %e de %B', strtotime($evento->fecha_fin)) }}
              </p>
            </div>

            <!--div class="col-md-auto info">
              <span><i class="fas fa-map-marker-alt"></i> {{ $evento->lugar }}</span>
              <span><i class="far fa-calendar-check"></i> {{ strftime('%e de %B', strtotime($evento->fecha_inicio)) }}</span>
            </div-->

          </div>
        </div>
      </div>

      @endforeach
    </div>
    <div class="col-md-3">
      <div class="card category-date-items no-br">
      @foreach($menu as $anio => $months)
        <div class="card-header bg-black d-flex justify-content-between align-items-center no-br" data-toggle="collapse" data-target="#{{ 'collapse'.$anio }}">
          <h5 class="m-0 text-white subtitle" style="font-size: 15px;">{{ $anio }}</h5>
          <span class="badge text-white"><i class="fa fa-chevron-down"></i></span>
        </div>
        <ul class="collapse list-group p-0 list-group-flush {{ ($loop->index === 0 || Request::get('periodo') == $anio ) ? 'show' : '' }}" id="{{ 'collapse'.$anio }}">
          @foreach($months->sort() as $month => $obras)

            <li class="list-group-item list-group-item-action d-flex align-items-center {{ ( request()->get('mes') == $month && request()->get('periodo') == $anio ) ? 'is-selected' : '' }}">

              <a href="{{ route('home.eventos', ['mes' => $month, 'periodo' => $anio ]) }}">{{ ucfirst($month) }}</a>

              @if( request()->get('mes') == $month && request()->get('periodo') == $anio )
                <a href="{{ route('home.eventos') }}" class="remove-filter">Regresar a eventos</a>
              @endif

              <span class="badge border">{{ $obras->count() }}</span>

            </li>

          @endforeach
        </ul>
      @endforeach
      </div>
    </div>
    <div class="col-12 mt-4">
      <div class="row justify-content-start">
        <div class="col-auto">
          <ul class="pagination">
            <li class="page-item {{ $eventos->currentPage() <= 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ route('home.eventos', ['page'=> $eventos->currentPage()-1 ]) }}"> <i class="fa fa-angle-double-left"></i> </a></li>
            @for($i = 1; $i <= $eventos->lastPage(); $i++)
            <li class="page-item {{ $i === $eventos->currentPage() ? 'active disabled' : '' }}"><a class="page-link" href="{{ route('home.eventos', ['page'=> $i ]) }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item {{ $eventos->currentPage() >= $eventos->lastPage() ? 'disabled' : '' }}"><a class="page-link" href="{{ route('home.eventos', ['page'=> $eventos->currentPage() + 1 ]) }}"> <i class="fa fa-angle-double-right"></i> </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
