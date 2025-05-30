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
    $default_features = $default_template['features'];

    $features = (!empty($item['fields']['features'])&& !empty($item['fields']['features'])) ? $item['fields']['features'] : $default_template['features'];

    $elements = [
        [
            'label' => form_label('Title ' . $label_required ),
            'element' => form_input(['name' => $fields_section . '[title]', 'value' => sanitize_output($section_fields['title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Short description ' . $label_required ),
            'element' => form_textarea(['name' => $fields_section . '[short_desc]', 'value' =>  sanitize_output($section_fields['short_desc'] ?? ''), 'rows' => '2', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label("Layout Type"),
            'element' => form_dropdown( $fields_section .'[layout_type]', $default_template['layout_type_arr'], sanitize_output($section_fields['layout_type'] ?? ''), ['class' => 'form-control']),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
    ];
    $input_section_type = form_input(['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type']);
?>


<div class="row">
    <?=$input_section_type . render_elements_form($elements);?>
</div>
<style>
    .features-items .feature-item-more,
    .features-items .feature-item {
        position: relative;
    }
    .features-items .feature-item .btn-remove {
        position: absolute;
        top: 55px;
        right: 0px;
    }
</style>
<div class="group-form-features">
    <div class="features-items">
        <?php if (!empty($features)) : $i = 0; ?>
            <?php foreach ($features as $key => $feature): $key = $i; $i++; ?>
                <?php
                    $item_title = !empty($section_fields['features'][$key]['title']) ? sanitize_output($section_fields['features'][$key]['title']) : '';
                    $item_content = !empty($section_fields['features'][$key]['content']) ? sanitize_output($section_fields['features'][$key]['content']) : '';
                ?>
                <div class="row feature-item" data-number="<?=$key;?>">
                    <hr class="col-md-12 col-sm-12 col-xs-12">
                    <div class="btn-remove">
                        <span class="btn btn-outline-secondary btn-sm btnRemoveItem"><i class="fe fe-x"></i></span>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="<?=$fields_section?>[features][<?=$key;?>][title]" value="<?=sanitize_output($item_title)?>" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="<?=$fields_section?>[features][<?=$key;?>][content]" cols="40" rows="2" class="form-control"><?=sanitize_output($item_content)?></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <hr class="col-md-12 col-sm-12 col-xs-12">
    <div class="text-right">
        <span class="btn btn-outline-info btn-sm btnAddItem"><i class="fe fe-plus-circle"></i> Add item</span>
    </div>
    <div class="feature-item-more d-none">
        <div class="row feature-item" data-number="__number__">
            <hr class="col-md-12 col-sm-12 col-xs-12">
            <div class="btn-remove">
                <span class="btn btn-outline-secondary btn-sm btnRemoveItem"><i class="fe fe-x"></i></span>
            </div>
            <h3></h3>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" __name__="<?=$fields_section?>[features][__number__][title]" class="form-control" placeholder="Eg: When I will receive my likes for Instagram?">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <textarea __name__="<?=$fields_section?>[features][__number__][content]" cols="40" rows="2" class="form-control" placeholder="..."></textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>
</div>

