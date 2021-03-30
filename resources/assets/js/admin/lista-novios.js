const Regalo = require('../helper/regalo.js');
var modalName = "choose_gift";

$('.agregar-cuenta-novios').on('click', function(e)
{
  e.preventDefault();

  var $this = $(this);
  var productId = $this.data('producto-id');
  var img = $this.data('img') ? '/uploads/products/'+$this.data('img') : '/media/default.jpg';
  var id = $this.data('item'); //id
  var title = $this.data('title');
  var price = $this.data('price');
  var cuentaNovios = $this.data('cuenta-id');
  var select = '#modal_choose_gift_select_stock';

  $('#modal_'+modalName+'_title').html(title);
  $('#modal_'+modalName+'_img').attr('src', img);
  $('#modal_'+modalName+'_price').html(price);
  $('#modal_'+modalName+'_product_id').val(productId);
  $('#modal_'+modalName+'_cuenta_id').val(cuentaNovios);
  //Get stock
  var data = {
    productId: productId,
    cuentaNoviosId: cuentaNovios
  };

  Regalo.rWeddingLOptions(data, select, modalName);
});

$('#modal_'+modalName+'_select_stock').on('change', '.shop_select_color', function(e){
    e.preventDefault();
    var $this = $(this);
    var value = $this.val();
    var stock = $this.find('option:selected').data('stock');
    Regalo.rSelectStockGift(stock, modalName);
});


$('#btn_choose_gift').on('click', function(e)
{
  e.preventDefault();

  var color = $('#modal_'+modalName+'_select_color').val();
  var cantidad = $('#modal_'+modalName+'_select_quantity').val();
  var productoId = $('#modal_'+modalName+'_product_id').val();
  var button = $('#btn_add_regalo_'+productoId);
  var cuentaId = button.data('cuenta-id');
  var listaCodigo = button.data('lista-codigo');

  $('#modal_choose_gift').modal('hide');

  $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "POST",
      url: "/programa-de-regalos/lista/addproduct",
      data: { cuenta_id: cuentaId, producto_id: productoId, cantidad: cantidad, color: color, lista_codigo: listaCodigo }
  })
  .done(function(msg){
      location.reload();
  });

});



//hide first modal
$(".agregar-cuenta-novios").on( "click", function() {
  $('#modal_lista_productos').modal('hide');
});
//trigger next modal
$(".agregar-cuenta-novios").on( "click", function() {
  $('#modal_choose_gift').modal('show');
});
