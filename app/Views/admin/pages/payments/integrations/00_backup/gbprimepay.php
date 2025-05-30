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
                    <label class="form-label">Customer key<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][customer_key]" value="<?php echo (isset($option->customer_key)) ? $option->customer_key : ''; ?>">
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
                    <label class="form-label">Curency Code</label>
                    <select name="payment_params[option][currency_code]" class="form-control square ajaxChangeCurrencyCode">
                      <option value="BATH" <?=(isset($option->currency_code) && $option->currency_code == 'BATH')? "selected" : ''?>>BATH</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="form-label"><?=lang("currency_rate")?></label>
                    <div class="input-group">
                      <span class="input-group-prepend">
                        <span class="input-group-text">1USD =</span>
                      </span>
                      <input type="text" class="form-control text-right" name="payment_params[option][rate_to_usd]" value="<?php echo (isset($option->rate_to_usd)) ? $option->rate_to_usd : 1; ?>">
                      <span class="input-group-append">
                        <span class="input-group-text new-currency-code"><?php echo (isset($option->currency_code)) ? $option->currency_code : 'BATH'; ?></span>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <ul>
                      <li>
                        If you use BATH as default currency code, please set rate 1USD = 1BATH;
                      </li>
                      <li>
                        Go to your <a href="https://www.gbprimepay.com/" target="_blank">GB Prime Pay account</a>
                      </li>
                      <li>
                        Select option <strong>Shop type</strong>: <code class="text-danger">Website shop</code>
                      </li>
                      <li>
                        Select options <strong>Bill payment</strong> and <strong>Qrcode payment</strong>: <code class="text-danger">Yes</code>
                      </li>
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

<script>
  $(document).on("change",".ajaxChangeCurrencyCode", function(){
    var _that = $(this),
        _type = _that.val();
    $(".new-currency-code").html(_type);
  });
</script>