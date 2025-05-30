<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>
    <?= $this->include('admin/partials/page_title') ?>

    <div class="row">
        <?php if (!empty($item_plugins)) : ?>
            <div class="col-md-12">
                <div class="row row-cards">
                    <?php
                        foreach ($item_plugins as $key => $row) :
                            $version = $row->version;
                            $purchase_exist = false;
                            $check_upgrade  = false;
                            
                            foreach ($items_installed as $key => $item_installed) {
                                if ($row->app_id == $item_installed['pid']) {
                                    $purchase_exist = true;
                                    $version = $item_installed['version'];
                                    if (version_compare($row->version, $item_installed['version'], '>')) {
                                        $check_upgrade = true;
                                        $purchase_code = $item_installed['purchase_code'];
                                    }
                                }
                            }
                    ?>
                        <div class="col-sm-6 col-lg-4 module-item">
                            <div class="card p-3">
                                <a target="_blank" href="<?=$row->link?>" class="mb-3">
                                    <img src="<?=$row->thumbnail?>" alt="<?=sanitize_output($row->name)?>" class="rounded">
                                </a>
                                <div class="d-flex align-items-center px-2">
                                    <div>
                                        <div class="product-name">
                                            <a href="<?=$row->link?>" target="_blank">
                                                <?=sanitize_output($row->name)?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ml-auto text-muted">
                                        <small>ver<?=$version?></small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center px-2 m-t-5">
                                    <div>
                                        <div class="product-price">
                                            $<?=$row->price?>
                                        </div>
                                    </div>
                                    <div class="ml-auto text-muted">
                                    <?php
                                        if (!$purchase_exist) {
                                            echo '<a href="'.$row->link.'" target="_blank" class="btn btn-pill btn-info btn-sm">Buy Now</a>';
                                        } else {
                                            if ($check_upgrade) {
                                                $url = admin_url($controller_name."/store/");
                                                echo '<a href="'.$url.'" class="btn btn-pill btn-primary btn-sm ajaxUpgradeVersion" data-purchase_code="'. $purchase_code .'"><i class="fe fe-arrow-up"></i> Upgrade version'.$row->version.'</a>';
                                            } else {
                                                echo '<span class="btn btn-pill btn-gray btn-sm">Purchased</span>';
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?= $this->endSection() ?>
