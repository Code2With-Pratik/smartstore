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

    $status_array = [
        'left' => 'Left',
        'right' => 'Right',
    ];
    $elements = [
        [
            'label' => form_label('Title ' . $label_required),
            'element' => form_input(['name' => $fields_section .'[title]', 'value' => sanitize_output($section_fields['title']), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Headling Text ' . $label_required),
            'element' => form_input(['name' => $fields_section .'[headling]', 'value' => sanitize_output($section_fields['headling']), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Short description ' . $label_required),
            'element' => form_textarea(['name' => $fields_section .'[short_desc]', 'value' => sanitize_output($section_fields['short_desc']), 'rows' => '2', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Image position ' . $label_required),
            'element' => form_dropdown( $fields_section .'[image_position]', $status_array, $section_fields['image_position'], ['class' => 'form-control']),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Image Url ' . $label_required),
            'element' => form_input(['name' => $fields_section . '[image_url]', 'value' => sanitize_output($section_fields['image_url']), 'type' => 'text', 'class' => $class_element]),
            'type' => "upload-image-input",
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
    ];
    $input_section_type = form_input(['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type']);
?>


<div class="row">
    <?= $input_section_type . render_elements_form($elements);?>
</div>
