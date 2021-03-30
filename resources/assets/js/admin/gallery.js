$('.reorder_link').on('click',function(){
    $("#uploadImgs").hide();
    $('.remove-img-galeria').hide();
    $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
    $(this).hide();
    $('.editReOrder_m').fadeIn();
    $('#reorderHelper').slideDown('slow');
    $('.image_link').attr("href","javascript:void(0);");
    $('.image_link').css("cursor","move");
});

$('.cancel-edit-order').on('click', function(){
    $('#reorderHelper').slideUp('slow');
    $("ul.reorder-photos-list").sortable('destroy');
    $('.remove-img-galeria').show();
    $('.editReOrder_m').hide();
    $('.reorder_link').show();
    $('#uploadImgs').show();
});

$('.cancel-upl-gallery').on('click', function(){
    $(this).hide();
    $('input#images').val('');
    $('.temp_img_g').remove();
    $('#saveReorder').fadeIn();
    $('#uploadGallery').hide();
    $('.reorder_link').show();
})

$('#gal_images').on('change', function(e) {

  var fileC = new Array();
  var files = e.target.files;
  $('.temp_img_g').remove();

  $.each(files, function(i, file){
      fileC.push(file);

      var reader = new FileReader();
      reader.onload = function (e) {
          var t = '<li id="{{$key}}" class="temp_img_g"><a href="javascript:void(0);" style="float:none;" class="image_link"><img src="'+e.target.result+'" alt="'+file.name+'" style="object-fit:cover;" width="250" height="156" alt=""></a></li>';
          $('ul.new_list').append(t);
      };
      reader.readAsDataURL(file);
  });


  $('#uploadGallery').fadeIn();
  $('.cancel-upl-gallery').fadeIn();
  $('.reorder_link').hide();

});
