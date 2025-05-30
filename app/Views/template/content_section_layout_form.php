<style>
    .manage-sections .section-default-list,
    .manage-sections .section-content {
      padding: 0px!important;
    }

    .section-list {
      min-height: 700px;
      padding: 10px;
    }
    .section-item {
      border: 1px solid #e8e8e8;
      margin-bottom: 10px; 
      box-sizing: border-box;
      border-radius: 5px; 
    }

    .section-item:hover {
      background-color: #f1f1f1;/
    }
    body.theme-dark .section-item:hover {
      background-color: #292727; 
    }
    body.theme-dark .section-item {
      border-color: #333;
    }
    .section-item .card-header {
      min-height: 2.5rem !important;
      background-color: #2d2653;
      border: 1px solid #2d2653;
      color: #fff;
      border-radius: 5px;
    }
    .section-item .card-header .card-title {
      font-size: 1rem !important;
    }

    .section-list .card-body {
    }
    .sortable-item {
      cursor: move; 
    }
    .sortable-handle {
      cursor: grab; 
    }
    .sortable-handle:active {
      cursor: grabbing;
    }
</style>

<div class="row manage-sections">
  <div class="col-md-8 ">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Content Layout </h3>
        <div class="card-options">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#more_details" data-toggle="tooltip" data-placement="top" title="Click to view detailed instructions">
              <i class="fa fa-question-circle"></i> Help 
          </button>
        </div>
      </div>
      <div class="card-body section-content">
        <div id="sortable-left" class="section-list">
          <?php
            $sections_layout = $item_lang ? json_decode($item_lang['sections_layout'], true) : [];
            if (!empty($sections_layout)) {
              foreach ($sections_layout as $key => $section_row) {
                $section_type = $section_row['section_type'];
                $section_order = $key;
                echo render_section_form($section_row, $section_type, $section_order, 'input_form');
              }
            } else {
              echo render_content_section_layout_form(null, $ui_components_list['left'], 'left');
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">UI Components</h3>
      </div>
      <div class="card-body section-content">
          
        <div id="sortable-right" class="section-list">
          <?php
            echo render_content_section_layout_form(null, $ui_components_list['right'], 'right');
          ?>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit Optional Content Section</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <div class="text-danger">NOTE:
            <small class="form-text text-muted">Only add content here after enabling the optional content section in the Content Section Layout. This section allows you to customize or hide content based on your needs, helping you better organize and enhance the layout of your page.</small>
          </div>
        </div>
        <div class="form-group">
            <?php
              $option_content = null;
              if (!empty($sections_layout)) {
                $filtered_option_content = array_filter($sections_layout, function($section) {
                  return isset($section['section_type']) && $section['section_type'] === 'optional_content_section';
                });
                if (!empty($filtered_option_content)) {
                  $filtered_option_content = array_values($filtered_option_content);
                  $filtered_option_content = $filtered_option_content[0];
                } else {
                  $filtered_option_content = null;
                }
                $option_content = $filtered_option_content['fields']['content'] ?? '';
              }
            ?>
          <textarea rows="2" class="form-control square plugin_editor" name="optional_content" placeholder="Write content in here">
            <?php echo sanitize_output($option_content); ?>
          </textarea>
          <div class="invalid-feedback"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="more_details" tabindex="-1" role="dialog" aria-labelledby="more_details" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="more_details">Guides for Content Layout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          Here are the instructions for managing content layout and adding icons:
        </p>
        <h5>1. Drag and Drop UI Components</h5>
        <p>
          Drag components from the right panel to the layout and arrange them as needed.
        </p>
        <ul>
          <li>Select a component from the "UI Components" panel.</li>
          <li>Drag it to the layout.</li>
          <li>Reorder components to customize your layout.</li>
        </ul>

        <h5>2. Icon Input</h5>
        <p>To add a Bootstrap 5 icon, follow these steps:</p>
        <ul>
          <li>Visit the <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons website</a>.</li>
          <li>Search for the icon you need.</li>
          <li>Copy the icon's class (e.g., <code>bi bi-house-door</code>).</li>
          <li>Paste the class into the icon input field in your form.</li>
        </ul>
        <p>Make sure to paste the full class name for the icon to display correctly.</p>

        <h5>Important Notes</h5>
        <div class="alert alert-warning">
          <strong>Note:</strong> The correct class is required for the icon to appear.
        </div>
        <div class="alert alert-info">
          <strong>Tip:</strong> Visit the <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons page</a> to explore more icons.
        </div>

        <h5>3. Optional Content Section</h5>
        <p>This section is optional and only appears after you drag a content section into the layout.</p>
        <ul>
          <li>Drag a section from the right panel to the layout area.</li>
          <li>Once the section is added, you can input additional details in the form fields.</li>
          <li>Only input fields for the section that has been added will be active.</li>
        </ul>
        <p>Ensure that the section is dragged into the layout before filling in any content.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    init_switch_toggle('.button-switch', '.button-switch-options');
    init_switch_toggle('.title-switch', '.title-switch-options');
    init_switch_toggle('.features-switch', '.features-switch-options');
  });
</script>

<script>
  $(document).ready(function() {
    $(document).on('click', '.btnAddItem', function() {
      var container = $(this).closest(".group-form-features"); 
      var section_container = $(this).closest(".section-item"); 
      var section_order = section_container.data("order"); 
      var number = container.find(".features-items .feature-item:last-child").data("number");

      if (number === undefined) {
          number = 0; 
      } else {
          number++; 
      }

      var extra_html = container.find(".feature-item-more").html();
      console.log(section_order);
      
      extra_html = extra_html.replace(/__name__/gi, "name");
      extra_html = extra_html.replace(/__number__/gi, number);
      extra_html = extra_html.replace(/\[default_form\]\[fields\]|\[\d+\]\[fields\]/gi, `[${section_order}][fields]`);

      container.find(".features-items").append(extra_html);
    });

    $(document).on('click', '.btnRemoveItem', function() {
      var featureItem = $(this).closest('.feature-item');
      featureItem.remove(); 
    });
  });
</script>

