var self = module.exports = {

	loading(){
	    $('#progress_form').show();
	    $('body').css('overflow', 'hidden');
	},
	hideLoading(){
	    $('#progress_form').hide();
	    $('body').css('overflow', 'initial');
	},
	getCartList(){
	    if (localStorage && localStorage.getItem('cart')) {
	      return JSON.parse(localStorage.getItem('cart'));
	    }
	    return null;
  	},
	update(list){
  		localStorage.setItem('cart', JSON.stringify(list));
	},
  	calcItemsInCart() {
	    var list = JSON.parse(localStorage.getItem('cart'));

	    if (list !== null && list.hasOwnProperty('products') || list !== null && list.hasOwnProperty('weddingcart')) {
	      listP = list.products;
	      listW = list.weddingcart;

	      var total = 0;
	      $.each(listP, function(key, item) {
	          total += item.quantity * 1;
	      });
	      $.each(listW, function(key, item) {
	          total += item.quantity * 1;
	      });
	      $('.ajax_cart_quantity').html(total);
	    }
	},

	cleanLocalStorage(){
	    var cart = {};
	    cart.products = [];
	    cart.weddingcart = [];
	    localStorage.setItem('cart', JSON.stringify(cart));
  	}

}