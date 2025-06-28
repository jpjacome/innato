@props(['reviews' => []])

<!-- Reviews Section -->
<section id="reviews" class="wrapper reviews-section section-light">
    <i class="ph ph-arrow-left reviews-icon reviews-icon-left"></i>
    <div class="reviews-list">
        @forelse($reviews as $review)
            <x-review-card 
                :rating="$review['rating'] ?? 4" 
                :text="$review['text']" 
                :reviewer="$review['reviewer']" 
            />
        @empty
            {{-- Default reviews if none provided --}}
            <x-review-card 
                rating="4" 
                text="Excellent as always! This is a very nice choice if you like good food and a superb environment." 
                reviewer="Jhon Doe" 
            />
            <x-review-card 
                rating="4" 
                text="A wonderful experience! The staff was friendly and the place was beautiful." 
                reviewer="Maria Perez" 
            />
            <x-review-card 
                rating="3" 
                text="Unforgettable trip, highly recommended for families." 
                reviewer="Carlos Ruiz" 
            />
            <x-review-card 
                rating="4" 
                text="Great value and amazing guides. Will come back!" 
                reviewer="Ana Gómez" 
            />
            <x-review-card 
                rating="3" 
                text="The best eco-tourism experience in Ecuador." 
                reviewer="Luis Torres" 
            />
        @endforelse
    </div>
    <i class="ph ph-arrow-right reviews-icon reviews-icon-right"></i>
</section>
