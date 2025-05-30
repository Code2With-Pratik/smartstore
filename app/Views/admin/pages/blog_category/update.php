<?php
  $form_config                          = config('AppConfig')->template['form'];
  $class_element                        = $form_config['class_element'];
  $class_element_editor                 = $form_config['class_element_editor'];
  $label_required                       = $form_config['label_required'];
  $class_element_checkbox_switch        = $form_config['class_element_checkbox_switch'];
  $form_status = get_form_item_status_config($controller_name);
  
  $label_image_popover = ' <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Display the image icon of category on home page. Use format 255px * 255px. You can insert the third party url" data-title="Details"></i>';
  $elements = [
      [
        'label' => form_label('Name (Default English Version)', 'Name'),
        'element' => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
        'class_main' => "col-md-12 col-sm-12 col-xs-12",
      ],
  ];

  $elements_name_version = [];
  if ($items_lang && $item) {
    foreach ($items_lang as $key => $itemLang) {
      if ($itemLang['code'] == 'en') {
        continue;
      }
      $item_label = 'Name ('. language_codes($itemLang['code']).' Version)';
      $itemLangName = '';
      if (!empty($item)) {
        $langNames = json_decode($item['lang_name'], true);
        $itemLangName = (isset($langNames[$key]) && $langNames[$key] != '') ? $langNames[$key] : $item['name'];
      }
      $elements_name = [
        'label'      => form_label($item_label),
        'element'    => form_input(['name' => "lang_name[$key]", 'value' => @$itemLangName, 'type' => 'text', 'class' => $class_element]),
        'class_main' => "col-md-12 col-sm-12 col-xs-12",
      ];
      $elements_name_version[] = $elements_name;
    }
  }
  $elements = array_merge($elements, $elements_name_version, [
      [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      ],
    ]
  );

  $url_slug_form = null;
  if (isset($item['url_slug'])) {
    $url_slug_form = sprintf(
      '<div class="col-md-12">
        <div class="form-group">
          <label>URL Slug <span class="form-required">*</span></label>
          <div class="input-group">
            <span class="input-group-prepend" id="basic-addon3">
              <span class="input-group-text text-muted">%s</span>
            </span>
            <input type="text" name="url_slug" class="form-control" value="%s">
          </div>
        </div> 
      </div>', base_url('blog/'), $item['url_slug']
    );
  }
  $form_attributes = [
    'class'                 => 'form actionForm',
    'data-task'             => 'json',
    'data-set_html_element' => (isset($item['ids'])) ? 'tr.tr_'.$item['ids'] : '',
    'method'                => "POST",
  ];
  $modal_title = (isset($item['id'])) ? 'Edit' : 'Add New' ;
  $form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];

  echo view('template/modal', [
    'modalTitle' => $modal_title,
    'modalType' => 'form',
    'formData' => [
      'url'        => admin_url($controller_name . "/store/"),
      'attributes' => $form_attributes
    ],
    'modalContent' => form_hidden($form_hidden) . render_elements_form($elements) . $url_slug_form,
  ]);
?>
<script>
  "use strict";
  $(document).ready(function() {
    plugin_editor('.editor');
    $(document).on('click','.btn-elFinder', function(){
      var passToElement = $('input[name=image]'),
          fileUrl = '<?=admin_url('/filemanager/elfinder_init')?>';
      getPathMediaByelFinderBrowser($(this), passToElement, fileUrl);
    });
  });
</script>
