<?php
  $setting_sidebar = [
    'general_setting' => [
      'name' => 'Settings', 'icon' => 'fe fe-disc',        'area_title' => true,  'route-name' => '#',
      'elements' => config('AppConfig')->admin_setting['sidebar'],
    ],
  ];
  $xhtml = '<div class="sidebar o-auto">';
  $i = 0;
  foreach ($setting_sidebar as $key => $item) {
    $xhtml .= sprintf('
      <div class="list-group list-group-transparent mb-0 mt-5">
        <h5><span class="icon mr-3"><i class="%s"></i></span>%s</h5>
      </div>', $item['icon'], $item['name']
    );
    if (!empty($item['elements'])) {
      $xhtml_child = '<div class="list-group list-group-transparent mb-0">';
      foreach ($item['elements'] as $element) {
        $link = admin_url('settings/' . $element['route-name']);
        $class_active = ($element['route-name'] == segment(3)) ? 'active' : '';
        $xhtml_child .= sprintf(
          '<a href="%s" class="list-group-item list-group-item-action %s"><span class="icon mr-3"><i class="%s"></i></span>%s</a>', $link, $class_active, $element['icon'],  $element['name']
        );
      }
      $xhtml_child  .= '</div>';
    }
    $i++;
    $xhtml .= $xhtml_child;
  }
  $xhtml .= '</div>';
  echo $xhtml;
?>
