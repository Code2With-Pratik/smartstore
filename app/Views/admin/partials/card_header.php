<?php
    $xhtmlActionsBtn = show_bulk_actions($controller_name);
?>
<div class="card-header massAction">
    <h3 class="card-title">Lists</h3>
    <div class="btnActions d-none btn-group" role="group" aria-label="Basic example">
        <span class="btn btn-primary m-r-2 number-items-selected"> 00 items selected</span>
        <?php echo $xhtmlActionsBtn; ?>
    </div>
    <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
    </div>
</div>