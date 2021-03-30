@extends('layouts.front',['subtitle' => 'Nosotros'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner')
<div class="container us-sec contenido">
  <div class="row">
    <div class="col-12 us-sec-content">
      <div class="img-cont-full brnd">
        <img src="{{ $us->img ? url('uploads/nosotros', $us->img ) : url('uploads/nosotros/default.jpg') }}" class="img-fluid" style="position: absolute;" alt="">
      </div>
      {!! $us->contenido !!}
    </div>
  </div>
</div>
@endsection
