
<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Páginas
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Editar Página de Contacto</h2>
        </div>
        <p class="control-panel-text-muted">Edita el contenido y la configuración de tu página de Contacto.</p>

        @if(session('success'))
            <div class="alert alert-success control-panel-alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error control-panel-alert-error-custom">
                <ul class="control-panel-alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="contact-edit-form" method="POST" action="{{ route('admin.contact.update') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-envelope"></i> Banner de Contacto</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner_title" class="control-panel-label">Título del Banner</label>
                        <input type="text" id="banner_title" name="banner_title" class="control-panel-input" value="{{ old('banner_title', $contactSetting->banner_title ?? 'CONTÁCTANOS Y VIAJEMOS JUNTOS POR EL ECUADOR.') }}">
                    </div>
                    <div>
                        <label for="banner_description" class="control-panel-label">Descripción del Banner</label>
                        <textarea id="banner_description" name="banner_description" class="control-panel-input" rows="3">{{ old('banner_description', $contactSetting->banner_description ?? 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto, exercitationem ex. In veritatis saepe numquam, dolor itaque suscipit fuga tempore?') }}</textarea>
                    </div>
                </div>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner_image" class="control-panel-label">Imagen del Banner</label>
                        @if(!empty($contactSetting->banner_image))
                            <div style="margin-bottom:8px"><img src="{{ asset('storage/' . $contactSetting->banner_image) }}" alt="Banner" style="max-width:120px;"></div>
                        @endif
                        <input type="file" id="banner_image" name="banner_image" class="control-panel-input">
                    </div>
                </div>
            </div>
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-paper-plane"></i> Formulario de Contacto</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="button_text" class="control-panel-label">Texto del Botón</label>
                        <input type="text" id="button_text" name="button_text" class="control-panel-input" value="{{ old('button_text', $contactSetting->button_text ?? 'ENVIAR') }}">
                    </div>
                    <div>
                        <label for="newsletter_label" class="control-panel-label">Etiqueta del Newsletter</label>
                        <input type="text" id="newsletter_label" name="newsletter_label" class="control-panel-input" value="{{ old('newsletter_label', $contactSetting->newsletter_label ?? 'Agregarme al newsletter') }}">
                    </div>
                </div>
            </div>
            <div class="control-panel-fixed-actions">
                <a href="{{ route('admin.pages') }}" class="control-panel-button">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="control-panel-button">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="/contact" target="_blank" class="control-panel-button">
                    <i class="fas fa-external-link-alt"></i> Ver Página
                </a>
            </div>
        </form>
    </div>
</x-control-panel-layout>
