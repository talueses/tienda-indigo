@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">
          Listas
          @if(request()->is('admin/giftregistry/edition'))
            - En edición
          @elseif(request()->is('admin/giftregistry/calculating'))  
            - Calculando costo de envio
          @elseif(request()->is('admin/giftregistry/calculating'))  
            - Tracking
          @elseif(request()->is('admin/giftregistry/finished'))
            - Finalizadas
          @endif
        </h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
          </ul>
        </div>
      </div>

      <div class="card my-3">

        <div class="card-body">
          <div class="clearfix mb-4">
              <div class="float-left">
                  <!--a class="text-primary mr-4" 
                  @if(request()->is('admin/orders'))
                    href="{{ route('admin.order.export') }}"
                  @elseif(request()->is('admin/orders/pending'))
                    href="{{ route('admin.order.export.pending') }}"
                  @elseif(request()->is('admin/orders/calculating'))
                    href="{{ route('admin.order.export.calculating') }}"
                  @elseif(request()->is('admin/orders/paid'))
                    href="{{ route('admin.order.export.paid') }}"
                  @endif
                  style="cursor:pointer;text-decoration:underline;"><i class="fas fa-file-excel"></i> Descargar Excel</a-->
              </div>
          </div>
          <div class="table-responsive">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Evento</th>
                  <th>Modo Entrega</th>
                  <th>Estado</th>
                  <th>Fecha</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
  
                @foreach($listas as $list)
                <tr>
                  <td>{{ $list->codigo }}</td>
                  <td>{{ $list->titulo }}</td>
                  <td>{{ ($list->entrega == 'recojo_tienda') ? 'Recojo en Tienda' : 'Delivery' }}</td>
                  <td>
                    <span class="badge {{ $list->getBadge() }}">{{ $list->getState('format') }}</span>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($list->fecha)->format('m/d/Y') }}</td>
                  <td>
                    <div class="btn-group float-right">
                      <a class="btn btn-default btn-action" href="{{ route('admin.giftregistry.showList', $list->codigo) }}"><i class="fas fa-pencil-alt"></i> Editar</a>
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


@endsection
