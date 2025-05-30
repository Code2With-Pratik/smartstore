<div class="table-responsive sortable-content">
    <table class="table table-hover table-bordered table-vcenter card-table">
        <?php echo render_table_thead($tb_columns, false, true, true, ['sort-table' => false]); ?>
        <tbody>
            <?php 
                $i = 0 ;
                foreach ($items as $key => $item):  $i++; 
            ?>
                <?php
                    $td_elements = [
                        'id' => [
                            'class' => 'text-center w-1p', 'attr' => [], 
                            'element' => $i, 
                        ],
                        'name' => [
                            'class' => ' w-20p', 'attr' => [], 
                            'element' => show_high_light(sanitize_output($item['name']), $params['search'], 'name'), 
                        ],
                        'template' => [
                            'class' => '', 'attr' => [], 
                            'element' => ucfirst(str_replace('_', ' ', $item['page_type'])), 
                        ],
                        'icon' => [
                            'class' => 'text-center w-15p', 'attr' => [], 
                            'element' => render_item_link_by_language($controller_name, $item, $items_language), 
                        ],
                        'status' => [
                            'class' => 'text-center w-10p', 'attr' => [], 
                            'element' => show_item_status($controller_name, $item['id'], $item['status'], ''), 
                        ],
                        'created' => [
                            'class' => 'text-center w-15p', 'attr' => [], 
                            'element' => show_item_datetime($item['created'], 'long'), 
                        ],
                        'button' => [
                            'class' => 'text-center w-5p', 'attr' => [], 
                            'element' => show_item_button_action($controller_name, $item['id'], '', ['item' => $item]), 
                        ],
                    ];
                    $tr_class_html_active = ($item['status']) ? '' : 'row-disabled';
                    $tr_element = [
                        'class' => 'tr_' . $item['ids'] . ' ' . $tr_class_html_active,
                        'attr'  => ['id' => $item['id']],
                        'tdElements' => $td_elements,
                    ];
                    echo renderTableTr($item, $tr_element, $params);
                ?> 
            <?php endforeach ?>
        </tbody>
    </table>
</div>