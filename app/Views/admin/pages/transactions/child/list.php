
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
                            'class' => 'text-center text-muted w-5p', 'attr' => [], 
                            'element' => show_high_light(esc($item['id']), $params['search'], 'id'), 
                        ],
                        'order_id' => [
                            'class' => 'text-center ', 'attr' => [], 
                            'element' => show_high_light(esc($item['order_id']), $params['search'], 'order_id'), 
                        ],
                        'customer' => [
                            'class' => 'text-center ', 'attr' => [], 
                            'element' => show_high_light(esc($item['email']), $params['search'], 'email'), 
                        ],
                        'payment' => [
                            'class' => 'text-center text-muted w-5p', 'attr' => [], 
                            'element' => ucfirst($item['type']) 
                        ],
                        'tnx_id' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => truncate_string_with_highlight(esc($item['transaction_id']), 25, "...", true, $params['search'], 'transaction_id'), 
                        ],
                        'amount' => [
                            'class' => 'text-center ', 'attr' => [], 
                            'element' => (double)$item['amount'] 
                        ],
                        'status' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], ''), 
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