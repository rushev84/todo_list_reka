<a
    class="
        @if ($type === 'delete')
            delete-image
        @else
            add-image
        @endif
        "

    data-item-id="{{ $itemId }}">

    <i class="fas
        @switch($type)
            @case('add')
                fa-plus
                @break
            @case('update')
                fa-sync-alt
                @break
            @case('delete')
                fa-trash text-danger
            @break
        @endswitch
        extra-small"></i>
</a>

