@extends('layouts.front')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('frontend/images/bg_3.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ route('welcome') }}">Home <i class="ion-ios-arrow-forward"></i></a></span>
                        <span class="mr-2"><a href="{{ route('bookings.history') }}">Bookings <i class="ion-ios-arrow-forward"></i></a></span>
                        <span>Write Review <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Write a Review</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- Review Form Section --}}
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {{-- Vehicle Info Card --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <img src="{{ $booking->kendaraan->images->where('is_primary', 1)->first() 
                                            ? asset('storage/' . $booking->kendaraan->images->where('is_primary', 1)->first()->image_path) 
                                            : asset('frontend/images/car-1.jpg') }}" 
                                         alt="{{ $booking->kendaraan->brand }}"
                                         class="img-fluid rounded">
                                </div>
                                <div class="col-md-8">
                                    <h4 class="font-weight-bold mb-2">
                                        {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                                    </h4>
                                    <p class="text-muted mb-2">
                                        <i class="fa fa-calendar mr-2"></i>
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="fa fa-hashtag mr-2"></i>
                                        Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Review Form --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="font-weight-bold mb-4">
                                ⭐ Rate Your Experience
                            </h4>

                            <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="rating" id="ratingValue" value="">

                                {{-- Star Rating with Emoji --}}
                                <div class="form-group">
                                    <label class="font-weight-bold">Overall Rating <span class="text-danger">*</span></label>
                                    <div class="rating-container">
                                        <div class="star-rating-wrapper">
                                            <span class="star-btn" data-rating="1">⭐</span>
                                            <span class="star-btn" data-rating="2">⭐</span>
                                            <span class="star-btn" data-rating="3">⭐</span>
                                            <span class="star-btn" data-rating="4">⭐</span>
                                            <span class="star-btn" data-rating="5">⭐</span>
                                        </div>
                                        <span class="rating-text ml-3">Click to rate</span>
                                    </div>
                                    @error('rating')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Comment --}}
                                <div class="form-group">
                                    <label class="font-weight-bold">Your Review <span class="text-danger">*</span></label>
                                    <textarea name="comment" 
                                              class="form-control @error('comment') is-invalid @enderror" 
                                              rows="6" 
                                              placeholder="Share your experience with this vehicle. What did you like? What could be improved?"
                                              required
                                              minlength="10"
                                              maxlength="1000">{{ old('comment') }}</textarea>
                                    <small class="form-text text-muted">
                                        <span id="charCount">0</span>/1000 characters (minimum 10 characters)
                                    </small>
                                    @error('comment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Info Box --}}
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle mr-2"></i>
                                    <strong>Note:</strong> Your review will be visible after admin approval. 
                                    Please be honest and constructive in your feedback.
                                </div>

                                {{-- Buttons --}}
                                <div class="d-flex justify-content-between pt-3">
                                    <a href="{{ route('bookings.history') }}" class="btn btn-secondary px-4">
                                        <i class="fa fa-arrow-left mr-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="fa fa-paper-plane mr-2"></i>Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
/* Star Rating dengan Emoji */
.rating-container {
    display: flex;
    align-items: center;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    margin-bottom: 10px;
    border: 2px solid #dee2e6;
}

.star-rating-wrapper {
    display: flex;
    gap: 8px;
}

.star-btn {
    background: none !important;
    border: none !important;
    font-size: 3rem;
    cursor: pointer;
    padding: 5px;
    transition: all 0.3s ease;
    filter: grayscale(100%);
    opacity: 0.4;
    line-height: 1;
    outline: none !important;
    box-shadow: none !important;
}

.star-btn:focus,
.star-btn:active,
.star-btn:focus:active,
.star-btn:hover:focus {
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
    background: none !important;
}

.star-btn:hover {
    transform: scale(1.2) rotate(15deg);
    filter: grayscale(0%);
    opacity: 1;
}

.star-btn.active {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.1);
    animation: bounce 0.3s ease;
}

@keyframes bounce {
    0%, 100% { transform: scale(1.1); }
    50% { transform: scale(1.3); }
}

.rating-text {
    font-size: 1.2rem;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.3s ease;
}

/* Form Styles */
.card {
    border-radius: 15px;
    overflow: hidden;
}

textarea.form-control {
    resize: vertical;
    border-radius: 8px;
    border: 2px solid #dee2e6;
    padding: 15px;
}

textarea.form-control:focus {
    border-color: #1089ff;
    box-shadow: 0 0 0 0.2rem rgba(16, 137, 255, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .star-btn {
        font-size: 2.5rem;
        padding: 3px;
    }

    .star-rating-wrapper {
        gap: 5px;
    }

    .rating-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .rating-text {
        margin-left: 0 !important;
        margin-top: 15px;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }

    .d-flex.justify-content-between .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="comment"]');
    const charCount = document.getElementById('charCount');
    const ratingText = document.querySelector('.rating-text');
    const ratingValue = document.getElementById('ratingValue');
    const starButtons = document.querySelectorAll('.star-btn');
    let selectedRating = 0;

    console.log('Review form loaded'); // Debug

    // Star Rating Handler
    starButtons.forEach((btn) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            selectedRating = parseInt(this.getAttribute('data-rating'));
            ratingValue.value = selectedRating;
            
            console.log('Rating selected:', selectedRating); // Debug
            
            updateStars(selectedRating);
            updateRatingText(selectedRating);
        });

        // Hover effect
        btn.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.getAttribute('data-rating'));
            updateStarsHover(hoverRating);
        });
    });

    // Reset hover saat mouse keluar
    document.querySelector('.star-rating-wrapper').addEventListener('mouseleave', function() {
        updateStars(selectedRating);
    });

    function updateStars(rating) {
        starButtons.forEach((btn, index) => {
            if (index < rating) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    function updateStarsHover(rating) {
        starButtons.forEach((btn, index) => {
            if (index < rating) {
                btn.style.filter = 'grayscale(0%)';
                btn.style.opacity = '1';
            } else {
                btn.style.filter = 'grayscale(100%)';
                btn.style.opacity = '0.4';
            }
        });
    }

    function updateRatingText(rating) {
        const texts = {
            '5': '⭐ Excellent! Amazing service!',
            '4': '⭐ Very Good! Really satisfied!',
            '3': '⭐ Good! It was okay',
            '2': '⭐ Fair! Could be better',
            '1': '⭐ Poor! Not satisfied'
        };
        ratingText.textContent = texts[rating];
        
        // Change color based on rating
        if (rating >= 4) {
            ratingText.style.color = '#28a745';
        } else if (rating >= 3) {
            ratingText.style.color = '#ffc107';
        } else {
            ratingText.style.color = '#dc3545';
        }
        ratingText.style.fontWeight = 'bold';
    }

    // Character counter
    if (textarea) {
        charCount.textContent = textarea.value.length;
        
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Form validation
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        const comment = textarea.value.trim();

        if (!selectedRating || selectedRating === 0) {
            e.preventDefault();
            alert('⭐ Please select a rating by clicking the stars above!');
            return false;
        }

        if (comment.length < 10) {
            e.preventDefault();
            alert('✍️ Please write at least 10 characters for your review!');
            textarea.focus();
            return false;
        }

        console.log('Form submitted with rating:', selectedRating); // Debug
        return true;
    });
});
</script>
@endpush