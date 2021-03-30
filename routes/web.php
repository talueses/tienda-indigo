<?php

Route::get('/test','TestController@test');


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Frontend Routes
Route::get('/','HomeController@index')->name('index');
Route::get('/terminos-y-condiciones','HomeController@terminos')->name('terminos');
Route::get('/politicas-de-devolucion','HomeController@devoluciones')->name('devoluciones');
Route::get('/politicas-de-privacidad-y-confidencialidad','HomeController@privacidad')->name('privacidad');
Route::get('/nosotros', 'HomeController@nosotros')->name('home.nosotros');
Route::get('/artistas', 'HomeController@artistas')->name('home.artistas');
Route::get('/artista/{slug}', 'HomeController@artista')->name('home.artista.detail');
Route::get('/notas', 'HomeController@notas')->name('home.notas');
Route::get('/notas/{slug}', 'HomeController@nota')->name('home.nota.detail');

Route::get('/obras', 'HomeController@obras')->name('home.obras');
Route::get('/obras/{slug}', 'HomeController@obra')->name('home.obra.detail');
Route::get('/eventos', 'HomeController@eventos')->name('home.eventos');
Route::get('/eventos/{slug}', 'HomeController@evento')->name('home.evento.detail');


Route::get('/tienda', 'TiendaController@index')->name('home.tienda');
Route::get('/producto/{slug}', 'TiendaController@producto')->name('home.tienda.producto');
Route::post('/producto/getstock', 'TiendaController@getStockProducto');
Route::post('/producto/getStockProductoCart', 'TiendaController@getStockProductoCart');
Route::post('/api/producto/getstock', 'TiendaController@getStockProductoAPI');


Route::post('/programa-de-regalos/getqtyneeded', 'GiftRegistryController@getQuantityNeeded');
Route::post('/programa-de-regalos/getproductstock', 'GiftRegistryController@getMyGiftLists');
Route::post('/programa-de-regalos/lista/addproduct', 'GiftRegistryController@addProduct')->name('home.novios.addproduct');
Route::get('/programa-de-regalos/preview/{id}', 'GiftRegistryController@preview')->name('listaregalo.preview');

Route::post('/programa-de-regalos/finalizarlista', 'GiftRegistryController@endlist')->name('saveList');
Route::post('/programa-de-regalos/cancelarcalculolista', 'GiftRegistryController@cancelCalcList')->name('cancelCalcList');


Route::get('/cart', 'TiendaController@cart')->name('home.cart');

 
Route::post('/shopcartinfo', 'CartController@getContents')->name('cart.info');
Route::get('/cartcheckout', 'CartController@checkout')->name('cart.checkout');

Route::post('/verifyauthstock', 'TiendaController@verifyAuthAndStock')->name('cart.verifyauth');
Route::post('/getorderdetails', 'OrdenController@getOrderPaymDetails');

Route::get('/contacto', 'HomeController@showContact')->name('home.contact');
Route::post('/contacto', 'HomeController@contact');

Route::post('/newsletter/subscribe', 'HomeController@newsletter');

//User
Route::get(	'/cuenta', 		'User\CustomerController@account')->name('customer.info');
Route::get(	'/login', 		'User\CustomerController@showLogin')->name('home.login');
Route::post('/login', 		'User\CustomerController@login');
Route::get(	'/logout', 		'Auth\LoginController@logout')->name('home.logout');
Route::get(	'/register', 	'User\CustomerController@showRegister')->name('customer.register');
Route::post('/register', 	'Auth\RegisterController@registerClient');
Route::post('/generateorder', 'CheckoutController@generateOrder')->name('order.generateorder');

Route::group(['middleware' => 'auth'], function() {
	Route::post('/ordercharge', 'CheckoutController@store');
	Route::post('/cuenta/ordenes/detalle/{id}/charge', 'CheckoutController@storeOrder')->name('cuenta.orden.charge');
	Route::post('/refundorder', 'CheckoutController@refund');
	Route::get('/cuenta/ordenes', 'User\CustomerController@showOrders')->name('cuenta.ordenes');
	Route::get('/cuenta/ordenes/detalle/{id}', 'User\CustomerController@showDetalleOrden')->name('cuenta.orden.detalle');
	Route::post('/cuenta/updtdetails', 'User\CustomerController@updateDetails')->name('cuenta.updtdetails');
	Route::get('/cuenta/changepw', 'User\CustomerController@showChangePassword')->name('cuenta.changepw');
	Route::post('/cuenta/changepw', 'User\CustomerController@changePassword');
});

// Passwords
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestFormClient')->name('customer.password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmailClient')->name('customer.password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetFormClient')->name('customer.password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

//Admin
Route::get('/programa-de-regalos', 'GiftRegistryController@index')->name('home.giftregistry');
Route::post('/programa-de-regalos/lista/update-password', 'User\WeddingController@updatePassword')->name('giftregistry.updatepassword');
Route::get('/programa-de-regalos/listas', 'GiftRegistryController@listas')->name('giftregistry.lists');
Route::post('/programa-de-regalos/listas/sendconfirmation', 'ListaRegaloAuth\ResetPasswordController@confirmAccount')->name('giftregistry.confirmaccount');
Route::get('/programa-de-regalos/listas/nuevo', 'GiftRegistryController@showNewList')->name('giftregistry.newlist');
Route::post('/programa-de-regalos/listas/crear', 'GiftRegistryController@createList')->name('giftregistry.createlist');
//
Route::get('/programa-de-regalos/lista/detalle/{codigo}', 'GiftRegistryController@showList')->name('giftregistry.showList');
Route::delete('/programa-de-regalos/lista/deleteimg/{id}', 'GiftRegistryController@removeImage')->name('giftregistry.removeimage');
Route::put('/programa-de-regalos/lista/{codigo}', 'GiftRegistryController@updateList')->name('home.novios.update');
Route::get('/programa-de-regalos/lista', 'GiftRegistryController@searchList')->name('home.novios.search');

Route::delete('/programa-de-regalos/lista/removeproduct', 'GiftRegistryController@removeProduct')->name('home.novios.removeproduct');

Route::post('/programa-de-regalos/register', 'User\WeddingController@register')->name('home.novios.register');
Route::get('/programa-de-regalos/activate', 'User\WeddingController@activate');
Route::post('/programa-de-regalos/login', 'User\WeddingController@login')->name('home.novios.login');
Route::get('/programa-de-regalos/logout', 'User\WeddingController@logout')->name('home.novios.logout');


Route::namespace('Admin')->group(function () {
	Route::namespace('Countries')->group(function () {
		Route::get('/api/countries', 'CountryController@getAll');
		Route::post('/api/countries/limametropolitana', 'CountryController@belongsToLimaMetropolitana');
	});
});

//Backend Routes
Route::group(['middleware' => 'admin'], function() {
	Route::namespace('Admin')->group(function () {
		//Dashboard
		Route::namespace('Dashboard')->group(function () {
			Route::get('/admin', 'DashboardController@index')->name('admin');
			Route::post('/admin/general', 'DashboardController@generalSetting')->name('admin.general');

			//About Us
			Route::post('/admin/nosotros', 'DashboardController@postAboutUs')->name('admin.aboutus');
			Route::get('/admin/nosotros', 'DashboardController@getAboutUs')->name('admin.aboutus');
			Route::delete('/admin/nosotros/img', 'DashboardController@deleteAboutUsImage')->name('admin.aboutus.deleteImage');
		});

		//Items
		Route::namespace('Items')->group(function () {
			//Categories
			Route::get('/admin/items/categories', 'CategoryController@index')->name('admin.categories');
			Route::get('/admin/items/categories/create', 'CategoryController@create')->name('admin.category.create');
			Route::post('/admin/items/categories', 'CategoryController@store')->name('admin.category.store');
			Route::put('/admin/items/categories/{id}', 'CategoryController@update')->name('admin.category.update');
			Route::get('/admin/items/categories/{id}/edit', 'CategoryController@edit')->name('admin.category.edit');
			Route::delete('/admin/items/categories/{id}', 'CategoryController@destroy')->name('admin.category.destroy');

			//Materials
			Route::get('/admin/items/materials', 'MaterialController@index')->name('admin.materials');
			Route::get('/admin/items/materials/create', 'MaterialController@create')->name('admin.material.create');
			Route::post('/admin/items/materials', 'MaterialController@store')->name('admin.material.store');
			Route::put('/admin/items/materials/{id}', 'MaterialController@update')->name('admin.material.update');
			Route::get('/admin/items/materials/{id}/edit', 'MaterialController@edit')->name('admin.material.edit');
			Route::delete('/admin/items/materials/{id}', 'MaterialController@destroy')->name('admin.material.destroy');

			//Types Products / Artworks
			Route::get('/admin/items/types', 'TypeController@index' )->name('admin.types');
			Route::get('/admin/items/types/create', 'TypeController@create')->name('admin.type.create');
			Route::post('/admin/items/types', 'TypeController@store')->name('admin.type.store');
			Route::put('/admin/items/types/{id}', 'TypeController@update')->name('admin.type.update');
			Route::get('/admin/items/types/{id}/edit', 'TypeController@edit')->name('admin.type.edit');
			Route::delete('/admin/items/types/{id}', 'TypeController@destroy')->name('admin.type.destroy');
		});

		//Artists
		Route::namespace('Artists')->group(function () {
			Route::get('/admin/artists', 'ArtistController@index')->name('admin.artists');
			Route::get('/admin/artists/create', 'ArtistController@create')->name('admin.artist.create');
			Route::post('/admin/artists', 'ArtistController@store')->name('admin.artist.store');
			Route::put('/admin/artists/{id}', 'ArtistController@update')->name('admin.artist.update');
			Route::get('/admin/artists/{slug}/edit', 'ArtistController@edit')->name('admin.artist.edit');
			Route::delete('/admin/artists/{id}', 'ArtistController@destroy')->name('admin.artist.destroy');
			Route::delete('/admin/artists/coverimg/{id}', 'ArtistController@removeCoverImage')->name('admin.artist.removeCoverImage');
		});

		//Artworks
		Route::namespace('Artworks')->group(function () {
			Route::get('/admin/artworks', 'ArtworkController@index')->name('admin.artworks');
			Route::get('/admin/artworks/create', 'ArtworkController@create')->name('admin.artwork.create');
			Route::post('/admin/artworks', 'ArtworkController@store')->name('admin.artwork.store');
			Route::put('/admin/artworks/{id}', 'ArtworkController@update')->name('admin.artwork.update');
			Route::get('/admin/artworks/{slug}/edit', 'ArtworkController@edit')->name('admin.artwork.edit');
			Route::delete('/admin/artworks/{id}', 'ArtworkController@destroy')->name('admin.artwork.destroy');
			Route::get('/admin/artworks/{id}/duplicate/', 'ArtworkController@duplicate')->name('admin.artwork.duplicate');

			Route::post('/admin/artworks/replicateproduct', 'ArtworkController@replicateProduct')->name('admin.artwork.replicate');
			Route::post('/admin/artworks/syncproduct', 'ArtworkController@syncproductProduct')->name('admin.artwork.syncproduct');

			Route::put('/admin/artworks/galleryimage/savegallery/{id}', 'ArtworkController@saveGallery')->name('admin.artwork.saveGallery');
			Route::post('/admin/artworks/galleryimage/updateposition/{id}', 'ArtworkController@updateGalleryPosition');
			Route::delete('/admin/artworks/galleryimage/{img}', 'ArtworkController@deleteGalleryImage')->name('admin.artwork.destroy.galleryimage');
		});


		//Products
		Route::namespace('Products')->group(function () {
			Route::get('/admin/products', 'ProductController@index')->name('admin.products');
			Route::get('/admin/products/{id}/edit', 'ProductController@edit')->name('admin.product.edit');
			Route::get('/admin/products/export', 'ProductController@export')->name('admin.product.export');
		});

		//Descuentos
		Route::namespace('Descuentos')->group(function () {
			Route::resource('/admin/descuentos','DescuentosController',  ['as' => 'admin']);
			Route::get('/descuentos/sincroniza', 'DescuentosController@sincronizaDescuentos')->name('admin.descuentos.sincroniza');
			Route::get('/descuentos/cancel/{id}', 'DescuentosController@cancelDescuento')->name('admin.descuentos.cancel');
		});
	

		//Countries
		Route::namespace('Countries')->group(function () {
			Route::get('/admin/countries', 'CountryController@index')->name('admin.countries');
			Route::post('/admin/countries', 'CountryController@store')->name('admin.countries.store');
			Route::get('/admin/countries/create', 'CountryController@create')->name('admin.countries.create');
			Route::get('/admin/countries/{id}/edit', 'CountryController@edit')->name('admin.countries.edit');
			Route::put('/admin/countries/{id}', 'CountryController@update')->name('admin.countries.update');
			Route::delete('/admin/countries/{id}', 'CountryController@destroy')->name('admin.countries.destroy');
		});


		//Gift Registry
		Route::namespace('GiftRegistry')->group(function () {

			Route::get('/admin/giftregistry', 'GiftRegistryController@index')->name('admin.giftregistry');
			Route::get('/admin/giftregistry/editing', 'GiftRegistryController@edition')->name('admin.giftregistry.edition');
			Route::get('/admin/giftregistry/calculating', 'GiftRegistryController@calculating')->name('admin.giftregistry.calculating');
			Route::get('/admin/giftregistry/tracking', 'GiftRegistryController@tracking')->name('admin.giftregistry.tracking');
			Route::get('/admin/giftregistry/finished', 'GiftRegistryController@finished')->name('admin.giftregistry.finished');			
			Route::post('/admin/giftregistry/description', 'GiftRegistryController@updateDescription')->name('admin.giftregistry.description');
			Route::get('/admin/giftregistry/lists/{id}', 'GiftRegistryController@listsById')->name('admin.giftregistry.lists');
			Route::get('/admin/giftregistry/createlist/{id}', 'GiftRegistryController@showCreateList')->name('admin.giftregistry.create');
			Route::post('/admin/giftregistry/storelist/{id}', 'GiftRegistryController@storeList')->name('admin.giftregistry.storeList');
			Route::get('/admin/giftregistry/list/{code}', 'GiftRegistryController@showList')->name('admin.giftregistry.showList');
			Route::put('/admin/giftregistry/list/{code}', 'GiftRegistryController@updateList')->name('admin.giftregistry.updateList');
			Route::delete('/admin/giftregistry/list/img/{id}', 'GiftRegistryController@removeImage')->name('admin.giftregistry.removeImage');

			Route::get('/admin/giftregistry/list/exportAccountList/{code}', 'GiftRegistryController@exportAccountAndList')->name('admin.giftregistry.exportAcountList');
			Route::get('/admin/giftregistry/list/export/{code}', 'GiftRegistryController@exportGiftList')->name('admin.giftregistry.exportGiftList');
			
			Route::post('/programa-de-regalos/getstocklist', 'GiftRegistryController@getProductStockList')->name('admin.giftregistry.stockList');

			Route::post('/admin/giftregistry/list/updatepassword', 'GiftRegistryController@updatePassword')->name('admin.giftregistry.updatePassword');
			Route::post('/admin/giftregistry/list/updateshipcost', 'GiftRegistryController@updateShipcost')->name('admin.giftregistry.updateShipcost');
			Route::post('/admin/giftregistry/list/deleteshipcost', 'GiftRegistryController@deleteShipcost')->name('admin.giftregistry.deleteShipcost');
			Route::post('/admin/giftregistry/list/updatetracking', 'GiftRegistryController@updateTracking')->name('admin.giftregistry.updateTracking');
			Route::post('/admin/giftregistry/list/deletetracking', 'GiftRegistryController@deleteTracking')->name('admin.giftregistry.deleteTracking');

			Route::post('/admin/giftregistry/createActivatedRegalosUser', 'GiftRegistryController@createActivatedRegalosUser')->name('admin.giftregistry.createActivatedRegalosUser');

		});

	});

	//Tienda - Programa Regalos
	Route::post('/admin/weddinglists/update/dsct', 'ListaRegaloController@updateDscto');
	Route::delete('/admin/weddinglists/list', 'ListaRegaloController@removeList')->name('weddinglist.remove');

	//Tienda - Productos
	Route::get('/admin/products/create', 'ProductoController@create')->name('product.create');
	Route::post('/admin/products', 'ProductoController@store')->name('product.store');
	Route::put('/admin/products/{id}', 'ProductoController@update')->name('product.update');
	Route::delete('/admin/products/{id}', 'ProductoController@destroy')->name('product.destroy');
	Route::post('/admin/products/galleryimage/updateposition/{id}', 'ProductoController@updateGalleryPosition');
	Route::get('/admin/products/{id}/duplicate/', 'ProductoController@duplicate')->name('product.duplicate');
	Route::put('/admin/products/galleryimage/savegallery/{id}', 'ProductoController@saveGallery')->name('product.saveGallery');
	Route::delete('/admin/products/galleryimage/{img}', 'ProductoController@deleteGalleryImage')->name('product.destroy.galleryimage');


	//Admin
	Route::post('/admin/video/upload', 'AdminController@uploadVideo')->name('home.uploadvideo');
	Route::delete('/admin/video/{id}', 'AdminController@destroyVideo')->name('home.destroyvideo');
	Route::post('/admin/slider', 'AdminController@createSlider')->name('home.addslide');
	Route::delete('/admin/slider/{id}', 'AdminController@destroySlider')->name('home.destroyslide');
	Route::put('/admin/slider/{id}', 'AdminController@updateSlider')->name('home.updateslide');
	Route::put('/admin/home/image', 'AdminController@updateHomeImage')->name('home.updatehomeimage');


	//Ordenes
	Route::get('/admin/orders', 'OrdenController@index' )->name('admin.orders');
	Route::get('/admin/orders/pending', 'OrdenController@pending' )->name('admin.orders.pending');
	Route::get('/admin/orders/calculating', 'OrdenController@calculating' )->name('admin.orders.calculating');
	Route::get('/admin/orders/tracking', 'OrdenController@tracking' )->name('admin.orders.tracking');
	Route::get('/admin/orders/paid', 'OrdenController@paid' )->name('admin.orders.paid');
	Route::get('/admin/orders/create', 'OrdenController@create')->name('admin.order.create');
	Route::put('/admin/orders/{id}', 'OrdenController@update')->name('admin.order.update');
	Route::get('/admin/orders/detail/{id}', 'OrdenController@show')->name('admin.order.show');
	Route::post('/admin/orders/imprimir', 'OrdenController@imprimir')->name('admin.order.imprimir');
	Route::post('/admin/orders/cancel', 'OrdenController@showCancelOrder')->name('admin.ordenes.cancelOrder');

	Route::get('/admin/orders/export', 'OrdenController@export')->name('admin.order.export');
	Route::get('/admin/orders/export/pending', 'OrdenController@exportPending')->name('admin.order.export.pending');
	Route::get('/admin/orders/export/calculating', 'OrdenController@exportCalculating')->name('admin.order.export.calculating');
	Route::get('/admin/orders/export/tracking', 'OrdenController@exportTracking')->name('admin.order.export.tracking');
	Route::get('/admin/orders/export/paid', 'OrdenController@exportPaid')->name('admin.order.export.paid');
	Route::post('/admin/orders/{id}/updateshipcost', 'OrdenController@updateShipCost')->name('admin.order.updateShipCost');
	Route::post('/admin/orders/{id}/updatetracking', 'OrdenController@updateTracking')->name('admin.order.updateTracking');
	Route::post('/cancelorder/{id}', 'OrdenController@cancelOrder')->name('admin.order.cancel');
	Route::post('/markdelivery/{id}', 'OrdenController@markDelivered')->name('admin.order.delivered');

	//Tienda - Pagos

	//Eventos
	Route::get('/admin/events', 'ExposicionController@index')->name('exhibitions');
	Route::get('/admin/events/create', 'ExposicionController@create')->name('exhibition.create');
	Route::post('/admin/events', 'ExposicionController@store')->name('exhibition.store');
	Route::put('/admin/events/{id}', 'ExposicionController@update')->name('exhibition.update');
	Route::get('/admin/events/{slug}/edit', 'ExposicionController@edit')->name('exhibition.edit');
	Route::delete('/admin/events/{id}', 'ExposicionController@destroy')->name('exhibition.destroy');
	Route::delete('/admin/events/img/{id}', 'ExposicionController@removeImage')->name('exhibition.removeImage');

	//image uploader
	Route::post('/admin/events/img/uploadimages', 'AdminController@uploadImageTextarea');
	Route::post('/admin/events/vid/uploadvideos', 'AdminController@uploadVideoTextarea');
	Route::put('/admin/events/galleryimage/savegallery/{id}', 'ExposicionController@saveGallery')->name('exhibition.saveGallery');
	Route::delete('/admin/events/galleryimage/{img}', 'ExposicionController@deleteGalleryImage')->name('exhibition.destroy.galleryimage');
	Route::post('/admin/events/galleryimage/updateposition/{id}', 'ExposicionController@updateGalleryPosition');

	//Notas
	Route::get('/admin/notes', 'NotaController@index')->name('notes');
	Route::get('/admin/notes/create', 'NotaController@create')->name('notes.create');
	Route::post('/admin/notes', 'NotaController@store')->name('notes.store');
	Route::put('/admin/notes/{id}', 'NotaController@update')->name('notes.update');
	Route::get('/admin/notes/{id}/edit', 'NotaController@edit')->name('notes.edit');
	Route::delete('/admin/notes/{id}', 'NotaController@destroy')->name('notes.destroy');

	Route::post('/admin/notes/galleryimage/updateposition/{id}', 'NotaController@updateGalleryPosition');
	Route::put('/admin/notes/galleryimage/savegallery/{id}', 'NotaController@saveGallery')->name('note.saveGallery');
	Route::delete('/admin/notes/galleryimage/{img}', 'NotaController@deleteGalleryImage')->name('note.destroy.galleryimage');


	//Newsletter
	Route::get('/admin/newsletter', 'NewsletterController@index')->name('newsletter');
	Route::get('/admin/newsletter/subscribe', 'NewsletterController@subscribe');
	Route::get('/admin/newsletter/export', 'NewsletterController@export')->name('newsletter.export');


	//Terminos Condiciones
	Route::get('/admin/terminos-y-condiciones', 'TerminosCondicionesController@index')->name('admin.terminosycondiciones');
	Route::get('/admin/terminos-y-condiciones/{name}', 'TerminosCondicionesController@edit')->name('admin.terminosycondiciones.edit');
	Route::post('/admin/terminos-y-condiciones', 'TerminosCondicionesController@store');
});


// Authentication Routes...
Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@login');
Route::post('/admin/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('/admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/admin/register', 'Auth\RegisterController@registerAdmin');

// Password Reset Routes...
Route::get('/admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/admin/password/reset', 'Auth\ResetPasswordController@reset');

// Password Reset Lista Regalo
Route::get('/programa-de-regalos/password/reset', 'ListaRegaloAuth\ForgotPasswordController@showLinkRequestForm')->name('listaregalo.password.request');
Route::post('/programa-de-regalos/password/email', 'ListaRegaloAuth\ForgotPasswordController@sendResetLinkEmail')->name('listaregalo.password.email');
Route::get('/programa-de-regalos/password/reset/{token}', 'ListaRegaloAuth\ResetPasswordController@showResetForm')->name('listaregalo.password.reset');
Route::post('/programa-de-regalos/password/reset', 'ListaRegaloAuth\ResetPasswordController@reset');
