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
            'label' => form_label('Number of Steps '  . $label_required),
            'element' => form_dropdown( $fields_section. '[number_steps]', $default_template['number_steps_arr'], $section_fields['number_steps'] ?? 4, ['class' => $class_element]),
            'class_main' => "col-md-12",
        ],
    ];
    $features_forms = '';
    $default_features = (!empty($item['fields']['features'])&& !empty($item['features'])) ? $item['fields']['features'] : $default_template['features'];
    $i = 0;
    foreach ($default_features as $key => $feature) {
        $features_forms .='<hr class="col-md-12 col-sm-12 col-xs-12">';

        $title = !empty($section_fields['features'][$i]['title']) ? sanitize_output($section_fields['features'][$i]['title']) : '';
        $content = !empty($section_fields['features'][$i]['content']) ? sanitize_output($section_fields['features'][$i]['content']) : '';

        $features_forms .= render_elements_form([
            [
                'label' => form_label('Step title ' . $i+1 . ' '  . $label_required),
                'element' => form_input(['name' => $fields_section. '[features]['.$i.'][title]', 'value' => $title, 'type' => 'text', 'class' => $class_element]),
                'class_main' => "col-md-12",
            ],
            [ 
                'label' => form_label('Step content ' . $i+1 . ' '  . $label_required),
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
