<div class="container-fluid banner mt-2">
  <div class="row">
    <img src="{{ isset($brand) ? $brand['img'] : asset('media/banner.jpg') }}" class="img-fluid ele" alt="">
    <div class="caption">
      @if(isset($brand))
      <span>
        <h3>{{ $brand['name'] }}</h3>
      </span>
      @else
      <span class="home">
        <img src="{{asset('media/indigo_logo.png')}}" class="img-fluid" alt="">
      </span>
      @endif
    </div>
  </div>
</div>
