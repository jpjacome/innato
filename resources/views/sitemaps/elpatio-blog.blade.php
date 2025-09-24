<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($posts as $post)
  <url>
    <loc>{{ url('/elpatio/blog/' . $post->slug) }}</loc>
    <lastmod>{{ $post->updated_at->tz('UTC')->format('Y-m-d\TH:i:s\Z') }}</lastmod>
  </url>
@endforeach
</urlset>
