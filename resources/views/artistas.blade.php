@extends('layouts.front', ['subtitle' => 'Artistas'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=>'Artistas','img'=> asset('media/artistas-prev.jpg')]])
<div class="container contenido">
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <p>Nuestros artistas son como familia. Somos increíblemente privilegiados de poder ver de primera mano sus obras, su proceso y conocerlos personalmente. Les presentamos a los principales miembros de la familia Indigo.</p>
    </div>
    <div class="col-12">
      <div class="row prev-element prev-artistas justify-content-around">
        @foreach($artistas->sortByDesc('destacado') as $artista)
        @if($loop->index % 3 == 0 )
        <div class="w-100"></div>
        @endif
        <div href="{{ route('home.artista.detail', $artista->slug) }}" class="col-lg-4 prev-artistas-item my-3">
          <div class="w-100 img-cont-full r1-1">
            @if($artista->recently)
            <span class="bagde bagde-left-top bg-primary text-white">nuevo</span>
            @endif

            @if($artista->destacado)
            <span class="bagde bagde-right-top bg-warning text-white">destacado</span>
            @endif

            @if(!$artista->img)
              <a href="{{ route('home.artista.detail', $artista->slug) }}">
                <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="{{ $artista->nombres.' '.$artista->apellidos }}">
              </a>
            @else
              <a href="{{ route('home.artista.detail', $artista->slug) }}">
                <img src="{{ url('uploads/artists', $artista->img) }}" class="img-fluid rounded border" alt="{{ $artista->nombres.' '.$artista->apellidos }}">
              </a>
            @endif

          </div>
          <p class="footing-name"><a href="{{ route('home.artista.detail', $artista->slug) }}">{{ $artista->nombres.' '.$artista->apellidos }}</a></p>
          <p class="text-dark">{{ $artista->obras->count().' obra(s)' }}</p>
        </div>
        @endforeach
      </div>
    </div>
    <div class="col-12">
      <div class="row justify-content-start">
        <div class="col-auto">
          <ul class="pagination">
            <li class="page-item {{ $artistas->currentPage() <= 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ route('home.artistas', ['page'=> $artistas->currentPage()-1 ]) }}"> <i class="fa fa-angle-double-left"></i> </a></li>
            @for($i = 1; $i <= $artistas->lastPage(); $i++)
            <li class="page-item {{ $i === $artistas->currentPage() ? 'active disabled' : '' }}"><a class="page-link" href="{{ route('home.artistas', ['page'=> $i ]) }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item {{ $artistas->currentPage() >= $artistas->lastPage() ? 'disabled' : '' }}"><a class="page-link" href="{{ route('home.artistas', ['page'=> $artistas->currentPage() + 1 ]) }}"> <i class="fa fa-angle-double-right"></i> </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
