<?php
$form_config          = config('AppConfig')->template['form'];
$class_element        = $form_config['class_element'];
$label_required       = $form_config['label_required'];
$form_status = get_form_item_status_config($controller_name);
$form_percentages = generate_percentage_array();
$discount_value = $item['discount_value'] ?? 10;
$status = $item['status'] ?? 1;
$start_date = '';
$end_date = '';

if (!empty($item)) {
  $start_date   = date("d-m-Y",  strtotime($item['start_date']));
  $end_date   = date("d-m-Y",  strtotime($item['end_date']));
}

$elements = [
  [
    'label' => form_label('Name'),
    'element' => form_input(['name' => 'name', 'value' => sanitize_output(@$item['name']), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label' => form_label('Code (from 6 letters)'),
    'element' => form_input(['name' => 'code', 'value' => sanitize_output(@$item['code']), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
    'class_main' => "col-md-6",
  ],
  [
    'label' => form_label('Discount value'),
    'element' => form_dropdown('discount_value', $form_percentages, (double)$discount_value, ['class' => $class_element]),
    'class_main' => "col-md-6",
  ],
  [
    'label' => form_label('Start Date'),
    'element' => form_input(['name' => 'start_date', 'value' => $start_date, 'type' => 'text', 'required' => 'required', 'class' => $class_element . ' square datepicker']),
    'class_main' => "col-md-6",
  ],
  [
    'label' => form_label('End Date'),
    'element' => form_input(['name' => 'end_date', 'value' => $end_date, 'type' => 'text', 'required' => 'required', 'class' => $class_element . ' square datepicker']),
    'class_main' => "col-md-6",
  ],
  [
    'label' => form_label('Status'),
    'element' => form_dropdown('status', $form_status, $status, ['class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => (isset($item['ids'])) ? 'tr.tr_'.$item['ids'] : '',
  'method'                => "POST",
];
$modal_title = (isset($item['id'])) ? 'Edit' : 'Add New' ;
$form_hidden = [
  'id' => $item['id'] ?? '',
];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
?>

<script>
  $(function() {
    $('.datepicker').datepicker({
      format: "dd-mm-yyyy",
      orientation: 'bottom',
      autoclose: true,
    });
    <?php if (empty($item['start_date']) ) { ?>
      $(".datepicker").datepicker().datepicker("setDate", new Date());
    <?php } ?>
    function truncateDate(date) {
      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }
  });
</script>