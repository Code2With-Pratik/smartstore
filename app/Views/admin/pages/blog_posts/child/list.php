<div class="table-responsive sortable-content">
    <table class="table table-hover table-bordered table-vcenter card-table" data-sort_table_url="">
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php 
                foreach($items as $key => $item) {
                    $languages_icon = '';
                    $tdElements = [
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => show_item_checkbox('checkItem', $item['id']), 
                        ],
                        'name' => [
                            'class' => '', 'attr' => [], 
                            'element' => show_high_light(esc($item['name']), $params['search'], 'name'), 
                        ],
                        'status' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], 'switch'), 
                        ],
                        'icon' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => render_item_link_by_language($controller_name, $item, $items_language), 
                        ],
                        'released' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_datetime($item['released'], 'long'), 
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