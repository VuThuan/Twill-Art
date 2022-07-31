<form class="m-search-bar{{ (isset($variation)) ? ' '.$variation : '' }}" action="{{ $action ?? '' }}"{!! (isset($behaviors)) ? ' data-behavior="'.$behaviors.'"' : '' !!}{!! (isset($dataAttributes)) ? ' '.$dataAttributes.'' : '' !!}{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <div class="m-search-bar__inner">

        <label class="m-search-bar__label--hiden" for="{{ $name ?? '' }}">Search</label>

        <input class="f-secondary{{ (isset($value) and $value and isset($clearLink) and $clearLink) ? ' s-populated' : '' }}" id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" placeholder="{!! $placeholder ?? '' !!}" type="text" value="{{ $value ?? '' }}" autocomplete="off">

        <button class="m-search-bar__submit" type="submit" aria-label="Search"><svg aria-hidden="true" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>

        @if (isset($clearLink))
        <a class="m-search-bar__clear" href="{{ $clearLink }}" aria-label="Clear search"><svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--close" /></svg></a>
        @endif

        @if (isset($behaviors) && strrpos($behaviors, "autocomplete") > -1)
        <button class="m-search-bar__clear" aria-label="Clear search" data-autocomplete-clear>
            <svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--close" /></svg>
        </button>
        @endif

        <span class="m-search-bar__loader"></span>

        @if (isset($hiddenFields))
            @foreach ($hiddenFields as $name => $value)
                <input name="{{ $name }}" type="hidden" value="{{ $value }}">
            @endforeach
        @endif

    </div>


    @if (isset($limit) && $limit)
    <span class="checkbox f-secondary">
        <input type="checkbox" value="{{ request()->url() }}" id="limit-search" data-behavior="limitSearch">
        <span class="f-secondary">
            @php
                $limitTo = request()->segment(count(request()->segments()));
                $limitTo = Str::title(str_replace('-', ' ', $limitTo));
                if ($limitTo == 'Artists') {
                    $limitTo = 'Artists/Cultures';
                }
            @endphp
            <label for="limit-search">Limit my search to {{ $limitTo }}</label>
        </span>
    </span>
    @endif

</form>
