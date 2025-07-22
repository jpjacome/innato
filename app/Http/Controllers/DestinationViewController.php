<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationViewController extends Controller
{
    /**
     * Display a specific destination page
     */
    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $destinations = Destination::where('status', 'active')
            ->orderBy('title')
            ->get();

        return view('single-page-destination', compact('destination', 'destinations'));
    }
    
    /**
     * Display all destinations index
     */
    public function index()
    {
        $destinations = Destination::where('status', 'active')
            ->orderBy('title')
            ->get();
            
        return view('destinations-index', compact('destinations'));
    }
}
