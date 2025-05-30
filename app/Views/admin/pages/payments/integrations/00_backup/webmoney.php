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
                    <label class="form-label">Webmoney Purse<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][purse]" value="<?php echo (isset($option->purse)) ? $option->purse : ''; ?>">
                  </div>

                  <div class="form-group">
                    <label class="form-label">Webmoney Secret<span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="payment_params[option][secret]" value="<?php echo (isset($option->secret)) ? $option->secret : ''; ?>">
                  </div>
                  
                  <div class="form-group">
                    <label class="form-label">Payment Descriptions <span class="form-required">*</span></label>
                    <textarea rows="3" name="payment_params[option][pm_details]" class="form-control"><?php echo (isset($option->pm_details)) ? strip_tags($option->pm_details) : 'Purchase a digital Service package'; ?></textarea>
                  </div>        

                  <div class="form-group">
                    <div class="form-group">
                      <span class="text-danger"><strong><?=lang('note')?></strong></span>
                      <ul class="text">
                        <li> To receive payments you must have minimum formal certificate with verified documents (or certificate of higher level). </li>
                        <li>Go to <code class="text-primary">https://merchant.wmtransfer.com/conf/purses.asp</code></li>
                        <li>Enter login details.</li>
                        <li>Click change for USD purse or other purse</li>
                        <li>Test/Work modes: work</li>
                        <li>Merchant name: set your panel title</li>
                        <li>Secret Key: set strong password</li>
                        <li> Success URL (POST): <code class="text-primary"><?=cn('checkout/webmoney/complete')?></code></li>
                        <li> Fail URL (LINK): <code class="text-primary"><?=cn('checkout/unsuccess')?></code></li>
                        <li>"Let to use URL sent in form" must be enabled</li>
                        <li>Control sign forming method: SHA256</li>
                      </ul>
                    </div>
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
