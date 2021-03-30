@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Países</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.countries.create') }}" title="Añadir nuevo país">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nuevo país</div>
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
                  <th>Nombres</th>
                  <th>Descripción</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($paises as $pais)
                <tr>
                  <td>{{ $pais->nombre }}</td>
                  <td>{{ $pais->desc }}</td>
                  <td>
                    
                    <div class="btn-group float-right">
                        <a class="btn btn-default btn-action" href="{{ route('admin.countries.edit', $pais->id) }}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                        <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>

                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item remove-item" data-toggle="modal" data-url="{{ route('admin.countries.destroy', $pais->id) }}" data-id="{{ $pais->id }}" data-target="#confirm_delete_item" href="#">
                              <i class="fas fa-trash-alt"></i> Eliminar
                            </a>
                          </li>
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

  @include('admin.layouts.delete-modal-item', ['title'=>'Eliminar país'])

@endsection

