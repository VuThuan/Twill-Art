<{{ $tag ?? 'li' }} class="m-listing m-listing--keyline-top{{ (isset($variation)) ? ' '.$variation : '' }}">
    <div class="m-listing__meta">
        @component('components.atoms._date')
            @slot('tag','p')
            {!! $item->present()->time !!}
        @endcomponent
        @component('components.atoms._title')
            @slot('tag','h4')
            @slot('font','f-list-3')
            {!! $item->present()->title !!}
        @endcomponent
        @if (isset($item->blurb))
            @if (Str::startsWith($item->blurb, '<p'))
                {!! str_replace('<p>', '<p class="f-body">', $item->present()->blurb) !!}
            @else
                <p class="f-body">{!! $item->present()->blurb !!}</p>
            @endif
        @endif
    </div>
    @if ($item->image)
        <div class="m-listing__img">
            @component('components.atoms._img')
                @slot('image', $item->image)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        </div>
    @endif
</{{ $tag ?? 'li' }}>
