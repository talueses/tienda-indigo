@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Productos</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('product.create') }}" title="Añadir nuevo producto">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nuevo producto</div>
                </a>
              </li>
          </ul>
        </div>
      </div>

      <div class="card my-3">

        <div class="card-body">

          <div class="clearfix mb-4">
              <div class="float-left">
                  <a class="text-primary mr-4" href="{{ route('admin.product.export') }}" style="cursor:pointer;text-decoration:underline;"><i class="fas fa-file-excel"></i> Descargar Excel</a>
              </div>
          </div>

          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Imagen</th>
                  <th>Nombres</th>
                  <th>Stock</th>
                  <th>Tipo</th>
                  <th>Artista</th>
                  <th>Precio</th>
                  <th>Descuento</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($productos as $producto)
                <tr>
                  <td>{{ $producto->sku }}</td>
                  <td>
                    @if ($producto->img)
                      <img src="/uploads/products/80x80_{{ $producto->img }}" alt="" height="80" width="80" style="object-fit: cover;">
                    @else
                      <img class="img-list-default" alt="">
                    @endif

                  </td>
                  <td>{{ $producto->nombre }}</td>
                  <td>{{ $producto->stock }}</td>
                  <td>{{ ($producto->tipo['nombre']) ? $producto->tipo['nombre'] : 'Ninguno' }}</td>
                  <td>{{ ($producto->artista['nombres']) ? $producto->artista['nombres'] : 'Ninguno'}}</td>
                  <td>S/.{{ $producto->precio }}</td>
                  <td>{{ $producto->descuento }}</td>
                  <td>
                    <div class="btn-group float-right">
                          <a class="btn btn-default btn-action" href="{!! URL::route('admin.product.edit', $producto->id) !!}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                          <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('product.duplicate', $producto->id) }}"><i class="fas fa-clone"></i> Duplicar</a></li>
                            <li><a class="dropdown-item remove-item" data-toggle="modal" data-url="{{ route('product.destroy', $producto->id) }}" data-id="{{ $producto->id }}" data-target="#confirm_delete_item" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a></li>
                          </ul>
                      </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

      </div>
    </div>

    @include('admin.layouts.delete-modal-item', ['title'=>'Eliminar producto'])

@endsection
