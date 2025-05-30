<div class="table-responsive sortable-content">
    <table class="table table-hover table-bordered table-vcenter card-table" data-sort_table_url="<?=admin_url($controller_name . '/' . 'sort_table')?>">
    <?php echo render_table_thead($tb_columns, false, false, true, ['sort-table' => true]) ?>
        <tbody class="ui-sortable">
            <?php 
                foreach($items as $key => $item) {

                    $item_type = config('AppConfig')->template['menu_type'][$item['type']];
                    $item_target = config('AppConfig')->template['form_link_target'][$item['target']];
                    $tdElements = [
                        'sort_handler' => [
                            'class' => 'sort-handler text-center w-5p', 'attr' => [], 
                            'element' => '<i class="fe fe-grid"></i>', 
                        ],
                        'name' => [
                            'class' => '', 'attr' => [], 
                            'element' => $item['name'] 
                        ],
                        'type' => [
                            'class' => 'text-center ', 'attr' => [], 
                            'element' => $item_type
                        ],
                        'target' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => $item_target
                        ],
                        'status' => [
                            'class' => 'text-center w-15p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], 'switch'), 
                        ],
                        'button' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_button_action($controller_name, $item['id']), 
                        ],
                    ];
                    $trElement = [
                        'class' => 'tr_' . $item['ids'],
                        'attr'  => ['id' => $item['id']],
                        'tdElements' => $tdElements,
                    ];
                    echo renderTableTr($item, $trElement, $params);
                }
            ?> 
        </tbody>
    </table>
</div>