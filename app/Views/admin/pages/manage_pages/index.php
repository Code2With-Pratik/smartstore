<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>
    <div class="container-xl">
        <?= $this->include('admin/partials/page_title') ?>
        <div class="row">
            <?php if (count($items) > 0): ?>
                    <div class="col-md-12 col-xl-12 items-by-category">
                        <div class="card">
                            <?= $this->include('admin/partials/card_header') ?>
                            <?php include('child/list.php'); ?>
                        </div>
                    </div>
                
            <?php else: ?>
                <?= $this->include('template/empty') ?>
            <?php endif ?>
        </div>
    </div>
<?= $this->endSection() ?>