
<?php
    $tdElements = [
        'name' => [
            'class' => '', 'attr' => [], 
            'element' => show_high_light(esc($item['name']), $params['search'], 'name'), 
        ],
        'balance' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => (double) $item['balance'], 
        ],
        'status' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => show_item_status($controller_name, $item['id'], $item['status'], 'switch'), 
        ],
        'created' => [
            'class' => 'text-center w-10p', 'attr' => [], 
            'element' => show_item_datetime($item['created'], 'long'), 
        ],
        'note' => [
            'class' => 'text-center w-20p', 'attr' => [], 
            'element' => esc($item['description']), 
        ],
        'button' => [
            'class' => 'text-center w-5p', 'attr' => [], 
            'element' => show_item_button_action($controller_name, $item['id'], 'btn-group'), 
        ],
    ];
    $trElement = [
        'class' => render_tr_class($controller_name, $item),
        'attr'  => ['id' => $item['id']],
        'tdElements' => $tdElements,
    ];
    echo renderTableTr($item, $trElement, $params);