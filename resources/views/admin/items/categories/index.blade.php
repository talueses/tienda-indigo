@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">
      
      <div class="page-head">
        <h2 class="page-title float-left">Categorías</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.category.create') }}" title="Añadir nueva categoría">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nueva categoría</div>
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
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($categorias as $categoria)
                <tr>
                  <td>{{ $categoria->nombre }}</td>
                  <td>{{ $categoria->desc }}</td>
                  <td>
                      <div class="btn-group float-right">
                          <a class="btn btn-default btn-action" href="{{ route('admin.category.edit', $categoria->id) }}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                          <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu">
                            <a class="dropdown-item remove-item" data-toggle="modal" data-url="{{ route('admin.category.destroy', $categoria->id) }}" data-id="{{ $categoria->id }}" data-target="#confirm_delete_item" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
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

  @include('admin.layouts.delete-modal-item', ['title'=>'Eliminar categoria'])

@endsection