<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Item;

class ItemController extends Controller
{
    // AJAX

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): JsonResponse
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
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

    public function deleteTag(Request $request)
    {
        $itemId = $request->input('itemId');
        $tagId = $request->input('tagId');

        $item = Item::find($itemId);
        $item->tags()->detach($tagId);

        return response()->json(['success' => true]);
    }

    public function addTag(Request $request)
    {
        $itemId = $request->input('itemId');
        $tagId = $request->input('tagId');
//
        $item = Item::find($itemId);
        $item->tags()->attach($tagId);

        return response()->json(['success' => true]);
    }

}
