<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <?php
          $id = (!empty($payment->id))? $payment->id: '';
          if ($id != "") {
            $url = cn($module."/ajax_update/$id");
          }else{
            $url = cn($module."/ajax_update");
          }
        ?>
        <form class="form actionForm" action="<?php echo $url?>" data-redirect="<?php echo cn($module); ?>" method="POST">
          <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo $payment->name; ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="form-body">
              <div class="row justify-content-md-center">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label class="form-label" ><?php echo lang("method_name"); ?></label>
                    <input type="hidden" class="form-control square" name="payment_params[type]" value="<?php echo $payment->type; ?>">
                    <input type="text" class="form-control square" name="payment_params[name]" value="<?php echo (!empty($payment->name))? $payment->name : '' ; ?>">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" >Sort</label>
                    <input type="number" class="form-control square" name="payment_params[sort]" value="<?php echo (!empty($payment->sort))? $payment->sort : 1 ; ?>">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"><?php echo lang("Status"); ?></label>
                    <select name="payment_params[status]" class="form-control square">
                      <option value="1" <?php echo (!empty($payment->status) && $payment->status == 1) ? 'selected' : '' ; ?>><?php echo lang("Active")?></option>
                      <option value="0" <?php echo (isset($payment->status) && $payment->status != 1) ? 'selected' : '' ; ?>><?php echo lang("Deactive")?></option>
                    </select>
                  </div>
                </div>
                <?php
                  $payment_params = json_decode($payment->params);
                  $option = $payment_params->option;
                ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label"><?=lang("transaction_fee")?></label>
                    <select name="payment_params[option][tnx_fee]" class="form-control square">
                      <?php
                        for ($i = 0; $i <= 30; $i++) {
                      ?>
                      <option value="<?=$i?>" <?=(isset($option->tnx_fee) && $option->tnx_fee == $i)? "selected" : ''?>><?php echo $i; ?>%</option>
                      <?php } ?>
                    </select>
                  </div>
                </div> 
                 
                <div class="col-md-12">
                  <hr>
                  <div class="form-group">
                    <label class="form-label"><?php echo lang("Environment")?></label>
                    <select name="payment_params[option][environment]" class="form-control square">
                      <option value="sandbox" <?php echo (isset($option->environment) && $option->environment == 'sandbox') ? 'selected' : ''; ?>><?php echo lang("sandbox_test"); ?></option>
                      <option value="live" <?php echo (isset($option->environment) && $option->environment == 'live') ? 'selected' : ''; ?>><?php echo lang("Live"); ?></option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="form-label">Public Key<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][public_key]" value="<?php echo (isset($option->public_key)) ? $option->public_key : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Secret key<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][secret_key]" value="<?php echo (isset($option->secret_key)) ? $option->secret_key : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Payment Descriptions <span class="form-required">*</span></label>
                    <textarea rows="3" name="payment_params[option][pm_details]" class="form-control"><?php echo (isset($option->pm_details)) ? strip_tags($option->pm_details) : 'Purchase a digital Service package'; ?></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label class="form-label"><?=lang("currency_rate")?></label>
                    <div class="input-group">
                      <span class="input-group-prepend">
                        <span class="input-group-text">1<?php get_option('currency_symbol', 'USD');?> =</span>
                      </span>
                      <input type="text" class="form-control text-right" name="payment_params[option][rate_to_usd]" value="<?php echo (isset($option->rate_to_usd)) ? $option->rate_to_usd : 76; ?>">
                      <span class="input-group-append">
                        <span class="input-group-text new_currency_code">IDR</span>
                      </span>
                    </div>
                  </div>

                  <h5>Payment Channels:</h5>
                  <div class="row">
                    <?php
                      $default_payment_channels = [
                        "credit_card",
                        "gopay",
                        "mandiri_clickpay",
                        "cimb_clicks",
                        "bca_klikbca",
                        "bca_klikpay",
                        "bri_epay",
                        "telkomsel_cash",
                        "echannel",
                        "bbm_money",
                        "xl_tunai",
                        "indosat_dompetku",
                        "mandiri_ecash",
                        "permata_va",
                        "bca_va",
                        "bni_va",
                        "danamon_online",
                        "other_va",
                        "kioson",
                        "Indomaret"
                      ];

                      $midtrans_payment_channels = isset($option->midtrans_payment_channels) ? $option->midtrans_payment_channels : ["credit_card","gopay","mandiri_clickpay"];
                      $i = 0;
                      foreach ($default_payment_channels as $row) {
                        $i++;
                    ?>
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="custom-controls-stacked">
                          <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="payment_params[option][midtrans_payment_channels][]" value="<?=$row?>" <?=(in_array($row, $midtrans_payment_channels)) ? "checked" : ''?>>
                            <span class="form-check-label">
                              <?=$row?>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <?php }?>
                  </div>

                  <div class="form-group">
                    <label><span class="text-danger">Notes: </span>Midtrans Callback URL (Login to Midtrans account, Go to Setting -> Configurations)</label>
                    <ul>
                      <li><strong>Finish Redirect URL</strong>: <span class="text-info"><?php echo cn('checkout'); ?></span></li>
                      <li><strong>Unfinish & Error Redirect URL</strong>: <span class="text-info"><?php echo cn('checkout/unsuccess'); ?></span></li>
                      <li><strong>Payment Notification URL</strong>: <span class="text-info"><?php echo cn('midtrans_ipn'); ?></span></li>
                    </ul>
                  </div>

                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?php echo lang("Submit")?></button>
            <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?php echo lang("Cancel")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
