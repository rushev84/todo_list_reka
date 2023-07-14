<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        $itemInput = $request->input('itemInput');
        $rosterId = $request->input('rosterId');

        $item = new Item;
        $item->name = $itemInput;
        $item->roster_id = $rosterId;
        $item->save();

        // Возвращаем успешный ответ с идентификатором новой записи
        return response()
            ->json([
                'success' => true,
                'itemId' => $item->id,
            ])
            ->header('Content-Type', 'application/json');
    }


    public function update(Request $request)
    {
        $itemId = $request->input('itemId');
        $newText = $request->input('newText');

        $item = Item::find($itemId);
        $item->name = $newText;
        $item->save();

        return response()
            ->json([
                'success' => true,
            ])
            ->header('Content-Type', 'application/json');
    }

    public function delete(Request $request)
    {
        $itemId = $request->input('itemId');

        $item = Item::find($itemId);
        $item->delete();

        return response()
            ->json([
                'success' => true,
            ])
            ->header('Content-Type', 'application/json');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('searchQuery');
        $rosterId = $request->input('rosterId');

        // Выполняем поиск элементов в базе данных на основе поискового запроса и rosterId
        $items = Item::where('roster_id', $rosterId)
            ->where('name', 'like', '%' . $searchQuery . '%')
            ->get();

        return response()
            ->json([
                'success' => true,
                'items' => $items,
            ])
            ->header('Content-Type', 'application/json');
    }

}
