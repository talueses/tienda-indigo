@extends('layouts.front', ['subtitle'=>$product->nombre])
@section('contenido')
@include('partials.banner')
<div class="container contenido pb-0">


    <div class="product-detail-inner">
      <div class="row">

          <div class="col-12 mb-3">
            <a class="btn btn-link px-0 action-back" href="{{ route('home.tienda') }}"><i class="fas fa-arrow-left"></i> Regresar a tienda</a>
          </div>

          <div class="col-lg-5">
            <div class="row">

              <div class="col-12">
                <div class="">
                  @if(!$product->img)
                    <figure class="img-cont-full r1-1" style="background-image: url({{ url('/media/default.jpg') }})">
                      <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="{{ $product->nombre }}">
                    </figure>
                  @else
                    <figure class="zoom zoomImg img-cont-full r1-1" onmousemove="zoom(event)" style="background-image: url({{ url('uploads/products', $product->img) }})">
                      <a href="{{ url('uploads/products', $product->img) }}" data-fancybox="gallery">
                        <img id="product_preview_img" src="{{ url('uploads/products', $product->img) }}" class="img-fluid" alt="{{ $product->nombre }}">
                      </a>
                    </figure>
                  @endif

                </div>
              </div>

              @if ($product->galeria_img)
              <div class="col-12 mt-2 mb-4">
                <div class="row justify-content-center">
                  @foreach($product->galeria_img as $img)
                  <div class="col-6 col-md-3">
                    <div class="w-100 img-cont-full r1-1">

                      <img src='{{ url($img) }}' class="img-fluid rounded gallery-img" alt="{{ $product->nombre }}">

                    </div>
                  </div>
                  @endforeach

                </div>
              </div>
              @endif

            </div>
          </div>

          <div class="col-lg-7">
              <div class="product-detail-description">
                  <div class="artist-name">
                    <a href="{{ route('home.artista.detail', $product->artista->slug ) }}">{{ $product->artista->nombres." ".$product->artista->apellidos }}</a>
                  </div>

                  <h3 class="product-name">{{ $product->nombre }}</h3>

                  <div class="category">
                    <a href="{{ route('home.tienda', ['filterby'=>'categoria_id','value'=> $product->categoria->id]) }}" class="list-inline-item text-secondary">{{ $product->categoria->nombre }}</a>
                  </div>

                  <div class="price">
                    @if ($product->dsct_lista_regalo!=0)
                      <strike><span>{{ getCurrencySign().$product->precio }}</span></strike>
                      <br><span style="color: red">-{{ getCurrencySign().$product->dsct_lista_regalo }}</span>
                      <br><span style="color: #5c116e;"><strong>{{ getCurrencySign().($product->precio - $product->dsct_lista_regalo) }}</strong></span>
                    @else
                      <span>{{ getCurrencySign().$product->precio }}</span>
                    @endif
                  </div>

                  <div class="availability">
                    @if($product->stock > 0)
                    <i class="fa fa-check-circle"></i> <span>{{$product->stock}} en stock</span>
                    @else
                    <p class="pt-2 m-0 text-danger">Lo sentimos, no hay stock disponible.</p>
                    @endif
                  </div>

                  <div class="fb-share-button" data-href="{{ route('home.tienda.producto', $product->slug) }}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?src=sdkpreparse&amp;u={{ route('home.tienda.producto', $product->slug) }}" class="fb-xfbml-parse-ignore">Compartir</a></div>

                  <div class="description mt-2">
                    <p>{{ $product->desc_corta }}</p>
                    <p class="text-justify">{{ $product->otros_detalles }}</p>
                  </div>

                  @if(auth('boda')->check())
                      <div class="qty-cart-box d-flex align-items-center">
                          <h5>lista:</h5>
                          <div>
                            <select id="product_detail_list" class="form-control" name="">
                              @foreach ($listas as $list)
                                <option value="{{ $list->codigo }}">{{ $list->titulo }}</option>
                              @endforeach
                            </select>
                          </div>
                      </div>

                      @if(!$product->color)
                        <div class="qty-cart-box d-flex align-items-center">
                            <h5>cantidad:</h5>
                            <div>
                              <select id="product_detail_quantity" class="form-control" name="">
                                @for ($i = 1; $i <= $product->stock; $i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                              </select>
                            </div>
                        </div>
                      @else
                        <div class="color-cart-box d-flex align-items-center">
                            <h5>color:</h5>
                            <div>
                              <select id="product_detail_color" class="form-control">
                                <option value="">Seleccionar</option>
                                @foreach($product->color as $color)
                                  @if($color->stock > 0)
                                    <option value="{{ $color->color }}" data-stock="{{ $color->stock }}">{{ $color->color }}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                        </div>

                        <div class="qty-cart-box d-flex align-items-center">
                            <h5>cantidad:</h5>
                            <div>
                              <select id="product_detail_quantity" class="form-control" name="" disabled></select>
                            </div>
                        </div>
                      @endif

                    <div class="mt-2"></div>

                    <div class="col-lg-5 p-0">
                      <button id="add_wedding_list" class="btn btn-large btn-danger py-2 linear w-100" data-cuenta-id="{{ auth('boda')->user()->id }}" data-producto-id="{{ $product->id }}"><p style="font-size: 13px;" class="subtitle text-uppercase m-0"><i class="fa fa-gift mr-2"></i> agregar a lista de regalos</p> </button>

                    </div>

                  @else
                      <div id="app">
                          <add-product :product="'{{ $product->id }}'"></add-product>
                      </div>

                  @endif

                <div style="max-width:350px;">
                  <hr class="mt-3 mb-2">
                  <p class="text-center mb-0">
                    <small class="d-flex align-items-center">
                      <i class="fas fa-truck fa-border fa-3x text-secondary mr-4"></i>
                       Delivery gratuito solo en Lima.
                       {{ @$free_delivery }}
                    </small>
                  </p>
                  <hr class="my-2">
                </div>

                <div class="mt-4">
                    <strong>Métodos de pago</strong>
                    <ul class="ls-metodos-pago list-unstyled">
                      <li class="float-left"><img src="//cdn.shopify.com/s/files/1/1584/8933/t/3/assets/paypal.png?22" alt="tarjetas"></li>
                    </ul>
                </div>

              </div>
          </div>

      </div>
    </div>


  <div class="row product-review-info mt-4">

    <div class="col-12">

      <div class="tab-button-outer">
        <nav id="tab-button">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Características del artículo</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Descripción</a>
            </div>
        </nav>
      </div>

    </div>

    <div class="col-12">
          <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

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
              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  {{ $product->desc }}
              </div>
          </div>
    </div>

  </div>

</div>

  <div class="container pb-4 mt-3">
    @if(!empty($products_like))
      <div class="row">
        <div class="col-lg-12 mt-3">
          <h4 class="subtitle">Productos similares</h4>
        </div>
        <div class="w-100"></div>
          @foreach($products_like as $product)
          <div class="col-lg-3 text-center prev-tienda-item my-4">
            <div class="w-100 img-cont-full r1-1">
              @if($product->recently && $product->dsct==0)
                <span class="bagde bagde-right-top new-product-lb text-white">producto nuevo</span>
              @endif
              @if($product->dsct_lista_regalo > 0)
                <span class="bagde bagde-right-top new-product-lb text-white">-{{ ($product->dsct_lista_regalo/$product->precio)*100 }}%</span>
              @endif
              <a href="{{ route('home.tienda.producto', $product->slug) }}">
                @if(!$product->img)
                <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="">
                @else
                <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded border" alt="">
                @endif
              </a>           
              @if ($product->dsct_lista_regalo > 0)
                  <span class="bagde bagde-left-bottom bg-success text-white">S/{{ $product->precio-$product->dsct_lista_regalo }}</span>
              @else
                  <span class="bagde bagde-left-bottom bg-black text-white">{{ 'S/ '.$product->precio }}</span>
              @endif    
            </div>
            <div class="featured-product w-100 sm-card pb-2 mt-2">
              <p class="title" title="{{ $product->nombre }}">{{ $product->nombre }}</p>
              <p class="mb-1"><small>{{ $product->categoria->nombre }}</small></p>
            </div>
          </div>            
          @endforeach
      </div>
    @endif
  </div>

@include('partials.modal-add-cart')
@include('partials.modal-confirm')

<script>
function zoom(e){
  var zoomer = e.currentTarget;
  e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
  e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
  x = offsetX/zoomer.offsetWidth*100
  y = offsetY/zoomer.offsetHeight*100
  zoomer.style.backgroundPosition = x + '% ' + y + '%';
}
</script>

@endsection
