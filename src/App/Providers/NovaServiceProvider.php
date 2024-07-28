<?php

namespace App\Providers;

use App\Nova\Brand;
use App\Nova\Client;
use App\Nova\Job;
use App\Nova\Model;
use App\Nova\Photo;
use App\Nova\Role;
use App\Nova\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {

            $menuSections = [
                MenuSection::make('Models', [
                    MenuItem::resource(Model::class),
                    MenuItem::resource(Tag::class),
                    MenuItem::resource(Photo::class),
                ])->icon('user')->collapsable(),

                MenuSection::make('Work', [
                    MenuItem::resource(Brand::class),
                    MenuItem::resource(Client::class),
                    MenuItem::resource(Job::class),
                    MenuItem::resource(Role::class),
                ])->icon('document-text')->collapsable(),
            ];

            return $menuSections;
        });

        Nova::footer(function ($request) {
            return Blade::render('');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
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
