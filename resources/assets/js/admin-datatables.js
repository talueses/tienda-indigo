$(document).ready(function() {
    $('#dataTable').DataTable( {
          "language": {
              "lengthMenu": "Mostrar _MENU_ records por página",
              "zeroRecords": "No se encontraron records",
              "search": "Buscar",
              "info": "Página _PAGE_ de _PAGES_",
              "infoEmpty": "No existen records",
              "infoFiltered": "(filtrado de _MAX_ records en total)",
              "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
              }
          }
      } );

      $('#adminData').DataTable( {
        "order": [[ 0, "desc" ]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ records por página",
            "zeroRecords": "No se encontraron records",
            "search": "Buscar",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No existen records",
            "infoFiltered": "(filtrado de _MAX_ records en total)",
            "paginate": {
              "previous": "Anterior",
              "next": "Siguiente"
            }
        }
    } );
  });
  