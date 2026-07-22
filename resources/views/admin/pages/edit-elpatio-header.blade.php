<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Editar Header de El Patio</h2>
        </div>

    <p class="control-panel-text-muted">Edita la navegación del header de El Patio y guarda para persistir los cambios en la base de datos.</p>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom:1rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form id="elpatio-header-form" method="POST" action="{{ route('admin.pages.update-elpatio-header') }}" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-bars"></i> Elementos del Menú
                </h3>
                <p class="control-panel-text-muted">Edita la etiqueta y URL de cada elemento del menú del header de El Patio.</p>

                <div class="control-panel-form-grid">
                    <div>
                        <label class="control-panel-label">Acerca de</label>
                                <div style="display:flex;gap:0.5rem;">
                                    @php $m = $elpatioSetting->header_menu[0] ?? null; @endphp
                                    <input type="text" name="menu_label[]" class="control-panel-input" value="{{ old('menu_label.0', $m['label'] ?? 'About Us') }}" placeholder="Etiqueta">
                                    <input type="text" name="menu_url[]" class="control-panel-input" value="{{ old('menu_url.0', $m['url'] ?? '#about') }}" placeholder="#about o /about">
                                </div>
                    </div>

                    <div>
                        <label class="control-panel-label">Habitaciones</label>
                        <div style="display:flex;gap:0.5rem;">
                            @php $m = $elpatioSetting->header_menu[1] ?? null; @endphp
                            <input type="text" name="menu_label[]" class="control-panel-input" value="{{ old('menu_label.1', $m['label'] ?? 'Rooms') }}" placeholder="Etiqueta">
                            <input type="text" name="menu_url[]" class="control-panel-input" value="{{ old('menu_url.1', $m['url'] ?? '#rooms') }}" placeholder="#rooms o /rooms">
                        </div>
                    </div>

                    <div>
                        <label class="control-panel-label">Galería de Fotos</label>
                        <div style="display:flex;gap:0.5rem;">
                            @php $m = $elpatioSetting->header_menu[2] ?? null; @endphp
                            <input type="text" name="menu_label[]" class="control-panel-input" value="{{ old('menu_label.2', $m['label'] ?? 'Photo Gallery') }}" placeholder="Etiqueta">
                            <input type="text" name="menu_url[]" class="control-panel-input" value="{{ old('menu_url.2', $m['url'] ?? '#gallery') }}" placeholder="#gallery o /gallery">
                        </div>
                    </div>

                    <div>
                        <label class="control-panel-label">Blog</label>
                        <div style="display:flex;gap:0.5rem;">
                            @php $m = $elpatioSetting->header_menu[3] ?? null; @endphp
                            <input type="text" name="menu_label[]" class="control-panel-input" value="{{ old('menu_label.3', $m['label'] ?? 'Blog') }}" placeholder="Etiqueta">
                            <input type="text" name="menu_url[]" class="control-panel-input" value="{{ old('menu_url.3', $m['url'] ?? '#blog') }}" placeholder="#blog o /blog">
                        </div>
                    </div>

                    <div>
                        <label class="control-panel-label">Tours</label>
                        <div style="display:flex;gap:0.5rem;">
                            @php $m = $elpatioSetting->header_menu[4] ?? null; @endphp
                            <input type="text" name="menu_label[]" class="control-panel-input" value="{{ old('menu_label.4', $m['label'] ?? 'Tours') }}" placeholder="Etiqueta">
                            <input type="text" name="menu_url[]" class="control-panel-input" value="{{ old('menu_url.4', $m['url'] ?? 'https://innatotravel.com/') }}" placeholder="URL completa o ruta">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview removed; admin now saves directly to DB --}}
            <div class="control-panel-card pages-card control-panel-form-section" style="margin-top:1rem;">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-share-alt"></i> Redes Sociales
                </h3>
                <p class="control-panel-text-muted">Edita los enlaces de redes sociales del header de El Patio (Instagram, TikTok, Facebook, WhatsApp).</p>

                <div class="control-panel-form-grid">
                    @php $s = $elpatioSetting->social_links ?? []; @endphp
                    <div>
                        <label class="control-panel-label">Instagram</label>
                        <input type="text" name="social_links[instagram]" class="control-panel-input" value="{{ old('social_links.instagram', $s['instagram'] ?? '') }}" placeholder="https://instagram.com/yourpage">
                    </div>
                    <div>
                        <label class="control-panel-label">TikTok</label>
                        <input type="text" name="social_links[tiktok]" class="control-panel-input" value="{{ old('social_links.tiktok', $s['tiktok'] ?? '') }}" placeholder="https://tiktok.com/@yourpage">
                    </div>
                    <div>
                        <label class="control-panel-label">Facebook</label>
                        <input type="text" name="social_links[facebook]" class="control-panel-input" value="{{ old('social_links.facebook', $s['facebook'] ?? '') }}" placeholder="https://facebook.com/yourpage">
                    </div>
                    <div>
                        <label class="control-panel-label">WhatsApp (enlace al chat)</label>
                        <input type="text" name="social_links[whatsapp]" class="control-panel-input" value="{{ old('social_links.whatsapp', $s['whatsapp'] ?? '') }}" placeholder="https://wa.me/1234567890 or https://api.whatsapp.com/send?phone=...">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="control-panel-fixed-actions">
        <a href="{{ route('admin.pages') }}" class="control-panel-button">
            <i class="fas fa-times"></i> Cancelar
        </a>
    <button id="elpatio-save-btn" type="submit" form="elpatio-header-form" class="control-panel-button">
            <i class="fas fa-save"></i> Guardar
        </button>
        <a href="/elpatio" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> Ver Página
        </a>
    </div>

    @push('scripts')
    <script>
        (function(){
            const form = document.getElementById('elpatio-header-form');
            const saveBtn = document.getElementById('elpatio-save-btn');

            function readForm() {
                const labels = Array.from(form.querySelectorAll('input[name="menu_label[]"]')).map(i => i.value.trim());
                const urls = Array.from(form.querySelectorAll('input[name="menu_url[]"]')).map(i => i.value.trim());
                return labels.map((l, idx) => ({ label: l || '', url: urls[idx] || '#' }));
            }
            // Serialize header_menu right before the form submits
            form.addEventListener('submit', function(e){
                try{
                    const items = readForm();
                    let existing = document.getElementById('header_menu_input');
                    if (!existing) {
                        existing = document.createElement('input');
                        existing.type = 'hidden';
                        existing.name = 'header_menu';
                        existing.id = 'header_menu_input';
                        form.appendChild(existing);
                    }
                    existing.value = JSON.stringify(items);
                } catch(err) {
                    console.error('failed to serialize header_menu', err);
                }
            });
        })();
    </script>
    @endpush

</x-control-panel-layout>
