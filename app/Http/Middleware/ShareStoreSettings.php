<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\StoreSettings;

class ShareStoreSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $settings = new StoreSettings();
        $settings = $settings->findOrCreate();
        View::share('storeSettings', $settings);
        return $next($request);
    }
}
