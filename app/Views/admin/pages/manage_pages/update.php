<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>

<?php
  $form_url = admin_url($controller_name . "/store/");
  $form_attributes = [
    'class'                 => 'form actionForm',
    'data-task'             => 'json',
    'data-set_html_element' => 'div.ajax-alert-message',
    'method'                => "POST",
  ];
  $form_title = ($task == 'edit_item') ? 'Edit' : 'Add New' ;
  $form_hidden = [
    'id' => $item['id'] ?? '', 
    'language_code' => $language_code
  ];
?>

<?= form_open($form_url, $form_attributes, $form_hidden) ?>
  <div class="row c-update-form">
    <?= render_html_language_version_note($language_code, 'col-md-12') ?>
    <div class="col-md-9">
      <?php
        echo render_card_component([
          'title' => 'Basic Informations',
          'card_body' => view($path_view_controller .'child/update/basic_info', [
            'item'      => $item,
            'item_lang' => $item_lang,
          ]),
        ]);
        echo render_card_component([
          'title' => 'SEO (Search Engine Optimize)',
          'is_card_collapsed' => true,
          'collapse_title' => '<span class="text-info">Edit Seo Meta </span>',
          'card_body' => view('template/page_seo_form', [
            'item'      => $item,
            'item_lang' => $item_lang,
          ]),
        ]);

        echo view('template/content_section_layout_form', [
          'item'      => $item,
          'item_lang' => $item_lang,
        ]);
      ?>
    </div>
    <div class="col-md-3">
      <?php 
        echo render_card_component([
          'title' => 'Publish',
          'card_body' => view('admin/pages/manage_pages/child/update/publish', [
            'item'      => $item,
            'item_lang' => $item_lang,
          ]),
        ]);
        if ($task == 'edit_item') {
          echo render_card_component([
            'title' => 'Languages Version',
            'card_body' => view('template/language_version', [
              'item'                  => $item,
              'controller_name'       => $controller_name,
              'items_language'        => $items_language,
            ]),
          ]);
        }
      ?>
    </div>
  </div>
<?= form_close(); ?>
<script>
  "use strict";
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {append_plugins: 'image  media code', height: 400});

    $(document).on('click','.btn-elFinder', function(){
      var _that = $(this);
      getPathMediaByelFinderBrowser(_that);
    });
  });
</script>

<?= $this->endSection() ?>