<style>
    .reviews-section .star-rating {
        font-size: 1.5rem;
        cursor: pointer;
    }
</style>
<style>
    .reviews-section .star-rating {
        font-size: 1.5rem;
        cursor: pointer;
    }
</style>

<!-- reviews Section -->


    <?php
        $is_add_reviews_button = $section_fields['btn_add_review_status'] ? 1 : 0;
        $is_load_more_button = $section_fields['btn_load_more_status'] ? 1 : 0;

        $total_reviews = array_sum(array_column($total_reviews_count_by_rating, 'total_reviews'));
        $ratings = $total_reviews_count_by_rating;
        $full_ratings = array_fill_keys([5, 4, 3, 2, 1], 0);
        
        $total_points = 0;
        foreach ($ratings as $item) {
            $rating = $item['rating'];
            $reviews = $item['total_reviews'];
            $full_ratings[$rating] = $reviews;
            $total_points += $rating * $reviews;
        }
        $average_rating = $total_reviews > 0 ? round($total_points / $total_reviews, 2) : 0;

        $review_stats  = [];
        foreach ($full_ratings as $rating => $reviews) {
            $review_stats [] = [
                'rating' => $rating,
                'total_reviews' => $reviews,
                'percent' => $total_reviews > 0 ? round(($reviews / $total_reviews) * 100, 2) : 0,
            ];
        }
    ?>
    <section class="py-5 overflow-hidden bg-body-tertiary reviews" data-aos="zoom-in">
        <div class="container">
            <div class="max-w-2xl mx-auto text-center pt-7 pb-4">
                <h2 class="m-0 text-primary text-base leading-7 fw-semibold">
                    <?=sanitize_output($section_fields['title'] ?? '') ; ?>
                </h2>
                <div class="m-0 mt-2 text-body-emphasis text-4xl leading-snug tracking-tight fw-bold m-b-1">
                    <?=sanitize_output($section_fields['short_desc'] ?? '') ; ?>
                </div>
                <div class="rating-box" data-aos="zoom-in" data-aos-delay="200">
                    <div class="d-flex align-items-center mb-3">
                        <div class="overall-rating me-3"><?= $average_rating; ?></div>
                        <div class="stars text-success">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php foreach ($review_stats  as $key => $item_review_stat): ?>
                            <div class="d-flex justify-content-between align-items-center mb-2" data-aos="zoom-in" data-aos-delay="500">
                                <span><?php echo $item_review_stat['rating']; ?> <i class="bi bi-star-fill"></i></span>
                                <div class="progress flex-grow-1 mx-2">
                                    <div class="progress-bar rating-bar" style="width: <?php echo number_format($item_review_stat['percent'], 2); ?>%;"></div>
                                </div>
                                <span><?php echo $item_review_stat['total_reviews']; ?></span>
                            </div>
                        <?php endforeach; ?> 
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-3" data-aos="zoom-in-down" data-aos-delay="600">
            <?php if (!empty($items_reviews)) : ?>
            <div id="reviews-content" class="row align-items-center align-items-xl-stretch flex-column flex-xl-row">
                <?php 
                    echo view('themes/regular/sections/child/reviews_section/items_list', ['items_reviews' => $items_reviews]);
                ?>           
            </div>
            <?php endif; ?>
            <div class="row justify-content-center mt-5 text-center">
                <div class="col-12">
                    <?php if ($is_add_reviews_button) : ?>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="bi bi-pencil-fill"></i> <?= __l("Share_your_feedback"); ?>
                        </button>
                    <?php endif; ?>
                    <?php
                        $btn_load_more_options = [
                            'spinner_selector'          => '.btnLoadMore .spinner',
                            'method'                    => 'GET',
                        ];
                    ?>
                    <?php if ($has_more_reviews && $is_load_more_button) : ?>
                    <button class="btnLoadMore btn btn-outline-primary" type="button" data-page="1" 
                            data-url="<?= base_url('load-more-reviews') ?>"
                            data-options='<?=json_encode($btn_load_more_options)?>'>
                        <span class="spinner-border spinner-border-sm spinner d-none" role="status" aria-hidden="true"></span>
                        <?= __l("Load_More"); ?>
                    </button>
                    <?php endif; ?>
                </div>  
            </div>
        </div>  
    </section>
<!-- Modal for reviews -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel"><?= __l("Submit_Your_Review"); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="sendForm" action="<?= base_url('submit-review')?>" method="POST">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label"><?= __l("Your_Name"); ?></label>
                        <input type="text" name="name" class="form-control" id="name" >
                        <!-- Error message for name validation -->
                        <div class="invalid-feedback error_name" ></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><?= __l("Email"); ?></label>
                        <input type="email" name="email" class="form-control" id="email" >
                        <!-- Error message for Email validation -->
                        <div class="invalid-feedback error_email"></div>
                    </div>
                    <div class="mb-3">
                        <label for="orderId" class="form-label"><?= __l("Order_ID"); ?></label>
                        <input type="text" name="client_order_id" class="form-control" id="orderId" >
                        <!-- Error message for order ID validation -->
                        <div class="invalid-feedback error_order_id"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?= __l("Rating"); ?></label>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="star-rating fs-3" id="starRating">
                                <i class="bi bi-star" data-value="1"></i>
                                <i class="bi bi-star" data-value="2"></i>
                                <i class="bi bi-star" data-value="3"></i>
                                <i class="bi bi-star" data-value="4"></i>
                                <i class="bi bi-star" data-value="5"></i>
                            </div>
                            <p id="rating_count" class="text-end mb-0 text-dark text-bold">5/5</p>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="5" required>
                        <!-- Error message for rating validation -->
                        <div class="invalid-feedback error_rating"></div>
                    </div>
                    <div class="mb-3">
                        <label for="reviewText" class="form-label"><?= __l("Your_Review"); ?></label>
                        <textarea class="form-control" name='review_text' id="reviewText" rows="10" ></textarea>
                        <!-- Error message for review text validation -->
                        <div class="invalid-feedback error_review_text"></div>
                    </div>
                    
                    <?= render_recaptcha_html('review_form'); ?>

                    <button class="btn btn-primary mb-3" type="submit" >
                        <span class="spinner-border spinner-border-sm spinner d-none" role="status" aria-hidden="true"></span>
                        <?= __l("Submit"); ?>
                    </button>
                    <div class="ajax-alert-message mt-2"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.star-rating i');
    const ratingInput = document.getElementById('rating');
    const ratingCount = document.getElementById('rating_count');

    // Set initial state: all stars filled (5 stars filled in yellow)
    document.addEventListener('DOMContentLoaded', function () {
        // Set all stars to be filled by default
        stars.forEach(star => {
            star.classList.remove('bi-star');        // Remove bi-star (empty)
            star.classList.add('bi-star-fill', 'text-warning'); // Add bi-star-fill and text-warning (yellow)
        });
        ratingCount.textContent = `5/5`; // Default rating text
    });

    // Hover effect: reset stars to empty (bi-star) and fill stars up to hovered star (bi-star-fill)
    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const ratingValue = this.getAttribute('data-value');
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= ratingValue) {
                    s.classList.remove('bi-star');            // Fill star
                    s.classList.add('bi-star-fill', 'text-warning');  // Add bi-star-fill and yellow color
                } else {
                    s.classList.remove('bi-star-fill', 'text-warning'); // Empty star
                    s.classList.add('bi-star');
                }
            });
        });

        // Reset stars to current rating when hover ends (mouseout)
        star.addEventListener('mouseout', function () {
            const currentRating = ratingInput.value;
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= currentRating) {
                    s.classList.remove('bi-star');            // Keep filled if already selected
                    s.classList.add('bi-star-fill', 'text-warning');
                } else {
                    s.classList.remove('bi-star-fill', 'text-warning');
                    s.classList.add('bi-star');               // Empty stars
                }
            });
        });

        // Click event: set the rating and fill stars up to clicked star
        star.addEventListener('click', function () {
            const ratingValue = this.getAttribute('data-value');
            ratingInput.value = ratingValue;  // Set the hidden rating input value

            // Update the rating count text
            ratingCount.textContent = `${ratingValue}/5`;
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= ratingValue) {
                    s.classList.remove('bi-star');            // Fill star
                    s.classList.add('bi-star-fill', 'text-warning');
                } else {
                    s.classList.remove('bi-star-fill', 'text-warning'); // Empty star
                    s.classList.add('bi-star');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {

        // Function to get CSRF token headers
        function get_csrf_headers() {
            // Get the token name from the meta tag
            var token_name = $('meta[name="csrf_name"]').attr('content');
            
            // Get the token value from the meta tag
            var token_value = $('meta[name="csrf_value"]').attr('content');
            
            // Create an object to store the CSRF token header
            var csrf_headers = {};
            
            // Add the token name and value to the headers object
            csrf_headers[token_name] = token_value;
            
            // Return the headers object containing the CSRF token
            return csrf_headers;
        }
        // Star rating logic can be handled here (mouseover, click, etc.)
    });
</script>

<script>
    // Initialize LoadMore functionality for all buttons with class 'load-more-btn'
    $(document).ready(function() {
        $('.loadMoreButton').each(function() {
            new LoadMore(this);  
        });
    });
</script>

