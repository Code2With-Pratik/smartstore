<?php
  $form_config                          = config('AppConfig')->template['form'];
  $class_element                        = $form_config['class_element'];
  $class_element_editor                 = $form_config['class_element_editor'];
  $label_required                       = $form_config['label_required'];
  $class_element_checkbox_switch        = $form_config['class_element_checkbox_switch'];
  $form_status = get_form_item_status_config($controller_name);
  $form_service_mode = [
    'manual' => 'Manual',
    'api' => 'API',
  ];
  $form_free_trial = [
    '0' => 'Not Allowed',
    '1' => 'Allowed',
  ];
  $language_codes_arr = language_codes();
  $unit_name_label = '<span class="badge bg-secondary">'. $language_codes_arr['en'] .'</span> <span class="text-info ml-2" data-toggle="collapse" data-target="#unit_name_translations">(Show translations)</span>';
  $elements_name = [
    [
      'label' => form_label('Service name'),
      'element' => form_input(['name' => 'name', 'value' => sanitize_output($item['name'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Unit name '. $unit_name_label),
      'element' => form_input(['name' => 'unit_name', 'value' => sanitize_output($item['unit_name'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  $unit_name_translations_arr = !empty($item['unit_name_translations']) ? json_decode($item['unit_name_translations'], true) : [];
  $elements_unit_name_lang = [];
  foreach ($items_language as $key => $item_language) {
    if ($item_language['code'] == 'en') continue;
    $elements_unit_name_lang = array_merge($elements_unit_name_lang, [
      [
        'label' => form_label('Unit name <span class="badge bg-secondary">' . $language_codes_arr[$item_language['code']] . '</span>'),
        'element' => form_input(['name' => 'unit_name_translations['. $item_language['code']. ']', 'value' => sanitize_output($unit_name_translations_arr[$item_language['code']] ?? ''), 'type' => 'text', 'class' => $class_element]),
        'class_main' => "",
      ],
    ]);
  }


  $elements_header = [
    [
      'label' => form_label('Category'),
      'element' => form_dropdown('cate_id', $items_category, @$item['cate_id'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Quantity'),
      'element' => form_input(['name' => 'quantity', 'value' => @$item['quantity'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Price'),
      'element' => form_input(['name' => 'price', 'value' => (double)($item['price'] ?? 1.99), 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Mode'),
      'element' => form_dropdown('add_type', $form_service_mode, @$item['add_type'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];

  array_unshift($items_provider, ['id' => 0, 'name' => 'Choose Provider']);
  $form_providers = array_column($items_provider, 'name', 'id');

  $items_provider_service = [];
  array_unshift($items_provider_service, ['id' => 0, 'name' => 'Choose Service']);
  $items_provider_service = array_column($items_provider_service, 'name', 'id');
  $elements_api_mode = [
    [
      'label' => form_label('Provider'),
      'element' => form_dropdown('api_provider_id', $form_providers, @$item['api_provider_id'], ['class' => 'ajaxGetServicesFromAPI ' . $class_element]),
      'class_main' => "",
    ],
    [
      'label' => form_label('Service'),
      'element' => form_dropdown('api_service_id', $items_provider_service, @$item['api_service_id'], ['class' => $class_element . ' ajaxGetServiceDetail']),
      'class_main' => "provider-services-list",
      'type' => "admin-change-provider-service-list",
    ],
    [
      'label' => form_label('Original Rate per 1000'),
      'element' => form_input(['name' => 'original_price', 'value' => (double)@$item['original_price'], 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "m-t-10",
    ],
  ];
  $elements_api_mode_detail = [
    [
      'label' => form_label('Min order'),
      'element' => form_input(['name' => 'min', 'value' => @$item['min'], 'type' => 'number', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Max order'),
      'element' => form_input(['name' => 'max', 'value' => @$item['max'], 'type' => 'number', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
  ];
  if (!empty($item['id'])) {
    $ids = $item['id'];
    $modal_title = 'Edit Service (ID: ' . $item['id'] . ')';
  } else {
    $modal_title = 'Add new';
  }
  $form_url = admin_url($controller_name . "/store/");
  $redirect_url = '';

  $form_attributes = [
    'class'                 => 'form actionForm',
    'data-task'             => 'json',
    'data-set_html_element' => (isset($item['ids'])) ? 'tr.tr_'.$item['ids'] : '',
    'method'                => "POST",
  ];

  $form_hidden = [
    'id'               => (isset($item['id']))             ? $item['id']             : '',
    'api_service_id'   => (isset($item['api_service_id'])) ? $item['api_service_id'] : '',
    'api_service_type' => (isset($item['type']))           ? $item['type'] : '',
  ];
?>
  <div id="main-modal-content" class="crud-service-form">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $modal_title; ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php echo form_open($form_url, $form_attributes); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?php echo form_hidden($form_hidden); ?>
            <?php echo render_elements_form($elements_name); ?>
            <?php
              echo '<div class="col-md-12">';
              echo form_fieldset('', ['class' => 'form-fieldset collapse', 'id' => 'unit_name_translations']);
              echo render_elements_form($elements_unit_name_lang);
              echo form_fieldset_close();
              echo '</div>';
            ?>
            <?php echo render_elements_form($elements_header); ?>
            <div class="col-md-12">
                <?php
                  if (isset($item['add_type']) && $item['add_type'] == 'api') {
                      $class_api_fieldset = '';
                      $class_manual_fieldset = 'd-none';
                  } else {
                      $class_api_fieldset = 'd-none';
                      $class_manual_fieldset = '';
                  }
                ?>
                <?php
                  echo form_fieldset('', ['class' => 'form-fieldset api-mode ' . $class_api_fieldset]);
                  echo render_elements_form($elements_api_mode);
                  echo '<div class="row">' . render_elements_form($elements_api_mode_detail) . '</div>';
                  echo form_fieldset_close();
                ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <?php echo render_button_form(['modal_close_btn' => true]);?>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
  var pathGetProviderServicesURL  = '<?php echo admin_url('providers/services'); ?>';
  /*----------  Load default service with API  ----------*/
  $( document ).ready(function() {
    if ($('select[name=add_type]').val() == "api") {
      $('.provider-services-list').removeClass('d-none');
      $('.provider-services-list .dimmer').addClass('active');
      var api_provider_id = $('select[name=api_provider_id]').val();
      if (api_provider_id == "" || api_provider_id == 0) return;
      var api_service_id = $('input[name=api_service_id]').val();
      pathGetProviderServicesURL = pathGetProviderServicesURL + '/' + api_provider_id;
      var data = $.param({token:token, api_service_id:api_service_id});
      $.post(pathGetProviderServicesURL, data, function(_result){
        setTimeout(function () {
          $('.provider-services-list .dimmer').removeClass('active');
          $(".provider-services-list select").html(_result);
          var _that = $( ".ajaxGetServiceDetail option:selected"),
              _rate = _that.attr("data-rate");
          $(".crud-service-form input[name=original_price]").val(_rate);
        }, 100);
      });
      return false;
    }
  });
  $(document).on("change", "select[name=add_type]", function(){
    var element = $(this),
      mode    = element.val();
    if(mode == 'api'){
      $('.api-mode').removeClass('d-none');
      $('.manual-mode').addClass('d-none');
    }else{
      $('.manual-mode').removeClass('d-none');
      $('.api-mode').addClass('d-none');
    }
  });
</script>

<?php if (!empty($js_validation_config) && !empty($js_validation_config['rules']) && !empty($js_validation_config['messages'])) : ?>
  <script>
    $(document).ready(function () {
      const rules = <?= $js_validation_config['rules']; ?>;
      const messages = <?= $js_validation_config['messages']; ?>; 
      setup_form_js_validation(".actionForm", rules, messages);
    });
  </script>
<?php endif; ?>