<div class="table-responsive">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, true, false, false, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php 
                foreach($items as $key => $item) {
                    $tdElements = [
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => show_item_checkbox('checkItem', $item['id']), 
                        ],
                        'name' => [
                            'class' => 'text-center', 'attr' => [], 
                            'element' => language_codes($item['code']), 
                        ],
                        'code' => [
                            'class' => 'text-center', 'attr' => [], 
                            'element' => strtoupper($item['code']), 
                        ],
                        'icon' => [
                            'class' => 'text-center', 'attr' => [], 
                            'element' => '<span class="flag-icon flag-icon-'.strtolower($item['country_code']).'"></span>', 
                        ],
                        'default' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['is_default'], ''), 
                        ],
                        'status' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], ''), 
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