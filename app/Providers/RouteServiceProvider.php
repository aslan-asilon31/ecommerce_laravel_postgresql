<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Users
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/User/user.php'));

                
            // Products
            Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/Routes/master_data/Product/product.php'));

            // Product Image
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Product/product_image.php'));

            // Product Detail
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Product/product_detail.php'));

            // Category
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Category/category.php'));

            // Category Detail
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Category/category_detail.php'));

            // Order
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Order/order.php'));

            // Review
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Review/review.php'));

            // Transaction
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Transaction/transaction.php'));

            // Payment
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/Routes/master_data/Payment/payment.php'));


            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
