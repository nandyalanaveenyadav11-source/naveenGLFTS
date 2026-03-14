<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCertification
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cargoType = $request->input('cargo_type');
        $driverId = $request->input('driver_id');

        if ($cargoType === 'Hazardous' && $driverId) {
            $driver = \App\Models\Driver::find($driverId);
            if (!$driver || strtolower($driver->certification_level) !== 'hazardous') {
                return response()->json(['error' => 'Driver lacks required certification for Hazardous cargo.'], 403);
            }
        }

        return $next($request);
    }
}
