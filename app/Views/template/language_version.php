<?php
  $edit_link = admin_url($controller_name . '/update/'. $item['id']);
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <ul>
                <?php foreach ($items_language as $key => $item_language) : ?>
                    <?php
                      if ($item_language['code'] != $language_code) {
                          $link = $edit_link .'?ref_lang='.$item_language['code'];
                          $flag_country = 'flag-icon-' . $item_language['code'];
                          echo sprintf('<li>
                                          <a href="%s" target="_blank"><span class="flag-icon flag-icon-%s"></span> %s <span class="fe fe-external-link"></span></a>
                                        </li>', $link, strtolower($item_language['country_code']), language_codes($item_language['code']));
                      }
                    ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
