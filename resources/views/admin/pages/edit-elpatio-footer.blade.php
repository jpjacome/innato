<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Editar Footer de El Patio</h2>
        </div>

        <p class="control-panel-text-muted">Edita el contenido del footer de El Patio y guarda para persistir los cambios en la base de datos.</p>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom:1rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form id="elpatio-footer-form" method="POST" action="{{ route('admin.pages.update-elpatio-footer') }}" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-info-circle"></i> Contacto</h3>
                @php $f = $elpatioSetting->footer ?? []; @endphp
                <div class="control-panel-form-grid">
                    <div>
                        <label class="control-panel-label">Dirección</label>
                        <input type="text" name="footer_address" class="control-panel-input" value="{{ old('footer_address', $f['address'] ?? '') }}">
                    </div>
                    <div>
                        <label class="control-panel-label">Correo electrónico</label>
                        <input type="email" name="footer_email" class="control-panel-input" value="{{ old('footer_email', $f['email'] ?? '') }}">
                    </div>
                    <div>
                        <label class="control-panel-label">Números de teléfono</label>
                        <div id="footer-phones">
                            @php $phones = $f['phones'] ?? []; @endphp
                            @if(count($phones))
                                @foreach($phones as $i => $p)
                                    <input type="text" name="footer_phone[]" class="control-panel-input" value="{{ old('footer_phone.' . $i, $p) }}" />
                                @endforeach
                            @else
                                <input type="text" name="footer_phone[]" class="control-panel-input" value="{{ old('footer_phone.0', '') }}" />
                            @endif
                        </div>
                        <button type="button" id="add-phone" class="control-panel-button control-panel-button-secondary" style="margin-top:0.5rem;">Agregar teléfono</button>
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section" style="margin-top:1rem;">
                <h3 class="control-panel-subtitle"><i class="fas fa-share-alt"></i> Redes Sociales</h3>
                <p class="control-panel-text-muted">Edita los enlaces de redes sociales que se muestran en el footer.</p>
                <div class="control-panel-form-grid">
                    @php $s = $elpatioSetting->social_links ?? ($f['social_links'] ?? []); @endphp
                    <div>
                        <label class="control-panel-label">Instagram</label>
                        <input type="text" name="footer_social_links[instagram]" class="control-panel-input" value="{{ old('footer_social_links.instagram', $s['instagram'] ?? '') }}">
                    </div>
                    <div>
                        <label class="control-panel-label">TikTok</label>
                        <input type="text" name="footer_social_links[tiktok]" class="control-panel-input" value="{{ old('footer_social_links.tiktok', $s['tiktok'] ?? '') }}">
                    </div>
                    <div>
                        <label class="control-panel-label">Facebook</label>
                        <input type="text" name="footer_social_links[facebook]" class="control-panel-input" value="{{ old('footer_social_links.facebook', $s['facebook'] ?? '') }}">
                    </div>
                    {{-- WhatsApp removed from social links per request --}}
                </div>
            </div>

            {{-- Copyright is static; admin cannot edit --}}

        </form>

        <div class="control-panel-fixed-actions">
            <a href="{{ route('admin.pages') }}" class="control-panel-button">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button id="elpatio-footer-save" type="submit" form="elpatio-footer-form" class="control-panel-button">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="/elpatio" target="_blank" class="control-panel-button">
                <i class="fas fa-external-link-alt"></i> Ver Página
            </a>
        </div>

    @push('scripts')
    <script>
        (function(){
            const form = document.getElementById('elpatio-footer-form');
            const addPhone = document.getElementById('add-phone');
            addPhone.addEventListener('click', function(){
                const container = document.getElementById('footer-phones');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'footer_phone[]';
                input.className = 'control-panel-input';
                container.appendChild(input);
            });

            form.addEventListener('submit', function(){
                try{
                    // Build footer structured payload and attach hidden input
                    const address = form.querySelector('[name="footer_address"]').value.trim();
                    const email = form.querySelector('[name="footer_email"]').value.trim();
                    const phones = Array.from(form.querySelectorAll('input[name="footer_phone[]"]')).map(i => i.value.trim()).filter(Boolean);
                    const social = {
                        instagram: form.querySelector('[name="footer_social_links[instagram]"]').value.trim(),
                        tiktok: form.querySelector('[name="footer_social_links[tiktok]"]').value.trim(),
                        facebook: form.querySelector('[name="footer_social_links[facebook]"]').value.trim(),
                    };

                    let existing = document.getElementById('footer_payload_input');
                    if (!existing) {
                        existing = document.createElement('input');
                        existing.type = 'hidden';
                        existing.name = 'footer';
                        existing.id = 'footer_payload_input';
                        form.appendChild(existing);
                    }
                    existing.value = JSON.stringify({ address, email, phones, social_links: social, copyright });
                } catch(err) { console.error('Failed to serialize footer payload', err); }
            });
        })();
    </script>
    @endpush

</x-control-panel-layout>
