<div class="table-responsive">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, false, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php 
                $i = 1;
                foreach($items as $key => $item) {
                    $tdElements = [
                        
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => $i++, 
                        ],
                        'email' => [
                            'class' => '', 'attr' => [], 
                            'element' => show_high_light(esc($item['email']), $params['search'], 'email'), 
                        ],
                        'total_orders' => [
                            'class' => 'text-center', 'attr' => [], 
                            'element' => sanitize_output($item['total_orders']), 
                        ],
                        'total_spent' => [
                            'class' => 'text-center', 'attr' => [], 
                            'element' => format_price_with_currency($item['total_spent']), 
                        ],
                        'ip' => [
                            'class' => 'text-center', 'attr' => [], 
                            'element' => show_high_light(esc($item['history_ip']), $params['search'], 'history_ip'), 
                        ],
                        'description' => [
                            'class' => '', 'attr' => [], 
                            'element' => strip_tags($item['description']), 
                        ],
                        'last_order' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_datetime($item['last_order'], 'long'), 
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