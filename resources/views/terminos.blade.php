@extends('layouts.front', ['subtitle'=>$title])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=> $title, 'img'=> asset('media/banner.jpg')]])
<section class="py-4 my-4">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h4 class="display-5">{{ $title }}</h4>
      </div>
      @if( $termino )
      <div class="col-12 mt-3">
        {!! $termino->valor !!}
      </div>
      @endif
    </div>
  </div>
</section>
@endsection
