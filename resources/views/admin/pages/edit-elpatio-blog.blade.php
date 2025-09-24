<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">
        <h2 class="control-panel-title">El Patio - Blog</h2>
        <p class="text-white opacity-75">Lista de entradas del blog. Aquí puedes crear una nueva entrada o editar las existentes.</p>

        <div class="control-panel-card pages-card edit-blog-card" style="margin-top:1rem;">
            <h3 class="control-panel-subtitle">Crear nueva entrada</h3>
            <form action="{{ route('admin.pages.store-elpatio-blog') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label for="excerpt">Extracto</label>
                    <textarea name="excerpt" id="excerpt" class="form-control">{{ old('excerpt') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="body">Contenido</label>
                    <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                    <trix-editor input="body"></trix-editor>
                </div>
                <div class="form-group">
                    <label for="featured_image">Imagen destacada</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control">
                    <img id="featured-preview" src="" alt="Previsualización" style="max-width:220px;display:none;margin-top:0.5rem;border:1px solid rgba(255,255,255,0.08);padding:4px;" />
                </div>
                <div style="margin-top:0.5rem;">
                    <button class="control-panel-button" type="submit"><i class="fas fa-plus"></i> Crear</button>
                </div>
            </form>
        </div>

        <h3 class="control-panel-title" style="margin-top:2rem;">Entradas existentes</h3>
        <div class="cards-wrapper">
            {{-- Existing posts will be injected here by controller. For now, show placeholder when none. --}}
            @php
                $postsList = isset($posts) ? $posts : session('posts', []);
            @endphp
            @if($postsList && count($postsList))
                @foreach($postsList as $post)
                    <div class="control-panel-card pages-card">
                        <h3 class="control-panel-subtitle">{{ $post['title'] }}</h3>
                        <p>{{ Str::limit($post['excerpt'] ?? '', 120) }}</p>
                        <div class="pages-card-actions">
                            <a href="{{ route('admin.pages.edit-elpatio-blog.edit', ['id' => $post['id']]) }}" class="control-panel-button"><i class="fas fa-edit"></i> Editar</a>
                            <a href="/elpatio/blog/{{ $post['slug'] ?? $post['id'] }}" target="_blank" class="control-panel-button">Ver página</a>
                            <form action="{{ route('admin.pages.edit-elpatio-blog.destroy', ['id' => $post['id']]) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="control-panel-button">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="control-panel-card pages-card">
                    <p>No hay entradas todavía. Crea la primera arriba.</p>
                </div>
            @endif
        </div>
    </div>
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/trix/dist/trix.css">
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/trix/dist/trix.umd.min.js" defer></script>
        <script>
        document.addEventListener('trix-attachment-add', function(event) {
            var attachment = event.attachment;
            if (attachment.file) {
                uploadTrixAttachment(attachment);
            }
        });

        function uploadTrixAttachment(attachment) {
            var file = attachment.file;
            var form = new FormData();
            form.append('file', file);

            var token = '{{ csrf_token() }}';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/uploads/trix', true);
            // Ask Laravel to return JSON validation errors when present
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);

            xhr.upload.onprogress = function(event) {
                var progress = event.loaded / event.total * 100;
                attachment.setUploadProgress(progress);
            }

            xhr.onload = function() {
                if (xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        attachment.setAttributes({
                            url: data.url,
                            href: data.url,
                            filename: file.name,
                            contentType: file.type
                        });
                    // Ensure editor shows upload as complete
                    attachment.setUploadProgress(100);
                } else {
                    console.error('Upload failed:', xhr.responseText);
                    try {
                        var err = JSON.parse(xhr.responseText);
                        alert('Upload error: ' + (err.message || JSON.stringify(err)));
                    } catch(e) {
                        alert('Upload failed. See console for details.');
                    }
                }
            };

            xhr.send(form);
        }
        </script>
    @endpush
    @push('scripts')
        <script>
        (function() {
            var input = document.getElementById('featured_image');
            var img = document.getElementById('featured-preview');
            if (!input || !img) return;
            input.addEventListener('change', function(e) {
                var file = input.files && input.files[0];
                if (!file) { img.style.display = 'none'; return; }
                var reader = new FileReader();
                reader.onload = function(ev) {
                    img.src = ev.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            });
        })();
        </script>
    @endpush
</x-control-panel-layout>
