<style>
    .google-maps {
        position: fixed !important;
        /*position: relative;*/
        padding-bottom: 75%;
        height: 0;
        overflow: hidden;
    }
    .google-maps iframe {
        position: fixed !important;
/*|        position: absolute;*/
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>
<footer>
  <div class="container-fluid">
    <div class="row">

      <div class="col-12 newsletter-b">

        <form action="/" method="post">

        <div class="row justify-content-center align-items-center">

          <div class="col-lg-auto text-center">
            <h4 class="title-block" style="padding-top: 7px;padding-bottom: 7px;padding-left: 40px;">Newsletter</h4>
            <h5 class="mt-2" style="letter-spacing: initial;font-size: 0.8em;">&iquest;Quieres saber m&aacute;s de nuestros<br> eventos y noticias?</h5>
          </div>

          <div class="col-lg-3 pr-lg-0 mb-2 mb-lg-0 mt-2 mt-lg-0">
            <input type="text" class="form-control mx-0" placeholder="Nombres y apellidos" id="inp_name_newsletter_pre_footer" name="name_newsletter" style="line-height: 1.5;border-width: 0;padding: 11.2px 8px;border-radius: 0;height: 40px;">
          </div>

          <div class="col-lg-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="fa fa-envelope"></span>
                </div>
                <input type="email" class="form-control pl-0" id="inp_newsletter_pre_footer" name="newsletter" placeholder="email@ejemplo.com">
                <div id="newsletter_subs_pre_footer" class="input-group-append pl-2 pr-2"> <span class="pt-2">Suscrí­bete</span>  <span class="fa fa-arrow-right"></span></div>
              </div>
          </div>
        </div>
        </form>
      </div>

      <div class="col-12 footing pb-3">
        <div class="container">
          <div class="row pt-3">

            <div class="col-lg-3 col-md-3 col-xs-3 m-0 p-0"> <!-- 1 -->
              <div class="row col-md-12">
                @foreach($generales as $general)
                  <div class="col-md-12">
                    <h4 class="text-capitalize">{{ $general->nombre }}:</h4>
                    <p class="mt-0">{!! $general->valor !!}</p>
                  </div>
                @endforeach
              </div>

            </div>

            <div class="col-lg-3 col-md-3 col-xs-3 m-0 p-0"> <!-- 2 -->

                <div class="row">
                  <div class="col-lg-5 col-md-5 col-xs-5">
                      <b>Indigo</b>
                      <ul class="list-unstyled">
                        <li><a href="{{ route('home.nosotros') }}" class="text-light" target="_blank"><small>Nosotros</small></small></a></li>
                        <li><a href="{{ route('home.artistas') }}" class="text-light" target="_blank"><small>Artistas</small></a></li>
                        <li><a href="{{ route('home.notas') }}" class="text-light" target="_blank"><small>Notas</small></a></li>
                        <li><a href="{{ route('home.eventos') }}" class="text-light" target="_blank"><small>Eventos</small></a></li>
                        <li><a href="{{ route('home.giftregistry') }}" class="text-light" target="_blank"><small>Regalos</small></a></li>
                        <li><a href="{{ route('home.tienda') }}" class="text-light" target="_blank"><small>Tienda</small></a></li>
                        <li><a href="{{ route('home.contact') }}" class="text-light" target="_blank"><small>Contacto</small></a></li>
                      </ul>
                  </div>

                  <div class="col-lg-6 col-md-6 col-xs-6 mr-0 ml-0 pl-0">
                    <b>Legal</b>
                    <ul class="list-unstyled">
                      <li><a href="{{ route('terminos') }}" class="text-light" target="_blank"><small>Términos y Condiciones de Uso</small></a></li>
                      <li><a href="{{ route('privacidad') }}" class="text-light" target="_blank"><small>Políticas de Privacidad y Confidencialidad</small></a></li>
                      <li><a href="{{ route('devoluciones') }}" class="text-light" target="_blank"><small>Políticas de Devoluciones</small></a></li>
                    </ul>
                  </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-6 col-xs-6 m-0 p-0">

                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-0 pl-5">
                      <b>Visitanos</b><br>
                      <small>Av. El Bosque 260 y 263, San Isidro.</small>

                      <br><br>
                      <b>Hablemos</b>
                      <ul class="list-unstyled">
                        <li><small>(+511) 440-3099</small></li>
                        <li><small>(+511) 421-2428</small></li>
                        <li><small>(+511) 441-2232</small></li>
                      </ul>
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mr-0 ml-0 pl-0">
                      <ul class="list-unstyled list-socials">
                        @foreach($socials as $social)
                        <li class="list-socials-item {{$social->nombre}}">
                          <a href="{{ $social->valor }}" target="_blank"><i class="fab {{ 'fa-'.$social->nombre }}"></i></a>
                        </li>
                        @endforeach
                      </ul>
                  <div id="map" style="width:100%;height:100%;"></div>
                  </div>
                </div>
            </div>
          </div>

          <div class="row text-center">
            <div class="col-12 pt-3">
              <a class="_blank" href="#" target="_blank" style="color: #a5a5a5;font-size: 0.88em;">© {{ date('Y') }} - Galeria Indigo</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</footer>