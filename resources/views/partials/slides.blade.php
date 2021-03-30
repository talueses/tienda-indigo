<div class="container-fluid">
  <div class="row">
    <div id="{{ $id }}" class="carousel slide w-100" data-ride="carousel" data-interval="3000" data-pause="false">
      <ol class="carousel-indicators">
        @if($slides->isEmpty())
        <li data-target="#{{ $id }}" data-slide-to="0" class="active"></li>
        <li data-target="#{{ $id }}" data-slide-to="1" class=""></li>
        @else
        @foreach ($slides as $slide)
        <li data-target="#{{ $id }}" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : ''}}"></li>
        @endforeach
        @endif
      </ol>
      <div class="carousel-inner">
        @if($slides->isEmpty())
        <div class="carousel-item active">
          <img class="d-block w-100 element" src="{{ url('media/default.jpg') }}" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100 element" src="{{ url('media/default.jpg') }}" alt="Second slide">
        </div>
        @else
        @foreach ($slides as $slide)
          
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                @if ($slide->video)
                  <video class="d-block w-100 element" src="{{ url('uploads/vid/'.$slide->contenido) }}" autoplay loop muted />
                @else
                  <img class="d-block w-100 element" src="{{ url('uploads/home/gallery/'.$slide->img) }}" alt="Slide">
                @endif  
            </div>
                   
        @endforeach
        @endif
      </div>
    </div>
  </div>
</div>
