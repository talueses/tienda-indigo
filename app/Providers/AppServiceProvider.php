<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);

        Carbon::setLocale('es');

        try {

              $socials = \App\General::whereIn('nombre', ['facebook','instagram','twitter','tripadvisor'])->whereNotNull('valor')->get();
              \View::share('socials', $socials);

              $generales = \App\General::whereIn('nombre', ['telefonos','direccion','horarios','free_delivery'])
                      ->whereNotNull('valor')->get();

              foreach ($generales as $general) {

                switch ($general->nombre) {
                  case 'telefonos':
                    $general->nombre = 'Teléfonos';
                    break;

                  case 'direccion':
                    $general->nombre = 'Dirección';
                    break;

                  case 'free_delivery':
                    $general->nombre = 'Free Delivery';
                    break;
                }

              }

              \View::share('generales', $generales);

        } catch (\Exception $e) {

            return [];

        }



        if (!Collection::hasMacro('paginate')) {
          # code...
          Collection::macro('paginate', function ($perPage = 12, $page = null, $options = [])
          {
            # code...
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
            return (new LengthAwarePaginator($this->forPage($page,$perPage),$this->count(), $perPage, $page, $options))
            ->withPath('');
          });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
