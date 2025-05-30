<?php if (!empty($post_categories)) : ?>
    <div class="row post-categories">
        <div class="col-12">
            <h4 class="mb-3"><?= __l("Post_Categories"); ?></h4>
            <?php foreach ($post_categories as $key => $post_category) : ?>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <a href="<?= blog_post_category_url($post_category['url_slug']); ?>" class="text-reset underline-hover"><?= sanitize_output($post_category['name']); ?></a>
                    <span class="badge border border-primary text-primary rounded-pill"><?= sanitize_output($post_category['post_count']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>	