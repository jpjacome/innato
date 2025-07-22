<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Reviews Component</h2>
        </div>
        <p class="control-panel-text-muted">Add, edit, or delete reviews displayed on your site.</p>

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

        <!-- Add Review Form -->
        <form method="POST" action="{{ route('admin.reviews.store') }}" class="control-panel-form-section" style="margin-bottom:2rem;">
            @csrf
            <div class="control-panel-form-grid">
                <div>
                    <label class="control-panel-label">Reviewer</label>
                    <input type="text" name="reviewer" class="control-panel-input" required>
                </div>
                <div>
                    <label class="control-panel-label">Text</label>
                    <input type="text" name="text" class="control-panel-input" required>
                </div>
                <div>
                    <label class="control-panel-label">Rating</label>
                    <input type="number" name="rating" class="control-panel-input" min="1" max="5" required>
                </div>
                <div>
                    <label class="control-panel-label">Location</label>
                    <input type="text" name="location" class="control-panel-input">
                </div>
                <div>
                    <label class="control-panel-label">Status</label>
                    <select name="status" class="control-panel-input" required>
                        <option value="published">Published</option>
                        <option value="pending">Pending</option>
                        <option value="hidden">Hidden</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="control-panel-button" style="margin-top:1rem;"><i class="fas fa-plus"></i> Add Review</button>
        </form>

        <!-- Reviews Cards Flex Layout -->
        <div class="control-panel-grid" style="display: flex; flex-wrap: wrap; gap: 2rem;">
            @foreach($reviews as $review)
                <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 1rem; width: 100%; max-width: 700px;">
                    <!-- Review Content Card -->
                    <div class="control-panel-card" style="flex: 2 1 320px; min-width: 320px; background: #f8f9fa;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span class="control-panel-badge"><i class="fas fa-user"></i> {{ $review->reviewer }}</span>
                            <span class="control-panel-badge" style="background: #ffe066; color: #262622;">
                                <i class="fas fa-star"></i> {{ $review->rating }}
                            </span>
                        </div>
                        <div class="control-panel-form-group">
                            <label class="control-panel-label">Text</label>
                            <div style="font-family:inherit; font-size:1rem; color:#262622; background:none; border:none; padding:0;">{{ $review->text }}</div>
                        </div>
                        @if($review->location)
                        <div class="control-panel-form-group">
                            <label class="control-panel-label">Location</label>
                            <div style="color:#6b7280;">{{ $review->location }}</div>
                        </div>
                        @endif
                        <div class="control-panel-form-group">
                            <label class="control-panel-label">Status</label>
                            <div>{{ ucfirst($review->status) }}</div>
                        </div>
                    </div>
                    <!-- Actions Card -->
                    <div class="control-panel-card" style="flex: 1 1 220px; min-width: 220px; background: #fff; align-self: flex-start;">
                        <form method="POST" action="{{ route('admin.reviews.update', $review) }}" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            @csrf
                            @method('PUT')
                            <label class="control-panel-label">Reviewer</label>
                            <input type="text" name="reviewer" value="{{ $review->reviewer }}" required>
                            <label class="control-panel-label">Text</label>
                            <input type="text" name="text" value="{{ $review->text }}" required>
                            <label class="control-panel-label">Rating</label>
                            <input type="number" name="rating" value="{{ $review->rating }}" min="1" max="5" required>
                            <label class="control-panel-label">Location</label>
                            <input type="text" name="location" value="{{ $review->location }}">
                            <label class="control-panel-label">Status</label>
                            <select name="status" required>
                                <option value="published" @if($review->status=='published')selected @endif>Published</option>
                                <option value="pending" @if($review->status=='pending')selected @endif>Pending</option>
                                <option value="hidden" @if($review->status=='hidden')selected @endif>Hidden</option>
                            </select>
                            <button type="submit" class="control-panel-button control-panel-button-secondary">Save</button>
                        </form>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" style="margin-top: 1rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="control-panel-button control-panel-button-danger" onclick="return confirm('Delete this review?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-control-panel-layout>
