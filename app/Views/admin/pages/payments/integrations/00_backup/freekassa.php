
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
                  <hr>
                  <div class="form-group">
                    <label class="form-label">Merchant ID<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][merchant_id]" value="<?php echo (isset($option->merchant_id)) ? $option->merchant_id : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Secret ID<span class="form-required">*</span></label>
                    <input type="text" class="form-control"  name="payment_params[option][secret_key]" value="<?php echo (isset($option->secret_key)) ? $option->secret_key : ''; ?>">
                  </div>
                  
                  <div class="form-group">
                    <label class="form-label">Curency Code</label>
                    <select name="payment_params[option][currency_code]" class="form-control square">
                      <option value="USD" <?php echo (isset($option->currency_code) && $option->currency_code == 'USD') ? 'selected' : '' ; ?> >USD - US Dollar</option>
                      <option value="RUB" <?php echo (isset($option->currency_code) && $option->currency_code == 'RUB') ? 'selected' : '' ; ?>>RUB - Russian Ruble</option>
                      <option value="EUR" <?php echo (isset($option->currency_code) && $option->currency_code == 'EUR') ? 'selected' : '' ; ?>>EUR - Euro</option>
                      <option value="KZT" <?php echo (isset($option->currency_code) && $option->currency_code == 'KZT') ? 'selected' : '' ; ?>>KZT - Kazakhstani Teng</option>
                    </select>
                  </div>


                </div>
                <?php
                  $payments_code = default_free_kassa_payment_code();
                ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Payment Method Acceptance Settings:</label>
                    <span class="text-danger"><strong><?=lang('note')?></strong></span>
                    <ul class="small">
                      <li> Go to the Free Kassa settings page </li>
                      <li> Select the notification method <code class="text-primary">POST</code> </li>
                      <li> Select the integration mode <code class="text-primary">NO</code></li>
                      <li> Site URL: <code class="text-primary"><?=cn()?></code> </li>
                      <li> Notification URL: <code class="text-primary"><?=cn('checkout/freekassa/complete')?></code></li>
                      <li> Success URL: <code class="text-primary"><?=cn('checkout/freekassa/complete')?></code></li>
                      <li> Unsuccess URL: <code class="text-primary"><?=cn('checkout/unsuccess')?></code>
                      <li>Make sure the list of payment methods have enabled in <a href="https://www.free-kassa.ru/cabinet/v2/settings?rc=1566461806" target="_blank" class="text-link">Payment Method</a></li>
                      <li>Please enable all Payment methods which support Curency Code at the same time. <br>For example: if you enable Curency Code - USD, you must be choose all payment support USD and set rate in currency rate fields</li>
                      </li>
                    </ul>
                  </div>
                </div>
                <?php
                  $freekassa_acceptance = isset($option->freekassa_acceptance) ? $option->freekassa_acceptance : ["70","123","64"];
                  $i = 0;
                  foreach ($payments_code as $key => $row) {
                    $i++;
                ?>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="custom-controls-stacked">
                      <label class="custom-switch mr-5">
                        <input type="checkbox" name="payment_params[option][freekassa_acceptance][]" class="custom-switch-input" value="<?=$key?>" <?=(in_array($key, $freekassa_acceptance)) ? "checked" : ''?> >
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"> <?=$key." - ".$row?></span>
                      </label>
                    </div>
                  </div>
                </div>
                <?php }?>

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
