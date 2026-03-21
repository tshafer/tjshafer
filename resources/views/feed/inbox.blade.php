{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ e(config('app.name', 'Site')) }} — private inbox</title>
        <link>{{ $siteUrl }}/</link>
        <description>Contact form submissions and booking requests (do not share this feed URL).</description>
        <language>en-us</language>
        <lastBuildDate>{{ $lastBuildDate }}</lastBuildDate>
        <atom:link href="{{ $feedUrl }}" rel="self" type="application/rss+xml"/>
        @foreach ($items as $item)
            <item>
                <title>{{ e($item['title']) }}</title>
                {{-- Unique link per item (query avoids readers that mishandle fragment-only URLs) --}}
                <link>{{ $siteUrl }}/?inbox={{ rawurlencode($item['guid']) }}</link>
                <guid isPermaLink="false">{{ e($item['guid']) }}</guid>
                <pubDate>{{ $item['pubDate'] }}</pubDate>
                <description>{{ e($item['description']) }}</description>
            </item>
        @endforeach
    </channel>
</rss>
