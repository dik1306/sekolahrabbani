<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class VisitorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Get the visitor count from your database or cache
        $visitorCount = $this->getVisitorCount();

        // Share the visitor count to all views
        View::share('visitorCount', $visitorCount);
    
    }

     /**
     * Get the total visitor count.
     *
     * @return int
     */
    private function getVisitorCount()
    {
        // Replace with your actual visitor count retrieval logic
        // Example:  You could retrieve the count from a database table
        $count = DB::table('t_visitors')->count();
        return $count;
    }
}
