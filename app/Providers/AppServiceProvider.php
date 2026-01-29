<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Blade;
use App\Models\Menu;
use App\Models\Requisition;
use App\Observers\RequisitionObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\FileLoader;
use App\Services\CustomTranslationLoader;
use App\Services\MenuService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Nothing related to translator here ✅
    }

    public function boot()
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        \URL::forceRootUrl(config('app.url'));

        // Custom translation loader
        $this->app->extend('translation.loader', function ($loader, $app) {
            return new CustomTranslationLoader($app['files'], $app['path.lang']);
        });

        /**
         * Register Requisition Observer
         */
        Requisition::observe(RequisitionObserver::class);

        /**
         * Sidebar menus
         */
        // view()->composer(
        //     ['admin.dashboard.dashboard', 'admin.dashboard.common.sidebar'],
        //     function ($view) {
        //         $sidebar_menus = Menu::orderBy('id', 'ASC')
        //             ->where('menu_parent', 0)
        //             ->get();

        //         $view->with('sidebar_menus', $sidebar_menus);
        //     }
        // );
        
        View::composer(
                'admin.dashboard.common.sidebar',
                function ($view) {
                    $view->with('sidebar_menus', MenuService::sidebar());
                }
            );

                View::composer('admin.dashboard.dashboard',
                function ($view) {
                    $view->with('sidebar_menus', MenuService::sidebar());
                }
            );

        /**
         * Settings
         */
        view()->composer(
            ['admin.dashboard.common.header', 'admin.dashboard.common.sidebar'],
            function ($view) {
                $settings = DB::table('settings')->where('id', 1)->first();
                $view->with('settings', $settings);
            }
        );

        /**
         * Mail theme
         */
        Config::set('mail.markdown.theme', 'default');
        Config::set('mail.markdown.paths', [resource_path('views/vendor/mail')]);

        /**
         * RTL / LTR helpers
         */
        Blade::if('rtl', function () {
            return session('direction', 'ltr') === 'rtl';
        });

        Blade::if('ltr', function () {
            return session('direction', 'ltr') === 'rtl';
        });
    }
}
