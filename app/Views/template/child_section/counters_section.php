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
        '1' => 'Active',
        '0' => 'Inactive',
    ];
    $features_forms = '';
    $default_features = (!empty($item['fields']['features'])&& !empty($item['features'])) ? $item['fields']['features'] : $default_template['features'];
    $i = 0;
    foreach ($default_features as $key => $feature) {
        
        $icon = !empty($section_fields['features'][$i]['icon']) ? sanitize_output($section_fields['features'][$i]['icon']) : '';
        $title = !empty($section_fields['features'][$i]['title']) ? sanitize_output($section_fields['features'][$i]['title']) : '';
        $number = !empty($section_fields['features'][$i]['number']) ? sanitize_output($section_fields['features'][$i]['number']) : '';
        
        $features_forms .= render_elements_form([
            [
                'label' => form_label('Feature icon ' . $i+1 . ' ' . $label_required),
                'element' => form_input(['name' => $fields_section. '[features]['.$i.'][icon]', 'value' => $icon, 'placeholder' => 'bi bi-bag-heart', 'type' => 'text', 'class' => $class_element]),
                'class_main' => "col-md-6",
            ],
            [
                'label' => form_label('Feature number ' . $i+1 . ' ' . $label_required),
                'element' => form_input(['name' => $fields_section. '[features]['.$i.'][number]', 'value' => $number, 'type' => 'text', 'class' => $class_element]),
                'class_main' => "col-md-6",
            ],
            [
                'label' => form_label('Feature title ' . $i+1 . ' ' . $label_required),
                'element' => form_input(['name' => $fields_section. '[features]['.$i.'][title]', 'value' => $title, 'type' => 'text', 'class' => $class_element]),
                'class_main' => "col-md-12",
            ],
            
        ]);
        $features_forms .='<hr class="col-md-12 col-sm-12 col-xs-12">';
        $i++;
    }
    $input_section_type = form_input(['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type']);
?>


<div class="row">
    <?=$input_section_type . $features_forms;?>
</div>
