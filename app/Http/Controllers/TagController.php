<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function delete(Request $request)
    {
//        $itemId = $request->input('itemId');
//        $tagId = $request->input('tagId');
//
//        dd($itemId);
//
//        $item = Item::find($itemId);
//        $item->tags()->detach($tagId);

        return response()->json(['success' => true]);
    }

}
