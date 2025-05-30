<?= $this->extend('admin/auth_blade') ?>



<?php
    $form_url = admin_url("login");
    $form_attributes = [
      'class'                 => 'form actionFormLogin',
      'data-task'             => 'json',
      'data-set_html_element' => '',
      'method'                => "POST",
    ];
?>
<?= $this->section('content') ?>
    <div class="auth-login-form">
        <div class="form-login">
            <?=form_open($form_url, $form_attributes)?>
                <div>
                    <div class="card-title text-center">
                        <div class="site-logo">
                            <a href="<?php echo base_url(); ?>">
                                <img src="<?= get_app_setting('website_logo') ?>" alt="<?= get_app_setting('website_name') ?>">
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon mb-5">
                            <span class="input-icon-addon">
                                <i class="fe fe-mail"></i>
                            </span>
                            <input type="email" class="form-control" name="email" placeholder="<?php echo lang("Email"); ?>" value="<?php echo (isset($cookie_email) && $cookie_email != "") ? strip_tags($cookie_email) : ""; ?>" >
                        </div>    
                            
                        <div class="input-icon mb-5">
                            <span class="input-icon-addon">
                                <i class="fa fa-key"></i>
                            </span>
                            <input type="password" class="form-control" name="password" placeholder="<?php echo lang("Password"); ?>" value="<?php echo (isset($cookie_pass) && $cookie_pass != "") ? strip_tags($cookie_pass) : ""; ?>" >
                        </div>  
                    </div>

                    <?= render_recaptcha_html('admin_login_form'); ?>

                    <div class="form-footer">
                        <button class="btn btn-pill btn-2 btn-block btn-submit btn-gradient">Login</button>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
<?= $this->endSection() ?>