<div class="table-responsive">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, false, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php
                $i = 0; 
                foreach($items as $key => $item) {
                    include('item_row.php');
                }
            ?> 
        </tbody>
    </table>
</div>