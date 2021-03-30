<ul class="sidebar navbar-nav d-print-none">
  <li class="{{ request()->is('admin') ? 'nav-item active' : 'nav-item' }}">
    <a class="nav-link" href="{{ route('admin') }}">
      <i class="fas fa-home"></i>
      <span class="nav-link-text">Inicio</span>
    </a>
  </li>


  <li class="{{ request()->is('admin/items*') ? 'nav-item dropdown active show' : 'nav-item dropdown' }}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesItems" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ request()->is('admin/items*') ? 'active' : 'false' }}">
      <i class="fa fa-archive"></i>
      <span class="nav-link-text">Items</span>
    </a>
    <div class="{{ request()->is('admin/items*') ? 'dropdown-menu d-sub-menu show' : 'dropdown-menu d-sub-menu' }}" aria-labelledby="pagesItems">
      <a class="{{ request()->is('admin/items/categories*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.categories') }}">Categorías</a>
      <a class="{{ request()->is('admin/items/materials*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.materials') }}">Materiales</a>
      <a class="{{ request()->is('admin/items/types*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.types') }}">Tipos de Producto / Obras</a>
    </div>
  </li>

  <li class="{{ request()->is('admin/artists*') || request()->is('admin/artworks*') ? 'nav-item dropdown active show' : 'nav-item dropdown' }}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesArtists" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ request()->is('admin/artists*') || request()->is('admin/artworks*') ? 'active' : 'false' }}">
      <i class="fas fa-paint-brush"></i>
      <span class="nav-link-text">Artistas</span>
    </a>
    <div class="{{ request()->is('admin/artists*') || request()->is('admin/artworks*') ? 'dropdown-menu d-sub-menu show' : 'dropdown-menu d-sub-menu' }}" aria-labelledby="pagesArtists">
      <a class="{{ request()->is('admin/artists*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.artists') }}">Todos los artistas</a>
      <a class="{{ request()->is('admin/artworks*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.artworks') }}">Obras</a>
    </div>
  </li>


  <li class="{{ request()->is('admin/products*') || request()->is('admin/countries*') || request()->is('admin/descuentos*') ? 'nav-item dropdown active show' : 'nav-item dropdown' }}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesEcommerce" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ request()->is('admin/products*') || request()->is('admin/countries*') ? 'active' : 'false' }}">
      <i class="fas fa-shopping-cart"></i>
      <span class="nav-link-text">Tienda</span>
    </a>
    <div class="{{ request()->is('admin/products*') || request()->is('admin/countries*') || request()->is('admin/descuentos*') ? 'dropdown-menu d-sub-menu show' : 'dropdown-menu d-sub-menu' }}" aria-labelledby="pagesEcommerce">
      <a class="{{ request()->is('admin/products*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.products') }}">Productos</a>
      <a class="{{ request()->is('admin/descuentos*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.descuentos.index') }}">Descuentos</a>
      <a class="{{ request()->is('admin/countries*') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.countries') }}">Paises</a>
    </div>
  </li>

  <li class="{{ request()->is('admin/orders*')  ? 'nav-item dropdown active show' : 'nav-item dropdown' }}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesEcommerce" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ request()->is('admin/orders*') ? 'active' : 'false' }}">
      <i class="far fa-credit-card"></i>
      <span class="nav-link-text">Ordenes</span>
    </a>
    <div class="{{ request()->is('admin/orders*') ? 'dropdown-menu d-sub-menu show' : 'dropdown-menu d-sub-menu' }}" aria-labelledby="pagesOrders">
      <a class="{{ request()->is('admin/orders') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.orders') }}"> Todas </a>
      <a class="{{ request()->is('admin/orders/calculating') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.orders.calculating') }}"> Calculando costo de envio </a>
      <a class="{{ request()->is('admin/orders/pending') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.orders.pending') }}"> Pendientes de pago </a>
      <a class="{{ request()->is('admin/orders/paid') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.orders.paid') }}">Pagadas</a>
      <a class="{{ request()->is('admin/orders/tracking') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.orders.tracking') }}"> Enviado </a>
    </div>
  </li>

  <li class="{{ request()->is('admin/giftregistry*')  ? 'nav-item dropdown active show' : 'nav-item dropdown' }}">
    <a class="nav-link dropdown-toggle" href="#" id="pagesEcommerce" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ request()->is('admin/giftregistry*') ? 'active' : 'false' }}">
      <i class="fas fa-gift"></i>
      <span class="nav-link-text">Programa de Regalos</span>
    </a>
    <div class="{{ request()->is('admin/giftregistry*') ? 'dropdown-menu d-sub-menu show' : 'dropdown-menu d-sub-menu' }}" aria-labelledby="pagesGiftregistry">
      <a class="{{ request()->is('admin/giftregistry') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.giftregistry') }}"> Listas </a>
      <a class="{{ request()->is('admin/giftregistry/edition') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.giftregistry.edition') }}"> En edición </a>
      <a class="{{ request()->is('admin/giftregistry/calculating') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.giftregistry.calculating') }}"> Calculando costo de envio </a>
      <a class="{{ request()->is('admin/giftregistry/tracking') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.giftregistry.tracking') }}"> Enviado </a>
      <a class="{{ request()->is('admin/giftregistry/finished') ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('admin.giftregistry.finished') }}"> Finalizadas </a>
    </div>
  </li>

  <li class="{{ request()->is('admin/events*') ? 'nav-item active' : 'nav-item' }}">
    <a class="nav-link" href="{{ route('exhibitions') }}">
      <i class="fas fa-calendar-alt"></i>
      <span class="nav-link-text">Eventos</span>
    </a>
  </li>

  <li class="{{ request()->is('admin/notes*') ? 'nav-item active' : 'nav-item' }}">
    <a class="nav-link" href="{{ route('notes') }}">
      <i class="fas fa-newspaper"></i>
      <span class="nav-link-text">Notas</span>
    </a>
  </li>

  <li class="{{ request()->is('admin/nosotros*') ? 'nav-item active' : 'nav-item' }}">
    <a class="nav-link" href="{{ route('admin.aboutus') }}">
      <i class="fas fa-file"></i>
      <span class="nav-link-text">Nosotros</span>
    </a>
  </li>

  <li class="{{ request()->is('admin/newsletter*') ? 'nav-item active' : 'nav-item' }}">
    <a class="nav-link" href="{{ route('newsletter') }}">
      <i class="fas fa-file"></i>
      <span class="nav-link-text">Newsletter</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.terminosycondiciones') }}">
      <i class="fas fa-file"></i>
      <span class="nav-link-text">Términos y Condiciones</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-cog"></i>
      <span class="nav-link-text">Cuenta</span>
    </a>
  </li>
</ul>
