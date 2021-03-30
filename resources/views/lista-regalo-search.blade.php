@extends('layouts.front', ['subtitle'=>'Programa de regalos'])
@section('contenido')
@include('partials.banner')
<div class="container contenido bg-white">

  @include('listaregalo.layouts.session')

  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-lg-4">
          <ul class="list-unstyled">
            <li><h2 class="text-dark text-uppercase">{{ $lista->titulo }}</h2></li>
            <li>

              <h4 class="subtitle text-secondary">
                @if($lista->organizador_uno) {{ $lista->organizador_uno }} @endif
                @if($lista->organizador_dos) {{ " & ". $lista->organizador_dos }} @endif
              </h4>
            </li>
            <li><p>{{ $lista->desc }}</p></li>
            <li class="d-flex align-items-center justify-content-start mb-3"><i class="far fa-calendar-alt mr-2 text-danger"></i><span>{{ strftime('%d de %B del %Y', strtotime($lista->fecha)) }}</span></li>
            <li class="d-flex align-items-center justify-content-start"><i class="fa fa-gift mr-2 text-danger"></i><span>{{ $lista->productos->count().' regalos enlistados' }}</span></li>
          </ul>
        </div>

        <div class="col-lg-8">
          <div class="w-100 text-center"> <!-- r1-1 img-cont-full  -->
            <img src="{{ url( $lista->img ? 'uploads/giftregistry/'.$lista->img : 'media/default.jpg' ) }}" class="img-fluid" alt="" style="max-height: 420px;">
          </div>
        </div>


        <div class="col-12 mt-5">
            <br/>
            <small class="float-right"> * Precio final por unidad con recargos y decuentos aplicados </small>
            <div class="table-responsive">
              <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">

                <thead>
                  <tr>
                    <th width="200"></th>
                    <th> Regalo </th>
                    <th> Color </th>
                    <th> Solicitados </th>
                    <th> Recibidos </th>
                    <th> Precio Unitario </th>
                    <th> Descuento </th>
                    <th> Recargo </th>
                    <th> Precio final unitario *</th>
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
                    <td>{{ $product->recibidos }}</td>
                    <td>
                      S/ {!! $product->precio!!}
                    </td>
                    <td>
                      S/ {!! $product->dsct_lista_regalo !!}
                    </td>
                    <td>
                      S/ {!! $product->recargo !!}
                    </td>
                    <td>
                         {!! showTotalPriceClient($product) !!}
                    </td>
                    <td>
                      @if( $product->solicitados == $product->recibidos )
                          <span>--</span>
                      @else
                          <button class="btn btn-outline-secondary black linear add_to_wedding_cart_btn" type="button" name="button" data-item="{{ $product->id }}" data-item-regalo-id="{{ $product->lista_regalo_id }}" data-wedding-list="{{ $lista->codigo }}" data-color="{{ ($product->color) ? $product->color : '' }}" data-img="{{ $product->img }}" data-title="{{ $product->nombre }}" data-price="{{ showTotalPriceClient($product) }}">Regalar</button>
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
  </div>
</div>

@include('partials.modal-add-cart')

@include('partials.modal-add-gift')

@include('partials.modal-client-gift')

@endsection
