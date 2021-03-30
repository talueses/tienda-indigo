@extends('layouts.front', ['subtitle'=>'Programa de regalos'])
@section('contenido')
@include('partials.banner')




    <div class="container contenido">
      <div class="row">
        <div class="col-lg-4">
          <ul class="list-unstyled">
            <li><h2 class="text-dark text-uppercase">{{ $cuenta->titulo }}</h2></li>
            <li>
              <h4 class="subtitle text-secondary">
                @if($cuenta->organizador_uno) {{ $cuenta->organizador_uno }} @endif
                @if($cuenta->organizador_dos) {{ " & ". $cuenta->organizador_dos }} @endif
              </h4>
            </li>
            <li><p>{{ $cuenta->desc }}</p></li>
            <li class="d-flex align-items-center justify-content-start mb-3"><i class="far fa-calendar-alt mr-2 text-danger"></i><span>{{ strftime('%d de %B del %Y', strtotime($cuenta->fecha)) }}</span></li>
            <li class="d-flex align-items-center justify-content-start"><i class="fa fa-gift mr-2 text-danger"></i><span>{{ $cuenta->productos->count().' regalos enlistados' }}</span></li>
          </ul>
        </div>

        <div class="col-lg-8">
          <div class="w-100 text-center"> <!-- r1-1 img-cont-full  -->
            <img src="{{ url( $cuenta->img ? 'uploads/giftregistry/'.$cuenta->img : 'media/default.jpg' ) }}" class="img-fluid" alt="" style="max-height: 420px;">
          </div>
        </div>



        <div class="col-12 mt-5">

            <div class="table-responsive">
              <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">

                <thead>
                  <tr>
                    <th width="200"></th>
                    <th>Regalo</th>
                    <th>Color</th>
                    <th>Solicitados</th>
                    <th>Stock</th>
                    <th>Recibidos</th>
                    <th>Precio Unitario</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>

                  @foreach($regalos as $product)
                  <tr>
                    <td class="pt-1 pb-1 pl-2">
                      @if(!$product->img)
                        <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded" style="width: 200px;height: 100px;object-fit: cover;" alt="">
                      @else
                        <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded" style="width: 200px;height: 100px;object-fit: cover;" alt="">
                      @endif
                    </td>
                    <td><a href="{{ url('/producto', $product->slug) }}">{{ $product->nombre }}</a></td>
                    <td>{{ ucfirst($product->color) }}</td>
                    <td>{{ $product->solicitados }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->recibidos }}</td>
                    <td>
                      @if(isset($product->dsct_lista_regalo) && ($product->dsct_lista_regalo > 0))
                        <span style="text-decoration: line-through;color: gray;">{{ 'S/ '.$product->precio }}</span> <br>
                        <span class="product-dsct">{{ 'S/ '. sprintf('%0.2f',(floatval($product->precio) - floatval($product->dsct_lista_regalo)) ) }}</span>
                      @else
                        <span>{{ 'S/ '. $product->precio }}</span>
                      @endif
                    </td>
                    <td>

                      @if( $product->solicitados == $product->recibidos )
                          <span>--</span>
                      @else
                          <span>---</span>
                      @endif
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>

        </div>





      </div>
    </div>




@include('partials.modal-add-cart')

@include('partials.modal-add-gift')

@include('partials.modal-client-gift')

@endsection
