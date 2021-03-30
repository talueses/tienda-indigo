var self = module.exports = 
{

  rWeddingLOptions(data, select, modalName) 
  {

    var items = [];
    //$ajax call
    $.ajax({ method: "post", headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "/programa-de-regalos/getstocklist", data: data})
      .done(function(resp){

          if(resp.success) {
            items = resp.data;
            self._rOptions(items, select, modalName);
          }

      });

  },

  rSelectStockGift(stock, modalName)
  {

    var selectStockDetail = $('select#modal_'+modalName+'_select_quantity');
    $('select#modal_'+modalName+'_select_quantity option').remove();

    var h = "";
      for (var i = 1; i <= stock; i++) {
        h += "<option value="+i+">"+i+"</option>";
      }
    selectStockDetail.append(h);
    if (stock) {
      selectStockDetail.prop('disabled', false);
      $('#btn_'+modalName).prop('disabled', false);
    }else{
      selectStockDetail.prop('disabled', true);
      $('#btn_'+modalName).prop('disabled', true);
    }
  },


  _rOptions(items, select, modalName)
  {

    var html = "";
    var select = $(select);
    var stockItems = items.stock;

    select.html('');

    if (self._hasStock(stockItems)) {

      $('#btn_add_product_cart span').html();

      if (self._hasColor(stockItems)) {

          $('#btn_'+modalName).prop('disabled', true);

          html += "<div class='pt-4'></div>";
          html += "<label for=''>Color</label>";
          html += "<select class='form-control shop_select_color' id='modal_"+modalName+"_select_color'>";
          html += "<option value=''>Seleccionar</option>";
          for (var i = 0; i < stockItems.length; i++) {
            html += "<option value='"+stockItems[i].color+"' data-stock='"+ stockItems[i].stock +"' >"+stockItems[i].color+"</option>";
          }
          html += "</select>";

          html += "<div class='pt-4'></div>";
          html += "<label for=''> Cantidad </label>";
          html += "<select class='form-control' id='modal_"+modalName+"_select_quantity' disabled>";
          for( var i = 1; i <= stockItems; ++i ) {
            html += "<option value='"+i+"'>"+i+"</option>";
          }
          html += "</select>";
      } else {
          var stock = stockItems[0].stock;

          html += "<div class='pt-4'></div>";
          html += "<label for=''> Cantidad </label>";
          html += "<select class='form-control' id='modal_"+modalName+"_select_quantity'>";
          for( var i = 1; i <= stock; ++i ) {
            html += "<option value='"+i+"'>"+i+"</option>";
          }
          html += "</select>";
      }

      html += "<br>";

      $('#btn_'+modalName).show();

    } else {
      
      html = "<div class='pt-4'></div>";
      html += "No hay stock disponible."; // o ya has agregado todos los productos a tu lista
      $('#btn_'+modalName).hide();
    }

    select.html( select.html() + html );
  },

  _hasColor(items)
  {
    var hasColor = false;
    
    for (var i = 0; i < items.length; i++) {
      if (items[i].hasOwnProperty('color')) { hasColor = true; }
    }
    return hasColor;
  },

  _hasStock(items) 
  {
    var hasStock = false;

    for (var i = 0; i < items.length; i++) {
      if (items[i].stock > 0 ) { hasStock = true; }
    }
    
    return hasStock;
  }

}
