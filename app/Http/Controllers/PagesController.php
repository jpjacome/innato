<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display the Pages page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.pages.index');
    }
}
