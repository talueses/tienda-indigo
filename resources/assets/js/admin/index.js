$(document).ready(function() {
  $('.remove-item').click(function() {
    var id = $(this).attr('data-id');
    var url = $(this).attr('data-url');
    $("#form_delete_item").attr("action", url);
    $('body').find('#form_delete_item').append('<input name="id" type="hidden" value="'+ id +'">');
  });

  $('.cancel-item-delete').click(function() {
    $('body').find('#form_delete_item').find( "input" ).remove();
  });
});