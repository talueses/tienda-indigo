@if(!$ordenes->isEmpty())
  <table class="table" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th width="10%">Id</th>
          <th>Total</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($ordenes as $orden)
        <tr>
          <td>#{{ $orden->orden_id }}</td>
          <td>{{ getCurrencySign() . number_format($orden->total, 2) }}</td>
          <td>{{ $orden->created_at }}</td>
          <td>
              <span class="badge {{ $orden->getOrderBadge() }}"> {{ $orden->getOrderStatus() }} </span>
          </td>
          <td>
            <div class="btn-group float-right">
              <a href="{{ route( 'cuenta.orden.detalle', $orden->orden_id ) }}">Ver detalles</a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

@else
  <div>
    <p>No existen ordenes realizadas.</p>
  </div>
@endif
