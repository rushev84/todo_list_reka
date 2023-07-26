<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Item;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\View\Components\Image as ImageComponent;


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
        $item->preview_image = 'grey.jpg';
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTag(Request $request): JsonResponse
    {
        $itemId = $request->input('itemId');
        $tagId = $request->input('tagId');

        $item = Item::find($itemId);
        $item->tags()->detach($tagId);

        return response()->json(['success' => true]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTag(Request $request): JsonResponse
    {
        $itemId = $request->input('itemId');
        $tagId = $request->input('tagId');

        $item = Item::find($itemId);
        $item->tags()->attach($tagId);

        return response()->json(['success' => true]);
    }

    public function addImage($id, Request $request): JsonResponse
    {
        if ($request->hasFile('fileInput')) {
            $file = $request->file('fileInput');

            // Генерируем уникальное имя для файла
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Сохраняем файл в папке storage/app/public/images
            $filePath = $file->storeAs('public/images', $fileName);

            // Формируем ссылку на сохраненный файл - /storage/images/filename.jpg
            $url = Storage::url($filePath);

            // Создание превью
            // создаём превьюшку типа Intervention Image
            $preview = Image::make($file)
                ->fit(70, 70, function ($constraint) {
                $constraint->upsize();
            });

            $previewFileName = 'preview_' . $fileName;

            $previewPath = storage_path('app/public/images/' . $previewFileName);
            $preview->save($previewPath);

            // Находим нужный item и присваиеваем ему нужные значения полей
            $item = Item::find($id);
            $item->preview_image = $previewFileName;
            $item->image = $fileName;
            $item->save();

            $html = Blade::renderComponent(new ImageComponent($item));

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id): JsonResponse
    {
        $item = Item::find($id);
        $item->preview_image = 'grey.jpg';
        $item->image = 'grey.jpg';
        $item->save();

        $html = Blade::renderComponent(new ImageComponent($item));

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
