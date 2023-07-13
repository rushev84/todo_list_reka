<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;

class RosterController extends Controller
{
    public function index()
    {
        $rosters = Roster::all();

        return view('roster.index', [
            'rosters' => $rosters,
        ]);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');

        $roster = new Roster;
        // TODO!!!
        $roster->user_id = 1;
        $roster->name = $name;
        $roster->save();

        // Возвращаем успешный ответ с идентификатором новой записи
        return response()
            ->json(['success' => true, 'id' => $roster->id])
            ->header('Content-Type', 'application/json');
    }

    public function show($id)
    {
        $roster = Roster::find($id);
        $items = $roster->items;

        return view('roster.show', [
            'roster' => $roster,
            'items' => $items,
        ]);
    }

    public function delete(Request $request)
    {
        $rosterId = $request->input('rosterId');

        $roster = Roster::find($rosterId);
        $roster->delete();

        return response()
            ->json(['success' => true])
            ->header('Content-Type', 'application/json');
    }

}
