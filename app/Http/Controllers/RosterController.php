<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;
use Illuminate\Support\Facades\Auth;

class RosterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rosters = $user->rosters;

        return view('roster.index', [
            'rosters' => $rosters,
        ]);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');

        $user = Auth::user();

        $roster = new Roster;
        $roster->user_id = $user->id;
        $roster->name = $name;
        $roster->save();

        // Возвращаем успешный ответ с идентификатором новой записи
        return response()
            ->json([
                'success' => true,
                'rosterId' => $roster->id,
            ])
            ->header('Content-Type', 'application/json');
    }

    public function update(Request $request)
    {
        $rosterId = $request->input('rosterId');
        $newText = $request->input('newText');

        $roster = Roster::find($rosterId);
        $roster->name = $newText;
        $roster->save();

        return response()
            ->json([
                'success' => true,
            ])
            ->header('Content-Type', 'application/json');
    }

    public function show($id)
    {
        $roster = Roster::find($id);
        $items = $roster->items;

        $user = Auth::user();
        $userTags = $user->tags;

        return view('roster.show', [
            'roster' => $roster,
            'items' => $items,
            'userTags' => $userTags,
        ]);
    }

    public function delete(Request $request)
    {
        $rosterId = $request->input('rosterId');

        $roster = Roster::find($rosterId);
        $roster->delete();

        return response()
            ->json([
                'success' => true,
            ])
            ->header('Content-Type', 'application/json');
    }

}
