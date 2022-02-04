<?php

namespace App\Providers;

use App\Shortcodes\ProductBrands;
use App\Shortcodes\ProductDiscount;
use App\Shortcodes\Productofferday;
use App\Shortcodes\ProductShortcode;
use Illuminate\Support\ServiceProvider;
use Vedmant\LaravelShortcodes\Facades\Shortcodes;

class ShortcodesServiceProvider extends ServiceProvider
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
        Shortcodes::add('sp', ProductShortcode::class);
        Shortcodes::add('pd', ProductDiscount::class);
        Shortcodes::add('brd', ProductBrands::class);
        Shortcodes::add('offer', Productofferday::class);
    }
}
