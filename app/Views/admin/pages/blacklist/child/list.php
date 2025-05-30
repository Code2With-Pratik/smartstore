<div class="table-responsive">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php
                foreach($items as $key => $item) {
                    if ($params['sub_controller'] == 'ip')  $blacklist_content = show_high_light(esc($item['ip']), $params['search'], 'ip');
                    if ($params['sub_controller'] == 'link')  $blacklist_content = show_high_light(esc($item['link']), $params['search'], 'link');
                    if ($params['sub_controller'] == 'email')  $blacklist_content = show_high_light(esc($item['email']), $params['search'], 'email');
                    $tdElements = [
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => show_item_checkbox('checkItem', $item['id']), 
                        ],
                        'name' => [
                            'class' => 'w-20p', 'attr' => [], 
                            'element' => $blacklist_content, 
                        ],
                        'description' => [
                            'class' => '', 'attr' => [], 
                            'element' => truncate_string(esc($item['description']), 200), 
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
                            'element' => show_item_button_action($controller_name, $item['id'], 'dropdown1', ['http_build_query' => ['action_type' => $params['sub_controller']]]), 
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