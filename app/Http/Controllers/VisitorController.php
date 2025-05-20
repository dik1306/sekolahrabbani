<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorPPDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_phone = Auth::user()->no_hp;

        $visitor = Visitor::all();
        $visitor_ppdb = VisitorPPDB::all();
        $count_visitor = $visitor->count();
        $count_visitor_ppdb = $visitor_ppdb->count();


        $visitor_by_location = Visitor::select('ip_address', 'location', DB::raw('count(location) as total'))
                ->groupby('location')
                ->orderby('total', 'desc')
                ->get();

        $visitor_ppdb_by_location = VisitorPPDB::select('ip_address', 'location', DB::raw('count(location) as total'))
        ->groupby('location')
        ->orderby('total', 'desc')
        ->get();

        return view('admin.laporan.visitor', compact('visitor', 'count_visitor', 'count_visitor_ppdb', 'visitor_by_location',
                    'visitor_ppdb_by_location'));
        
    }
}
