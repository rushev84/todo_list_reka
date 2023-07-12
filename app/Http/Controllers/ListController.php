<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoList;

class ListController extends Controller
{
    public function show($id)
    {
        $list = TodoList::find($id);
        dd($list->items);
        return view('list.show');
    }
}
