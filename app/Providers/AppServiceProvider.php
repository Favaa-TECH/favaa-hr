<?php

namespace App\Providers;

use App\Models\Leave;
use App\Models\Permission;
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
        View::composer('components.layouts.partials.sidenav',function($view){
            $view->with([
                'leaveCount'=> Leave::all()->where('status','pending')->count(),
                'permissionCount' => Permission::all()->where('status','pending')->count(),
            ]);
        });
    }
}
