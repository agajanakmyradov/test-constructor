<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   $tests = Test::paginate(20);
        return view('index', compact('tests'));
    }
}
