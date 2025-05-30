<?= $this->extend('admin/main_blade') ?>

<?= $this->section('content') ?>
    <?= $this->include('admin/partials/page_title') ?>
    <div class="row ">
        <?php if (count($items) > 0): ?>
        <div class="col-md-12 col-xl-12 ">
            <div class="card">
                <?= $this->include('admin/partials/card_header') ?>
                <?= $this->include($path_view_controller . 'child/list') ?>
            </div>
            <?= $this->include('admin/partials/pagination') ?>
        </div>
        <?php else: ?>
        <?= $this->include('template/empty') ?>
        <?php endif ?>
    </div>
<?= $this->endSection() ?>