@include('mails.layouts.header', ['title' => "Orden Generada"])

<!-- BEGIN TEMPLATE // -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td align="center" valign="top" id="templateHeader">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
            <tr>
            <td align="center" valign="top" width="600" style="width:600px;">
            <![endif]-->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
              <tr>
                <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                  <tbody class="mcnImageBlockOuter">
                    <tr>
                      <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                          <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                              <tbody><tr>
                                  <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                    <img align="center" alt="" src="{{Request::root()}}/media/indigo_logo.png" width="201" style="max-width:430px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                  </td>
                              </tr>
                          </tbody></table>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </td>
          </tr>
      </table>
      <!--[if (gte mso 9)|(IE)]>
      </td>
      </tr>
      </table>
      <![endif]-->
      </td>
  </tr>
  <tr>
    <td align="center" valign="top" id="templateBody">
      <!--[if (gte mso 9)|(IE)]>
      <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
      <tr>
      <td align="center" valign="top" width="600" style="width:600px;">
      <![endif]-->
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
        <tr>
          <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
            <tbody class="mcnTextBlockOuter">
              <tr>
                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                    <!--[if mso]>
                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                    <tr>
                    <![endif]-->

                    <!--[if mso]>
                    <td valign="top" width="600" style="width:600px;">
                    <![endif]-->
                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                        <tbody>
                          <tr>

                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                              
                                <h2 style="font-size: 26px;">Gracias por su orden.</h2>

                                <p>Su orden ha sido recibida y está siendo procesada. Se calculará el costo del flete y se le enviará una confirmación a su correo electrónico. A continuación se mostrarán los detalles de la misma.</p>

                                <h3 style="font-weight:bold;">Orden: #{{ $order_id }}</h3>

                                <table class="mcnOrderProducts" style="border-collapse: collapse;width: 100%;">
                                    <tr>
                                      <th>&nbsp;</th>
                                      <th style="width: 15%;text-align: center;"><small> Producto</small></th>
                                      <th style="text-align: center;"><small> Cantidad</small></th>
                                      <th style="text-align:center;"><small> Precio</small></th>
                                      {{-- <th><small> Descuento</small></th> --}}
                                      <th style="text-align:center;"><small>Total</small></th>
                                    </tr>

                                    @if($items)
                                      @foreach($items as $product)
                                        <tr style=" text-align: center;">
                                          <td  style="width: 15%;">
                                          @if ($product->img)
                                            <img src="{{Request::root()}}/uploads/products/80x80_{{ $product->img }}" alt="" height="80" width="80" style="object-fit: cover;">
                                          @else
                                            <img class="img-list-default" height="80" width="80" style="object-fit: cover;" alt="{{ $product->nombre }}">
                                          @endif
                                          </td>
                                          <td><small style="text-transform: capitalize;"><b>{{$product->nombre}}</b> {{ (isset($product->color)) ? '- '.ucfirst($product->color) : '' }}</small></td>
                                          <td><small>{{ $product->quantity }}</small></td>
                                          <td>
                                            <center>
                                              @if($product->dsct != 0 )
                                                <small><strong><strike> S/ {{ $product->precio  }}</strike></strong></small>
                                                <br><small style="color: red"> - S/ {{$product->dsct}}</small><br>
                                                <small style="color: #5c116e;">{{$product->precio - $product->dsct}}</small>
                                              @else
                                                <small><strong> S/ {{ $product->precio  }}</strong></small>
                                              @endif                                              
                                            </center>
                                          </td>
                                          {{-- <td><small>{{ $product->dsct != 0 ? 'S/ '.$product->dsct: '--' }}</small></td> --}}
                                        <td><small style="color:teal"> <strong> S/ {{ ($product->precio - $product->dsct) * $product->quantity}} </strong></small></td>
                                        </tr>
                                      @endforeach
                                    @endif

                                    <tr>
                                      <td colspan="4" style="color: #444444;"><b>Subtotal</b></td>
                                      <td style="font-size:15px">{{ 'S/ ' . $total }}</td>
                                    </tr>
                                    <tr>
                                      <td colspan="4" style="color: #444444;font-size:15px"><b>Costo de envío</b></td>
                                      <td >Por Confirmar</td>
                                    </tr>
                                    <tr>
                                      <td colspan="4" style="color: #444444;"><b>Total</b></td>
                                      <td><small style="color:#5c116e;font-size:15px"> <strong> S/  {{$total }} </strong> </small> </td>
                                    </tr>

                                  </table>

                                  <br>

                                  <h3 style="font-weight:bold;">Estado de la Orden</h3>

                                  <div style="background-color:#5c116e;color:white;padding: 5px 10px;">
                                    Pago Pendiente
                                  </div>

                                  <br>

                                  <h3 style="font-weight:bold;">Detalles del Cliente</h3>

                                 <table style="border-collapse: collapse;width: 100%;">
                                      <tr style="height: 40px;">
                                        <td style="width: 50%;">Correo electr&oacute;nico: {{ isset($customer->email) ? $customer->email : '' }}</td>
                                        <td>Direcci&oacute;n: {{ isset($customer->direccion) ? $customer->direccion : '' }}</td>
                                      </tr>
                                      <tr style="height: 40px;">
                                        <td>Nombres: {{ isset($customer->nombres) ? $customer->nombres : '' }}</td>
                                        <td>Ciudad: {{ isset($customer->ciudad) ? $customer->ciudad : '' }}</td>
                                      </tr>
                                      <tr style="height: 40px;">
                                        <td>Apellidos: {{ isset($customer->apellidos) ? $customer->apellidos : '' }}</td>
                                        <td>Pa&iacute;s: {{ isset($customer->pais) ? $customer->pais : '' }}</td>
                                      </tr>
                                      <tr style="height: 40px;">
                                        <td>Tel&eacute;fono: {{ isset($customer->telefono) ? $customer->telefono : '' }}</td>
                                        <td></td>
                                      </tr>
                                  </table>
                                                 
                                  <h3 style="font-weight:bold;">Detalles de Entrega</h3>
                                  <table style="border-collapse: collapse;width: 100%;">
                                    <tr style="height: 40px;">
                                      <td style="width: 50%;"><b>Tipo de entrega:</b> {{ ($detalle_envio->entrega == 'delivery') ? 'Delivery' : 'Recojo en tienda' }}</td>
                                      <td><b>Pais:</b> {{ ($name_pais->nombre) ? $name_pais->nombre : '--' }}</td>
                                    </tr>
                                    <tr style="height: 40px;">
                                      <td style="width:50%"><b>Departamento:</b> {{ ($name_depto!='') ? $name_depto: '' }}</td>
                                      <td><b>Distrito:</b> {{ ($detalle_envio->distrito) ? strtoupper($detalle_envio->distrito): '' }}</td>
                                    </tr>
                                    <tr style="height: 40px;">
                                      <td><b>Direccion:</b> {{ ($detalle_envio->direccion) ? $detalle_envio->direccion : '' }}</td>

                                    </tr>
                                </table>
                                  </td>
                              </tr>
                        </tbody>
                    </table>
                  <!--[if mso]>
                  </td>
                  <![endif]-->

                  <!--[if mso]>
                  </tr>
                  </table>
                  <![endif]-->
                </td>
              </tr>
            </tbody>
      </table>
    </td>
  </tr>
</table>
<!--[if (gte mso 9)|(IE)]>
</td>
</tr>
</table>
<![endif]-->
</td>
</tr>





@include('mails.layouts.footer')
