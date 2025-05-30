<?php
    $form_class           = config('AppConfig')->template['form'];
    $class_element        = $form_class['class_element'];
    $class_element_editor = $form_class['class_element_editor'];
    $label_required       = $form_class['label_required'];
  
    $elements_basic = [
        [
            'label' => form_label('Name ' . $label_required),
            'element' => form_input(['name' => 'name', 'value' => sanitize_output($item_lang['name'] ?? ''), 'type' => 'text', 'required' => 'required', 'placeholder' => 'Enter name...', 'class' => $class_element]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label'       => form_label('Url Slug ' . $label_required),
            'element'     => form_input(['name' => 'url_slug', 'value' => sanitize_output($item_lang['url_slug'] ?? ''), 'type' => 'text', 'class' => $class_element]),
            'type'        => "general-url-slug",
            'base_url'    => base_url('blog/'),
            'class_main'  => "col-md-12 col-sm-12 col-xs-12",
        ],
        [
            'label' => form_label('Image thumbnail ' . $label_required),
            'element' => form_input(['name' => 'image', 'value' => sanitize_output($item['image'] ??''), 'type' => 'text', 'class' => $class_element]),
            'type' => "upload-image-input",
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
        [ 
            'label' => form_label('Article Content '  . $label_required),
            'element' => form_textarea(['name' => 'content', 'value' => sanitize_output($item_lang['content'] ??''), 'rows' => '10', 'class' => $class_element_editor]),
            'class_main' => "col-md-12 col-sm-12 col-xs-12",
        ],
    ];
?>
<div class="row justify-content-md-center">
  <?php echo render_elements_form($elements_basic); ?>
</div>
