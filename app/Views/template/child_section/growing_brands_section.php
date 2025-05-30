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
    $image_url_proper = '<i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="The background image for the header sets the visual tone of your landing page. Please upload a high-quality image with a minimum width of 1920px x 689px (aspect ratio of 16:9 is ideal)." data-title="Details"></i>';
    $elements = [
        [
            'label' => form_label('Title '.  $label_required ),
            'element' => form_input(['name' => $fields_section . '[title]', 'value' => sanitize_output($section_fields['title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Short description '.  $label_required ),
            'element' => form_textarea(['name' => $fields_section . '[short_desc]', 'value' => sanitize_output($section_fields['short_desc'] ?? ''), 'rows' => '2', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Button Title ' .  $label_required ),
            'element' => form_input(['name' => $fields_section . '[button_name]', 'value' => sanitize_output($section_fields['button_name'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Button Url Slug ' .  $label_required ),
            'element' => form_input(['name' => $fields_section . '[button_url]', 'value' => sanitize_output($section_fields['button_url'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
    ];
    $input_section_type = form_input(['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type']);
?>


<div class="row">
    <?= $input_section_type . render_elements_form($elements);?>
</div>
