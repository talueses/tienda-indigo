@extends ('admin.layouts.master')
@section ('content')
<div class="container-fluid">
      <div class="page-head">
        <h2 class="page-title float-left">
          Ordenes
          @if(request()->is('admin/orders/pending'))
            - Pendientes
          @elseif(request()->is('admin/orders/calculating'))  
            - Calculando costo de envio
          @elseif(request()->is('admin/orders/tracking'))
            - Tracking
          @elseif(request()->is('admin/orders/paid'))
            - Pagadas
          @elseif(request()->is('admin/orders/cancel'))
            - Cancelado
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
                  <a class="text-primary mr-4" 
                  @if(request()->is('admin/orders'))
                    href="{{ route('admin.order.export') }}"
                  @elseif(request()->is('admin/orders/pending'))
                    href="{{ route('admin.order.export.pending') }}"
                  @elseif(request()->is('admin/orders/calculating'))
                    href="{{ route('admin.order.export.calculating') }}"
                  @elseif(request()->is('admin/orders/tracking'))
                    href="{{ route('admin.order.export.tracking') }}"
                  @elseif(request()->is('admin/orders/paid'))
                    href="{{ route('admin.order.export.paid') }}"
                  @endif
                  style="cursor:pointer;text-decoration:underline;"><i class="fas fa-file-excel"></i> Descargar Excel</a>
              </div>
          </div>
          
          <div class="table-responsive">
            <table class="table" id="adminData" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width="10%">Id</th>
                  <th>Cliente</th>
                  <th>Total</th>
                  <th>Fecha</th>
                  <th>Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($ordenes as $orden)
                <tr>
                  <td>{{ $orden->orden_id }}</td>
                  <td>{{ $orden->usuario }}</td>
                  <td>S/ {{ number_format($orden->total, 2) }}</td>
                  <td>{{ $orden->created_at }}</td>
                  <td><span class="badge {{ $orden->getOrderBadge() }}">{{ $orden->getOrderStatus() }}</span></td>
                  <td>
                    <div class="btn-group float-right">
                      <a class="btn btn-default btn-action" href="{{ route('admin.order.show', $orden->orden_id) }}"><i class="fas fa-search-plus"></i> Ver Detalle</a>
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