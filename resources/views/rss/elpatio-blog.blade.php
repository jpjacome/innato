<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
  <channel>
    <title>El Patio Blog</title>
    <link>{{ url('/elpatio/blog') }}</link>
    <description>Latest posts from El Patio</description>
    @foreach($posts as $post)
      <item>
        <title>{{ $post->title }}</title>
        <link>{{ url('/elpatio/blog/' . $post->slug) }}</link>
        <guid>{{ url('/elpatio/blog/' . $post->slug) }}</guid>
        <pubDate>{{ $post->published_at ? $post->published_at->toRfc822String() : $post->created_at->toRfc822String() }}</pubDate>
        <description><![CDATA[{!! $post->excerpt ?? '' !!}]]></description>
      </item>
    @endforeach
  </channel>
</rss>
