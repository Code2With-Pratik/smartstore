<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>

<?php
  $form_config          = config('AppConfig')->template['form'];
  $class_element        = $form_config['class_element'];
  $label_required       = $form_config['label_required'];
  $form_status = get_form_item_status_config($controller_name);
  $form_menu_target = config('AppConfig')->template['form_link_target'];
  $menu_type_array = config('AppConfig')->template['menu_type'];

  $options = ($item['options']) ?? [];
  $url_slug = null;
  $sncate_id = null;
  if ($options) {
    $url_slug = get_value_by_key($item['options'], 'url_slug');
    $sncate_id = get_value_by_key($item['options'], 'sncate_id');
  }
  $language_codes_arr = language_codes();

  $name_lang_arr = !empty($item['name_lang']) ? json_decode($item['name_lang'], true) : [];
  $elements_name_lang = [];
  $elements_link_url_slug = [];
  foreach ($items_language as $key => $item_language) {
    $elements_name_lang = array_merge($elements_name_lang, [
      [
        'label' => form_label('Name <span class="badge bg-secondary">' . $language_codes_arr[$item_language['code']] . '</span>'),
        'element' => form_input(['name' => 'name_lang['. $item_language['code']. ']', 'value' => sanitize_output($name_lang_arr[$item_language['code']] ?? ''), 'type' => 'text', 'class' => $class_element]),
        'class_main' => "col-md-12 col-sm-12 col-xs-12",
      ],
    ]);
    $elements_link_url_slug = array_merge($elements_link_url_slug, [
      [
        'label' => form_label('Link (url-slug) <span class="badge bg-secondary">' . $language_codes_arr[$item_language['code']] . '</span>'),
        'element' => form_input(['name' => 'menu_params[url_slug]['. $item_language['code']. ']', 'value' => sanitize_output($url_slug[$item_language['code']] ?? ''), 'type' => 'text', 'class' => $class_element]),
        'class_main' => "col-md-12 col-sm-12 col-xs-12 link-field",
      ],
    ]);
  }

  $elements = [
    [
      'label' => form_label('Status '. $label_required),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Target'),
      'element' => form_dropdown('target', $form_menu_target, @$item['target'], ['class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Type'),
      'element' => form_dropdown('type', $menu_type_array, @$item['type'], ['class' => $class_element . ' menu-type']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];

  if ($items_social_network) {
    $ids = array_column($items_social_network, 'id');
    $names = array_column($items_social_network, 'name');
    $social_options = array_combine($ids, $names);
    $elements[] = [
      'label' => form_label('Select a Social Network Category'),
      'element' => form_dropdown('menu_params[sncate_id]', $social_options, $sncate_id, ['class' => $class_element . ' menu-type']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 social-network-field",
    ];
  }

  $form_attributes = [
    'class'                 => 'form actionForm',
    'data-redirect'         => admin_url($controller_name),
    'data-task'             => 'json',
    'data-set_html_element' => '',
    'method'                => "POST",
  ];
  $form_title = (isset($item['id'])) ? 'Edit Menu: "' . $item['name'] . '"' : 'Add new Menu Item' ;
  $form_hidden = ['id' => $item['id'] ?? '' ];
  $form_url = admin_url($controller_name . "/store/");
?>

  <?= form_open($form_url, $form_attributes, $form_hidden) ?>
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <?php
          $form_html = render_elements_form($elements_name_lang) . render_elements_form($elements) . render_elements_form($elements_link_url_slug);
          $card_body_html = sprintf('<div class="row justify-content-md-center">%s</div>', $form_html);
          $card_body_html .= sprintf('<div class="col-md-12 col-sm-12 col-xs-12">%s</div>', render_button_form(['back_url' => admin_url($controller_name)]));
          echo render_card_component([
            'title' => $form_title,
            'card_body' => $card_body_html,
          ]);
        ?>
      </div>
        
      </div>
    </div>
  <?= form_close(); ?>

  <script>
    $(document).ready(function() {
      const linkField = $('.link-field');
      const socialNetworkField = $('.social-network-field');
      const menuType = $('.menu-type');
      function toggleFields() {
          var type = menuType.val();
          if (type === "link") {
              linkField.removeClass('d-none');
              socialNetworkField.addClass('d-none');
          } else if (type === "social_network_option") {
              linkField.addClass('d-none');
              socialNetworkField.removeClass('d-none');
          } else {
              linkField.addClass('d-none');
              socialNetworkField.addClass('d-none');
          }
      }
      toggleFields();
      menuType.change(function() {
          toggleFields();
      });
    });
  </script> 

<?= $this->endSection() ?>