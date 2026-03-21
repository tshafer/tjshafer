{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Tom Shafer — Writing</title>
        <link>{{ $siteUrl }}/writing</link>
        <description>Dev log and notes from tjshafer.com</description>
        <language>en-us</language>
        <atom:link href="{{ $siteUrl }}/feed.xml" rel="self" type="application/rss+xml"/>
        @foreach ($posts as $post)
            <item>
                <title>{{ $post['title'] }}</title>
                <link>{{ $siteUrl }}/writing/{{ $post['slug'] }}</link>
                <guid isPermaLink="true">{{ $siteUrl }}/writing/{{ $post['slug'] }}</guid>
                <pubDate>{{ \Illuminate\Support\Carbon::parse($post['date'])->timezone('America/Phoenix')->format('r') }}</pubDate>
                <description>{{ e($post['excerpt'] ?? \Illuminate\Support\Str::limit(strip_tags($post['body']), 280)) }}</description>
            </item>
        @endforeach
    </channel>
</rss>
