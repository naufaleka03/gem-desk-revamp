<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('role', function ($roles){
            return "<?php if(auth()->check() && auth()->user()->roles === $roles): ?>";
        });

        Blade::directive('endrole', function (){
            return '<?php endif; ?>';
        });
        
        Paginator::useBootstrap();
    }
}
