
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
                    <label class="form-label">Public Key<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][public_key]" value="<?php echo (isset($option->public_key)) ? $option->public_key : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Private Key<span class="form-required">*</span></label>
                    <input type="text" class="form-control"  name="payment_params[option][secret_key]" value="<?php echo (isset($option->secret_key)) ? $option->secret_key : ''; ?>">
                  </div>

                  <?php
                    $coins = array(
                      'BTC'  => 'Bitcoin',
                      'LTC'  => 'Litecoin',
                      'ETH'  => 'Ether',
                      'BCH'  => 'Bitcoin Cash',
                      'DASH' => 'DASH',
                      'XRP'  => 'Ripple',
                      'LTCT' => 'Litecoin Testnet',
                    );
                  ?>
                  <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
                    <h5 class="text-info"><i class="fe fe-link"></i> Coin Acceptance Settings:</h5>
                    <p class="text-danger"><strong><?=lang('note')?></strong> <?=lang("make_sure_the_list_of_coins_have_the_enabled_status_in")?> <a href="https://www.coinpayments.net/acct-coins" target="_blank" class="text-link">Coinpayments</a></p>
                    <div class="row">
                      <?php
                        $coinpayments_acceptance = isset($option->coinpayments_acceptance) ? $option->coinpayments_acceptance : ["BTC","LTC","XRP"];
                        $i = 0;
                        foreach ($coins as $key => $row) {
                          $i++;
                      ?>
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="custom-controls-stacked">
                            <label class="custom-switch mr-5">
                              <input type="checkbox" name="payment_params[option][coinpayments_acceptance][]" class="custom-switch-input" value="<?=$key?>" <?=(in_array($key, $coinpayments_acceptance)) ? "checked" : ''?> >
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

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?php echo lang("Submit")?></button>
            <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?php echo lang("Cancel")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
