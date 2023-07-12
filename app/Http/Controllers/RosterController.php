<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;

class RosterController extends Controller
{
    public function show($id)
    {
        $roster = Roster::find($id);
        $items = $roster->items;
        return view('roster.show', [
            'roster' => $roster,
            'items' => $items,
        ]);
    }

}
