<x-control-panel-layout>
    <div class="control-panel-card pages-main-card">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;">
            <div>
                <h2 class="control-panel-title" style="margin-bottom:0.25rem;">
                    <i class="ph ph-pencil-simple"></i> Nueva Entrada del Blog
                </h2>
                <p style="opacity:0.7; font-size:0.92rem; margin:0;">El Patio Hostels — Blog</p>
            </div>
            <a href="{{ route('admin.pages.edit-elpatio-blog') }}" class="control-panel-button control-panel-button-secondary">
                <i class="ph ph-arrow-left"></i> Volver al Blog
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:1rem;">
                <i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores:
                <ul style="margin:0.5rem 0 0 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pages.store-elpatio-blog') }}" method="POST" enctype="multipart/form-data" id="blog-create-form">
            @csrf

            <div class="blog-editor-layout">
                <!-- Main content column -->
                <div class="blog-editor-main">
                    <div class="form-group">
                        <label for="title">Título <span style="color:#ED5934;">*</span></label>
                        <input type="text" name="title" id="title" class="form-control blog-title-input"
                               value="{{ old('title') }}" required placeholder="Escribe el título de tu entrada..."
                               autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="slug-preview">Slug (URL) <small style="opacity:0.6; font-weight:400;">— generado automáticamente del título</small></label>
                        <input type="text" id="slug-preview" class="form-control" readonly
                               style="background:rgba(255,255,255,0.04); color:rgba(255,255,255,0.55); font-family:monospace; font-size:0.88rem;"
                               placeholder="ej: mi-entrada-del-blog-1234567890">
                    </div>

                    <div class="form-group">
                        <label for="excerpt">Extracto <small style="opacity:0.6; font-weight:400;">— resumen breve que aparece en listados</small></label>
                        <textarea name="excerpt" id="excerpt" class="form-control" rows="3"
                                  placeholder="Escribe un breve resumen de la entrada...">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="body">Contenido</label>
                        <div class="trix-wrapper">
                            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                            <trix-editor input="body" placeholder="Escribe el contenido de tu entrada aquí..."></trix-editor>
                        </div>
                        <small style="opacity:0.55; font-size:0.8rem;">Puedes insertar imágenes arrastrándolas o usando el botón de adjuntar.</small>
                    </div>
                </div>

                <!-- Sidebar column -->
                <div class="blog-editor-sidebar">
                    <!-- Publish box -->
                    <div class="blog-sidebar-box">
                        <h4 class="blog-sidebar-box-title"><i class="ph ph-rocket-launch"></i> Publicación</h4>
                        <div class="form-group" style="margin-bottom:0.75rem;">
                            <label class="toggle-label" for="is_published">
                                <input type="checkbox" name="is_published" id="is_published" value="1"
                                       {{ old('is_published', '1') == '1' ? 'checked' : '' }} style="margin-right:0.5rem;">
                                Publicar inmediatamente
                            </label>
                            <small style="opacity:0.55; display:block; margin-top:0.25rem;">Desmarca para guardar como borrador.</small>
                        </div>
                        <button type="submit" class="control-panel-button control-panel-button-primary" style="width:100%;">
                            <i class="ph ph-floppy-disk"></i> Guardar entrada
                        </button>
                    </div>

                    <!-- Featured image box -->
                    <div class="blog-sidebar-box">
                        <h4 class="blog-sidebar-box-title"><i class="ph ph-image"></i> Imagen Destacada</h4>
                        <div class="featured-image-drop" id="featured-drop">
                            <input type="file" name="featured_image" id="featured_image" class="featured-file-input" accept="image/*">
                            <div class="featured-drop-placeholder" id="featured-placeholder">
                                <i class="ph ph-upload-simple" style="font-size:2rem; opacity:0.5;"></i>
                                <p style="margin:0.4rem 0 0; font-size:0.85rem; opacity:0.65;">Haz clic o arrastra una imagen</p>
                                <small style="opacity:0.45;">JPG, PNG, WEBP — máx. 2MB</small>
                            </div>
                            <img id="featured-preview" src="" alt="Previsualización"
                                 style="display:none; width:100%; border-radius:6px; object-fit:cover; max-height:180px;">
                            <button type="button" id="remove-featured" style="display:none; margin-top:0.5rem; background:none; border:none; color:#ED5934; cursor:pointer; font-size:0.85rem;">
                                <i class="ph ph-x"></i> Quitar imagen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/trix/dist/trix.css">
        <style>
        /* ---- Form base styles ---- */
        .blog-editor-main .form-group {
            margin-bottom: 1.25rem;
        }
        .blog-editor-main .form-group > label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text, #f0ece4);
        }
        .blog-editor-main .form-control {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: 1px solid #555;
            border-radius: 8px;
            font-size: 0.95rem;
            background: rgba(255,255,255,0.06);
            color: var(--text, #f0ece4);
            font-family: inherit;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .blog-editor-main .form-control:focus {
            outline: none;
            border-color: #D6DF27;
            box-shadow: 0 0 0 2px rgba(214,223,39,0.15);
        }
        .blog-editor-main textarea.form-control {
            resize: vertical;
        }

        /* ---- Blog Editor Layout ---- */
        .blog-editor-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 1.5rem;
            align-items: start;
        }
        @media (max-width: 900px) {
            .blog-editor-layout { grid-template-columns: 1fr; }
            .blog-editor-sidebar { order: -1; }
        }
        .blog-title-input {
            font-size: 1.3rem !important;
            font-weight: 600;
        }
        /* Sidebar boxes */
        .blog-sidebar-box {
            background: rgba(255,255,255,0.04);
            border: 1px solid #555;
            border-radius: 10px;
            padding: 1rem 1.1rem;
            margin-bottom: 1rem;
        }
        .blog-sidebar-box-title {
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            opacity: 0.7;
            margin: 0 0 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        /* Trix dark theme overrides */
        .trix-wrapper trix-toolbar .trix-button-row {
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid #555;
        }
        .trix-wrapper trix-editor {
            background: rgba(255,255,255,0.04);
            color: #f0ece4;
            border: 1px solid #555;
            border-top: none;
            min-height: 320px;
            border-radius: 0 0 8px 8px;
            padding: 1rem;
            font-size: 1rem;
            line-height: 1.7;
        }
        .trix-wrapper trix-toolbar {
            border: 1px solid #555;
            border-radius: 8px 8px 0 0;
            overflow: hidden;
        }
        .trix-wrapper .trix-button {
            color: rgba(255,255,255,0.75);
        }
        .trix-wrapper .trix-button:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .trix-wrapper .trix-button.trix-active { color: #262622; background: #D6DF27; }
        /* Featured image drop */
        .featured-image-drop {
            border: 2px dashed #666;
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.2s;
            position: relative;
        }
        .featured-image-drop:hover { border-color: #D6DF27; }
        .featured-file-input {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/trix/dist/trix.umd.min.js" defer></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-generate slug preview from title
            var titleInput = document.getElementById('title');
            var slugPreview = document.getElementById('slug-preview');
            if (titleInput && slugPreview) {
                titleInput.addEventListener('input', function() {
                    var slug = this.value
                        .toLowerCase()
                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim().replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                    slugPreview.value = slug ? slug + '-' + Math.floor(Date.now()/1000) : '';
                });
            }

            // Featured image preview
            var input = document.getElementById('featured_image');
            var preview = document.getElementById('featured-preview');
            var placeholder = document.getElementById('featured-placeholder');
            var removeBtn = document.getElementById('remove-featured');

            function showPreview(src) {
                preview.src = src;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
                removeBtn.style.display = 'inline-block';
            }
            function clearPreview() {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
                removeBtn.style.display = 'none';
                input.value = '';
            }
            if (input) {
                input.addEventListener('change', function() {
                    var file = this.files[0];
                    if (!file) { clearPreview(); return; }
                    var reader = new FileReader();
                    reader.onload = function(e) { showPreview(e.target.result); };
                    reader.readAsDataURL(file);
                });
            }
            if (removeBtn) removeBtn.addEventListener('click', clearPreview);
        });

        // Trix image upload
        document.addEventListener('trix-attachment-add', function(event) {
            var attachment = event.attachment;
            if (attachment.file) { uploadTrixAttachment(attachment); }
        });
        function uploadTrixAttachment(attachment) {
            var file = attachment.file;
            var form = new FormData();
            form.append('file', file);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/uploads/trix', true);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.upload.onprogress = function(e) { attachment.setUploadProgress(e.loaded / e.total * 100); };
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    attachment.setAttributes({ url: data.url, href: data.url });
                } else {
                    alert('Error subiendo imagen. Inténtalo de nuevo.');
                }
            };
            xhr.send(form);
        }
        </script>
    @endpush
</x-control-panel-layout>
