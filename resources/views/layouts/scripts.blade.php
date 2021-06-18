@if(Route::current())
    @if( Route::current()->getName() == 'home.cart' || Route::current()->getName() == 'cuenta.orden.detalle' )
    @endif
@endif
<script type="text/javascript">
// $("#map").css("position","fixed !important");
 function initMap() {
  var uluru = {lat: -12.0431805, lng: -77.0282364};
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 13, center: uluru});
  var marker = new google.maps.Marker({
  	position: uluru, 
  	map: map,
  	label: {
  		text:'Galería Indigo San Isidro',
  		color: 'black'
  	}
  });
};
</script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBYaD9zJPavbe_l7VyKJdCl5h-X3qlSyI&callback=initMap"></script>

@yield('javascript')