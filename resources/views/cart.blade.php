@extends('layouts.front', ['subtitle'=>'Carrito de Compras'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=>'Carrito de Compras', 'img'=> asset('media/banner.jpg')]])
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript">
    $.noConflict() </script>
@section('page-js-script')
<script type="text/javascript">
  
</script>
@stop
<div class="container">

  <div class="row mt-5">
    
    <div id="success_form" class="col-12 col-sm-12 mx-auto text-center" style="display:none;">
      <i class="far fa-check-circle fa-4x text-success"></i>
      
      <h3 class="title2 mt-3 text-success">Gracias por su orden.</h3>
      <h5 class="h6" id="success_form_response">
        Su orden ha sido realizada satisfactoriamente. Le hemos enviado un mensaje a su correo con la información detallada de la misma. Si no logra visualizar el mensaje, asegúrese de revisar su carpeta SPAM.
      </h5>
      <br>
    </div>

    <div id="success_form_free_delivery" class="col-12 col-sm-12 mx-auto text-center" style="display:none;">
      <p class="text-center mb-0">
        <small class="d-flex align-items-center font-weight-bold">
          <i class="fas fa-truck fa-border fa-3x text-secondary mr-4"></i>
            {{-- {{ $free_delivery }}--}} <span>Delivery gratuito sólo en distritos seleccionados de Lima. &nbsp; &nbsp;<span id="success_form_free_delivery_text"></span> &nbsp; &nbsp; Recojo de piezas a partir de las 2 p.m. del día siguiente de realizada la compra, en el horario de la galería.</span>
        </small>
      </p>
      <br>
    </div>

    <div id="success_form_non_free_delivery" class="col-12 col-sm-12 mx-auto text-center" style="display:none;">
      <p class="text-center mb-0">
        <small class="d-flex align-items-center font-weight-bold">
          <i class="fas fa-truck fa-border fa-3x text-secondary mr-4"></i>
          El costo de envío será enviado a su correo electrónico en los próximos días.
        </small>
      </p>
      <br>
    </div>

    <div id="error_form" class="col-12 col-sm-12 mx-auto text-center" style="display:none;">
      <i class="fa fa-exclamation-circle fa-4x text-danger"></i>
      <h3 class="title2 mt-3 text-danger">No se pudo completar la transacción</h3>
      <h5 class="h6" id="error_form_response">Ha ocurrido un error, por favor intentelo de nuevo.</h5>
      <br>
    </div>

  </div>

</div>


<div id="main_orden" class="container contenido pt-3">


    @if ($role == "boda")
        <h4>No tienes acceso</h4>
        <p>Por favor cierra sesión y ingresa con una cuenta de usuario común.</p>
    @else
        <div id="app">
          <cart></cart>
        </div>

        <button id="monto" class="btn btn-success">Pagar</button>
        <script src="https://checkout.culqi.com/js/v3"></script>
        <script>
        var totalP="";
    $('#monto').on('click', function(e) {
      
        totalP = Number(document.getElementById('total_price1').innerHTML)*100;
        Culqi.publicKey = 'pk_test_enUyyIuFaZuVwi6T';
        Culqi.settings({
            title: 'Total Carrito',
            currency: 'PEN',
            description: 'Indigo Store',
            amount: totalP      
        });
        // Abre el formulario con las opciones de Culqi.settings
        Culqi.open();
        e.preventDefault();
        
    });
    function culqi() {
      if (Culqi.token) { 
      var token = Culqi.token.id;
      var email = Culqi.token.email;
      let _token   = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
          url:'/ajax-request',
          type:'POST',
          data:{
              precio:totalP,
              token:token,
              email:email,
              _token: _token
          }
      }).done(function(resp){
          alert(resp);
        })

      
    } else { // ¡Hubo algún problema!
      // Mostramos JSON de objeto error en consola
      console.log(Culqi.error);
      alert(Culqi.error.user_message);
  }
};
</script>
        <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script type="text/javascript">
         
          </script>

            @endif


</div>

@endsection
