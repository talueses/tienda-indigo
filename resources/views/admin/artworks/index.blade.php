@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Obras</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.artwork.create') }}" title="Añadir nuevo método de pago">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nueva obra</div>
                </a>
              </li>
          </ul>
        </div>
      </div>

      <div class="card my-3">

        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <th>Artista</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($obras as $obra)
                <tr>
                  <td>{{ $obra->sku }}</td>
                  <td>
                    @if ($obra->img)
                      <img src="/uploads/artworks/80x80_{{ $obra->img }}" alt="" height="80" width="80">
                    @else
                      <img class="img-list-default" alt="">
                    @endif
                  </td>
                  <td>{{ $obra->nombre }}</td>
                  <td>{{ ($obra->artista_nombres) ? $obra->artista_nombres : 'Ninguno' }}</td>
                  <td>{{ ($obra->publicado) ? 'Publicado' : 'Borrador' }}</td>
                  <td>

                      <div class="btn-group float-right">
                          <a class="btn btn-default btn-action" href="{{ route('admin.artwork.edit', $obra->slug) }}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                          <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.artwork.duplicate', $obra->id) }}" data-id="{{ $obra->id }}"><i class="fas fa-clone"></i> Duplicar</a></li>
                            <li><a class="dropdown-item remove-item" data-toggle="modal" data-url="{{ route('admin.artwork.destroy', $obra->id) }}" data-id="{{ $obra->id }}" data-target="#confirm_delete_item" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a></li>
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

  @include('admin.layouts.delete-modal-item', ['title'=>'Eliminar obra'])

@endsection
