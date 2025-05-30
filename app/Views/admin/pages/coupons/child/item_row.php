
<?php
    if (strtotime($item['start_date']) > strtotime($item['end_date'])) {
        $item['status'] = 2;
        db_update(TB_COUPONS, ['status' => 2], ['ids' => $item['ids']]);
    }
    $tdElements = [
        'checkBox' => [
            'class' => 'text-center w-1p', 'attr' => [], 
            'element' => show_item_checkbox('checkItem', $item['id']), 
        ],
        'id' => [
            'class' => 'text-center w-1p', 'attr' => [], 
            'element' => $item['id'], 
        ],
        'name' => [
            'class' => '', 'attr' => [], 
            'element' => show_high_light(sanitize_output($item['name']), $params['search'], 'name'), 
        ],
        'code' => [
            'class' => '', 'attr' => [], 
            'element' => show_high_light(sanitize_output($item['code']), $params['search'], 'code'), 
        ],
        'discount_value' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => (double)$item['discount_value'], 
        ],
        'start_date' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => show_item_datetime($item['start_date'], 'short'), 
        ],
        'end_date' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => show_item_datetime($item['end_date'], 'short'), 
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
        'class' => render_tr_class($controller_name, $item),
        'attr'  => ['id' => $item['id']],
        'tdElements' => $tdElements,
    ];
    echo renderTableTr($item, $trElement, $params);
