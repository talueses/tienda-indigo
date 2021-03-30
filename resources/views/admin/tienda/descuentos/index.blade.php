@extends ('admin.layouts.master')
@section ('content')
<div class="container-fluid">
      <div class="page-head">
        <h2 class="page-title float-left">Descuentos
        </h2>
        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
            {{-- @if(count($productos)>0)
             <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.descuentos.sincroniza') }}" title="Sincronizar">
                  <i class="fas fa-plus-circle"></i>
                  <div>Actualizar</div>
                </a>
              </li>
            @endif --}}
            <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.descuentos.create') }}" title="Añadir nuevo producto">
                  <i class="fas fa-plus-circle"></i>
                  <div>Crear Descuento</div>
                </a>
              </li>
          </ul>
        </div>
      </div>
  
          <!--@producto -->
          <div class="row">
          @foreach($productos as $product)
          
          <div class="col-md-3 text-center prev-tienda-item my-4" style="height:250px;">
            {{-- <h6><span class="badge badge-info bagde-top new-product-lb"> S/ {{($product->aplicado!=NULL)? $product->precio + $product->descuento:$product->precio }} </span> --}}
            @if ($product->aplicado)
              <span class="badge badge-discount bagde-top new-product-lb">-{{floor(($product->descuento/$product->precio)*100) }} %</span>
            @else
              <span class="badge bagde-top"> &puncsp; </span>
            @endif
            {{-- <span class="badge badge-warning bagde-top new-product-lb">{{ \Carbon\Carbon::parse($product->fecha_inicio)->format('d/m/Y') }} </span> --}}

          </h6>
          <div class="w-100 w- img-cont-full r1-1" style="height: 240px;">
              <a href="#">
              @if(!$product->img)
                <img src="{{ url('/media/default.jpg') }}" class="img-thumbnail" alt="">
              @else
                <img src="{{ url('uploads/products', $product->img) }}" style="height: 250px;" class="img-thumbnail" alt="">
              @endif
            </a>
          </div>

          <div class="w-100 card pb-2 mt-2">
          <h6>
            <span class="badge badge-{{ $product->aplicado?'discount':'secondary' }} bagde-right-top new-product-lb">S/{{number_format($product->precio -$product->descuento,2) }} </span>
            <a href="{{ route('admin.descuentos.cancel',$product->producto_id)}}">
              <span class="badge badge-danger bagde-right-top new-product-lb"><li class="fa fa-minus-circle"></li> Quitar</span>
            </a> 
            <a href="{{ route('admin.descuentos.edit',$product->producto_id)}}">
              <span class="badge badge-danger bagde-right-top new-product-lb"><li class="fa fa-minus-circle"></li> Editar</span>
            </a>  
          </h6>
              <p class="footing-name" title="{{ $product->nombre }}">
                <strong>Categoria:</strong>{{ $product->categoria->nombre }} <br>
                <strong>Nombre</strong>{{ $product->nombre }}<br>
                <strong> Promocion </strong><br>
                <strong>Inicio:</strong>{{ \Carbon\Carbon::parse($product->fecha_inicio)->format('d/m/Y') }} <br>
                <strong>Fin:</strong>{{ \Carbon\Carbon::parse($product->fecha_fin)->format('d/m/Y') }} <br>
                status:<span class="badge badge-{{ $product->aplicado?'discount':'warning' }}"> {{ $product->aplicado?'Vigente':'Por iniciar' }} </span>
              
              </p>
          </div>
        </div>
        @endforeach
          </div>
          <!-- @ end producto -->
     
    </div>
@endsection