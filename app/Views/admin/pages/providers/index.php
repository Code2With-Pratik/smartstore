<?= $this->extend('admin/main_blade') ?>

<?= $this->section('content') ?>
    <?= $this->include('admin/partials/page_title') ?>
    <?= $this->include('admin/partials/page_filter') ?>
    <div class="row">
        <?php if (count($items) > 0): ?>
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <?= $this->include('admin/partials/card_header') ?>
                <?= $this->include($path_view_controller . 'child/list') ?>
            </div>
        </div>
        <div class="col-md-12">
            <?= $this->include('admin/partials/pagination') ?>
        </div>
        <?php else: ?>
        <?= $this->include('template/empty') ?>
        <?php endif ?>
    </div>
<?= $this->endSection() ?>