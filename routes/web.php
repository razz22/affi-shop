<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroBannerController as AdminHeroBannerController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Temporary cache-clear / diagnostics route (no SSH access on host)
| Remove this once the site is confirmed working.
|--------------------------------------------------------------------------
*/

Route::get('/fix', function () {
    $results = [];
    foreach (['config:clear', 'cache:clear', 'route:clear', 'view:clear', 'event:clear', 'optimize:clear'] as $command) {
        try {
            Artisan::call($command);
            $results[$command] = trim(Artisan::output()) ?: 'OK';
        } catch (\Throwable $e) {
            $results[$command] = 'ERROR: '.$e->getMessage();
        }
    }

    $dbStatus = 'not tested';
    try {
        DB::connection()->getPdo();
        $dbStatus = 'Connected OK to database "'.DB::connection()->getDatabaseName().'"';
    } catch (\Throwable $e) {
        $dbStatus = 'FAILED: '.$e->getMessage();
    }

    $diagnostics = [
        'PHP Version' => PHP_VERSION,
        'Laravel Version' => app()->version(),
        'APP_ENV' => config('app.env'),
        'APP_DEBUG' => config('app.debug') ? 'true' : 'false',
        'APP_URL' => config('app.url'),
        'Database' => $dbStatus,
        'storage/framework/views writable' => is_writable(storage_path('framework/views')) ? 'yes' : 'NO — fix permissions',
        'storage/framework/cache writable' => is_writable(storage_path('framework/cache')) ? 'yes' : 'NO — fix permissions',
        'storage/logs writable' => is_writable(storage_path('logs')) ? 'yes' : 'NO — fix permissions',
        'bootstrap/cache writable' => is_writable(base_path('bootstrap/cache')) ? 'yes' : 'NO — fix permissions',
        'public/build/manifest.json exists' => file_exists(public_path('build/manifest.json')) ? 'yes' : 'NO — assets not built/uploaded',
        'PUBLIC_UPLOADS_PATH' => config('filesystems.disks.public.root'),
        'PUBLIC_UPLOADS_URL' => config('filesystems.disks.public.url'),
    ];

    $html = '<html><head><title>Fix / Diagnostics</title></head><body style="font-family: monospace; padding: 2rem; background:#111; color:#eee;">';
    $html .= '<h2>Cache clear results</h2><pre>';
    foreach ($results as $cmd => $result) {
        $html .= htmlspecialchars($cmd).': '.htmlspecialchars($result)."\n";
    }
    $html .= '</pre><h2>Diagnostics</h2><pre>';
    foreach ($diagnostics as $label => $value) {
        $html .= htmlspecialchars($label).': '.htmlspecialchars((string) $value)."\n";
    }
    $html .= '</pre></body></html>';

    return response($html);
});

/*
|--------------------------------------------------------------------------
| Public storefront routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/deals', [DealController::class, 'index'])->name('deals');
Route::get('/best-sellers', [ProductController::class, 'bestsellers'])->name('bestsellers');
Route::get('/new-arrivals', [ProductController::class, 'newArrivals'])->name('new-arrivals');
Route::get('/popular', [ProductController::class, 'popular'])->name('popular');
Route::get('/gift-cards', [ProductController::class, 'giftCards'])->name('gift-cards');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brand/{brand}', [BrandController::class, 'show'])->name('brand.show');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::get('/go/{product}', [RedirectController::class, 'go'])->name('go');

/*
|--------------------------------------------------------------------------
| Admin authentication
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('login');
Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('brands', AdminBrandController::class)->except('show');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::resource('banners', AdminHeroBannerController::class)->except('show');

    Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy'])
        ->name('products.images.destroy');
    Route::patch('products/{product}/images/{image}/primary', [ProductImageController::class, 'primary'])
        ->name('products.images.primary');
});
