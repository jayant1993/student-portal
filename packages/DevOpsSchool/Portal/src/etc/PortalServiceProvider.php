<?php

namespace Portal\etc;

use Illuminate\Support\ServiceProvider;

class PortalServiceProvider extends ServiceProvider
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