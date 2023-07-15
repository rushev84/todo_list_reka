<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Roster;
use App\Models\Item;

class RosterController extends Controller
{
    /**
     * @return Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $rosters = $this->user->rosters;

        return view('roster.index', [
            'rosters' => $rosters,
        ]);
    }

    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Contracts\View\View
     */
    public function show($id, Request $request): View
    {
        $roster = Roster::find($id);

        $items = [];

        if ($request->has('searchText') || $request->has('tag')) {
            $searchText = $request->input('searchText');
            $tags = $request->input('tag');

            $query = Item::where('roster_id', $id);

            // Фильтрация по текстовому поиску
            if (!empty($searchText)) {
                $query->where('name', 'like', '%' . $searchText . '%');
            }

            // Фильтрация по выбранным тегам
            if (!empty($tags)) {
                $query->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('id', $tags);
                });
            }

            $items = $query->get();
        }

        else {
            $items = $roster->items;
        }

        return view('roster.show', [
            'roster' => $roster,
            'items' => $items,
            'userTags' => $this->user->tags,
        ]);
    }

    // AJAX

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
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
