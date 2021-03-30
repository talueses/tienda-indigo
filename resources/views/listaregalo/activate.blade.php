@extends('layouts.front', ['subtitle'=>'Registro'])
@section('contenido')
@include('partials.banner')

<div class="container">

        <div class="row">

            <div class="col-md-6 offset-md-3 mt-5 mb-4 text-center">
                @if($success)
                  <p style="font-size: 1.2em;">{{$msg}}</p>
                @else
                  <p style="font-size: 1.2em;">Hubo un error al activar la cuenta. Por favor comuníquese con nosotros.</p>
                @endif
            </div>
        </div>

</div>
@endsection
