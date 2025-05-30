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
            'label' => form_label("Show Title"),
            'element' => [
                'input_name'    => $fields_section. '[title_status]',
                'value'         => $section_fields['title_status'] ?? 0,
                'input_class'   => $class_element_checkbox_switch . ' title-switch'
            ],
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox-switch",
        ],
        [
            'label' => form_label('Title'),
            'element' => form_input(['name' => $fields_section. '[title]', 'value' => sanitize_output($section_fields['title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12 title-switch-options",
        ],
        [
            'label' => form_label('Short description'),
            'element' => form_textarea(['name' => $fields_section. '[short_desc]', 'value' => sanitize_output($section_fields['short_desc'] ?? ''), 'rows' => '2', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12 title-switch-options",
        ],
        [
            'label' => form_label("Layout type"),
            'element' => form_dropdown( $fields_section. '[layout_type]', $default_template['layout_type_arr'], $section_fields['layout_type']  ?? 'tab', ['class' => $class_element]),
            'class_main' => "col-md-6",
        ],
        [
            'label' => form_label("Features Status"),
            'element' => [
                'input_name'    => $fields_section. '[features_status]',
                'value'         => $section_fields['features_status'],
                'input_class'   => $class_element_checkbox_switch  . ' features-switch'
            ],
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
            'type' => "checkbox-switch",
        ],
        [
            'label' => form_label('Features Title'),
            'element' => form_input(['name' => $fields_section. '[features_title]', 'value' => sanitize_output($section_fields['features_title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12 features-switch-options",
        ],
        [
            'label' => form_label('Features Content'),
            'element' => form_textarea(['name' => $fields_section. '[features_content]', 'value' => sanitize_output($section_fields['features_content'] ?? ''), 'rows' => '8', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12 features-switch-options",
        ],
    ];
    $input_section_type = ['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type'];
?>
<div class="row">
    <?=form_input($input_section_type) . render_elements_form($elements);?>
</div>
