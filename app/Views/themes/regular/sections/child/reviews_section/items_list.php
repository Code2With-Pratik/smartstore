<?php foreach ($items_reviews as $key => $item_review): ?>
    <div class="col-12 col-sm-10 col-md-7 col-lg-6 col-xl-4 mt-3">
        <div class="p-3 h-100 d-flex flex-column bg-body-tertiary shadow rounded-4">
            <div class="d-flex align-items-center fs-5">
                <i class="bi bi-chat-left fs-3 me-4"></i> 
                <h5 class=""><?=sanitize_output($item_review['name']); ?> <i class="bi bi-check text-success me-2"></i></h5>
            </div>
            <div class="text-warning">
                <?php 
                    $rating = $item_review['rating']; 
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $rating) {
                            echo '<i class="bi bi-star-fill"></i>';
                        } else {
                            echo '<i class="bi bi-star"></i>';
                        }
                    }
                ?>
            </div>
            <p>"<?=sanitize_output($item_review['comment']); ?>"</p>
        </div>
    </div>
<?php endforeach; ?>