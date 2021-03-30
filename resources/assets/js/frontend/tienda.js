const functions = require('../components/functions.js');
const Cart = require('../components/Cart.js');
const Shop = require('./shop.js');
var modalName = "add_product_cart";

$(document).ready(function(){
  functions.calcItemsInCart();
  Shop.changeStockByColor(modalName);
});


/* Product Detail */
$('.gallery-img').on('click', function(e){
  //console.log($(this).attr('src'));
  var newLink = $(this).attr('src');
  url = encodeURI(newLink);
  $('.zoomImg').css('background-image', "url("+url+")" );
  $('.zoomImg').find('a').attr('href', url);
  $('#product_preview_img').attr('src', url);
});

var selectStockDetail = $('#product_detail_quantity');
$('#product_detail_color').on('change', function(e){
    e.preventDefault();
    var $this = $(this);
    var value = $this.val();
    var stock = $this.find('option:selected').data('stock');
    rSelectStock(stock);

    $('#btn_'+modalName).prop('disabled', false);
});

/**
* @ADD_CART
**/
$('#product_detail_add_to_cart_btn').click(function(e){
    e.preventDefault();


    var $this = $(this);

    var colorValue = $('#product_detail_color').val();
    var id = $this.data('item');
    var quantity = $('#product_detail_quantity').val();
    var color = (colorValue != null) ? colorValue : '';
    var weddingListId = ($this.data('wedding-list-id') != null) ? $this.data('wedding-list-id') : '';

    var product = {
      id: id,
      quantity: quantity,
      color: color,
      wedding_list_id: weddingListId
    }

    Cart.add(product);
    //functions.addProduct(product);
    functions.calcItemsInCart();

    setSuccessModal($this);
    setQuantity();
    showSuccessModal();
});



/* Tienda */
$('.add_to_cart_btn').click(function(e)
{
  e.preventDefault();

  var $this = $(this);
  var productId = $this.data('item');
  var img = $this.data('img');
  var id = $this.data('item'); //id
  var title = $this.data('title');
  var price = $this.data('price');
  var select = '#modal_add_product_cart_select_stock';

  $('#modal_'+modalName+'_title').html(title);
  $('#modal_'+modalName+'_img').attr('src', '/uploads/products/'+img);
  $('#modal_'+modalName+'_price').html(price);
  $('#modal_'+modalName+'_product_id').val(productId);

  $('#layer_cart_product_title').html(title);
  $('#modal_cart_img').attr('src', '/uploads/products/'+img);
  $('#layer_cart_product_price').html(price);

  setSuccessModal($this);

  $('#modal_add_product').modal('show');

  Shop.displayModalOptions(productId, select, modalName);
});


/**
* @ADD_CART
**/
$('#btn_add_product_cart').click(function(e)
{
  e.preventDefault();

  var $this = $(this);

  var colorValue = $('#modal_'+modalName+'_select_color').val();
  var id = $('#modal_'+modalName+'_product_id').val();
  var quantity = $('#modal_'+modalName+'_select_quantity').val();
  var color = (colorValue != null) ? colorValue : '';
  var weddingListId = ($this.data('wedding-list-id') != null) ? $this.data('wedding-list-id') : '';

  var product = {
    id: id,
    quantity: parseInt(quantity),
    color: color,
    wedding_list_id: weddingListId
  }

  Cart.add(product);
  //functions.addProduct(product);
  functions.calcItemsInCart();
  setQuantity();
  showSuccessModal();
});



/* Functions */
function setQuantity(){
  var modalQuantity = $('#modal_add_product_cart_select_quantity').val();
  var quantity = $('#product_detail_quantity').val();
  $('#layer_cart_product_quantity').html(modalQuantity | quantity);
}
function setSuccessModal($this){
  var productId = $this.data('item');
  var img = $this.data('img');
  var id = $this.data('item'); //id
  var title = $this.data('title');
  var price = $this.data('price');

  $('#layer_cart_product_title').html(title);
  $('#modal_cart_img').attr('src', '/uploads/products/'+img);
  $('#layer_cart_product_price').html(price);
}
function showSuccessModal() {
  $('#modal_cart').modal('show');
}
function rSelectStock(stock){
  $('#product_detail_quantity option').remove();
  var h = "";
      for (var i = 1; i <= stock; i++) {
        h += "<option value="+i+">"+i+"</option>";
      }
  selectStockDetail.append(h);
  selectStockDetail.prop('disabled', false);
}
