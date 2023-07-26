<li class="list-group-item d-flex align-items-center justify-content-between">
    <div class="imgcont">
        <x-image :item="$item" id="image-{{ $item->id }}"/>
    </div>

    <div style="flex-grow: 1; padding-left: 10px" class="editable" data-item-id="{{ $item->id }}">{{ $item->name }}</div>
    <div class="tags-container d-flex align-items-center">
        <div class="tags mr-20">
            @foreach($item->tags as $tag)
                <span class="badge bg-info" id="{{ $tag->id }}">{{ $tag->name }}&nbsp;<i class="fas fa-times delete-tag"></i></span>
            @endforeach
            <span class="badge bg-primary plus-tag"><i class="fas fa-plus"></i></span>
        </div>
        <div class="tag-list-container" style="display: none;">
            <ul class="tag-list">
                @foreach($userTags as $userTag)
                    <li id="{{ $userTag->id }}" class="add-tag">{{ $userTag->name }}</li>
                @endforeach
            </ul>
        </div>
        <div style="margin-left: 5px">
            <button class="btn btn-secondary edit-btn">Переименовать</button>
            <button class="btn btn-dark save-btn d-none">Сохранить</button>
            <button class="btn btn-success delete-btn" data-item-id="{{ $item->id }}">Выполнено!</button>
        </div>
    </div>
</li>
