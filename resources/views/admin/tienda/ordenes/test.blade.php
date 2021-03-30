<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
        <h2>Orden Detalle </h2>
          @if(is_null($detalle_envio->costo_envio) && ($detalle_envio->estado == 'Pendiente') || is_null($detalle_envio->costo_envio) && ($detalle_envio->estado == 'Calculando'))
            Falta confirmar costo de envio
          @endif
          <h4>
            Orden #{{$detalle_envio->orden_id}}
          </h4>
          <br>
          <p>
            <b>Estado:</b>
            <span> {{ $detalle_envio->getOrderStatus() }} </span>
            <br>
            <b>Fecha de orden:</b> {{ $detalle_envio->created_at }}
            @if(!is_null($detalle_envio->delivery_at))
            <br>
            <b>Entregado:</b> {{ $detalle_envio->delivery_at }}
            @endif
          </p>
          <br>
          <h5 >Detalles de Entrega</h5>
          <table style="border-collapse: collapse;width: 100%;">
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Tipo de entrega:</b> {{ ($detalle_envio->entrega == 'delivery') ? 'Delivery' : 'Recojo en tienda' }}</td>
                {{--<td><b>Departamento:</b> {{ ($detalle_envio->departamento) ? $detalle_envio->departamento : '--' }}</td>--}}
              </tr>
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Pais:</b> {{ isset($name_pais->nombre) ? $name_pais->nombre : '--' }}</td>
                <td><b>Departamento:</b> {{ ($detalle_envio->departamento) ? $detalle_envio->departamento : '--' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>Distrito:</b> {{ ($detalle_envio->distrito) ? $detalle_envio->distrito : '--' }}</td>
                <td><b>Direccion:</b> {{ ($detalle_envio->direccion) ? $detalle_envio->direccion : '--' }}</td>
              </tr>
          </table>
          <br>
          <h5>Detalles del Cliente</h5>
          <table style="border-collapse: collapse;width: 100%;">
              {{--z<tr style="height: 40px;">
                <td style="width: 50%;"><b>Correo electr&oacute;nico:</b> {{ isset($usuario->email) ? $usuario->email : '' }}</td>
                <td><b>Direcci&oacute;n:</b> {{ isset($usuario->direccion) ? $usuario->direccion : '' }}</td>
              </tr>--}}
              <tr style="height: 40px;">
                <td><b>Nombres:</b> {{ isset($usuario->name) ? $usuario->name : '' }}</td>
                <td><b>Email:</b> {{ isset($usuario->email) ? $usuario->email : '' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>Apellidos:</b> {{ isset($usuario->apellidos) ? $usuario->apellidos : '' }}</td>
                <td><b>Ciudad:</b> {{ isset($usuario->ciudad) ? $usuario->ciudad : '' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>Tel&eacute;fono:</b> {{ isset($usuario->telefono1) ? $usuario->telefono1 : '' }}</td>
                <td><b>Pa&iacute;s:</b> {{ isset($usuario->pais) ? $usuario->pais : '' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>DNI:</b> {{ isset($usuario->dni) ? $usuario->dni : '' }}</td>
                <td><b>Direccion:</b> {{ isset($usuario->direccion) ? $usuario->direccion : '' }}</td>
              </tr>
          </table>
          <br>
          <h5>Método de Pago</h5>
          <table style="border-collapse: collapse;width: 100%;">
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Tipo de Tarjeta:</b> {{ ucfirst($metodo_pago) }}</td>
                <td><b>Tarjeta:</b><h2><strong>**** **** **** {{ $ordenes[0]->card }}</strong> </h2> </td>
              </tr>
          </table>
          <hr>
          <!-- resumen orden -->
                  <table class="table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th width="10%">&nbsp;</th>
                        <th>SKU</th>
                        <th width="40%">Nombre del Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ordenes as $producto)       
                        <tr>
                          <td>
                            @if(!$producto->img)
                                <img src="{{ url('/media/default.jpg') }}">
                            @else
                                <img id="product_preview_img" src="{{ url('uploads/products', '80x80_'.$producto->img) }}">
                            @endif
                          </td>
                          <td>{{ $producto->sku }}</td>
                          <td>
                            {{ $producto->producto_nombre ." ". ucfirst($producto->color) }}
                            @if (isset($producto->lista_regalo_id) )
                            <br>
                            <span>Lista Regalo: {{ $producto->codigo }}</span>
                            @endif
                          </td>
                          <td>
                            {{ getCurrencySign() . number_format($producto->precio_unidad, 2) }}
                          </td>
                          <td>{{ $producto->cantidad }}</td>
                          <td>{{ getCurrencySign() . number_format($producto->precio_unidad * $producto->cantidad, 2)  }}</td>
                        </tr>
                      @endforeach
                      <tr style="border-top: 2px solid #b5b5b5;">
                        <td colspan="4"></td>
                        <td style="color: #444444;"><b>Subtotal</b></td>
                        <td>{{ getCurrencySign() . number_format($subtotal, 2) }}</td>
                      </tr>
                      <tr>
                        <td colspan="4"></td>
                        <td style="color: #444444;"><b>Envio</b></td>
                        <td>
                          @if($detalle_envio->costo_envio)
                            {{ getCurrencySign() . number_format($detalle_envio->costo_envio, 2) }}
                          @elseif($detalle_envio->estado == 'Pagado' && !$detalle_envio->costo_envio)
                            {{ getCurrencySign() . '0.00'}}
                          @else
                            <span>Por confirmar</span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4"></td>
                        <td style="color: #444444;"><b>Total</b></td>
                        <td><span>{{ getCurrencySign() . number_format($total, 2) }}</span></td>
                      </tr>
                    </tbody>
                  </table>
          <hr>
</body>
</html>


