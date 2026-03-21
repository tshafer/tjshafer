{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ e(config('app.name', 'Site')) }} — private inbox</title>
        <link>{{ $siteUrl }}/</link>
        <description>Contact form submissions and booking requests (do not share this feed URL).</description>
        <language>en-us</language>
        <atom:link href="{{ $feedUrl }}" rel="self" type="application/rss+xml"/>
        @foreach ($items as $item)
            <item>
                <title>{{ e($item['title']) }}</title>
                <link>{{ $siteUrl }}/</link>
                <guid isPermaLink="false">{{ e($item['guid']) }}</guid>
                <pubDate>{{ $item['pubDate'] }}</pubDate>
                <description>{{ e($item['description']) }}</description>
            </item>
        @endforeach
    </channel>
</rss>
