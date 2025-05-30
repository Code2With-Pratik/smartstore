<?php
    $filerStatusButton = show_filter_status_button($controller_name, $items_status_count, $params);
    $show_search_area    = show_search_area($controller_name, $params);
?>
<div class="row">
    <div class="col-md-8">
        <?= $filerStatusButton; ?>
    </div>
    <div class="col-md-4 search-area">
        <?= $show_search_area; ?>
    </div>
</div>