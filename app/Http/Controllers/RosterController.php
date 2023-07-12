<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;

class RosterController extends Controller
{
    public function show($id)
    {
        $roster = Roster::find($id);
        dd($roster->items);
        return view('list.show');
    }
}
