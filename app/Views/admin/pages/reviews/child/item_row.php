<?php

$tdElements = [
    'checkBox' => [
        'class' => 'text-center w-1p', 'attr' => [], 
        'element' => show_item_checkbox('checkItem', $item['id']), 
    ],
    'id' => [
        'class' => 'w-1p text-center', 'attr' => [], 
        'element' => sanitize_output($item['id']), 
    ],
    'name' => [
        'class' => 'w-10p', 'attr' => [], 
        'element' => show_high_light(esc($item['name']), $params['search'], 'name') . '<br>' . show_high_light(esc($item['email']), $params['search'], 'email'), 
    ],
    'client_order_id' => [
        'class' => 'text-center w-5p', 'attr' => [], 
        'element' => show_high_light(esc($item['client_order_id']), $params['search'], 'client_order_id'), 
    ],
    'comment' => [
        'class' => 'text-center w-20p', 'attr' => [], 
        'element' => truncate_string($item['comment'], 200), 
    ],
    'rating' => [
        'class' => 'w-1p text-center', 'attr' => [], 
        'element' => display_rating_with_stars($item['rating']), 
    ],
    'ip_address' => [
        'class' => 'w-10p text-center', 'attr' => [], 
        'element' => show_high_light(esc($item['ip']), $params['search'], 'ip'), 
    ],
    'status' => [
        'class' => 'text-center w-5p', 'attr' => [], 
        'element' => show_item_status($controller_name, $item['id'], $item['status'], ''), 
    ],
    'last_submission_time' => [
        'class' => 'text-center w-10p', 'attr' => [], 
        'element' => show_item_datetime($item['last_submission_time'], 'long'), 
    ],
    'last_change' => [
        'class' => 'text-center w-10p', 'attr' => [], 
        'element' => show_item_datetime($item['changed'], 'long'), 
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