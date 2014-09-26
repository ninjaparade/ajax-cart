<?php  namespace Ninjaparade\Cart;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //register cart
        $this->app->register('Cartalyst\Cart\Laravel\CartServiceProvider');
        AliasLoader::getInstance()->alias('Cart', 'Cartalyst\Cart\Laravel\Facades\Cart');

        //register converter
        $this->app->register('Cartalyst\Converter\Laravel\ConverterServiceProvider');
        AliasLoader::getInstance()->alias('Converter', 'Cartalyst\Converter\Laravel\Facades\Converter');
    }

    public function boot()
    {

    }
}