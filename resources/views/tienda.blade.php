@extends('layouts.front',['subtitle'=> 'Tienda'])
@section('contenido')
@include('partials.banner',['brand'=> ['name'=>'Tienda online', 'img'=> asset('media/tienda-prev.jpg')]])

@if (auth('boda')->check())
<div id="app" class="container contenido">
@else
<div class="container contenido">
@endif

  <div class="row">
    <div class="col-lg-3">

      <aside class="sidebar-wrapper">

        <a class="btn btn-outline-secondary black linear mb-4" href="{{ route('home.tienda') }}">Mostrar todo</a>

        <div class="sidebar-single">
            <h3 class="sidebar-title">Filtrar</h3>

            <div class="sidebar-body">
              <ul>
                <li><a href="{{ request()->fullUrlWithQuery(['orderby'=>'precio','orden'=>'asc','page'=>1]) }}"><small class="text-muted"><i class="mr-2 fas fa-sort-numeric-down text-dark"></i>menor precio</small></a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['orderby'=>'precio','orden'=>'desc','page'=>1]) }}"><small class="text-muted"><i class="mr-2 fas fa-sort-numeric-up text-dark"></i>mayor precio</small></a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['orderby'=>'created_at','orden'=>'desc','page'=>1]) }}"><small class="text-muted"><i class="mr-2 fas fa-sort-alpha-up text-dark"></i>menor antig&uuml;edad</small></a></li>
                <li><a href="{{ request()->fullUrlWithQuery(['orderby'=>'created_at','orden'=>'asc','page'=>1]) }}"><small class="text-muted"><i class="mr-2 fas fa-sort-alpha-down text-dark"></i>mayor antig&uuml;edad</small></a></li>
              </ul>
            </div>
        </div>


         <div class="sidebar-single">
              <h3 class="sidebar-title">precio</h3>

              <div class="sidebar-body">
                  <div class="input-group price">
                    <div class="input-group-prepend">
                      <small class="text-primary">{{ 'S/ '.$products->minprice }}</small>
                    </div>
                    <input id="price-filter" type="range" class="mx-2" value="{{ $products->currentprice }}" min="{{ $products->minprice }}" max="{{ $products->maxprice }}">
                    <div class="input-group-append">
                      <small id="price-filter-value" class="text-primary">{{ 'S/ '.$products->currentprice }}</small>
                    </div>
                  </div>
              </div>
          </div>


          <div class="sidebar-single">
              <h3 class="sidebar-title">categorias</h3>

              <div class="sidebar-body">
                <ul>
                  @foreach($bycategories as $category => $items )
                    <li><a href="{{ route('home.tienda', ['filterby' => 'categoria_id', 'value'=> $items->first()->categoria->id ]) }}"><small class="text-muted subtitle">{{ $category }}</small> <span class="badge">{{ $items->count() }}</span></a></li>
                  @endforeach
                </ul>
              </div>
          </div>


          <div class="sidebar-single">
              <h3 class="sidebar-title">artistas</h3>

              <div class="sidebar-body">
                <ul>
                  @foreach($byartists as $artist => $items )
                    <li><a href="{{ route('home.tienda', ['filterby' => 'artista_id', 'value'=> $items->first()->artista->id ]) }}"><small class="text-muted subtitle">{{ $artist }}</small> <span class="badge">{{ $items->count() }}</span></a></li>
                  @endforeach
                </ul>
              </div>
          </div>

          <div class="sidebar-single">
              <h3 class="sidebar-title">materiales</h3>
              <div class="sidebar-body">
                <ul>
                  @foreach($bymaterials as $item )
                    @if($item->productos->count() > 0)
                      <li><a href="{{ route('home.tienda', ['filterby' => 'material_id', 'value'=> $item->id ]) }}"><small class="text-muted subtitle">{{ $item->nombre }}</small> <span class="badge">{{ $item->productos->count() }}</span></a></li>
                    @endif
                  @endforeach
                </ul>
              </div>
          </div>


      </aside>


    </div>


    <div class="col-md-9">
      <div class="row">
        <div class="col-12">
          <div class="row justify-content-end">
            <div class="col-md-auto">
              <ul class="pagination">
                <li class="page-item {{ $products->currentPage() <= 1 ? 'disabled' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page'=> $products->currentPage()-1 ]) }}"> <i class="fa fa-angle-double-left"></i> </a></li>
                @for($i = 1; $i <= $products->lastPage(); $i++)
                <li class="page-item {{ $i === $products->currentPage() ? 'active' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page'=> $i ]) }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item {{ $products->currentPage() >= $products->lastPage() ? 'disabled' : '' }}"><a class="page-link" href="{{ request()->fullUrlWithQuery(['page'=> $products->currentPage() + 1 ]) }}"> <i class="fa fa-angle-double-right"></i> </a></li>
              </ul>
            </div>
          </div>
        </div>
        @foreach($products as $product)
        <div class="col-lg-4 text-center prev-tienda-item my-4">
          <div class="w-100 img-cont-full r1-1">
            @if($product->recently && $product->dsct==0 )
            <span class="bagde bagde-right-top new-product-lb text-white">producto nuevo</span>
            @endif
            @if($product->dsct  > 0 )
              {{-- <span class="bagde bagde-right-top new-product-lb text-white">- S/ {{ $product->descuento}}</span> --}}
              <span class="bagde bagde-right-top new-product-lb text-white">-{{ ($product->dsct/$product->precio)*100 }}%</span>
            @endif
            <a href="{{ route('home.tienda.producto', $product->slug) }}">
              @if(!$product->img)
                <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="">
              @else
                <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded border" alt="">
              @endif
            </a>
            <span class="bagde bagde-left-bottom {{ $product->dsct>0? 'badge-discount':'bg-black' }} text-white">S/ {{ $product->precio -$product->dsct   }}</span>            
            @if($product->dsct > 0 )
            {{-- <span class="bagde badge-success bagde-right-bottom"> S/ {{  $product->precio-$product->descuento }}</span> --}}
            @endif
          </div>
          <div class="w-100 card pb-2 mt-2">
              <a href="#" class="btn btn-link text-secondary add_to_cart_btn" data-item="{{ $product->id }}" data-img="{{ $product->img }}" data-title="{{ $product->nombre }}" data-price="{{ $product->precio-$product->descuento }}" >    <p class="footing-name" title="{{ $product->nombre }}">{{ $product->nombre }}</p> </a>

          
            <p class="mb-1"><small>{{ $product->categoria->nombre }}</small></p>
            <div class="row justify-content-center mb-1">
              <div class="col-auto">
                <a target="_blank" class="btn btn-link text-secondary" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ Request::root().'/producto/'.$product->slug }}','facebook-share-dialog','width=800,height=600');"><i class="fa fa-share-alt"></i></a>
              </div>
              <div class="col-auto">
                <a href="{{ route('home.tienda.producto', $product->slug) }}" class="btn btn-link text-secondary"><i class="fa fa-eye"></i> </a>
              </div>

              @if (!auth('boda')->check())
              <div class="col-auto">
                <a href="#" class="btn btn-link text-secondary add_to_cart_btn" data-item="{{ $product->id }}" data-img="{{ $product->img }}" data-title="{{ $product->nombre }}" data-price="{{ $product->precio-$product->descuento }}" ><i class="fa fa-cart-plus"></i> </a>
              </div>
              @endif

            </div>


            @if (auth('boda')->check())
            <div class="row my-2">
              <div class="col-md-12">
                  <button @click="[openModal=true, productId='{{$product->id}}']" class="btn btn-danger subtitle agregar-cuenta-novios linear p-2" data-img="{{ $product->img }}" data-title="{{ $product->nombre }}" data-price="{{ $product->precio }}" data-producto-id="{{ $product->id }}" data-cuenta-id="{{ auth('boda')->user()->id }}" type="button" name="button">Agregar a lista de regalos<i class="fa fa-gift ml-2"></i></button>
              </div>
            </div>
            @endif


          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  @if (auth('boda')->check())
  <modal-addgift :open="openModal" :product="productId" :giftaccountid='{{$cuenta->id}}' @closemodal="openModal=false"></modal-addgift>
  @endif

</div>


@include('partials.modal-add-cart')
@include('partials.modal-confirm')
@include('partials.modal-add-product')

@if(auth('boda')->check())
    @include('partials.modal-choose-gift')
@endif

@endsection
