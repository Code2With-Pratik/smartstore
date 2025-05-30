<?php
    $social_links  = get_app_setting('social_links');
    $social_links = json_decode($social_links, true);
?>
<?php if ($social_links ) : ?>

    <style>
        .btn-social {
            border: none;
        }
        .twitter-btn {
            background-color: #1DA1F2;
        }

        .facebook-btn {
            background-color: #1877F2; 
        }

        .instagram-btn {
            background-color: #E1306C; 
        }

        .linkedin-btn {
            background-color: #0077B5; 
        }

        .youtube-btn {
            background-color: #FF0000; 
        }

        .tiktok-btn {
            background-color: #000000; 
        }

        .whatsapp-btn {
            background-color: #4fe565; 
        }

        .pinterest-btn {
            background-color: #e8292f; 
        }

        a.btn-social:hover {
            background-color: inherit!important; 
            color: #fd7702!important;
            border:solid 1px #fd7702!important;
        }
    </style>
    
    <div class="row follow-us">
        <div class="col-12 col-sm-6 col-lg-12">
            <h4 class="mt-4 mb-3"><?= __l("Follow_Us"); ?></h4>
            <div class="row">
                <?php foreach ($social_links as $key => $social_link): ?>
                <div class="col-md-6 mb-2">
                    <a href="<?=sanitize_output($social_link['link'])?>" target="_blank" class="btn btn-social <?=sanitize_output($key)?>-btn d-flex align-items-center justify-content-start text-white">
                        <span class="me-2">
                            <i class="<?= sanitize_output($social_link['icon']); ?>"></i>
                        </span> <?= ucfirst(sanitize_output($key)); ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>