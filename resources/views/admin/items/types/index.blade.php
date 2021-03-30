@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Tipos</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.type.create') }}" title="Añadir nuevo producto">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nuevo tipo</div>
                </a>
              </li>
          </ul>
        </div>
      </div>

      @include('admin.layouts.errors')

      <div class="card my-3">

        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombres</th>
                  <th>Descripción</th>
                  <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombres</th>
                  <th>Descripción</th>
                  <th></th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($tipos as $tipo)
                <tr>
                  <td>{{ $tipo->nombre }}</td>
                  <td>{{ $tipo->desc }}</td>
                  <td>

                    <div class="btn-group float-right">
                        <a class="btn btn-default btn-action" href="{{ route('admin.type.edit', $tipo->id) }}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                        <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                          <a class="dropdown-item remove-item" data-toggle="modal" data-url="{{ route('admin.type.destroy', $tipo->id) }}" data-id="{{ $tipo->id }}" data-target="#confirm_delete_item" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
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

  @include('admin.layouts.delete-modal-item', ['title'=>'Eliminar tipo'])

@endsection