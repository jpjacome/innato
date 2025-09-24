<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">
        <h2 class="control-panel-title">Editar Entrada</h2>
        <div class="control-panel-card pages-card edit-blog-card">
            <form action="{{ route('admin.pages.edit-elpatio-blog.update', ['id' => $post['id']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post['title']) }}" required>
                </div>
                <div class="form-group">
                    <label for="excerpt">Extracto</label>
                    <textarea name="excerpt" id="excerpt" class="form-control">{{ old('excerpt', $post['excerpt'] ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="body">Contenido</label>
                    <input id="body" type="hidden" name="body" value="{{ old('body', $post['body'] ?? '') }}">
                    <trix-editor input="body"></trix-editor>
                </div>
                <div class="form-group">
                    <label for="featured_image">Imagen destacada (reemplaza)</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control">
                    @if(!empty($post['featured_image']))
                        <p>Imagen actual: <em>{{ $post['featured_image'] }}</em></p>
                        <img id="featured-preview" src="{{ asset('storage/' . $post['featured_image']) }}" alt="Imagen actual" style="max-width:220px;display:block;margin-top:0.5rem;border:1px solid rgba(255,255,255,0.08);padding:4px;" />
                    @endif
                </div>
                <div style="margin-top:0.5rem;">
                    <button class="control-panel-button" type="submit"><i class="fas fa-save"></i> Guardar</button>
                    <a href="{{ route('admin.pages.edit-elpatio-blog') }}" class="control-panel-button">Cancelar</a>
                </div>
            </form>
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
