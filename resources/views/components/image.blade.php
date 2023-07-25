<div class="imgcont">
    @if($item->preview_image === 'grey.jpg')
        <div class="image-container">
            <img src="/storage/images/{{ $item->preview_image }}" alt="" width="70" height="70" class="no-preview-image">
        </div>
        <div class="text-center d-flex justify-content-center">
            <div>
                <x-image-button type="add" :itemId="$item->id"/>
            </div>
        </div>
    @else
        <div class="image-container">
            <img src="/storage/images/{{ $item->preview_image }}" alt="" width="70" height="70" data-full-image="{{ $item->image }}" class="preview-image">
        </div>
        <div class="text-center d-flex justify-content-center">
            <div style="margin-right: 2px">
                <x-image-button type="update" :itemId="$item->id"/>
            </div>
            <div style="margin-left: 2px">
                <x-image-button type="delete" :itemId="$item->id"/>
            </div>
        </div>
    @endif
</div>
