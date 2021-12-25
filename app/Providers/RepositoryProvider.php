<?php

namespace App\Providers;

use App\Repositories\Contracts\Historic\HistoricInterface;
use App\Repositories\Orm\Historic\HistoricRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\Product\ProductInterface;
use App\Repositories\Orm\Product\ProductRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(HistoricInterface::class, HistoricRepository::class);
    }
}
