<ul class="list-unstyled list-socials fixed">
  @foreach($socials as $social)
  <li class="list-socials-item">
    <a href="{{ $social->valor }}" target="_blank"><i class="fab {{ 'fa-'.$social->nombre }}"></i></a>
  </li>
  @endforeach
</ul>
