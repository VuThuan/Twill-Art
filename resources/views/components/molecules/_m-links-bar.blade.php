@php
    $linksPrimaryFontClass = ' f-link';
    $isTabs = (isset($variation) and $variation === 'm-links-bar--tabs');
    $linksPrimaryFontClass = (isset($variation) and ($variation === 'm-links-bar--buttons' or $variation === 'm-links-bar--title-bar-companion')) ? ' btn f-buttons' : $linksPrimaryFontClass;
    $linksPrimaryFontClass = ($isTabs) ? ' f-module-title-2' : $linksPrimaryFontClass;
    $linksSecondaryFontClass = ($isTabs) ? ' f-link' : $linksPrimaryFontClass;
    $activePrimaryLink = false;
    $headingId = "h-visit-nav";
    if (isset($linksPrimary)) {
        for ($i = 0; $i < count($linksPrimary); $i++) {
            if (isset($linksPrimary[$i]['active']) && $linksPrimary[$i]['active']) {
                $activePrimaryLink = $i;
            }
            if ($i == 0) {
                $headingId .= '-' .Str::kebab($linksPrimary[$i]['label']);
            }
        }
    }
    $behavior = isset($behavior) ?? null;
    if (isset($overflow) and $overflow) {
        $behavior .= ' linksBar';
    }
@endphp
<nav class="m-links-bar{{ (isset($variation) and $variation) ? " ".$variation : "" }}"{!! (isset($behavior)) ? ' data-behavior="'.$behavior.'"' : '' !!}{!! (isset($dataAttributes)) ? ' '.$dataAttributes.'' : '' !!}{!! (isset($id) and $id) ? ' id="'.$id.'"' : '' !!} aria-label="page{!! (isset($isPrimaryPageNav)) ? '' : ' secondary' !!}">
  @if ((isset($linksPrimary) and $linksPrimary) or (isset($primaryHtml) and $primaryHtml))
    <h2 class="sr-only" id="{{ $headingId }}">Page {!! (isset($isPrimaryPageNav)) ? '' : 'secondary ' !!}navigation</h2>
    <ul class="m-links-bar__items-primary{{ (isset($primaryVariation) and $primaryVariation) ? ' '.$primaryVariation : '' }}" data-links-bar-primary aria-labelledby="{{ $headingId }}">
      @if (isset($linksPrimary) and $linksPrimary)
          @foreach ($linksPrimary as $link)
          <li class="m-links-bar__item{{ (isset($link['liVariation']) and $link['liVariation']) ? ' '.$link['liVariation'] : '' }}{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
              <a class="m-links-bar__item-trigger{{ $linksPrimaryFontClass }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}" {!! (isset($link['loadMoreUrl']) and $link['loadMoreUrl']) ? 'data-behavior="loadMore" data-load-more-url="'. $link['loadMoreUrl'] .'"' : '' !!} {!! (isset($link['loadMoreTarget']) and $link['loadMoreTarget']) ? 'data-load-more-target="'. $link['loadMoreTarget'] .'"' : '' !!}{!! (isset($link['loadMoreLimitText']) and $link['loadMoreLimitText']) ? 'data-load-more-limit-text="'. $link['loadMoreLimitText'] .'"' : '' !!}{!! (!empty($link['ajaxScrollTarget'])) ? ' data-ajax-scroll-target="'.$link['ajaxScrollTarget'].'"' : '' !!}{!! (!empty($link['ajaxTabTarget'])) ? ' data-ajax-tab-target="'.$link['ajaxTabTarget'].'"' : '' !!}{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}>
                @if (isset($link['icon']) and $link['icon'] and isset($variation) and $variation === 'm-links-bar--buttons')<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
                {!! $link['label'] !!}
                @if (isset($link['icon']) and $link['icon'] and (!isset($variation) or $variation !== 'm-links-bar--buttons'))<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
              </a>
          </li>
          @endforeach
          @if (isset($overflow) and $overflow)
          <li class="m-links-bar__item m-links-bar__item--push m-links-bar__item--overflow s-hidden" data-links-bar-primary-overflow>
              @component('components.atoms._dropdown')
                @slot('prompt', ($isTabs && $activePrimaryLink > -1 ? $linksPrimary[$activePrimaryLink]['label'] : "More"))
                @slot('ariaTitle', 'More links')
                @slot('variation','dropdown--filter dropdown--tabs'.(!$isTabs ? ' f-link' : ''))
                @slot('font', $linksPrimaryFontClass)
                @slot('options', $linksPrimary)
              @endcomponent
          </li>
          @endif
      @endif
      @if (isset($primaryHtml) and $primaryHtml)
          {{ $primaryHtml }}
      @endif
    </ul>
  @endif
  @if ((isset($linksSecondary) and $linksSecondary) or (isset($secondaryHtml) and $secondaryHtml))
    <ul class="m-links-bar__items-secondary{{ (isset($secondaryVariation) and $secondaryVariation) ? ' '.$secondaryVariation : '' }}">
      @if (isset($linksSecondary) and $linksSecondary)
          @foreach ($linksSecondary as $link)
          <li class="m-links-bar__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
              <a class="m-links-bar__item-trigger{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : $linksSecondaryFontClass }}" href="{{ $link['href'] }}"{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}>{!! $link['label'] !!}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a>
          </li>
          @endforeach
      @endif
      @if (isset($secondaryHtml) and $secondaryHtml)
          {{ $secondaryHtml }}
      @endif
    </ul>
  @endif
</nav>
