const functions = require('../components/functions.js');

$('#u_btn_checkout').on('click', function(e) {
    let orden_id = $('#orden_id').val();

    console.log('orden id', orden_id);
    let postUrl = '/cuenta/ordenes/detalle/'+orden_id+'/charge'
    
    culquiOrders(postUrl)    

    e.preventDefault();

    $.ajax({
        method: "POST", headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, url: "/getorderdetails", data: {'orden_id': orden_id}
    }).done(function(resp){

        if (resp.success) {

            total = parseFloat(resp.data)
            var grandTotal = resp.data * 100;

            if (grandTotal > 0) {
                Culqi.settings({
                    title: 'Galeria Indigo',
                    currency: 'PEN',
                    description: 'Orden',
                    amount: grandTotal
                });

                Culqi.open();
                document.location.href = '#';
            }
        }else if (resp.error){ }//$('#cart_order_error').show();

    })
    .fail(function(jqXHR){
        var response = JSON.parse(jqXHR.responseText);
        if (response.error == 'Unauthenticated') {
            location.href = '/login';
        }
    });

});

var culquiOrders = function (postUrl) 
{
    window.culqi = function() {

        functions.loading();

        var mainOrder = document.getElementById('detail_section');

        let data = {
            'culqiId': Culqi.token.id,
            'email': Culqi.token.email,
            'metodoPago': Culqi.token.iin.card_type,    
        }
        console.log('culqui_data', data)
        $.ajax({
            method: "POST", headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, url: postUrl, data
        }).done(function(resp) 
        {
            if(resp.code == 'AUT0000')
            {
                if (mainOrder !== null) {
                    mainOrder.innerHTML = '';
                }
                document.getElementById('success_form').style.display = "inline-block";
           
            } else if(resp.object == 'error')
            {
                document.getElementById('error_form').style.display = "inline-block";
                document.getElementById('error_form_response').innerHTML = resp.user_message;
            }

            functions.hideLoading();
        })
        .fail(function(jqXHR)
        {
            var response = JSON.parse(jqXHR.responseText);
            console.log(response)
            if (response.error == 'Unauthenticated') {
                location.href = '/login';
            }
        });
    }

}