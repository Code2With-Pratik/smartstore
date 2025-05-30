<?php
    $form_class                         = config('AppConfig')->template['form'];
    $class_element                      = $form_class['class_element'];
    $class_element_editor               = $form_class['class_element_editor'];
    $label_required                     = $form_class['label_required'];
    $class_element_checkbox_switch      = $form_class['class_element_checkbox_switch'];

    $section_order_name = 'sections['. $section_order .']';
    $fields_section = $section_order_name.'[fields]';

    $default_template = config('AppConfig')->client_template['default_sections'][$section_type]['fields'];
    $section_fields = (!empty($item['fields'])&& !empty($item['fields'])) ? $item['fields'] : $default_template;
    $class_element = 'form-control';
    
    $elements = [
        [
            'label' => form_label('Title ' . $label_required),
            'element' => form_input(['name' => $fields_section . '[title]', 'value' => sanitize_output($section_fields['title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Short description ' . $label_required),
            'element' => form_textarea(['name' => $fields_section . '[short_desc]', 'value' => sanitize_output($section_fields['short_desc'] ?? ''), 'rows' => '2', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label("Image position " . $label_required),
            'element' => form_dropdown( $fields_section . '[image_position]', $default_template['image_position_arr'], sanitize_output($section_fields['image_position'] ?? ''), ['class' => $class_element]),
            'class_main' => "col-md-6",
        ],
        [
            'label' => form_label('Image Url Slug ' . $label_required),
            'element' => form_input(['name' => $fields_section . '[image_url]', 'value' => sanitize_output($section_fields['image_url'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'type' => "upload-image-input",
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label("Information status (Config on Setting page)"),
            'element' => [
                'input_name'    => $fields_section . '[information_status]',
                'value'         => $section_fields['information_status'],
                'input_class'   => $class_element_checkbox_switch
            ],
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox-switch",
        ],
    ];
    $input_section_type = ['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type'];
?>
<div class="row">
    <?=form_input($input_section_type) . render_elements_form($elements);?>
</div>
