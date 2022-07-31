<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/Person">
    <a href="{!! route('artists.show', $item) !!}" class="m-listing__link" itemprop="url"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if ($item->imageFront('hero'))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--square' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero'))
                    @component('components.atoms._img')
                        @slot('image', $image ?? $item->imageFront('hero'))
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
                    @component('components.molecules._m-listing-video')
                        @slot('item', $item)
                        @slot('image', $image ?? null)
                    @endcomponent
                @else
                    <span class="default-img"></span>
                @endif
            </span>
        @endif
        <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {!! $item->present()->title !!}
            @endcomponent
            @if ($item->nationality or $item->birth_date or $item->death_date)
                <br>
                <span class="intro {{ $captionFont ?? 'f-secondary' }}">
                    @if ($item->nationality)
                        {!! $item->present()->nationality !!},
                    @endif
                    @if ($item->birth_date)
                        {{ $item->birth_date }}
                    @endif
                    @if ($item->birth_date and $item->death_date)
                        {{ ' – ' }}
                    @endif
                    @if ($item->death_date)
                        {{ $item->death_date }}
                    @endif
                </span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
