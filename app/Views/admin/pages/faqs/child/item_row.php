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
    'question' => [
        'class' => 'w-20p', 'attr' => [], 
        'element' => show_high_light(esc($item['question']), $params['search'], 'question'), 
    ],
    'answer' => [
        'class' => '', 'attr' => [], 
        'element' => truncate_string($item['answer'], 200), 
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
$trElement = [
    'class' => render_tr_class($controller_name, $item),
    'attr'  => ['id' => $item['id']],
    'tdElements' => $tdElements,
];
echo renderTableTr($item, $trElement, $params);