<header>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-8 col-lg-2">
          <a href="{{ route('index') }}"><img src="{{asset('media/indigo_logo.png')}}" class="img-fluid" alt="Galería Indigo"></a>
        </div>
        <div class="col-4 col-lg-10 d-menu-none">
          <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarTogglerIndigo" aria-controls="navbarTogglerIndigo" aria-expanded="false" aria-label="Toggle navigation">
            <!--span class="navbar-toggler-icon"></span-->
            <i class="fas fa-bars"></i>
          </button>
        </div>
        <div class="col-lg-10">
          <div class="row align-items-center">

            <div class="col-12 collapse navbar-collapse" id="navbarTogglerIndigo">
              <ul class="responsive-menu text-uppercase">
                <li class="responsive-menu-item"><a href="{{ route('home.nosotros') }}">nosotros</a></li>
                <li class="responsive-menu-item"><a href="{{ route('home.artistas') }}">artistas</a></li>
                <li class="responsive-menu-item"><a href="{{ route('home.notas') }}">notas</a></li>
                <li class="responsive-menu-item"><a href="{{ route('home.eventos') }}">eventos</a></li>
                <li class="responsive-menu-item"><a href="{{ route('home.tienda') }}">tienda</a></li>
                <li class="responsive-menu-item"><a href="{{ route('home.contact') }}">contacto</a></li>
              </ul>
            </div>

            <div class="col-md-9 web-menu">
              <ul class="responsive-menu">


                <li class="{{ request()->is('nosotros') ? 'active responsive-menu-item' : 'responsive-menu-item' }}"><a href="{{ route('home.nosotros') }}">nosotros</a></li>
                <li class="{{ request()->is('artista*') ? 'active responsive-menu-item' : 'responsive-menu-item' }}"><a href="{{ route('home.artistas') }}">artistas</a></li>
                <li class="{{ request()->is('nota*') ? 'active responsive-menu-item' : 'responsive-menu-item' }}"><a href="{{ route('home.notas') }}">notas</a></li>
                <li class="{{ request()->is('evento*') ? 'active responsive-menu-item' : 'responsive-menu-item' }}"><a href="{{ route('home.eventos') }}">eventos</a></li>
                <li class="{{ request()->is('tienda*') || request()->is('producto*') ? 'active responsive-menu-item' : 'responsive-menu-item' }}"  ><a href="{{ route('home.tienda') }}">tienda</a></li>
                <li class="{{ request()->is('contacto') ? 'active responsive-menu-item' : 'responsive-menu-item' }}"><a href="{{ route('home.contact') }}">contacto</a></li>
              </ul>
            </div>
            <div class="col-md-3 ecommerce-menu">
              <ul class="responsive-menu">
                <!--li class="responsive-menu-item"><a href="#"><i class="fa fa-search"></i></a></li-->
                <!--li class="responsive-menu-item"><a href="#"><i class="fa fa-user"></i></a></li-->
                <li class="responsive-menu-item">
                    <div class="dropdown">
                      <span id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                          <i class="fa fa-user"></i>
                      </span>
                      <div class="dropdown-menu bg-inverse" aria-labelledby="dropdownLogin" style="border-radius: 0;">
                        @if(auth('boda')->check() || auth()->check())
                          <a href="{{ route('customer.info') }}" class="dropdown-item dropdown-i-i">Cuenta</a>
                          <a href="{{ route('home.logout') }}" class="dropdown-item dropdown-i-i">Salir</a>
                        @else
                          <a href="{{ route('home.login') }}" class="dropdown-item dropdown-i-i">Ingresar</a>
                        @endif
                      </div>
                    </div>
                </li>
                @if(!auth('boda')->check())
                <!--<li class="responsive-menu-item" ><a data-toggle="modal" data-target="#exampleModal" href="#">
                  <i class="fa fa-shopping-cart"></i><span class="ajax_cart_quantity"></span></a>
                </li>-->
                <li class="responsive-menu-item">
                  <div class="dropdown">
                    
                      <span   aria-haspopup="true" aria-expanded="false" style="color: white;">     
                        <a href="{{ route('home.cart') }}"> 
                          <i class="fa fa-shopping-cart"></i><span class="ajax_cart_quantity"></span> 
                        </a>
                      </span>
                   
                    <!--<div class="dropdown-menu bg-inverse" aria-labelledby="dropdownProduct" style="border-radius: 0;" id="cart-product">

                      @if(auth('boda')->check() || auth()->check())
                        <a href="{{ route('customer.info') }}" class="dropdown-item dropdown-i-i">Cuenta</a>
                        <a href="{{ route('home.logout') }}" class="dropdown-item dropdown-i-i">Salir</a>
                      @else
                        <a href="{{ route('home.login') }}" class="dropdown-item dropdown-i-i">Ingresar</a>
                      @endif-->
                    </div>
                  </div>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>