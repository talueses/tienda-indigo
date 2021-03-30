
const bootstrap = require('bootstrap')

try {
    window.$ = window.jQuery = require('jquery');
    require('../vendor/fancybox.min.js');
    require('../vendor/bsdatepicker.min.js');
    require('./tienda.js');
    require('./lista-novios.js');
    require('./customer-checkout.js');
} catch (e) {}


window.Vue = require('vue');
import Notifications from 'vue-notification'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

/**
 * Culqi
 */
try {
  Culqi.publicKey = 'pk_test_6kWbDd6q0qH3ba2B';
  require('./culqi');
} catch (e) {

}


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('cart', require('../components/Cart.vue').default);
Vue.component('checkout', require('../components/CheckoutCart.vue').default);
Vue.component('checkout-area', require('../components/Checkout.vue').default);

Vue.component('modal-addgift', require('../components/ModalListaRegalo.vue').default);
Vue.component('add-product', require('../components/AddProduct.vue').default);

Vue.component('gift-detail', require('../components/GiftDetail.vue').default);
Vue.component('gift-cart', require('../components/GiftCart.vue').default);
Vue.component('checkout-gift', require('../components/CheckoutGiftCart.vue').default);

Vue.component('country-detail', require('../components/CountryDetail.vue').default);
Vue.component('departments', require('../components/Departments.vue').default);
Vue.component('districts', require('../components/Districts.vue').default);

Vue.use(Notifications)
Vue.use(Loading);

const app = new Vue({
    el: '#app',
    data: {
        openModal: false,
        productId: null
    }
});


var dataPlay = true;

$('.carousel-item').click(function() {
    if (dataPlay === true) {
        dataPlay = false;
        $('#slide-main').carousel('pause');
    } else if (dataPlay === false) {
        dataPlay = true;
        $('#slide-main').carousel('cycle');
    }
});

var pagination = $('.pagination')
var pricefilter = $('#price-filter')
var pricevalue = $('#price-filter-value')
var selectsform = $('select.select_option')
var imgWeddingAccount = $('#select_img_wedding_account')


function initMap(ele, coords) {
  var pos = { lat: coords.lat, lng: coords.lng }
  var map = new google.maps.Map(ele,{
    zoom: 17,
    center: pos
  })
  var marker = new google.maps.Marker({
    position: pos,
    map: map
  })
}

pagination.find('li').each(function (key,item) {
  $(item).addClass('page-item').find('a,span').addClass('page-link')
})

pricefilter.on('change', function () {
  pricevalue.html('S/ '+this.value)
  window.location.href = `${window.location.pathname}?filterby=precio&rule=<&value=${this.value}`
})

try {
  var ele = document.getElementById('g-maps')
  initMap(ele, { lat: -12.094887, lng: -77.033788 })

  var map = document.getElementById('g_maps_contact')
  initMap(map, { lat: -12.094887, lng: -77.033788 })

} catch (e) {
  //console.error(e.message)
}

selectsform.each(function (item, value) {
  $(value).on('change', function () {
    window.location.href = this.value
  })
})


$('#newsletter_subs_pre_footer').on('click', function(){

  var name = $('#inp_name_newsletter_pre_footer').val();
  var subs = $('#inp_newsletter_pre_footer').val();

  if (validateEmail(subs)) {
    $.ajax({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, method: "post", url: "/newsletter/subscribe", data: {nombres:name, email: subs} })
      .done(function(resp) {

        if (resp.success) {
          $('#success-newsletter').modal('show');
        } else {
          console.log(resp.data.email);

          $('#alert_newsletter_body').html(resp.data.email);
          $('#success-newsletter').modal('show');
        }
      });


    $('#inp_name_newsletter_pre_footer').val('');
    $('#inp_newsletter_pre_footer').val('');
  }

})


$('#newsletter_subs').on('click', function(){
  var nombres = $('#inp_name_newsletter').val();
  var email = $('#inp_newsletter').val();
  //var modalTitle = $('#newsletter_subs_title');
  var modalBody = $('#newsletter_subs_body');

  if (validateEmail(email)) {

    $.ajax({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, method: "post", url: "/newsletter/subscribe", data: {nombres:nombres, email: email} })
      .done(function(resp) {

        if (resp.success) {
          $('.newsletter-b-success').show();
          $('.newsletter-b-error').hide();
          $('#newsletter_subs_default').hide();

          //
          $('#inp_name_newsletter').hide();
          $('#newsletter_subs_form').hide();

          modalBody.css("color", "black");
          modalBody.html('¡Gracias por suscribirte a nuestra newsletter! A partir de ahora recibirás en tu correo novedades de Galeria Indigo.');

          setTimeout(function() {
            $('#m_newsletter_indigo').modal('hide');
          }, 3000);

        } else {
          $('.newsletter-b-success').hide();
          $('.newsletter-b-error').show();
          modalBody.css("color", "red");
          //modalTitle.html("Error al suscribirte");
          modalBody.html(resp.data.email[0]);
        }
      });

    $('#inp_name_newsletter').val('');
    $('#inp_newsletter').val('');
  } else {

    $('.newsletter-b-success').hide();
    $('.newsletter-b-error').show();
    modalBody.css("color", "red");
    modalBody.html("Error al suscribirte");
  }

  $('#newsletter_modal').modal('show');

});

imgWeddingAccount.on('change', function () {
  var input = this;

  if (input.files && input.files[0]) 
  {
      var reader = new FileReader();
      reader.onload = function (e) {
          $('#imgpreview').attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
  }
  
})

$(document).ready(function() {

    var cart = localStorage.getItem("cart");
    cart = JSON.parse(cart);

    if (cart === null) {
      var cart = {};
      cart.products = [];
      cart.weddingcart = [];
      localStorage.setItem('cart', JSON.stringify(cart));
    }

    $("#m_newsletter_indigo").modal('show');

    var copyText = $("#copy_input");
    $('#btn_copy_link').click(function(){
        copyText.select();
        document.execCommand("Copy");

        $('#copied_link').show();
        setTimeout(function() { $('#copied_link').hide(); }, 1000);
    });

    copyText.keypress(function(e) {
      e.preventDefault();
    });


});

function validateEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
