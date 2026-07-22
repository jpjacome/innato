<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">

        <!-- Header -->
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;">
            <div>
                <h2 class="control-panel-title" style="margin-bottom:0.25rem;">
                    <i class="ph ph-newspaper"></i> Blog — El Patio Hostels
                </h2>
                <p style="opacity:0.7; font-size:0.92rem; margin:0;">Administra las entradas del blog del hostal.</p>
            </div>
            <a href="{{ route('admin.pages.create-elpatio-blog') }}" class="control-panel-button control-panel-button-primary">
                <i class="ph ph-plus-circle"></i> Nueva Entrada
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom:1rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error" style="margin-bottom:1rem;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Posts list -->
        @php $postsList = isset($posts) ? $posts : []; @endphp

        @if($postsList && count($postsList))
            <div class="blog-admin-list">
                @foreach($postsList as $post)
                    @php
                        $isPublished = !empty($post['published_at']);
                        $dateStr = $isPublished
                            ? \Carbon\Carbon::parse($post['published_at'])->format('d M Y')
                            : 'Borrador';
                    @endphp
                    <div class="blog-admin-item">
                        <!-- Thumbnail -->
                        <div class="blog-admin-thumb">
                            @if(!empty($post['featured_image']))
                                <img src="{{ asset('storage/' . $post['featured_image']) }}" alt="{{ $post['title'] }}">
                            @else
                                <div class="blog-admin-thumb-placeholder">
                                    <i class="ph ph-image" style="font-size:2rem; opacity:0.3;"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Content -->
                        <div class="blog-admin-item-content">
                            <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.25rem; flex-wrap:wrap;">
                                <h3 class="blog-admin-item-title">{{ $post['title'] }}</h3>
                                <span class="blog-status-badge {{ $isPublished ? 'published' : 'draft' }}">
                                    {{ $isPublished ? 'Publicado' : 'Borrador' }}
                                </span>
                            </div>
                            <p class="blog-admin-item-meta">
                                <i class="ph ph-calendar-blank"></i> {{ $dateStr }}
                                @if(!empty($post['slug']))
                                    &nbsp;&bull;&nbsp; <span style="font-family:monospace; font-size:0.8rem; opacity:0.6;">{{ $post['slug'] }}</span>
                                @endif
                            </p>
                            @if(!empty($post['excerpt']))
                                <p class="blog-admin-item-excerpt">{{ Str::limit($post['excerpt'], 120) }}</p>
                            @endif
                        </div>
                        <!-- Actions -->
                        <div class="blog-admin-item-actions">
                            <a href="{{ route('admin.pages.edit-elpatio-blog.edit', ['id' => $post['id']]) }}"
                               class="control-panel-button" title="Editar">
                                <i class="ph ph-pencil-simple"></i> Editar
                            </a>
                            @if($isPublished)
                                <a href="/elpatio/blog/{{ $post['slug'] ?? $post['id'] }}" target="_blank"
                                   class="control-panel-button control-panel-button-secondary" title="Ver en el sitio">
                                    <i class="ph ph-arrow-square-out"></i> Ver
                                </a>
                            @endif
                            <form action="{{ route('admin.pages.edit-elpatio-blog.destroy', ['id' => $post['id']]) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('¿Eliminar esta entrada permanentemente?')">
                                @csrf
                                @method('DELETE')
                                <button class="control-panel-button blog-btn-delete" title="Eliminar">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center; padding:3rem 1rem; opacity:0.6;">
                <i class="ph ph-newspaper" style="font-size:3.5rem; display:block; margin-bottom:0.75rem; opacity:0.4;"></i>
                <p style="font-size:1.05rem; margin-bottom:1rem;">No hay entradas todavía.</p>
                <a href="{{ route('admin.pages.create-elpatio-blog') }}" class="control-panel-button control-panel-button-primary">
                    <i class="ph ph-plus-circle"></i> Crear primera entrada
                </a>
            </div>
        @endif
    </div>

    @push('head')
    <style>
    .blog-admin-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .blog-admin-item {
        display: grid;
        grid-template-columns: 110px 1fr auto;
        gap: 1rem;
        align-items: center;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 10px;
        padding: 0.85rem 1rem;
        transition: border-color 0.2s, background 0.2s;
    }
    .blog-admin-item:hover {
        border-color: rgba(214,223,39,0.4);
        background: rgba(255,255,255,0.06);
    }
    @media (max-width: 700px) {
        .blog-admin-item { grid-template-columns: 72px 1fr; }
        .blog-admin-item-actions { grid-column: 1 / -1; display:flex; gap:0.4rem; flex-wrap:wrap; }
    }
    .blog-admin-thumb {
        width: 110px;
        height: 72px;
        border-radius: 7px;
        overflow: hidden;
        flex-shrink: 0;
        background: rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .blog-admin-thumb img { width:100%; height:100%; object-fit:cover; }
    .blog-admin-thumb-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; }
    .blog-admin-item-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.3;
    }
    .blog-admin-item-meta {
        font-size: 0.8rem;
        opacity: 0.6;
        margin: 0 0 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        flex-wrap: wrap;
    }
    .blog-admin-item-excerpt {
        font-size: 0.85rem;
        opacity: 0.65;
        margin: 0;
        line-height: 1.4;
    }
    .blog-admin-item-actions {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        align-items: flex-end;
    }
    .blog-admin-item-actions .control-panel-button {
        font-size: 0.82rem;
        padding: 0.3rem 0.75rem;
        white-space: nowrap;
    }
    .blog-btn-delete { color: #ED5934 !important; border-color: #ED5934 !important; }
    .blog-btn-delete:hover { background: #ED5934 !important; color: #fff !important; }
    .blog-status-badge {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 0.15rem 0.55rem;
        border-radius: 20px;
    }
    .blog-status-badge.published { background: rgba(5,80,41,0.3); color: #6ee7a0; border: 1px solid rgba(110,231,160,0.3); }
    .blog-status-badge.draft { background: rgba(237,89,52,0.15); color: #f4a07a; border: 1px solid rgba(237,89,52,0.3); }
    </style>
    @endpush
</x-control-panel-layout>

