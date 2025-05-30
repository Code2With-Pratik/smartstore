<?php
  $card_title = (isset($title)) ? $title : 'Card Title';
  $card_body = (isset($card_body)) ? $card_body : 'Null';

  $card_collapse_class = (isset($is_card_collapsed) && $is_card_collapsed) ? 'card-collapsed' : '';

  $collapsed_icon_class = ($card_collapse_class == 'card-collapsed') ? '<i class="fe fe-chevron-down"></i>' : '<i class="fe fe-chevron-up"></i>';
  $card_collapse_title = (isset($collapse_title) && $collapse_title) ? $collapse_title : $collapsed_icon_class;
  $is_remove_card = (isset($is_remove_card) && $is_remove_card) ? true : false;
?>

<div class="card <?= $card_collapse_class ?>">
  <div class="card-header">
    <h3 class="card-title"><?= $card_title ?></h3>
    <div class="card-options">
      <a href="#" class="card-options-collapse" data-toggle="card-collapse">
        <?= $card_collapse_title; ?>
      </a>
      <?php if ($is_remove_card) : ?>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
      <?php endif; ?>
    </div>
  </div>
  <div class="card-body">
    <?= $card_body ?>
  </div>
</div>