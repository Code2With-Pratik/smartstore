<?php
    $collapse_id = 'collapse-'.$section_type . ids();
    $draff_icon = ($section_form_type == 'default_form') ? 'fe fe-chevrons-left' :'fe fe-move';
?>
<div class="section-item" data-type="<?=$section_type?>" data-order="<?=$section_order?>" draggable="false">
    <div class="card-header">
        <h5 class="card-title sortable-item"><i class="<?=$draff_icon?>"></i> <?php echo $title; ?></h5>
        <?php if ($section_form_type == 'input_form') : ?>
        <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="collapse" data-target="#<?php echo $collapse_id; ?>" draggable="false" aria-expanded="true">
                <i class="fe fe-chevron-up"></i>
            </a>
            <a class="remove-btn" onclick="removeItem(event)" draggable="false"><i class="fe fe-x"></i></a>
        </div>
        <?php endif; ?>
    </div>
    <!-- //collapse -->
    <div class="card-body <?php  echo ($section_form_type == 'default_form' ? 'collapse' : 'collapse') ?>" id="<?php echo $collapse_id; ?>">
        <?php echo $section_content; ?>
    </div>
</div>