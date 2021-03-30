@extends('layouts.front', ['subtitle'=>'Cuenta de Programa de Regalos'])
@section('contenido')
@include('partials.banner')


<div class="container contenido">

  @include('listaregalo.layouts.session')

  <div class="card">
    <div class="card-body">
      <p>Cuenta no activada.</p>
      <p>Por favor confirme su cuenta primero.</p>
      <form action="{{ route('giftregistry.confirmaccount') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="user_token" value="{{ $user_token }}">
        <button type="submit" class="btn btn-outline-secondary black linear mt-3">Reenviar email</button>
      </form>
    </div>
  </div>

</div>

@endsection
