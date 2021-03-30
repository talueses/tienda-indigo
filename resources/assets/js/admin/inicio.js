// MODAL - #edit_home_img
$('.update-home-img').on('click', function(e){

  var $this = $(this);
  var id = $this.data('id');
  var name = $this.data('name');
  var img = $this.data('img');

  $('.home_image_name').val(name);
  $('#imgpreview_edit_home').attr('src', img);

});


$('#file_preview_home').on('change', function(){
  var input = this;
  var img = $('#imgpreview_edit_home');

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        img.attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
  }

});
