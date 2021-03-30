<div class="customer-menu">

  <h4 class="menu-title">Mi Cuenta <span class="badge badge-light" style="background-color:#F1EBCD;"><small>Programa de Regalos</small></span> </h4>

  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <a class="{{ \Route::current()->getName() == 'home.giftregistry' ? 'active' : '' }}" href="{{ route('home.giftregistry') }}">Mi Información</a>
    </li>
    <li class="list-group-item">
      <a class="{{ \Route::current()->getName() == 'giftregistry.lists' || \Route::current()->getName() == 'giftregistry.showList' ? 'active' : '' }}" href="{{ route('giftregistry.lists') }}">Listas de Regalo</a>
    </li>
    <li class="list-group-item">
      <a class="{{ \Route::current()->getName() == 'giftregistry.newlist' || \Route::current()->getName() == 'cuenta.orden.detalle' ? 'active' : '' }}" href="{{ route('giftregistry.newlist') }}">Crear nueva lista</a>
    </li>
    <li class="list-group-item">
      <a href="{{ route('home.logout') }}">Cerrar Sesión</a>
    </li>
  </ul>

</div>
