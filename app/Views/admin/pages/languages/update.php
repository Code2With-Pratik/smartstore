<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>

  <?php
    $class_element        = config('AppConfig')->template['form']['class_element'];
    $class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
    $label_required       = config('AppConfig')->template['form']['label_required'];
    $form_status = get_form_item_status_config($controller_name);

    $form_url = admin_url($controller_name . "/store/");
    $form_attributes = [
      'class'                 => 'form actionForm',
      'data-task'             => 'json',
      'data-set_html_element' => '',
      'method'                => "POST",
    ];
    $form_title = (isset($item['id'])) ? 'Edit' : 'Add New' ;
    $form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];

    $language_codes = language_codes();
    $form_language_codes = [];
    foreach ($language_codes as $key => $value) {
      $form_language_codes[$key] = strtoupper($key) . ' - ' .$value;
    } 
    $form_country_codes = country_codes();
    $form_language_default = [
      '0' => 'No',
      '1' => 'Yes',
    ];
    $elements = [
      [
        'label'      => form_label('Language Code'),
        'element'    => form_dropdown('code', $form_language_codes, ($item['code'] ?? 'en'), ['class' => $class_element]),
        'class_main' => "col-md-3",
      ],
      [
        'label'      => form_label('Location'),
        'element'    => form_dropdown('country_code', $form_country_codes, ($item['country_code'] ?? 'GB'), ['class' => $class_element]),
        'class_main' => "col-md-3",
      ],
      [
        'label'      => form_label('Default'),
        'element'    => form_dropdown('is_default', $form_language_default, ($item['is_default'] ?? 0), ['class' => $class_element]),
        'class_main' => "col-md-3",
      ],
      [
        'label'      => form_label('Status'),
        'element'    => form_dropdown('status', $form_status, ($item['status'] ?? 1), ['class' => $class_element]),
        'class_main' => "col-md-3",
      ],
    ];
  ?>
  
  <div class="row">
    <div class="col-md-12">
      <?=form_open($form_url, $form_attributes, $form_hidden)?>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-edit"></i> <?= $form_title ?></h3>
            <div class="card-options">
              <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
              <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
            </div>
          </div>
          <div class="card-body">
            <div class="form-body">
              <div class="row">
                <?php echo render_elements_form($elements); ?>
              </div>
              <hr>
              <div class="row">
                <?php
                  $language_elemmens = [];
                  if (!empty($default_lang)) {
                    foreach ($default_lang as $slug => $slug_value) {
                      $item_slug = (strlen($slug) >= 20)? truncate_string($slug, 20) : $slug;
                      $item_value = (isset($lang_by_code[$slug])) ? $lang_by_code[$slug] : $slug_value;
                      $item_value = $item_value;
                      $xhmtl_value = '';
                      $input_name = 'langs['. $slug .']';
                      if (strlen($slug_value) >= 64) {
                        $tool_tip = render_tooltip_popover_html(html_entity_decode($item_value), 'tooltip');
                        $language_elemmens[] = [
                          'label' => form_label($item_slug . ' '. $tool_tip),
                          'element' => form_textarea(['name' => $input_name, 'value' => html_entity_decode($item_value), 'rows' => '3', 'class' => $class_element]),
                          'class_main' => "col-md-12 col-sm-12 col-xs-12",
                        ];
                      } else {
                        $popover_tip = render_tooltip_popover_html(sanitize_output($item_value), 'tooltip');
                        $language_elemmens[] = [
                          'label' => form_label($item_slug  . ' '.  $popover_tip),
                          'element' => form_input(['name' => $input_name, 'value' => html_entity_decode(sanitize_output($item_value)), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
                          'class_main' => "col-md-12 col-sm-12 col-xs-12",
                        ];
                      }
                    }
                  }
                  if (!empty($language_elemmens)) {
                    echo render_elements_form($language_elemmens); 
                  }    
                ?>
              </div>

            </div>
          </div>
          <div class="card-footer m-t-20">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <?php echo render_button_form(['back_url' => admin_url($controller_name)]);?>
            </div>
          </div>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
<?= $this->endSection() ?>