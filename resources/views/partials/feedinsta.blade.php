<div class="feedinsta">

    @foreach($feed as $feed_item)
    <a href="{{ $feed_item->link }}" class="feed-item" target="_blank">
      <img src="{{ $feed_item->imageThumbnailUrl }}" alt="Galería Indigo | Instagram">
    </a>
    @endforeach

</div>
