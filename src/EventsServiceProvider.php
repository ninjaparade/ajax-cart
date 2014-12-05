<?php  namespace Ninjaparade\Cart;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class EventsServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    
    }

    public function boot()
    {
        $this->app['events']->subscribe(get_class(app('Ninjaparade\Cart\Handlers\PromocodeHandler')));
    }
}