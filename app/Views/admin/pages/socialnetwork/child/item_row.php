
<?php 
    $tdElements = [
        'sort_handler' => [
            'class' => 'sort-handler w-1p', 'attr' => [], 
            'element' => '<i class="fe fe-grid"></i>', 
        ],
        'checkBox' => [
            'class' => 'text-center w-1p', 'attr' => [], 
            'element' => show_item_checkbox('checkItem', $item['id']), 
        ],
        'name' => [
            'class' => '', 'attr' => [], 
            'element' => show_high_light(sanitize_output($item['name']), $params['search'], 'name'), 
        ],
        'status' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => show_item_status($controller_name, $item['id'], $item['status'], 'switch'), 
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
