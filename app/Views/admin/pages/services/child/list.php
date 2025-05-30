<div class="table-responsive sortable-content">
    <table class="table table-hover table-bordered table-vcenter card-table" data-sort_table_url="<?=admin_url($controller_name . '/' . 'sort_table')?>">
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => true, 'checkboxDataName' => $items_category[0]['cate_id']]); ?>
        <tbody class="ui-sortable">
            <?php
                foreach($items_category as $key => $item) {
                    include('item_row.php');
                }
            ?> 
        </tbody>
    </table>
</div>