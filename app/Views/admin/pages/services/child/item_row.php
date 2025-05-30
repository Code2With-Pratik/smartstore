
<?php
    $item_is_free =  ($item['is_free']) ? '<span class="text-purple">Allowed</span>' : '<small>Not Allowed</small>';
    $item_mode =  ($item['add_type'] && $item['add_type'] == 'api') ? '<span class="badge badge-outline text-purple">API</span>' : '<span class="badge badge-outline text-secondary">Manual</span>';
    if ($item['api_name'] != '') {
        $api_provider_name =  $item['api_name'] . '<br><small class="text-muted">' . show_high_light(esc($item['api_service_id']), $params['search'], 'api_service_id') . '</small>';
    } else {
        $api_provider_name = '';
    }
    $tdElements = [
        'sort_handler' => [
            'class' => 'sort-handler w-1p', 'attr' => [], 
            'element' => '<i class="fe fe-grid"></i>', 
        ],
        'checkBox' => [
            'class' => 'text-center w-1p', 'attr' => [], 
            'element' => show_item_checkbox('checkItem', $item['id'], 'checkItem', $item['cate_id']), 
        ],
        'id' => [
            'class' => 'text-center  w-5p', 'attr' => [], 
            'element' => show_high_light(esc($item['id']), $params['search'], 'id'), 
        ],
        'name' => [
            'class' => '', 'attr' => [], 
            'element' => show_high_light(esc($item['name']), $params['search'], 'name'), 
        ],
        'original_price' => [
            'class' => 'text-center w-5p text-muted', 'attr' => [], 
            'element' => (double)$item['original_price'], 
        ],
        'discount_value' => [
            'class' => 'text-center w-5p text-muted', 'attr' => [], 
            'element' => ($item['discount_value'] > 0) ? '-'.(double)$item['discount_value'] . '%' : '', 
        ],
        'price' => [
            'class' => 'text-center w-5p', 'attr' => [], 
            'element' => (double)$item['price'], 
        ],
        'quantity' => [
            'class' => 'text-center w-5p', 'attr' => [], 
            'element' => esc($item['quantity']), 
        ],
        'type' => [
            'class' => 'text-center w-5p', 'attr' => [], 
            'element' => $item_mode, 
        ],
        'provider' => [
            'class' => 'text-center w-5p text-muted', 'attr' => [], 
            'element' => $api_provider_name, 
        ],
        'api_provider_price' => [
            'class' => 'text-center w-5p text-muted', 'attr' => [], 
            'element' => ($item['api_provider_price'] > 0) ? (double)$item['api_provider_price'] : '', 
        ],
        'status' => [
            'class' => 'text-center w-5p', 'attr' => [], 
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
