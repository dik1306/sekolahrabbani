<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Increment visitor count in database or cache
        //  $position = Location::get();
         
        //  $add_user = Visitor::create([
        //     'ip_address' => request()->ip(),
        //     'user_agent' => request()->userAgent(),
        //     'location' => $position->cityName,
        //     'created_at' => now()
        //  ]);
         return $next($request);
    }

    private function incrementVisitorCount()
    {
        //Database version
         $visitorCount = DB::table('t_visitors')->increment('id');
    }
}
