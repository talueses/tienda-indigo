@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">
      
      <div class="page-head">
        <h2 class="page-title float-left">Materiales</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.material.create') }}" title="Añadir nuevo material">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nuevo material</div>
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
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th></th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($materiales as $material)
                <tr>
                  <td>{{ $material->nombre }}</td>
                  <td>{{ $material->desc }}</td>
                  <td>
                      <div class="btn-group float-right">
                          <a class="btn btn-default btn-action" href="{{ route('admin.material.edit', $material->id) }}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                          <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu">
                            <a class="dropdown-item remove-item" data-toggle="modal" data-url="{{ route('admin.material.destroy', $material->id) }}" data-id="{{ $material->id }}" data-target="#confirm_delete_item" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
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

  @include('admin.layouts.delete-modal-item', ['title'=>'Eliminar material'])

@endsection