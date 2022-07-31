<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}" itemscope itemtype="http://schema.org/VisualArtsEvent">
    <a href="{{ route('events.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
            @if ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @component('components.molecules._m-listing-video')
                    @slot('item', $item)
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
        <span class="m-listing__meta">
            @if (!request('type'))
                @if ($item->is_member_exclusive)
                    @component('components.atoms._type')
                        @slot('variation', 'type--membership')
                        Member Exclusive
                    @endcomponent
                @elseif ($item->audience === \App\Models\Event::LUMINARY)
                    @component('components.atoms._type')
                        @slot('variation', 'type--membership')
                        Luminary
                    @endcomponent
                @else
                    @component('components.atoms._type')
                        @if (method_exists($item, 'present'))
                            {{ $item->present()->type }}
                        @else
                            {{ $item->type }}
                        @endif
                    @endcomponent
                @endif
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-4')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            @if (!empty($item->list_description))
                <br>
                @component('components.atoms._short-description')
                    {!! $item->present()->list_description !!}
                @endcomponent
            @endif
            <br>
            <span class="m-listing__meta-bottom">
                @component('components.atoms._date')
                    @if (isset($showDateWithTime) && $showDateWithTime)
                        {!! $item->present()->formattedNextOcurrence !!}
                    @else
                        {!! $item->present()->nextOcurrenceTime !!}
                    @endif
                @endcomponent

                @switch ($item->present()->ticketStatus)
                    @case('sold-out')
                        <br>
                        @component('components.atoms._tag')
                            @slot('variation','tag--tertiary')
                            @slot('tag','span')
                            Sold Out
                        @endcomponent
                        @break
                    @case('free')
                        <br>
                        @component('components.atoms._tag')
                            @slot('variation','tag--primary')
                            @slot('tag','span')
                            Free
                        @endcomponent
                        @break
                    @case('register')
                        <br>
                        @component('components.atoms._tag')
                            @slot('variation','tag--secondary')
                            @slot('tag','span')
                            Registration Required
                        @endcomponent
                        @break
                    @case('rsvp')
                        <br>
                        @component('components.atoms._tag')
                            @slot('variation','tag--secondary')
                            @slot('tag','button')
                            @slot('behavior', 'getUrl')
                            @slot('dataAttributes', 'data-href="'. $item->rsvp_link .'"')
                            RSVP
                        @endcomponent
                        @break
                    @case('buy-ticket')
                        <br>
                        @component('components.atoms._tag')
                            @slot('variation','tag--secondary')
                            @slot('tag','button')
                            @slot('behavior', 'getUrl')
                            @slot('dataAttributes', 'data-href="'. $item->buy_tickets_link .'"')
                            {!! !empty($item->buy_button_text) ? $item->present()->buy_button_text : 'Buy ticket' !!}
                        @endcomponent
                        @break
                @endswitch
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
