<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Roster;

class RosterController extends Controller
{
    public function index()
    {
        $rosters = $this->user->rosters;

        return view('roster.index', [
            'rosters' => $rosters,
        ]);
    }

    public function create(Request $request)
    {
        $name = $request->input('name');

        $roster = new Roster;
        $roster->user_id = $this->user->id;
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

    public function show($id, Request $request)
    {
        $roster = Roster::find($id);
        $userTags = $this->user->tags;

        // если в get-запросе есть параметры для поиска
        if ($request) {
            $searchText = $request->input('searchText');

            $items = Item::where('roster_id', $id)
                ->where('name', 'like', '%' . $searchText . '%')
                ->get();
        }

        else {
            $items = $roster->items;
        }

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
