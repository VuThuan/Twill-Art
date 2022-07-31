<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8" standalone="no" ?>'.PHP_EOL
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    @foreach($meta as $key => $metaItem)
        @if($key === 'link')
            <{{ $key }}>{{ url($metaItem) }}</{{ $key }}>
            <atom:link href="{{ url($metaItem) }}" rel="self" type="application/rss+xml" />
        @elseif($key === 'title')
            <{{ $key }}><![CDATA[{{ $metaItem }}]]></{{ $key }}>
        @elseif($key === 'updated')
            <pubDate>{{ \Carbon\Carbon::parse($metaItem)->toRssString() }}</pubDate>
        @elseif($key === 'id')

        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif
    @endforeach
    @foreach($items as $item)
        <item>
            <title><![CDATA[{{ $item->title }}]]></title>
            <link>{{ url($item->link) }}</link>
            <guid>{{ url($item->link) }}</guid>
            {{-- WEB-2245: Does `author` ever return anything? --}}
            <dc:creator>{{ $item->author }}</dc:creator>
            <description>
                <![CDATA[{!! $item->summary !!}]]>
            </description>
            @if($item->__isset('enclosure'))
                <enclosure url="{{ url($item->enclosure) }}" length="{{ $item->enclosureLength }}" type="{{ $item->enclosureType }}" />
            @endif
            <pubDate>{{ $item->updated->toRssString() }}</pubDate>
            @foreach($item->category as $category)
            <category type="html">
                <![CDATA[{!! $category !!}]]>
            </category>
            @endforeach
        </item>
    @endforeach
</channel>
</rss>
