
<?php if ($order_chart_spline) : ?>
  <style>
    #orders_chart_spline {
      height: 25rem;
    }
  </style>
  <!-- Chart Area -->
  <div class="col-sm-12 charts">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo sanitize_output($title)?></h3>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="p-4 card">
            <div id="orders_chart_spline"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      Chart_template.chart_spline('#orders_chart_spline', <?=$order_chart_spline ?>);
    });
  </script>

<?php endif; ?>
