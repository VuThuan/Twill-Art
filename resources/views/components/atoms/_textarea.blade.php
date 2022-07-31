<span class="textarea{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            @slot('optional', $optional ?? null)
            {!! $slot !!}
        @endcomponent
    @endif
    <textarea class="f-secondary" type="{{ $type ?? 'text'}}" id="{{ $id ?? '' }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" {{ $disabled ?? '' }}>{{ $value ?? '' }}</textarea>
    @if (isset($hint))
        @component('components.blocks._text')
            @slot('tag', 'span')
            @slot('font', 'f-caption')
            {{ $hint ?? '' }}
        @endcomponent
    @endif
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
