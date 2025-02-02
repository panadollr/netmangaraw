<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Ophim\Core\Models\Setting;
use Ophim\Core\Models\Taxonomy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $env = config('app.env');
        if ($env !== 'local') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('frontend-web.partials.header', function ($view) {
            $headerGenres = Taxonomy::where('type', 'genre')
                ->orderBy('name', 'asc')
                ->get();

            $view->with('headerGenres', $headerGenres);
        });

        View::composer('frontend-web.partials.notification', function ($view) {
            $notification =  Setting::where('key', 'notifications')->value('value');

            $view->with('notification', $notification);
        });

        View::composer('frontend-web.partials.footer', function ($view) {
            $footerGenres =
                Taxonomy::where("type", 'genre')
                ->orderBy('name', 'asc')
                ->get();

            $view->with('footerGenres', $footerGenres);
        });
    }
}
