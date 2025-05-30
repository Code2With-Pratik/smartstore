<div class="row">
  <div class="col-md-12 col-lg-12">
    <h6><i class="fa fa-code"></i> Custom header code
      <i class="fa fa-question-circle" data-title="Details" data-toggle="popover" data-trigger="hover" data-placement="right" 
      data-content="- Use this field to add your own CSS rules or another header code
        <br>
        <br>
        - This code should be placed in the  <strong> &#60;head&#62;</strong> tag of your page for enabling Google Analytics, Facebook Pixel, or similar tracking codes. ">
      </i>
    </h6>
    <div class="form-group">
      <textarea rows="5" name="embed_js_code_header" id="embed_head_javascript"><?= get_app_setting('embed_js_code_header') ?></textarea>
    </div>

    <hr>
    
    <h6><i class="fa fa-code"></i> Custom footer code
      <i class="fa fa-question-circle" data-title="Details" data-toggle="popover" data-trigger="hover" data-placement="right" 
      data-content="- Use this field to add your own javascript code or any tracking code
        <br>
        <br>
        - Place this code just before the closing <strong> &#60;/body&#62;</strong> tag of the page. It is typically used for integrating chat plugins and other interactive features">
      </i>
    </h6>
    <div class="form-group">
      <textarea rows="5" placeholder="<script>...</script>" name="embed_js_code_footer" id="embed_javascript"><?= get_app_setting('embed_js_code_footer') ?></textarea>
    </div>
  </div> 
</div>

<script>
  setTimeout(function(){
    var editor = CodeMirror.fromTextArea(document.getElementById("embed_head_javascript"), {
      lineNumbers: true,
      theme: "monokai",
    });
    var editor = CodeMirror.fromTextArea(document.getElementById("embed_javascript"), {
      lineNumbers: true,
      theme: "monokai",
    });

  }, 200);
</script>