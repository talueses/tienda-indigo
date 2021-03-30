const functions = require('../components/functions.js');

window.culqi = function() {

    var total = getTotal();
    var list = functions.getCartList();

    var modoEntrega = document.querySelector('input[name="modo_entrega"]:checked').value;
    var modoFactura = document.getElementById('modo_factura').checked;
    var departamento = document.getElementById('envio_departamento').value;
    var direccion = document.getElementById('envio_direccion').value;
    var ruc = document.getElementById('ruc').value;
    var razonSocial = document.getElementById('razon_social').value;
    var paisId = document.getElementById('envio_pais').value;
    var distrito = document.getElementById('envio_lima').value;
    var belongsLM = document.getElementById('belongsLM').value;

    var ordenId = (document.getElementById('orden_id') !== null) ? document.getElementById('orden_id').value : null;


    if(Culqi.token) {
        functions.loading();

        var mainOrder = document.getElementById('main_orden');
        var errorForm = document.getElementById('error_form');

        if (mainOrder !== null) {
          mainOrder.innerHTML = '';
        }

        var data = {
            "id": Culqi.token.id,
            "amount": total,
            "email": Culqi.token.email,
            "list": list,
            "modoEntrega": modoEntrega,
            "modoFactura": modoFactura,
            "pais": paisId,
            "departamento": departamento,
            "distrito": distrito,
            "metodoPago": Culqi.token.iin.card_type,
            "direccion": direccion,
            "ruc": ruc,
            "razonSocial": razonSocial,
            "orden_id": ordenId,
            "pago": 1,
            "freeDelivery": belongsLM
        }


        axios.post('/ordercharge', data).then(function (response) {
            console.log(response);
            var response = response.data;

                if(response.code == "AUT0000")
                {
                    functions.cleanLocalStorage();
                    functions.calcItemsInCart()           
                    document.getElementById('success_form').style.display = "inline-block";
                    if(belongsLM) 
                    {
                        document.getElementById('success_form_free_delivery').style.display = "inline-block";
                    }    
                    
                    //actualizar icono carrito
                } else if(response.object == "error")
                {
                    document.getElementById('error_form').style.display = "inline-block";
                    document.getElementById('error_form_response').innerHTML = response.user_message;
                }
                functions.hideLoading();

            })
            .catch(function (error) {

                if (error.response) {
                  console.error('transaction error', error.response.data);
                }

                if (errorForm !== null) {
                  errorForm.style.display = "inline-block";
                }

                functions.hideLoading();
            });

    } else {
        console.error("token no existe");
        console.error(Culqi.error.user_message);
        functions.hideLoading();
    }
}

var getTotal = function()
{
    var totalPP = $('.total_product_price');
    var price = 0;
    var text = '';
    var total = 0;
    $.each(totalPP, function(key, item){
        text = $(this).html();
        price = text.split("S/ ");
        total += parseFloat(price[1]);
    });

    return total*100;
}
