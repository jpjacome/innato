<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Experience Center Page</h2>
        </div>
        <p class="control-panel-text-muted">Edit the content and settings for your Experience Center page.</p>

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

        <form id="experience-center-edit-form" method="POST" action="{{ route('admin.experience-center.update') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-university"></i> Banner 1 (Arriba)</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner_title" class="control-panel-label">Título</label>
                        <input type="text" id="banner_title" name="banner_title" class="control-panel-input" value="{{ old('banner_title', $experienceCenterSetting->banner_title ?? 'VISITA NUESTRO LOCAL Y DISFRUTA DE UN CAFE.') }}">
                    </div>
                    <div>
                        <label for="banner_description" class="control-panel-label">Descripción</label>
                        <textarea id="banner_description" name="banner_description" class="control-panel-input" rows="3">{{ old('banner_description', $experienceCenterSetting->banner_description ?? 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto, exercitationem ex. In veritatis saepe numquam, dolor itaque suscipit fuga tempore?') }}</textarea>
                    </div>
                    <div>
                        <label for="button_text" class="control-panel-label">Texto del Botón</label>
                        <input type="text" id="button_text" name="button_text" class="control-panel-input" value="{{ old('button_text', $experienceCenterSetting->button_text ?? 'CONOCE MÁS') }}">
                    </div>
                    <div>
                        <label for="container2_video" class="control-panel-label">Video (mp4/webm/ogg)</label>
                        <div style="margin-bottom:8px">
                            <video controls style="max-width:200px;">
                                @if(!empty($experienceCenterSetting->container2_video))
                                    <source src="{{ asset('storage/' . $experienceCenterSetting->container2_video) }}" type="video/mp4">
                                @else
                                    <source src="{{ asset('assets/vids/coffee.mp4') }}" type="video/mp4">
                                @endif
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <input type="file" id="container2_video" name="container2_video" class="control-panel-input" accept="video/mp4,video/webm,video/ogg">
                    </div>
                </div>
            </div>
            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle"><i class="fas fa-university"></i> Banner 2 (Abajo)</h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="banner2_title" class="control-panel-label">Título</label>
                        <input type="text" id="banner2_title" name="banner2_title" class="control-panel-input" value="{{ old('banner2_title', $experienceCenterSetting->banner2_title ?? 'VISÍTANOS Y DESCUBRE NUESTROS PRODUCTOS LOCALES.') }}">
                    </div>
                    <div>
                        <label for="banner2_description" class="control-panel-label">Descripción</label>
                        <textarea id="banner2_description" name="banner2_description" class="control-panel-input" rows="3">{{ old('banner2_description', $experienceCenterSetting->banner2_description ?? 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto, exercitationem ex. In veritatis saepe numquam, dolor itaque suscipit fuga tempore?') }}</textarea>
                    </div>
                    <div>
                        <label for="banner2_button_text" class="control-panel-label">Texto del Botón</label>
                        <input type="text" id="banner2_button_text" name="banner2_button_text" class="control-panel-input" value="{{ old('banner2_button_text', $experienceCenterSetting->banner2_button_text ?? 'CONOCE MÁS') }}">
                    </div>
                    <div>
                        <label for="container3_image" class="control-panel-label">Imagen</label>
                        <div style="margin-bottom:8px">
                            @php
                                $imgPath = null;
                                if (!empty($experienceCenterSetting->container3_image)) {
                                    $imgPath = asset('storage/' . ltrim($experienceCenterSetting->container3_image, '/\\'));
                                } else {
                                    $imgPath = asset('assets/imgs/bg2.png');
                                }
                            @endphp
                            <img src="{{ $imgPath }}" alt="Imagen Container 3" style="max-width:200px;">
                        </div>
                        <input type="file" id="container3_image" name="container3_image" class="control-panel-input" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="control-panel-fixed-actions">
                <a href="{{ route('admin.pages') }}" class="control-panel-button">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="control-panel-button">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="/experience-center" target="_blank" class="control-panel-button">
                    <i class="fas fa-external-link-alt"></i> View Experience Center Page
                </a>
            </div>
        </form>
    </div>
</x-control-panel-layout>
