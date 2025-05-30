<?php
    $section_order_name = 'sections['. $section_order .']';
    $input_section_type = form_input(['name' => $section_order_name . '[section_type]', 'value' => $section_type, 'type' => 'hidden', 'class' => 'section_type']);
?>

<div class="row">
    <?=$input_section_type;?>
    <p class="form-description">Use the form below to edit or customize the content for the optional section</p>
</div>