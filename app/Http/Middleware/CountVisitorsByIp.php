<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CountVisitorsByIp
{
    public function handle($request, Closure $next)
    {
        $ip = \Request::getClientIp(true);



        // Check if the IP address exists in the visitors table
        $visitor = DB::table('visitors')->where('ip_address', $ip)->first();

        // If the IP address does not exist, add a new record

        if (!$visitor) {
            DB::table('visitors')->insert([
                'ip_address' => $ip,
                'count' => 1,
            ]);
        }

        // If the IP address exists, increment the count
        else {

                DB::table('visitors')->where('ip_address', $ip)->increment('count');

        }

        return $next($request);
    }
}
