<?php
  $footer_links         = get_app_setting('footer_links');
  $footer_links         = ($footer_links) ? json_decode($footer_links, true) : [];
  $language_key         = array_keys($footer_links);
  $items_language       = db_fetch('code, country_code', TB_LANGUAGE_LIST, ['status' => 1], 'is_default', 'DESC');
?>  
<?php if (!empty($items_language)) : ?>
<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-tabs"  role="tablist">
      <?php
        $tab_title = null;
        $i = 1; 
        foreach ($items_language as $key => $item_language) {
          $tab_id = '#footer-link-' . $item_language['code'];
          $class_active = ($i == 1) ? 'active' : '';
          $i++;
          $tab_title .= sprintf('
            <li class="nav-item">
              <a class="nav-link %s"  data-toggle="tab" href="%s" role="tab" aria-controls="%s" aria-selected="true"><span class="m-r-2 flag-icon flag-icon-%s"></span> %s</a>
            </li>', $class_active, $tab_id, $item_language['code'], strtolower($item_language['country_code']), language_codes($item_language['code']));
        }
        echo $tab_title;
      ?>
    </ul>
  </div>
  <div class="col-md-12 m-t-20">
    <div class="tab-content">
      <?php
        $tab_title = null;
        $i = 1; 
        foreach ($items_language as $key => $item_language) {
          $tab_id = 'footer-link-' . $item_language['code'];
          $class_active = ($i == 1) ? 'show active' : '';
          $tab_content = view('admin/pages/settings/tab_content/child/footer_link_tab', [
            'lang_code' => $item_language['code'], 
            'footer_links' => $footer_links[$item_language['code']] ?? [],
          ]);
          $i++;
          $tab_title .= sprintf('
            <div class="tab-pane fade %s" id="%s" role="tabpanel" aria-labelledby="%s">
             %s
            </div>', $class_active, $tab_id, $item_language['code'], $tab_content);
        }
        echo $tab_title;
      ?>
    </div>
  </div>
</div>
<?php endif; ?>
<script>
  $(document).ready(function() {
    $(document).on('click', '.btnAddItem', function() {
      var table = $(this).closest('table');
      var item_rows = table.find('.tb-rows'); 
      let max_number = 0;
      item_rows.find('.tb-row').each(function() {
          let row_number = $(this).data('number');
          if (row_number > max_number) {
              max_number = row_number;
          }
      });
      let new_row = item_rows.find('.tb-row-more').clone();
      let new_number = max_number + 1;
      new_row.removeClass('d-none'); 
      new_row.removeClass('tb-row-more'); 
      new_row.find('input').each(function() {
        var name_attr = $(this).attr('__name__');
        if (name_attr) {
          var updated_name = name_attr.replace('__number__', new_number); 
          $(this).attr('name', updated_name); 
          $(this).removeAttr('__name__'); 
        }
      });
      new_row.data('number', new_number);
      new_row.attr('data-number', new_number);
      $(this).closest('tr').before(new_row);
    });

    $(document).on('click', '.btnRemoveItem', function() {
      $(this).closest('.tb-row').remove(); 
    });
  });
</script>
