<?php if ($recent_clients) : ?>
  <div class="col-md-12 col-xl-12">
    <div class="card">
      <div class="card-header ">
          <h4 class="card-title"><?php echo sanitize_output($title)?></h4>
          <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
          </div>
      </div>
      <?php 
        $tb_columns = [
          "id"               => ['name' => '#', 'class' =>  'text-center'],
          "user"             => ['name' => 'Customer',      'class' => 'text-center'],
          "total_order"      => ['name' => 'Total Order',       'class'     =>      'text-center'],
          "ip_address"       => ['name' => 'History IP',    'class' =>      'text-center'],
          "created"          => ['name' => 'created',       'class'       =>          'text-center'],
        ];
      ?>
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-vcenter card-table">
          <?php echo render_table_thead($tb_columns, false, false, false, []); ?>
          <tbody class="ui-sortable">
            <?php 
              $i = 1;
              foreach($recent_clients as $key => $item) {
                $tdElements = [
                  'checkBox' => [
                    'class' => 'text-center w-1p', 'attr' => [], 
                    'element' => $i++, 
                  ],
                  'email' => [
                    'class' => '', 'attr' => [], 
                    'element' => esc($item['email']), 
                  ],
                  'total_orders' => [
                    'class' => 'text-center', 'attr' => [], 
                    'element' => esc($item['total_orders']), 
                  ],
                  'ip' => [
                    'class' => 'text-center w-20p', 'attr' => [], 
                    'element' => esc($item['history_ip']), 
                  ],
                  'created' => [
                    'class' => 'text-center w-20p', 'attr' => [], 
                    'element' => show_item_datetime($item['created'], 'long'), 
                  ],
                ];
                $trElement = [
                  'class' => 'tr_' . $item['ids'],
                  'attr'  => ['id' => $item['id']],
                  'tdElements' => $tdElements,
                ];
                echo renderTableTr($item, $trElement, []);
              }
            ?> 
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php endif; ?>
