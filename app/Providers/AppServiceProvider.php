<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use Bootstrap for pagination
        Paginator::useBootstrap();

        // Share categories with all views
        try {
            $categories = ProductCategory::where('is_active', true)
                ->orderBy('name')
                ->get();

            View::share('categories', $categories);
        } catch (\Exception $e) {
            // Handle case where table might not exist yet (during migrations)
            View::share('categories', collect([]));
        }
    }
}
