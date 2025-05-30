<?php
    $author_post = get_app_setting('blog_author_name');
    $item_content 	= sanitize_output($item_post['content']);
    $item_released 	= show_client_date_time($item_post['released']);
?>
<style>
    .next-previous-post .post-image {
        width: 70px;
        height: 70px; 
        object-fit: cover;
    }

    .next-previous-post .post-link {
        height: 70px;
        display: flex;
        flex-direction: column;
        justify-content: center; 
        text-align: left;
    }

    .next-previous-post .post-link-right {
        text-align: right;
    }

</style>

<section class="post-single overflow-hidden py-6 py-md-6 py-xl-8 position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="post px-0 px-md-5">
                    <h1 class=""><?= sanitize_output($item_post['name']); ?></h1>
                    <div class="mt-2 post-meta">
                        <p>
                            <i><?= __l("by"); ?></i> <span class="author"><?= esc($author_post); ?></span> 
                            <span class="separator">|</span> 
                            <a href="<?= blog_post_category_url($item_post['blog_category_url_slug']); ?>" class="category"><?= esc($item_post['blog_category_name']); ?></a> 
                            <span class="separator">|</span> 
                            <span class="date"><?= esc($item_released); ?></span>
                        </p>
                    </div>
                    <img src="<?= esc($item_post['image'] ?? '') ?>" alt="<?= sanitize_output($item_post['name'] ?? '') ?>" class="img-fluid mb-4 rounded-3">
                    <div class="post-single-content">
                        <?= html_entity_decode($item_content); ?>
                    </div>

                    <?php if (!empty($items_pagination)): ?>
                        <?php
                            $item_prev = $items_pagination['item_prev'] ?? '';
                            $item_next = $items_pagination['item_next'] ?? '';
                        ?>
                        <div class="next-previous-post d-flex justify-content-between align-items-center mt-6">
                            <!-- Previous Post -->
                            <?php if ($item_prev): ?>
                                <?php $post_name = $item_prev['name']; ?>
                                <div class="d-flex align-items-center">
                                    <img src="<?= esc($item_prev['image']) ?>" alt="<?= sanitize_output($post_name)?>" class="img-fluid rounded-3 me-2 post-image">
                                    <a href="<?= blog_post_single_url($item_prev['url_slug']) ?>" class="text-reset underline-hover post-link post-link-left">
                                        <span><i class="bi bi-arrow-left fw-bold"></i> <small><?= __l("Previous_post"); ?></small></span>
                                        <b data-bs-toggle="tooltip" title="<?= sanitize_output($post_name)?>">
                                            <?= truncate_string($post_name, 30); ?>
                                        </b>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($item_next): ?>
                                <?php $post_name = $item_next['name']; ?>
                                <div class="d-flex align-items-center <?= !$item_prev ? 'ms-auto' : '' ?>">
                                    <a href="<?= blog_post_single_url($item_next['url_slug']) ?>" class="text-reset underline-hover post-link post-link-right" >
                                        <span><small><?= __l("Next_post"); ?></small> <i class="bi bi-arrow-right fw-bold"></i></span>
                                        <b data-bs-toggle="tooltip" title="<?= sanitize_output($post_name)?>">
                                            <?= truncate_string($post_name, 30); ?>
                                        </b>
                                    </a>
                                    <img src="<?= esc($item_next['image']) ?>" alt="<?= sanitize_output($post_name)?>" class="img-fluid ms-2 rounded-3 post-image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>    
                </div>
            </div>
            <div class="col-lg-3">
                <div class="py-7">
                    <div class="row">
                        <h4 class="mb-3"><?= __l("Share_this_article"); ?></h4>
                        <div class="social-share mt-1">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" class="btn btn-outline-primary me-2"><i class="bi bi-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>" class="btn btn-outline-info me-2"><i class="bi bi-twitter" target="_blank"></i></a>
                            <a href="https://www.instagram.com" class="btn btn-outline-danger me-2"><i class="bi bi-instagram" target="_blank"></i></a>
                            <a href="https://wa.me/?text=<?= current_url() ?>" class="btn btn-outline-dark"><i class="bi bi-whatsapp" target="_blank"></i></a>
                        </div>
                    </div>
                    <?php if (!empty($items_related_post)): ?>
                    <div class="row rencent-posts">
                        <!-- Recent post widget START -->
                        <div class="col-12 col-sm-6 col-lg-12">
                            <h4 class="mt-4 mb-3"><?= __l("Posts_in_this_Category"); ?></h4>
                            <?php foreach ($items_related_post as $key => $item_related_post) : ?>
                                <?php
                                    $post_name = sanitize_output($item_related_post['name']);
                                ?>   
                                <div class="card border-0 mb-3 post-item">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-4">
                                            <a href="<?= blog_post_single_url($item_related_post['url_slug']); ?>" class="text-reset underline-hover">
                                                <img class="rounded" src="<?= sanitize_output($item_related_post['image'] ?? '')?>" alt="<?= sanitize_output($item_related_post['name']); ?>">
                                            </a>
                                        </div>
                                        <div class="col-8">
                                            <a href="<?= blog_post_single_url($item_related_post['url_slug']); ?>" class="text-reset underline-hover fs-6"><?= truncate_string($post_name, 40); ?></a>
                                            <div class="small mt-1 post-date"><?= show_client_date_time($item_related_post['released']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div> 
    </div>
</section>