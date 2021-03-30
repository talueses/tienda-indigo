<table border="1" cellpadding="2" cellspacing="1" width="100" style="border: 1px solid #000000; width:100%;">
    <tr>
      <th style="font-size:14px; text-align: center;" colspan="{!! count($headers) !!}">REPORTE DE REGISTROS - {!! $name !!}</th>
    </tr>
    <tr>
    @foreach ($headers as $header)
      <th style="background-color: #f5f5dc; text-align: center; font-size:16px; width: 30px;">{!! $header !!}</th>
    @endforeach
    </tr>
    @foreach ($values as $column)
    <tr>
      @foreach ($column as $row)
      <td style="font-size:14px; text-align: center;">{!! $row !!}</td>
      @endforeach
    </tr>
    @endforeach
</table>