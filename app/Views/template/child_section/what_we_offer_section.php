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
            'element' => form_input(['name' => $fields_section . '[title]', 'value' => sanitize_output($section_fields['title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Headling title ' . $label_required),
            'element' => form_input(['name' => $fields_section . '[headling]', 'value' => sanitize_output($section_fields['headling'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Short description ' . $label_required),
            'element' => form_textarea(['name' => $fields_section . '[short_desc]', 'value' => sanitize_output($section_fields['short_desc'] ?? ''), 'rows' => '2', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label("Image position " . $label_required),
            'element' => form_dropdown( $fields_section .'[image_position]', $status_array, sanitize_output($section_fields['image_position'] ?? ''), ['class' => 'form-control']),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Image Url ' . $label_required),
            'element' => form_input(['name' => $fields_section . '[image_url]', 'value' => sanitize_output($section_fields['image_url'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'type' => "upload-image-input",
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
    ];


    $features_forms = '';
    $default_features = (!empty($item['fields']['features'])&& !empty($item['features'])) ? $item['fields']['features'] : $default_template['features'];
    $i = 0;
    foreach ($default_features as $key => $feature) {
        $features_forms .='<hr class="col-md-12 col-sm-12 col-xs-12">';

        $icon = !empty($section_fields['features'][$i]['icon']) ? sanitize_output($section_fields['features'][$i]['icon']) : '';
        $title = !empty($section_fields['features'][$i]['title']) ? sanitize_output($section_fields['features'][$i]['title']) : '';
        $content = !empty($section_fields['features'][$i]['content']) ? sanitize_output($section_fields['features'][$i]['content']) : '';
        
        $features_forms .= render_elements_form([
            [
                'label' => form_label("Boostrap 5 icon's class " . $i+1 . ' '  . $label_required),
                'element' => form_input(['name' => $fields_section. '[features]['.$i.'][icon]', 'value' => $icon, 'placeholder' => 'bi bi-bag-heart', 'type' => 'text', 'class' => $class_element]),
                'class_main' => "col-md-6",
            ],
            [
                'label' => form_label('Feature title ' . $i+1 . ' '  . $label_required),
                'element' => form_input(['name' => $fields_section. '[features]['.$i.'][title]', 'value' => $title, 'type' => 'text', 'class' => $class_element]),
                'class_main' => "col-md-12",
            ],
            [ 
                'label' => form_label('Feature content ' . $i+1 . ' '  . $label_required),
                'element' => form_textarea(['name' => $fields_section. '[features]['.$i.'][content]', 'value' => $content, 'rows' => '2', 'class' => $class_element]),
                'class_main' => "col-md-12",
            ],
        ]);
        $i++;
    }
    $input_section_type = form_input(['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type']);
?>


<div class="row">
    <?=$input_section_type . render_elements_form($elements) . $features_forms;?>
</div>
