<?php
    $author_post = get_app_setting('blog_author_name');
?>
<?php foreach ($items_post as $key => $item_post) : ?>
    <?php
        $item_content 	= sanitize_output($item_post['content']);
        $item_content 	= html_entity_decode($item_content);
        $item_content 	= truncate_string(strip_tag_css($item_content, 'html'), 150);
        $item_released 	= show_client_date_time($item_post['released']);
    ?>
    <div class="col-sm-6 item">
        <div class="card">
            <!-- Card img -->
            <div class="position-relative">
                <img class="card-img" src="<?= sanitize_output($item_post['image'] ?? '') ?>" alt="<?= sanitize_output($item_post['name'] ?? '') ?>">
            </div>
            <div class="card-body px-0 pt-3">
                <h4 class="card-title mt-2">
                    <a href="<?= blog_post_single_url($item_post['url_slug']) ?>" class="text-reset underline-hover"><?= sanitize_output($item_post['name'] ?? '') ?></a>
                </h4>
                <p class="card-text"><?= esc($item_content) ?></p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xs me-2">
                            <img class="avatar-img rounded-circle" src="<?= base_url('assets/images/author-avatar.png'); ?>" alt="avatar">
                        </div>
                        <span><?= __l("by"); ?> <a href="<?= client_url(); ?>" class="text-reset"><?= esc($author_post); ?></a></span>
                    </div>
                    <span><?= esc($item_released) ?></span>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>