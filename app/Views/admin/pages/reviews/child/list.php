<div class="table-responsive sortable-content">
    <table class="table table-hover table-bordered table-vcenter card-table" >
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php 
                
                foreach($items as $key => $item) {
                    include('item_row.php');
                    
                }
            ?> 
        </tbody>
    </table>
</div>