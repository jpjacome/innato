<x-control-panel-layout>
	<div class="control-panel-card control-panel-with-fixed-actions">
		<div class="control-panel-header-flex">
			<a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
				<i class="fas fa-arrow-left"></i> Volver a Páginas
			</a>
			<h2 class="control-panel-title control-panel-title-no-margin">Editar El Patio</h2>
		</div>

		<form id="elpatio-edit-form" method="POST" action="{{ route('admin.pages.update-elpatio') }}" enctype="multipart/form-data" class="control-panel-form-section">
			@csrf
			@method('PUT')

			<!-- Hero -->
			<div class="control-panel-card pages-card control-panel-form-section">
				<h3 class="control-panel-subtitle"><i class="fas fa-image"></i> Hero / Portada</h3>
				<p>Imagen de fondo y logo de carga.</p>
				<div class="control-panel-form-grid">
					<div>
						<label for="hero_background" class="control-panel-label">Imagen de fondo (hero)</label>
						@php $heroBg = isset($elpatioSetting) && !empty($elpatioSetting->hero_background) ? asset('storage/' . $elpatioSetting->hero_background) : '' ; @endphp
						<img id="preview-hero-background" src="{{ $heroBg }}" style="max-width:180px; margin-bottom:6px; {{ $heroBg ? 'display:block;' : 'display:none;' }}">
						<input type="file" id="hero_background" name="hero_background" class="control-panel-input" accept="image/*" onchange="previewImage(this,'preview-hero-background')">
						<small class="control-panel-small-text">Actual: {{ optional($elpatioSetting)->hero_background ?? 'ninguna' }}</small>
					</div>
					<div>
						<label for="loading_logo" class="control-panel-label">Logo de carga (loading screen)</label>
						@php $loadLogo = isset($elpatioSetting) && !empty($elpatioSetting->loading_logo) ? asset('storage/' . $elpatioSetting->loading_logo) : '' ; @endphp
						<img id="preview-loading-logo" src="{{ $loadLogo }}" style="max-width:120px; margin-bottom:6px; {{ $loadLogo ? 'display:block;' : 'display:none;' }}">
						<input type="file" id="loading_logo" name="loading_logo" class="control-panel-input" accept="image/*" onchange="previewImage(this,'preview-loading-logo')">
					</div>
				</div>
			</div>

			<!-- About Section -->
			<div class="control-panel-card pages-card control-panel-form-section">
				<h3 class="control-panel-subtitle"><i class="fas fa-info-circle"></i> Sección About</h3>
				<div class="control-panel-form-grid">
					<div>
						<label for="about_title" class="control-panel-label">Título (About) + highlight</label>
						<div class="dual-input-row">
							<div class="dual-input-col">
								<input type="text" id="about_title" name="about_title" class="control-panel-input" value="{{ old('about_title', optional($elpatioSetting)->about_title ?? 'About our Casa') }}">
							</div>
							<div class="dual-input-col dual-input-highlight-col">
								<input type="text" id="about_title_highlight" name="about_title_highlight" class="control-panel-input" placeholder="Highlight (e.g. Casa)" value="{{ old('about_title_highlight', optional($elpatioSetting)->about_title_highlight ?? 'Casa') }}">
							</div>
						</div>
					</div>
					<div>
						<label for="about_text" class="control-panel-label">Texto (About)</label>
						<textarea id="about_text" name="about_text" class="control-panel-input" rows="4">{{ old('about_text', optional($elpatioSetting)->about_text ?? '') }}</textarea>
					</div>
				</div>
				<div class="control-panel-form-grid" style="margin-top:1rem;">
					<div>
						<label for="about_image" class="control-panel-label">Imagen (About masked)</label>
						@php $aboutImg = isset($elpatioSetting) && !empty($elpatioSetting->about_image) ? asset('storage/' . $elpatioSetting->about_image) : '' ; @endphp
						<img id="preview-about-image" src="{{ $aboutImg }}" style="max-width:160px; margin-bottom:6px; {{ $aboutImg ? 'display:block;' : 'display:none;' }}">
						<input type="file" id="about_image" name="about_image" class="control-panel-input" accept="image/*" onchange="previewImage(this,'preview-about-image')">
					</div>
				</div>
			</div>

			<!-- About 2 Section -->
			<div class="control-panel-card pages-card control-panel-form-section">
				<h3 class="control-panel-subtitle"><i class="fas fa-info-circle"></i> Sección About 2 (Why El Patio)</h3>
				<div class="control-panel-form-grid">
					<div>
						<label for="about2_title" class="control-panel-label">Título (About 2) + highlight</label>
						<div class="dual-input-row">
							<div class="dual-input-col">
								<input type="text" id="about2_title" name="about2_title" class="control-panel-input" value="{{ old('about2_title', optional($elpatioSetting)->about2_title ?? 'Why El Patio?') }}">
							</div>
							<div class="dual-input-col dual-input-highlight-col">
								<input type="text" id="about2_title_highlight" name="about2_title_highlight" class="control-panel-input" placeholder="Highlight (e.g. El Patio?)" value="{{ old('about2_title_highlight', optional($elpatioSetting)->about2_title_highlight ?? 'El Patio?') }}">
							</div>
						</div>
					</div>
					<div>
						<label for="about2_text" class="control-panel-label">Texto (About 2)</label>
						<textarea id="about2_text" name="about2_text" class="control-panel-input" rows="4">{{ old('about2_text', optional($elpatioSetting)->about2_text ?? '') }}</textarea>
					</div>
				</div>
				<div class="control-panel-form-grid" style="margin-top:1rem;">
					<div>
						<label for="about2_image" class="control-panel-label">Imagen (About 2)</label>
						@php $about2Img = isset($elpatioSetting) && !empty($elpatioSetting->about2_image) ? asset('storage/' . $elpatioSetting->about2_image) : '' ; @endphp
						<img id="preview-about2-image" src="{{ $about2Img }}" style="max-width:160px; margin-bottom:6px; {{ $about2Img ? 'display:block;' : 'display:none;' }}">
						<input type="file" id="about2_image" name="about2_image" class="control-panel-input" accept="image/*" onchange="previewImage(this,'preview-about2-image')">
					</div>
				</div>
			</div>

			<!-- Rooms / Amenities -->
			<div class="control-panel-card pages-card control-panel-form-section">
				<h3 class="control-panel-subtitle"><i class="fas fa-bed"></i> Sección Rooms / Amenities</h3>
				<div class="control-panel-form-grid">
					<div>
						<label for="rooms_title" class="control-panel-label">Título (Rooms) + highlight</label>
						<div class="dual-input-row">
							<div class="dual-input-col">
								<input type="text" id="rooms_title" name="rooms_title" class="control-panel-input" value="{{ old('rooms_title', optional($elpatioSetting)->rooms_title ?? 'We provide the best facilities') }}">
							</div>
							<div class="dual-input-col dual-input-highlight-col">
								<input type="text" id="rooms_title_highlight" name="rooms_title_highlight" class="control-panel-input" placeholder="Highlight (e.g. best facilities)" value="{{ old('rooms_title_highlight', optional($elpatioSetting)->rooms_title_highlight ?? 'best facilities') }}">
							</div>
						</div>
					</div>
					<div style="flex:1;">
						<label class="control-panel-label">Lista de amenities</label>
						<!-- Button to open icons list modal -->
						<button type="button" id="open-amenities-icons-list-modal" class="control-panel-button" style="margin-top:6px;">
							<i class="ph ph-list"></i> Lista de Iconos
						</button>
						@php
							$defaultAmenities = [
								['icon' => 'ph ph-coffee', 'text' => 'BREAKFAST INCLUDED'],
								['icon' => 'ph ph-cooking-pot', 'text' => 'FULLY EQUIPPED KITCHEN'],
								['icon' => 'ph ph-bed', 'text' => 'SOLID WOOD BUNK BEDS (KING SINGLE 105X190CM)'],
								['icon' => 'ph ph-t-shirt', 'text' => 'BEST-QUALITY COTTON LINENS'],
								['icon' => 'ph ph-sim-card', 'text' => 'ECUADORIAN CELL PHONE SIM CARDS, ACTIVATED WITH YOUR INFO.'],
								['icon' => 'ph ph-credit-card', 'text' => 'CREDIT CARD ACCEPTED'],
								['icon' => 'ph ph-shield', 'text' => 'BIG STORAGE LOCKERS'],
								['icon' => 'ph ph-user', 'text' => 'PERSONAL ACCESS'],
								['icon' => 'ph ph-bathtub', 'text' => 'TIDY BATHROOMS'],
								['icon' => 'ph ph-thermometer-hot', 'text' => 'HOT WATER'],
								['icon' => 'ph ph-airplane', 'text' => 'AIRPORT TRANSFER'],
								['icon' => 'ph ph-clock', 'text' => 'LATE CHECK IN'],
								['icon' => 'ph ph-wifi-high', 'text' => 'FREE HIGH-SPEED WI-FI'],
								['icon' => 'ph ph-television', 'text' => 'TV ROOM'],
								['icon' => 'ph ph-suitcase', 'text' => 'LUGGAGE STORE SERVICE'],
								['icon' => 'ph ph-calendar', 'text' => 'DAY-USE SERVICE'],
								['icon' => 'ph ph-t-shirt', 'text' => 'LAUNDRY SERVICE'],
							];
							// Support either array (new cast) or legacy JSON string
							$rawValue = optional($elpatioSetting)->amenities_list ?? [];
							if (is_string($rawValue)) {
								$raw = json_decode($rawValue, true) ?: [];
							} else {
								$raw = $rawValue ?: [];
							}
						@endphp
						@foreach($defaultAmenities as $i => $def)
							@php
								// prefer stored value if present, support string or object formats
								$stored = data_get($raw, $i, null);
								$icon = is_string($stored) ? '' : (data_get($stored, 'icon') ?? data_get($stored, 'class') ?? $def['icon']);
								$text = is_string($stored) ? $stored : (data_get($stored, 'text') ?? data_get($stored, 'label') ?? $def['text']);
							@endphp
							<div class="control-panel-form-grid" style="display:flex; align-items:center; gap:1rem; margin-bottom:8px;">
								<div style="width:220px; min-width:160px;">
									<label class="control-panel-label">Clase icono</label>
									<input type="text" name="amenity_icon[]" class="control-panel-input" placeholder="ph ph-coffee" value="{{ old('amenity_icon.'.$i, $icon) }}">
								</div>
								<div style="flex:1 1 360px; max-width:520px;">
									<label class="control-panel-label">Texto de la amenidad</label>
									<input type="text" name="amenity_text[]" class="control-panel-input" value="{{ old('amenity_text.'.$i, $text) }}">
								</div>
							</div>
						@endforeach

						<!-- Amenities Icons List Modal -->
						<div id="amenitiesIconsListModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
							<div style="background:#fff; max-width:480px; width:90vw; max-height:80vh; border-radius:12px; box-shadow:0 2px 24px #2225; padding:2rem 1.5rem; overflow:auto; position:relative;">
								<h3 style="margin-top:0; margin-bottom:1rem; font-size:1.3rem;">Nombres de Iconos Phosphor</h3>
								<button type="button" id="close-amenities-icons-list-modal" style="position:absolute; top:12px; right:16px; background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
								<input type="text" id="amenitiesIconFilterInput" placeholder="Filtrar iconos..." style="width:100%; margin-bottom:0.75rem; padding:0.4rem 0.7rem; font-size:1rem; border:1px solid #ddd; border-radius:6px;">
								<div style="max-height:60vh; overflow-y:auto; border:1px solid #eee; border-radius:8px; padding:0.5rem 0.75rem; background:#fafafa;">
									<ul id="amenitiesIconsListUl" style="list-style:none; margin:0; padding:0; font-size:1.05rem;">
										@foreach(file(public_path('assets/phosphor-icon-names.txt')) as $iconName)
											<li style="padding:2px 0; border-bottom:1px solid #f0f0f0;">{{ trim($iconName) }}</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Photo Gallery -->
			<div class="control-panel-card pages-card control-panel-form-section">
				<h3 class="control-panel-subtitle"><i class="fas fa-images"></i> Galería de fotos</h3>
				<p>Sube varias imágenes para la galería. Puedes añadir o quitar entradas.</p>
				<div id="gallery-list">
					@php
						$defaultGallery = [];
						$gallery = old('gallery', optional($elpatioSetting)->gallery ?? $defaultGallery);
					@endphp
					@if(is_array($gallery) && count($gallery))
						@foreach($gallery as $i => $g)
							@php
								$gPath = is_string($g) ? $g : (data_get($g, 'image') ?? data_get($g, 'path') ?? null);
								$gText = is_string($g) ? '' : (data_get($g, 'text') ?? '');
							@endphp
							<div class="control-panel-form-grid" style="align-items:center; gap:1rem; margin-bottom:8px;">
								<div>
									<img id="preview-gallery-{{ $i }}" src="{{ $gPath ? (str_starts_with($gPath, 'http') ? $gPath : asset('storage/' . $gPath)) : '' }}" style="max-width:120px; display: {{ $gPath ? 'block' : 'none' }}; margin-bottom:6px;">
									<input type="file" name="gallery[]" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-gallery-{{ $i }}')">
									<!-- Keep a hidden field to indicate this slot keeps an existing image path -->
									<input type="hidden" name="gallery_existing[]" value="{{ $gPath ?? '' }}">
								</div>
								<div style="flex:1;">
									<label class="control-panel-label">Descripción (opcional)</label>
									<input type="text" name="gallery_text[]" class="control-panel-input" value="{{ old('gallery_text.'.$i, $gText) }}">
								</div>
								<div>
									<button type="button" class="control-panel-button" onclick="removeNode(this)">Eliminar</button>
								</div>
							</div>
						@endforeach
					@else
						<!-- empty initial slot -->
						<div class="control-panel-form-grid" style="align-items:center; gap:1rem; margin-bottom:8px;">
							<div>
								<img id="preview-gallery-0" src="" style="max-width:120px; display:none; margin-bottom:6px;">
								<input type="file" name="gallery[]" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-gallery-0')">
							</div>
							<div style="flex:1;">
								<label class="control-panel-label">Descripción (opcional)</label>
								<input type="text" name="gallery_text[]" class="control-panel-input" value="">
							</div>
							<div>
								<button type="button" class="control-panel-button" onclick="removeNode(this)">Eliminar</button>
							</div>
						</div>
					@endif
				</div>
				<div style="margin-top:8px;">
					<button type="button" class="control-panel-button" onclick="addGalleryItem()">Agregar imagen</button>
				</div>
			</div>



		</form>
	</div>

	<!-- Fixed Action Buttons -->
	<div class="control-panel-fixed-actions">
		<a href="{{ route('admin.pages') }}" class="control-panel-button">
			<i class="fas fa-times"></i> Cancelar
		</a>
		<button type="submit" form="elpatio-edit-form" class="control-panel-button">
			<i class="fas fa-save"></i> Guardar
		</button>
		<a href="/elpatio-live" target="_blank" class="control-panel-button">
			<i class="fas fa-external-link-alt"></i> Ver Página
		</a>
	</div>

	<script>
		function previewImage(input, imgId) {
			const img = document.getElementById(imgId);
			if (!img) return;
			if (input.files && input.files[0]) {
				const reader = new FileReader();
				reader.onload = function(e) {
					img.src = e.target.result;
					img.style.display = 'block';
				};
				reader.readAsDataURL(input.files[0]);
			} else {
				img.src = '';
				img.style.display = 'none';
			}
		}

		function removeNode(btn) {
			const node = btn.closest('.control-panel-form-grid');
			if (node) node.remove();
		}

		function addGalleryItem() {
			const list = document.getElementById('gallery-list');
			const idx = list.children.length;
			const wrapper = document.createElement('div');
			wrapper.className = 'control-panel-form-grid';
			wrapper.style = 'align-items:center; gap:1rem; margin-bottom:8px;';
			wrapper.innerHTML = `
				<div>
					<img id="preview-gallery-${idx}" src="" style="max-width:120px; display:none; margin-bottom:6px;">
					<input type="file" name="gallery[]" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-gallery-${idx}')">
					<input type="hidden" name="gallery_existing[]" value="">
				</div>
				<div style="flex:1;">
					<label class="control-panel-label">Descripción (opcional)</label>
					<input type="text" name="gallery_text[]" class="control-panel-input" value="">
				</div>
				<div>
					<button type="button" class="control-panel-button" onclick="removeNode(this)">Eliminar</button>
				</div>
			`;
			list.appendChild(wrapper);
		}

		function addPostItem() {
			const list = document.getElementById('posts-list');
			const idx = list.children.length;
			const wrapper = document.createElement('div');
			wrapper.className = 'control-panel-form-grid';
			wrapper.style = 'align-items:center; gap:1rem; border:1px solid #eee; padding:8px; margin-bottom:8px;';
			wrapper.innerHTML = `
				<div style="width:140px;">
					<img id="preview-post-${idx}" src="" style="max-width:140px; display:none; margin-bottom:6px;">
					<input type="file" name="posts_images[]" class="control-panel-input" accept="image/*" onchange="previewImage(this, 'preview-post-${idx}')">
				</div>
				<div style="flex:1;">
					<label class="control-panel-label">Título</label>
					<input type="text" name="posts_title[]" class="control-panel-input" value="">
					<label class="control-panel-label">Meta (fecha / autor)</label>
					<input type="text" name="posts_meta[]" class="control-panel-input" value="">
					<label class="control-panel-label">Extracto</label>
					<textarea name="posts_excerpt[]" class="control-panel-input" rows="2"></textarea>
				</div>
				<div>
					<button type="button" class="control-panel-button" onclick="removeNode(this)">Eliminar</button>
				</div>
			`;
			list.appendChild(wrapper);
		}

		// Amenities icons modal handlers
		document.addEventListener('DOMContentLoaded', function() {
			const openBtn = document.getElementById('open-amenities-icons-list-modal');
			const closeBtn = document.getElementById('close-amenities-icons-list-modal');
			const modal = document.getElementById('amenitiesIconsListModal');
			const filterInput = document.getElementById('amenitiesIconFilterInput');
			const iconsListUl = document.getElementById('amenitiesIconsListUl');

			if (openBtn && modal) {
				openBtn.addEventListener('click', function() { modal.style.display = 'flex'; });
			}
			if (closeBtn && modal) {
				closeBtn.addEventListener('click', function() { modal.style.display = 'none'; });
			}
			// close when clicking outside
			if (modal) {
				modal.addEventListener('click', function(e) {
					if (e.target === modal) modal.style.display = 'none';
				});
			}

			if (filterInput && iconsListUl) {
				filterInput.addEventListener('input', function() {
					const q = this.value.trim().toLowerCase();
					Array.from(iconsListUl.querySelectorAll('li')).forEach(li => {
						li.style.display = li.textContent.toLowerCase().includes(q) ? 'block' : 'none';
					});
				});
			}
		});

		// Ensure gallery slots include hidden gallery_existing[] inputs at submit time
		(function(){
			const form = document.getElementById('elpatio-edit-form');
			if (!form) return;
			form.addEventListener('submit', function(e){
				try {
					const list = document.getElementById('gallery-list');
					if (!list) return;
					const slots = Array.from(list.querySelectorAll('.control-panel-form-grid'));
					slots.forEach(slot => {
						// If a hidden input for existing path is missing, create one (empty by default)
						if (!slot.querySelector('input[name="gallery_existing[]"]')) {
							const container = slot.querySelector('div') || slot;
							const hidden = document.createElement('input');
							hidden.type = 'hidden';
							hidden.name = 'gallery_existing[]';
							hidden.value = '';
							container.appendChild(hidden);
						}
					});
					// Console debug so you can inspect before submission in browser devtools
					console.info('ElPatio admin submit: gallery_existing count=', document.querySelectorAll('input[name="gallery_existing[]"]').length, 'gallery_text count=', document.querySelectorAll('input[name="gallery_text[]"]').length);
				} catch (err) {
					console.error('Error ensuring gallery_existing inputs', err);
				}
			});
		})();
	</script>
</x-control-panel-layout>
