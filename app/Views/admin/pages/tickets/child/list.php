
<div class="table-responsive">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, true, false, true, ['sort-table' => false]); ?>
        <tbody class="ui-sortable">
            <?php 
                foreach($items as $key => $item) {
                    $item_subject = show_high_light(esc($item['subject']), $params['search'], 'subject');
                    $detail_link = admin_url($controller_name . '/send_mail/' . $item['id']);
                    $item_subject_html =  sprintf('<a href="%s" data-toggle="tooltip" data-placement="top" title="Details" class="ajaxModal">%s</a>', $detail_link, $item_subject);
                    $tdElements = [
                        'checkBox' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => show_item_checkbox('checkItem', $item['id']), 
                        ],
                        'id' => [
                            'class' => 'text-center w-5p', 'attr' => [], 
                            'element' => show_high_light(esc($item['id']), $params['search'], 'id'), 
                        ],
                        'from' => [
                            'class' => 'w-15p', 'attr' => [], 
                            'element' => show_high_light(esc($item['from']), $params['search'], 'from'), 
                        ],
                        'subject' => [
                            'class' => 'text-center w-15p', 'attr' => [], 
                            'element' => $item_subject_html, 
                        ],
                        'ip' => [
                            'class' => 'text-center w-15p', 'attr' => [], 
                            'element' => show_high_light(esc($item['ip']), $params['search'], 'ip'), 
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