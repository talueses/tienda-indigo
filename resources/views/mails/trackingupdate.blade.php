@include('mails.layouts.header', ['title' => "Tracking"])

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

    <h2 style="font-size: 26px;">Se ha actualizado su @if(isset($codigo_lista)) lista de regalos @else orden @endif</h2>

    <p>
      Su @if(isset($codigo_lista)) lista de regalos @else orden @endif ya cuenta con c&oacute;digo de seguimiento
    </p>

    <h3 style="font-weight:bold;">@if(isset($codigo_lista)) Lista: {{ $codigo_lista}} @else Orden: #{{ $orden_id }} @endif</h3>
    <br>

    <h3 style="font-weight:bold;">Estado de la @if(isset($codigo_lista)) Lista de regalos @else Orden @endif</h3>

    <div style="background-color:#5c116e;color:white;padding: 5px 10px;">
      Con c&oacute;digo de seguimiento
    </div>

    <br>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
        <tbody class="mcnButtonBlockOuter">
          <tr>
            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
              <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #00ADD8;">
                <tbody>
                  <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Helvetica;font-size: 18px;padding: 18px;background-color: white;border: 2px solid black;">
                        <a class="mcnButton " title="Ver detalle" href="{{ $route }}" target="_blank" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #101010;">Ver detalle</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
        </tr>
      </tbody>
    </table>

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
