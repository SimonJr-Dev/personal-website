<?php

namespace App\Providers;

use App\Support\SiteContent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The footer shows the role line the admin edits, on every public page.
        View::composer('partials.footer', function ($view) {
            $view->with('site', SiteContent::all());
        });
    }
}
