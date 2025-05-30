<div class="table-responsive sortable-content">
    <table class="table table-hover table-bordered table-vcenter card-table" data-sort_table_url="<?=admin_url($controller_name . '/' . 'sort_table')?>">
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => true, 'checkboxDataName' => $items_category[0]['main_sn_id']]); ?>
        <tbody class="ui-sortable">
            <?php 
                foreach($items_category as $key => $item) {
                    $tdElements = [
                        'sort_handler' => [
                            'class' => 'sort-handler w-1p', 'attr' => [], 
                            'element' => '<i class="fe fe-grid"></i>', 
                        ],
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => show_item_checkbox('checkItem', $item['id'], 'checkItem', $item['main_sn_id']), 
                        ],
                        'id' => [
                            'class' => 'text-center w-5p', 'attr' => [], 
                            'element' => sanitize_output($item['id']), 
                        ],
                        'name' => [
                            'class' => ' w-20p', 'attr' => [], 
                            'element' => show_high_light(sanitize_output($item['name']), $params['search'], 'name'), 
                        ],
                        'icon' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => render_item_link_by_language($controller_name, $item, $items_language), 
                        ],
                        'status' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], 'switch'), 
                        ],
                        'changed' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_datetime($item['changed'], 'long'), 
                        ],
                        'created' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_datetime($item['created'], 'long'), 
                        ],
                        'button' => [
                            'class' => 'text-center w-5p', 'attr' => [], 
                            'element' => show_item_button_action($controller_name, $item['id']), 
                        ],
                    ];
                    $tr_class_html_active = ($item['status']) ? '' : 'row-disabled';
                    $trElement = [
                        'class' => 'tr_' . $item['ids'] . ' ' . $tr_class_html_active,
                        'attr'  => ['id' => $item['id']],
                        'tdElements' => $tdElements,
                    ];
                    echo renderTableTr($item, $trElement, $params);
                }
            ?> 
        </tbody>
    </table>
</div>