<div class="table-responsive">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php 
                foreach($items as $key => $item) {
                    $tdElements = [
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => show_item_checkbox('checkItem', $item['id']), 
                        ],
                        'id' => [
                            'class' => 'text-center w-5p', 'attr' => [], 
                            'element' => show_item_orderId($controller_name, $item, $params), 
                        ],
                        'client_order_id' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => '<strong>' . show_high_light(esc($item['client_order_id']), $params['search'], 'client_order_id') . '</strong>', 
                        ],
                        'user' => [
                            'class' => 'text-center ', 'attr' => [], 
                            'element' => show_high_light(esc($item['email']), $params['search'], 'email'), 
                        ],
                        'order_details' => [
                            'class' => '', 'attr' => [], 
                            'element' => show_item_order_details($controller_name, $item, $params), 
                        ],
                        'created' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_datetime($item['created'], 'long'), 
                        ],
                        'response' => [
                            'class' => 'text-center w-10p text-danger', 'attr' => [], 
                            'element' => esc($item['note']), 
                        ],
                        'status' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], ''), 
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