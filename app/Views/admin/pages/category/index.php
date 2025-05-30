<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>

    <?= $this->include('admin/partials/page_title') ?>
    <div class="row">
        <?php if (count($items) > 0): ?>
            <?php foreach ($items as $key => $items_category): ?>
                <?php
                    $item_category_status = (int)$items_category['0']['status'];
                    $class_html_active = ($item_category_status === 1) ? '' : 'row-disabled';
                ?>
                <div class="col-md-12 col-xl-12 items-by-category">
                    <div class="card">
                        <div class="card-header <?= $class_html_active; ?>">
                            <h4 class="card-title">
                                <?=sanitize_output($key);?>
                            </h4>
                            <div class="card-options">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <?php include('child/list.php'); ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <?= $this->include('template/empty') ?>
        <?php endif ?>
    </div>
<?= $this->endSection() ?>