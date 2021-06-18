window._ = require('lodash');
const functions = require('./functions');

var self = module.exports = {

  has(product) {
    var cart = functions.getCartList();
    var list = cart.products;
    var found = false;

    for (var i = 0; i < list.length; i++) {
      item = list[i];
      if (product.id == item.id && product.color == item.color && product.wedding_list_id == item.wedding_list_id) {
        found = true;
      }
    }
    return found;
  },

  add(product){
      var list;
      var msg = "";
      // if the new item already exists, increment the value
      if (self.has(product)) {
        self.updateProduct(product, product.quantity);
        msg = "Producto actualizado en el carrito";
      // otherwise add the item
      } else {
        list = functions.getCartList();

        if(product.quantity != null){
          list.products.push(product);
          msg = "Producto agregado al carrito";

          //update the cart
          functions.update(list);
        }
      }

      return msg;
  },

  updateProduct(product, qty){
    var list = functions.getCartList();
    var quantity = 0;
    if (isNaN(qty) || qty <= 0) { qty = 1; }

    _.forEach(list.products, function(item, key) {
      if (product.id == item.id && product.color == item.color && product.wedding_list_id == item.wedding_list_id) {
        quantity = parseInt(qty);
        item.quantity = quantity;
      }
    });

    functions.update(list);
  },

  deleteProduct(product){
    var list = functions.getCartList();
    var arr = list.products;
    var item, index;
    for (var i = 0; i < arr.length; i++) {
      item = arr[i];
      if (product.id == item.id && product.color == item.color && product.wedding_list_id == item.wedding_list_id) {
        index = i;
      }
    }

    arr.splice(index, 1);

    var cart = {};
    cart.products = arr;
    functions.update(cart);
  },

};
  function culqi() {
  if (Culqi.token) { // ¡Objeto Token creado exitosamente!
  var token = Culqi.token.id;
  alert('Se ha creado un token:' + token);
  //En esta linea de codigo debemos enviar el "Culqi.token.id"
  //hacia tu servidor con Ajax
} else { // ¡Hubo algún problema!
  // Mostramos JSON de objeto error en consola
  console.log(Culqi.error);
  alert(Culqi.error.user_message);
}
};