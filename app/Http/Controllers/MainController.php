<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        if (true) {
            return redirect()->route('rosters.index');
        }

        return redirect()->route('login');
    }
}
