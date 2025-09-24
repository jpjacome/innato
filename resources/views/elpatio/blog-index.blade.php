<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>El Patio Blog</title>
  <meta name="description" content="Blog de El Patio - noticias y guías locales">
  <link rel="canonical" href="{{ url('/elpatio/blog') }}" />
  <link rel="stylesheet" href="/css/elpatio-test.css">
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Blog",
    "name": "El Patio Blog",
    "url": "{{ url('/elpatio/blog') }}"
  }
  </script>
</head>
<body>
  <header class="header">
    <a href="/elpatio" class="logo"><img src="/assets/elpatio/imgs/logo4.png" alt="El Patio"></a>
  </header>

  <main class="blog-listing">
    <h1>Blog</h1>
    <div class="posts-grid">
      @foreach($posts as $post)
        <article class="post-card">
          <a href="/elpatio/blog/{{ $post->slug }}">
            @if(!empty($post->featured_image))
              <div class="post-thumb" style="background-image:url('/storage/{{ $post->featured_image }}')"></div>
            @endif
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit($post->excerpt ?? '', 140) }}</p>
          </a>
        </article>
      @endforeach
    </div>

    <div class="pagination-wrapper">
      {{ $posts->links() }}
    </div>
  </main>
</body>
</html>
