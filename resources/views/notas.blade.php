@extends('layouts.front', ['subtitle'=>'Notas'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=>'Notas', 'img'=> asset('media/banner.jpg')]])
<div class="container contenido">
  <div class="row justify-content-around">
    <div class="col-md-9">
      @foreach( $notas as $nota )


        <div class="card mb-4 rounded-0" style="width:700px;">

            @if ($nota->img)
              <a href="{{route('home.nota.detail', $nota->slug)}}">
                <img class="card-img-top rounded-0" src="{{url('/uploads/notes/'.$nota->img)}}" alt="" style="height: 314px;object-fit: cover;">
              </a>
            @endif

            <div class="card-body">

              <div class="col-12 my-2 pl-0">
                <p class="m-0 d-flex align-items-center"><i class="far fa-calendar-alt mr-2 text-secondary"></i> <small>{{ $nota->created_at_formated }}</small></p>
              </div>

              <h5 class="dark-t event-detail-title"><a href="{{route('home.nota.detail', $nota->slug)}}" class="text-dark">{{ $nota->titulo }}</a></h5>
              @if($nota->fuente)<h6 class="dark-t event-detail-title mb-4">{{ strtoupper($nota->fuente) }}</h6>@endif

              <div class="card-text">
                  {!! html_cut($nota->desc, 400) !!}

                  @if (str_word_count($nota->desc) > 100)
                    <p>...</p>
                  @endif
              </div>

              @if (str_word_count($nota->desc) > 100)
              <small class="float-right"><a href="{{route('home.nota.detail', $nota->slug)}}">Continuar leyendo</a></small>
              @endif
            </div>

          	<!--div class="card-footer">

          	</div-->

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
        <ul class="collapse list-group p-0 list-group-flush {{ $loop->index === 0 ? 'show' : '' }}" id="{{ 'collapse'.$anio }}">
          @foreach($months->sort() as $month => $obras)

            <li class="list-group-item list-group-item-action d-flex align-items-center {{ ( request()->get('mes') == $month && request()->get('periodo') == $anio ) ? 'is-selected' : '' }}">
              <a href="{{ route('home.notas', ['mes' => $month, 'periodo' => $anio ]) }}">{{ ucfirst($month) }}</a>

              @if( request()->get('mes') == $month && request()->get('periodo') == $anio )
                <a href="{{ route('home.notas') }}" class="remove-filter">Regresar a notas</a>
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
            <li class="page-item {{ $notas->currentPage() <= 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ route('home.notas', ['page'=> $notas->currentPage()-1 ]) }}"> <i class="fa fa-angle-double-left"></i> </a></li>
            @for($i = 1; $i <= $notas->lastPage(); $i++)
            <li class="page-item {{ $i === $notas->currentPage() ? 'active disabled' : '' }}"><a class="page-link" href="{{ route('home.notas', ['page'=> $i ]) }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item {{ $notas->currentPage() >= $notas->lastPage() ? 'disabled' : '' }}"><a class="page-link" href="{{ route('home.notas', ['page'=> $notas->currentPage() + 1 ]) }}"> <i class="fa fa-angle-double-right"></i> </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
