<div class="customer-menu">

  <h4 class="menu-title">Mi Cuenta</h4>

  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <a class="{{ \Route::current()->getName() == 'customer.info' ? 'active' : '' }}" href="{{ route('customer.info') }}">Mis Datos</a>
    </li>
    <li class="list-group-item">
      <a class="{{ \Route::current()->getName() == 'cuenta.changepw' ? 'active' : '' }}" href="{{ route('cuenta.changepw') }}">Cambiar contraseña</a>
    </li>
    <li class="list-group-item">
      <a class="{{ \Route::current()->getName() == 'cuenta.ordenes' || \Route::current()->getName() == 'cuenta.orden.detalle' ? 'active' : '' }}" href="{{ route('cuenta.ordenes') }}">Mis Ordenes</a>
    </li>
    <li class="list-group-item">
      <a href="{{ route('home.logout') }}">Cerrar Sesión</a>
    </li>
  </ul>

</div>
