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
                      </table></td>
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
                    <tbody><tr>

                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                            <h2 style="font-size: 26px;">Su orden ha sido cancelada</h2>

                            <p>Acaba de cancelar la orden #{{ $orden_id }} el d&iacute;a {{ $cancelled_at }}.</b> <br>
                               <a href="{{$route}}">{{$route}}</a>
                            </p>

                            <h3 style="font-weight:bold;">Orden: #{{ $orden_id }}</h3>

                            <table class="mcnOrderProducts" style="border-collapse: collapse;width: 100%;">
                                <tr>
                                  <th style="width: 50%;">Producto</th>
                                  <th>Precio</th>
                                  <th>Cantidad</th>
                                  <th>Total</th>
                                </tr>

                                @if($cart_products)
                                  @foreach($cart_products as $product)
                                    <tr>
                                      <td style="text-transform: capitalize;"><b>{{$product->nombre}}</b> {{ (isset($product->color)) ? '- '.ucfirst($product->color) : '' }}</td>
                                      <td>S/ {{ $product->precio }}</td>
                                      <td>{{ $product->quantity }}</td>
                                      <td>S/ {{ $product->total }}</td>
                                    </tr>
                                  @endforeach
                                @endif

                                <tr>
                                  <td colspan="3" style="color: #444444;"><b>Subtotal</b></td>
                                  <td style="font-size: 15px">{{ 'S/ ' . $subtotal }}</td>
                                </tr>
                                <tr>
                                  <td colspan="3" style="color: #444444;"><b>Env&iacute;o</b></td>
                                  <td style="font-size: 15px">{{ 'S/ ' . $costo_envio }}</td>
                                </tr>
                                <tr>
                                  <td colspan="3" style="color: #444444; font-size: 15px;"><b>Total</b></td>
                                  <td style="font-size: 15px">{{ 'S/ ' . $total }}</td>
                                </tr>

                              </table>

                              <br>

                              <h3 style="font-weight:bold;">Estado de la Orden</h3>

                              <div style="background-color:#dc3545;color:white;padding: 5px 10px;">
                                Orden Cancelada
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
