var self = module.exports = {

  displayModalOptions(productId, select, modalName){
    var product = {"productId":productId};

    $.ajax({ method: "post", headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "/producto/getstock", data: product })
      .done(function(resp){
        if(resp.success) {
          items = resp.data;
          self._rOptions(items, select, modalName);
        }
      })
  },

  _hasColor(items){
    var hasColor = false;
    for (var i = 0; i < items.length; i++) {
      if (items[i].hasOwnProperty('color')){ hasColor = true; }
    }
    return hasColor;
  },

  _hasStock(items){
    var hasStock = false;
    for (var i = 0; i < items.length; i++) {
      if (items[i].stock > 0 ) { hasStock = true; }
    }
    return hasStock;
  },

  _rOptions(items, select, modalName){

    var html = "";
    var select = $(select);

    select.html('');

    if (self._hasStock(items)) {
      //addComprarBtn();

      $('#btn_add_product_cart span').html();

      if (self._hasColor(items)) {

          $('#btn_'+modalName).prop('disabled', true);

          html += "<div class='pt-4'></div>";
          html += "<label for=''>Color</label>";
          html += "<select class='form-control shop_select_color' id='modal_"+modalName+"_select_color'>";
          html += "<option value=''>Seleccionar</option>";
          for (var i = 0; i < items.length; i++) {
            html += "<option value='"+items[i].color+"' data-stock='"+ items[i].stock +"' >"+items[i].color+"</option>";
          }
          html += "</select>";

          html += "<div class='pt-4'></div>";
          html += "<label for=''>Cantidad</label>";
          html += "<select class='form-control' id='modal_"+modalName+"_select_quantity' disabled>";
          for( var i = 1; i <= items; ++i ) {
            html += "<option value='"+i+"'>"+i+"</option>";
          }
          html += "</select>";
      } else {
          var stock = items[0].stock;

          html += "<div class='pt-4'></div>";
          html += "<label for=''>Cantidad</label>";
          html += "<select class='form-control' id='modal_"+modalName+"_select_quantity'>";
          for( var i = 1; i <= stock; ++i ) {
            html += "<option value='"+i+"'>"+i+"</option>";
          }
          html += "</select>";
      }
      html += "<br>";

      $('#btn_'+modalName).show();

    }else{
      //removeComprarBtn();
      html = "<div class='pt-4'></div>";
      html += "No hay stock disponible para este producto.";
      $('#btn_'+modalName).hide();
    }

    select.html( select.html() + html );
  },

  changeStockByColor(modalName){
    $('#modal_'+modalName+'_select_stock').on('change', '.shop_select_color', function(e){
        e.preventDefault();
        var $this = $(this);
        var value = $this.val();
        var stock = $this.find('option:selected').data('stock');

        self._rSelectStockGift(stock, modalName);
    });
  },

  _rSelectStockGift(stock, modalName){
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
  }

}
