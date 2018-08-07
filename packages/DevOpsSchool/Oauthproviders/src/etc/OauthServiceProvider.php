<?php

namespace Oauthproviders\etc;

use Illuminate\Support\ServiceProvider;

class OauthServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}