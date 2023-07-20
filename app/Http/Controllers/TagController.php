<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Roster;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * @return Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $tags = $this->user->tags;

        return view('tag.index', [
            'tags' => $tags,
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

        $tag = new Tag();
        $tag->user_id = $this->user->id;
        $tag->name = $name;
        $tag->save();

        // Возвращаем успешный ответ с идентификатором новой записи
        return response()
            ->json([
                'success' => true,
                'tagId' => $tag->id,
            ])
            ->header('Content-Type', 'application/json');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $tagId = $request->input('tagId');

        $tag = Tag::find($tagId);
        $tag->delete();

        return response()
            ->json([
                'success' => true,
            ])
            ->header('Content-Type', 'application/json');
    }
}
