<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // get all data from menu.json file
        // $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/verticalMenu.json'));
        // $verticalMenuData = json_decode($verticalMenuJson);

        // menu user
        $verticalMenuJsonU = file_get_contents(base_path('resources/data/menu-data/verticalMenuUser.json'));
        $verticalMenuDataU = json_decode($verticalMenuJsonU);
        // menu admin
        $verticalMenuJsonA = file_get_contents(base_path('resources/data/menu-data/verticalMenuAdmin.json'));
        $verticalMenuDataA = json_decode($verticalMenuJsonA);
        
        // $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
        // $horizontalMenuData = json_decode($horizontalMenuJson);

        // Share all menuData to all the views
        View::share('menuData',[$verticalMenuDataU, $verticalMenuDataA]);
    }
}
