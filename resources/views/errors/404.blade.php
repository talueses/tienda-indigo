@extends('layouts.front', ['subtitle' => 'Inicio'])
@section('contenido')
@include('partials.socialfixed')


<div class="container h-100" style="margin-top: 5em;">
    <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-12 col-md-9 col-lg-8 col-xl-6 text-center">
          <h1 class="display-1 text-danger" style="font-weight: bolder;">404</h1>
          <p class="lead">Lo sentimos! No podemos encontrar la página que estás buscando...</p>
        </div>
    </div>
</div>

@endsection
