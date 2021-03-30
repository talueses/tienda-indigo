<div id="m_newsletter_indigo" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-newsletter newsletter">
		<div class="modal-content border-0 rounded-0 p-4">

				<button type="button" style="right: 25px;position: absolute;top: 15px;" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>

				<div class="modal-header border-bottom-0">
					<h4 class="mb-0">Suscríbete a nuestro<br> newsletter</h4>
				</div>
				<div class="modal-body pt-2">

					{{--<img src="{{url('http://localhost:8000/uploads/exhibitions/48ad623aea3e0c7275b73413cc122ffa.jpg')}}" class="img-fluid">--}}

					<div class="mt-2 mb-4">
						<p id="newsletter_subs_default">&iquest;Quieres saber m&aacute;s de nuestros eventos y noticias?<br>
	          Ingresa tu correo:</p>
					</div>

					<div class="text-center mb-3">
						<i class="far fa-envelope-open fa-4x text-muted newsletter-b-success" style="display:none"></i>

						<i class="fas fa-exclamation-circle fa-4x text-danger newsletter-b-error" style="display:none;"></i>
					</div>

					<p id="newsletter_subs_body" class="text-center"></p>

					<input type="text" class="form-control" id="inp_name_newsletter" name="name_newsletter" placeholder="Nombres y apellidos" style="height: 40px;border-radius: 0;"><br>

					<div id="newsletter_subs_form" class="input-group">
						<div class="input-group-prepend">
							<span class="fa fa-envelope text-dark"></span>
						</div>
						<input type="email" class="form-control pl-0" id="inp_newsletter" name="newsletter" placeholder="email@ejemplo.com" style="height: auto;">
						<div id="newsletter_subs" class="input-group-append pl-2 pr-2"> <span class="pt-2">Suscríbete</span>  <span class="fa fa-arrow-right"></span></div>
					</div>

				</div>

		</div>
	</div>
</div>
