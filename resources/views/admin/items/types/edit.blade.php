 @extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">
  
  <form method="POST" action="{{ route('admin.type.update', $tipo->id) }}">  
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="page-head">
        <h2 class="page-title float-left">Editar Tipo Producto</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.types') }}">Cancelar</a>
              </li>
              <li>
                  <button class="btn btn-primary btn-action" type="submit">Actualizar</button>
              </li>
          </ul>
        </div>
      </div>

      @include('admin.layouts.errors')
      <!-- card -->     
        <div class="row">
          
          <div class="col-sm-8">

              <div class="card mb-3">
                
                <div class="card-header">Tipo de Producto</div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="nombre" class="col-form-label">Nombre</label>
                            <div>
                              <input class="form-control" value="{{ $tipo->nombre }}" name="nombre" type="text" id="nombre">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="desc">Descripción</label>
                          <textarea class="form-control" name="desc" id="desc" rows="5" col="8">{{ $tipo->desc }}</textarea>
                        </div>

                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>


          </div>

          <div class="col-sm-4"></div>

        </div>
      <!-- /card -->
  
  </form>

</div>

@endsection