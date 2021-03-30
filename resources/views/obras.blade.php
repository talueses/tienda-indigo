@extends('layouts.front', ['subtitle'=>'Obras'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=> ['name'=> 'Obras', 'img'=> asset('media/tienda-prev.jpg')]])
<div class="container contenido">
  <div class="row">
    <div class="col-12 us-sec-content">
      <div class="img-cont-full brnd">
        <img src="{{ url('uploads/page', $obra->img ) }}" class="img-fluid" alt="">
      </div>
      {!! $obra->contenido !!}
    </div>
  </div>
</div>
@endsection
