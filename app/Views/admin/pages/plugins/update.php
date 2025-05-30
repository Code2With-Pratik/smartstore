<?php
    $form_config          = config('AppConfig')->template['form'];
    $class_element        = $form_config['class_element'];
    $label_required       = $form_config['label_required'];
    $elements = [
        [
        'label' => form_label('Purchase code'),
        'element' => form_input(['name' => 'purchase_code', 'value' => '', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
        'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
    ];
    $form_attributes = [
        'class'                 => 'form actionForm',
        'data-task'             => 'json',
        'data-set_html_element' => '',
        'method'                => "POST",
    ];
    $modal_title = 'Install Plugin';
    $form_hidden = ['type' => 'install'];

    echo view('template/modal', [
        'modalTitle' => $modal_title,
        'modalType' => 'form',
        'formData' => [
            'url'        => admin_url($controller_name . "/store/"),
            'attributes' => $form_attributes
        ],
        'modalContent' => form_hidden($form_hidden) . render_elements_form($elements) . form_input(['type'  => 'hidden', 'class' => 'plugin_editor d-none']),
    ]);