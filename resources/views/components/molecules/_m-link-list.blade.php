@if (isset($screenreaderTitle))
<h3 class="sr-only" id="{{ 'h-' .Str::slug($screenreaderTitle) }}">{{ $screenreaderTitle }}</h3>
@endif
  <ul class="m-link-list{{ (isset($variation)) ? ' '.$variation : '' }}"{!! isset($screenreaderTitle) ? ' aria-labelledby="h-' .Str::slug($screenreaderTitle) .'"' : '' !!}>
    @foreach ($links as $link)
    <li class="m-link-list__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        @if (isset($variation) && strrpos($variation, "--download"))
            <a class="m-link-list__trigger{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}" href="{{ $link['link'] }}" data-gtm-event-category="side-nav" data-gtm-event="{{ UrlHelpers::lastUrlSegment($link['link']) }}">
                <span class="m-link-list__trigger-file-name {{ $font ?? 'f-secondary' }}">
                @if (isset($link['name']))
                    {{ $link['name'] }}
                @endif
                </span>
                <span class="m-link-list__trigger-file-meta {{ $font ?? 'f-secondary' }}">
                @if (isset($link['extension']))
                    {{ strtoupper($link['extension']) }}@if (isset($link['size'])){{ ', '}}@endif
                @endif
                @if (isset($link['size']))
                    {{ $link['size'] }}
                @endif
                </span>
                <svg class="icon--download--24"><use xlink:href="#icon--download--24" /></svg>
            </a>
        @else
            @if (isset($link['href']))
            <a class="m-link-list__trigger {{ $font ?? 'f-secondary' }}{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}"{!! isset($link['embed']) ? ' data-behavior="triggerMediaModal"' : '' !!}{!! isset($link['api_model']) ? ' data-subtype="' . $link['api_model'] . '"' : '' !!} data-gtm-event-category="side-nav" data-gtm-event="{{ UrlHelpers::lastUrlSegment($link['href']) }}">
                @if (isset($link['iconBefore']) and $link['iconBefore'])<svg aria-hidden="true" class="m-link-list__icon-before icon--{{ $link['iconBefore'] }}"><use xlink:href="#icon--{{ $link['iconBefore'] }}" /></svg>@endif
                <span class="m-link-list__label"{!! (isset($link['itemprop'])) ? ' itemprop="'.$link['itemprop'].'"' : '' !!}>{!! SmartyPants::defaultTransform($link['label']) !!}</span>
                @if (isset($link['iconAfter']) and $link['iconAfter'])<svg aria-hidden="true" class="m-link-list__icon-after icon--{{ $link['iconAfter'] }}"><use xlink:href="#icon--{{ $link['iconAfter'] }}" /></svg>@endif
                @if (isset($link['embed']))<textarea style="display: none;">{!! is_array($link['embed']) ? Arr::first($link['embed']) : $link['embed'] !!}</textarea>@endif
            </a>
            @else
            <span class="m-link-list__trigger {{ $font ?? 'f-secondary' }}{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}">
                @if (isset($link['iconBefore']) and $link['iconBefore'])<svg aria-hidden="true" class="m-link-list__icon-before icon--{{ $link['iconBefore'] }}"><use xlink:href="#icon--{{ $link['iconBefore'] }}" /></svg>@endif
                <span class="m-link-list__label"{!! (isset($link['itemprop'])) ? ' itemprop="'.$link['itemprop'].'"' : '' !!}>{!! SmartyPants::defaultTransform($link['label']) !!}</span>
                @if (isset($link['iconAfter']) and $link['iconAfter'])<svg aria-hidden="true" class="m-link-list__icon-after icon--{{ $link['iconAfter'] }}"><use xlink:href="#icon--{{ $link['iconAfter'] }}" /></svg>@endif
            </span>
            @endif
            @if (isset($link['sublabel']))
                <div class="m-link-list__sublabel">{{ $link['sublabel'] }}</div>
            @endif
            @if (isset($link['links']))
                <ul class="m-link-list__sub-list">
                    @foreach ($link['links'] as $sublink)
                        <li class="m-link-list__item{{ (isset($sublink['active']) and $sublink['active']) ? ' s-active' : '' }}">
                            <a class="m-link-list__trigger {{ $sublinkFont ?? 'f-secondary' }}" href="{{ $sublink['href'] }}" data-gtm-event-category="side-nav" data-gtm-event="{{ UrlHelpers::lastUrlSegment($sublink['href']) }}"><span class="m-link-list__label">{!! SmartyPants::defaultTransform($sublink['label']) !!}</span>@if (isset($sublink['icon']) and $sublink['icon'])<svg aria-hidden="true" class="{{ $sublink['icon'] }}"><use xlink:href="#{{ $sublink['icon'] }}" /></svg>@endif</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </li>
    @endforeach
</ul>
