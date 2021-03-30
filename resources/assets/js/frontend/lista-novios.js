const functions = require('../components/functions.js');
const Shop = require('./shop.js');
const Cart = require('../components/Cart.js');
var modalName = "choose_gift";

$(document).ready(function(){
  Shop.changeStockByColor(modalName);
});

/* Admin */
$('.agregar-cuenta-novios').on('click', function(e){
  e.preventDefault();

  var $this = $(this);
  var productId = $this.data('producto-id');
  var img = $this.data('img');
  var id = $this.data('item'); //id
  var title = $this.data('title');
  var price = $this.data('price');
  var cuentaNovios = $this.data('cuenta-id');
  var select = '#modal_choose_gift_select_stock';

  $('#modal_'+modalName+'_title').html(title);
  $('#modal_'+modalName+'_img').attr('src', '/uploads/products/'+img);
  $('#modal_'+modalName+'_price').html(price);
  $('#modal_'+modalName+'_product_id').val(productId);

  $('#modal_choose_gift').modal('show');

  var data = { productId: productId, cuentaNoviosId: cuentaNovios };
  //Regalo.rWeddingLOptions(data, select, modalName);
});

$('#btn_choose_gift').on('click', function(e) 
{
  e.preventDefault();

  var color = $('#modal_'+modalName+'_select_color').val();
  var cantidad = $('#modal_'+modalName+'_select_quantity').val();
  var productoId = $('#modal_'+modalName+'_product_id').val();
  var $button = $('#btn_add_regalo_'+productoId);
  var cuentaId = $button.data('cuenta-id');

  $('#modal_choose_gift').modal('hide');
  //$button.hide();
  //$button.siblings('.agregado-cuenta-novios').show();

  $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "POST",
      url: "/programa-de-regalos/lista/addproduct",
      data: { cuenta_id: cuentaId, producto_id: productoId, cantidad: cantidad, color: color }
  })
  .done(function(msg){
      if (msg == 'success') {
        $('#modal_gift_cart_added').modal('show');
      }
  });

});

var body = $('body');

$('.remove-product').click(function() {
  var id = $(this).attr('data-id');
  var color = $(this).attr('data-color');
  var url = $(this).attr('data-url');
  var list = $(this).attr('data-list');
  $("#form_delete_product").attr("action", url);

  console.log('remove product color', color);

  body.find('#form_delete_product').find( "input[name='id']" ).remove();

  body.find('#form_delete_product').append('<input name="id" type="hidden" value="'+ id +'">');

});

$('.cancel-product-delete').click(function() {
  body.find('#form_delete_product').find( "input[name='id']" ).remove();
  body.find('#form_delete_product').find( "input[name='color']" ).remove();
});

//Tienda Producto
$('#add_wedding_list').click(function() {

    var $this = $(this);

    $this.prop( "disabled", true );

    var cuentaId = $this.data('cuenta-id');
    var productoId = $this.data('producto-id');

    /**/
    var listaId = $('#product_detail_list').val();
    var cantidad = $('#product_detail_quantity').val();
    var color = $('#product_detail_color').val();

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "POST",
        url: "/programa-de-regalos/lista/addproduct",
        data: {
          cuenta_id: cuentaId,
          lista_codigo: listaId,
          producto_id: productoId,
          cantidad: cantidad,
          color: color
        }
    })
    .done(function( msg ) {

        if (msg == 'success') {
          $('#modal_gift_cart_added').modal('show');
        }
    })
    .always( function() {
        $this.prop( "disabled", false );
    });

});

/* //Admin */



/* Client */
$('.add_to_wedding_cart_btn').click(function(e){
  e.preventDefault();

  var $this = $(this);
  var productId = $this.data('item');
  var img = $this.data('img');
  var title = $this.data('title');
  var price = $this.data('price');
  price = price.split("S/")[1].trim();

  var weddingList = $this.data('wedding-list');
  var color = $this.data('color');
  var originalId = $this.data('item-regalo-id');
  var select = '#modal_client_gift_select_stock';

  $('#modal_client_gift_title').html(title);
  $('#modal_client_gift_img').attr('src', '/uploads/products/'+img);
  $('#modal_client_gift_price').html(price);
  $('#modal_client_gift_product_id').val(productId);
  $('#modal_client_gift_wedding_list').val(weddingList);
  $('#modal_client_gift_product_color').val(color);

//////
  $('#modal_client_gift_list_id').val(originalId);


  $('#modal_client_gift').modal('show');

  var product = { "id":productId, "color":color };

  getGiftNeeded(product, weddingList, select);

});


/**
* @ADD_CART maldicionnnn
**/
$('#modal_client_gift_btn_comprar').on('click', '#btn_add_client_wedding_list', function(e){
  e.preventDefault();

  var colorValue = $('#modal_client_gift_product_color').val();
  var id = $('#modal_client_gift_product_id').val();
  var quantity = $('select[name="modal_choose_gift_select"]').val();
  var weddingListValue = $('#modal_client_gift_wedding_list').val();
  var weddingListRealId = $('#modal_client_gift_list_id').val();
  var color = (colorValue != null) ? colorValue : '';
  var weddingListId = (weddingListValue != null) ? weddingListValue : '';
  var weddingListRealId = (weddingListRealId != null) ? weddingListRealId : '';


  var product = {
    id: id,
    quantity: quantity,
    color: color,
    wedding_product_id: weddingListRealId,
    wedding_list_id: weddingListId
  }
  console.log(product);
  Cart.add(product);
  functions.calcItemsInCart();

  //modal
  product.image = $('#modal_client_gift_img').attr('src');
  product.title = $('#modal_client_gift_title').html();
  product.price = $('#modal_client_gift_price').html();
  showSuccessModal(product);

});

function showSuccessModal(product) {
  $('#modal_cart_gift_img').attr('src', product.image);
  $('#layer_cart_gift_title').html(product.title);
  $('#layer_cart_gift_quantity').html(product.quantity);
  $('#layer_cart_gift_price').html(product.price);
  $('#modal_gift_cart').modal('show');
}



$('#form-novios-register').on('submit', function(e){
    e.preventDefault();

    var form = $(this);
    var data = form.serialize();

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "POST",
        url: "/programa-de-regalos/register",
        data: data
    })
  .done(function(resp, data){
    console.log(resp, data);

    if (resp.success) {
      window.location.replace(resp.url);
    } else {
      var errors = resp.errors;

      $('#form-novios-register input').siblings('.help-block').find('.text-danger').html('');

      $.each( errors, function( key, value ) {
        $('#form-novios-register input[name="'+key+'"]').siblings('.help-block').find('.text-danger').html(value);
      });
    }

  });

});


/* //Client */



/* Functions */
function getGiftNeeded(product, listId, select){
  var data = {
    listId: listId,
    productId: product.id,
    color: product.color
  }

  $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "POST",
      url: "/programa-de-regalos/getqtyneeded",
      data: data
  })
  .done(function(resp){
    if(resp.success) {
      data = resp.data;
      showSelectCliente(data, select);
    }
  })
  .fail(function(jqXHR){
  })

}


function showSelectCliente(data, select){
  var html = "";
  var select = $(select);

  select.html('');

  if (data.num > 0) {
    addComprarBtn();
    html = "<label for=''>Cantidad</label>";
    html += "<select class='form-control' name='modal_choose_gift_select'>";
    for( var i = 1; i <= data.num; ++i ) {
        html += "<option value='"+i+"'>"+i+"</option>";
    }
    html += "</select>";
    html += "<br><br>";
  }else{
    removeComprarBtn();
    html = "No hay stock disponible";
  }

  select.html( select.html() + html );
}

function addComprarBtn(){
  removeComprarBtn();
  var html = "";
  html += "<button id='btn_add_client_wedding_list' class='continue btn btn-outline-secondary linear' title='Regalar' data-dismiss='modal'>";
  html += "<span>Regalar</span>";
  html += "</button>";
  $('#modal_client_gift_btn_comprar').append(html);
}

function removeComprarBtn(){
  $('#btn_add_client_wedding_list').remove();
}
