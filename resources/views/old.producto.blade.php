@extends('layouts.front', ['subtitle'=>$product->nombre])
@section('contenido')
@include('partials.banner')
<div class="container contenido pb-0">

  <div class="row">

    <div class="col-12 mb-3">
      <a class="text-primary btn btn-link px-0" href="{{ route('home.tienda') }}"><i class="fas fa-arrow-left"></i> Regresar a tienda</a>
    </div>

    <div class="col-12">
      <h1 class="subtitle">{{ $product->nombre }}</h1>
      <ul class="list-inline list-unstyled p-0">
        <a href="{{ route('home.artista.detail', $product->artista->slug ) }}" class="list-inline-item text-bold btn-link text-primary">{{ $product->artista->nombres." ".$product->artista->apellidos }}</a>
        <li class="list-inline-item">|</li>
        <a href="{{ route('home.tienda', ['filterby'=>'categoria_id','value'=> $product->categoria->id]) }}" class="list-inline-item text-secondary">{{ $product->categoria->nombre }}</a>
      </ul>
      <hr>
    </div>
    <div class="col-12 mt-4">
      <div class="row">
        <div class="col-md-4">
          <div class="row">
            <div class="col-12">
              <div class="img-cont-full r1-1">
                @if(!$product->img)
                  <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="{{ $product->nombre }}">
                @else
                  <a data-fancybox="gallery" href="{{ url('uploads/products', $product->img) }}">
                    <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid" alt="{{ $product->nombre }}">
                  </a>
                @endif

              </div>
            </div>
            <div class="col-12 my-4">
              <div class="row justify-content-center">
                @foreach($product->galeria_img as $img)
                <div class="col-md-3">
                  <div class="w-100 img-cont-full r1-1">
                    <a data-fancybox="gallery" href='{{ url("uploads/products/shop", trim(str_replace("\"","",$img))) }}'>
                      <img src='{{ url("uploads/products/shop", trim(str_replace("\"","",$img))) }}' class="img-fluid rounded" alt="{{ $product->nombre }}">
                    </a>
                  </div>
                </div>
                @endforeach

              </div>
            </div>
          </div>
        </div>


        <div class="col-md-5">
          <p>{{ $product->desc_corta }}</p>
          <p class="text-justify">{{ $product->otros_detalles }}</p>
        </div>


        <div class="col-md-3">
          <h2 class="text-right">{{ 'S/ '.$product->precio }}</h2>
          <div class="mt-2"></div>

          @if(!$product->color)
            <div class="form-row">
              <div class="col">
                <label for="">Cantidad:</label>
              </div>
              <div class="col">
                  <select id="product_detail_quantity" class="form-control" name="">
                    @for ($i = 1; $i <= $product->stock; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
              </div>
            </div>
          @else

            <div class="form-row">
              <div class="col">
                <label for="">Color:</label>
              </div>
              <div class="col">


                <select id="product_detail_color" class="form-control" name="">
                  <option value="">Seleccionar</option>
                  @foreach($product->color as $color)
                    @if($color->stock > 0)
                      <option value="{{ $color->color }}" data-stock="{{ $color->stock }}">{{ $color->color }}</option>
                    @endif
                  @endforeach
                </select>

              </div>
            </div>
            <div class="mt-2"></div>


            <div class="form-row">
              <div class="col">
                <label for="">Cantidad:</label>
              </div>
              <div class="col">
                  <select id="product_detail_quantity" class="form-control" name="" disabled></select>
              </div>
            </div>
          @endif

          <div class="mt-2"></div>

          <ul class="list-unstyled p-0 mb-2 text-left">
            @if($product->sku)
            <li class="text-uppercase"><span class="mr-2 text-bold">sku:</span>{{ $product->sku }}</li>
            @endif

            @if($product->stock > 0)
            <li class="text-primary pt-2"><span class="mr-2 text-bold text-uppercase">stock:</span>{{ $product->stock.' unidades.' }}</li>
            @else
            <p class="pt-2 m-0 text-danger">Lo sentimos, no hay stock disponible.</p>
            @endif

          </ul>

          @if(!auth('boda')->check())
          <button id="product_detail_add_to_cart_btn" href="#" class="btn btn-outline-secondary black linear w-100 py-2 my-2" data-item="{{ $product->id }}" data-img="{{ $product->img }}" data-title="{{ $product->nombre }}" data-price="{{ $product->precio }}" @if($product->stock == 0) {{ 'disabled' }} @endif>
            <p class="subtitle text-uppercase m-0"><i class="fa fa-shopping-cart mr-2"></i> Agregar al carrito</p>
          </button>
          @endif

          @if (auth('boda')->check() && !$costo_envio)
            <button {{-- (!$selected->isEmpty()) ? 'style=display:none;' : '' --}} id="add_wedding_list" class="btn btn-large btn-danger py-2 linear w-100" data-cuenta-id="{{ auth('boda')->user()->id }}" data-producto-id="{{ $product->id }}"><p style="font-size: 13px;" class="subtitle text-uppercase m-0"><i class="fa fa-gift mr-2"></i> agregar a lista de regalos</p> </button>
            <!--button {{-- (!$selected->isEmpty()) ? 'style=display:inline-block;' : '' --}} id="added_wedding_list" class="btn btn-large btn-secondary w-100 display-none" disabled><p class="subtitle text-uppercase m-0"><i class="fa fa-gift mr-2"></i> agregado a lista</p> </button-->
          @endif

          <hr class="mt-3 mb-2">
          <p class="text-center mb-0"><small class="d-flex align-items-center"><i class="fas fa-truck fa-border fa-3x text-secondary"></i> Delivery gratuito solo en Lima.</small></p>
          <hr class="my-2">

        </div>
      </div>
    </div>


    <div class="col-12 my-3 bg-white p-0" style="min-height:400px; border: 1px solid #e6e6e6;">

      <div class="row">
        <div class="col-3">
         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
           <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Características del artículo</a>
           <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Descripción</a>
         </div>
        </div>
        <div class="col-9">
         <div class="tab-content" id="v-pills-tabContent">

           <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

              <h4 class="pt-4">Detalles de la Obra</h4>
              <table class="table">
               <tbody>
                <tr>
                  <th>Dimensiones</th>
                  <td><p>
                    @if($product->tamano)
                      Alto: {{ explode('x',$product->tamano)[0].' cm' }}, Ancho: {{ explode('x',$product->tamano)[1].' cm'  }}, Largo: {{ explode('x',$product->tamano)[2].' cm'  }}
                    @else
                      ---
                    @endif
                  </p></td>
                </tr>
                <tr>
                  <th>Peso</th>
                  <td><p>{{ ($product->peso) ? $product->peso.' Kg.' : '---' }}</p></td>
                </tr>
                <tr>
                  <th>Material</th>
                  <td><p>
                    @if($product->materiales)
                      @foreach($product->materiales as $key => $material)
                        @if ( $key == count($product->materiales) - 1 )
                          <span>{{ $material->nombre }}.</span>
                        @else
                          <span>{{ $material->nombre }}, </span>
                        @endif
                      @endforeach
                    @else
                      ---
                    @endif
                  </p></td>
                </tr>
               </tbody>
              </table>

           </div>
           <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
             <h4 class="pt-4">Descripción</h4>
              {{ $product->desc }}
           </div>
         </div>
        </div>
       </div>

    </div>


  </div>
</div>
<div class="container pb-4 mb-3">
  <div class="row">
    <div class="col-lg-10 my-3">
      <h3 class="subtitle">Productos similares:</h3>
    </div>
    <div class="w-100"></div>
    @foreach($products_like as $product)
    <div class="col-lg-3 text-center prev-tienda-item my-4">

      <div class="w-100 img-cont-full r1-1">
        @if($product->recently)
        <span class="bagde bagde-right-top bg-success text-white">producto nuevo</span>
        @endif

        <a href="{{ route('home.tienda.producto', $product->slug) }}">
        @if(!$product->img)
          <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="">
        @else
          <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded border" alt="">
        @endif
        </a>

        <span class="bagde bagde-left-bottom bg-warning text-white">{{ 'S/ '.$product->precio }}</span>
      </div>

      <div class="w-100 card pb-2 mt-2">
        <p class="footing-name" title="{{ $product->nombre }}">{{ $product->nombre }}</p>
        <p class="mb-1"><small>{{ $product->categoria->nombre }}</small></p>
      </div>
    </div>
    @endforeach
  </div>
</div>

@include('partials.modal-add-cart')
@include('partials.modal-confirm')

@endsection
