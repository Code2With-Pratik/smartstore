<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>

    <?php

        $class_element        = config('AppConfig')->template['form']['class_element'];
        $class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
        $label_required       = config('AppConfig')->template['form']['label_required'];
        $timezone = tz_list();
        $form_timezone = array_combine(array_column($timezone, 'zone'), array_column($timezone, 'time'));
        $elements = [
            [
                'label' => form_label('Name', 'First name'),
                'element' => form_input(['name' => 'first_name', 'value' => @$item['first_name'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
            [
                'label' => form_label('Last name', 'Last name'),
                'element' => form_input(['name' => 'last_name', 'value' => @$item['last_name'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
            [
                'label' => form_label('Email', 'Email'),
                'element' => form_input(['name' => 'email', 'value' => @$item['email'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
            [
                'label' => form_label('Timezone'),
                'element' => form_dropdown('timezone', $form_timezone, @$item['timezone'], ['class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
        ];
        $elements_change_pass = [
            [
                'label' => form_label('Current password', 'Current password'),
                'element' => form_input(['name' => 'current_password', 'value' => '', 'type' => 'password', 'class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
            [
                'label' => form_label('Password', 'New Password'),
                'element' => form_input(['name' => 'password', 'value' => '', 'type' => 'password', 'class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
            [
                'label' => form_label('Confirm password', 'Confirm password'),
                'element' => form_input(['name' => 're_password', 'value' => '', 'type' => 'password', 'class' => $class_element]),
                'class_main' => "col-md-12 col-sm-12 col-xs-12",
            ],
        ];
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span><i class="icon fe fe-user"></i></span> Your account</h3>
                </div>
                <div class="card-body">
                    <?php
                        $redirect_url = admin_url("/profile/");
                        $form_url        = admin_url("/profile/");
                        $form_attributes = ['class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST"];
                        $form_hidden     = [
                            'id'    => $item['id'] ?? '',
                            'task'  => 'account_info',
                        ];
                    ?>
                    <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
                        <div class="form-body">
                            <div class="row">
                                <?php echo render_elements_form($elements); ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?php echo render_button_form();?>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div> 

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><span><i class="icon fe fe-user"></i></span> Change password</h3>
                </div>
                <div class="card-body">
                    <?php
                        $redirect_url = admin_url("/profile/");
                        $form_url        = admin_url("/profile/");
                        $form_attributes = ['class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST"];
                        $form_hidden     = [
                            'id'    => $item['id'] ?? '',
                            'task'    => 'change_password',
                        ];
                    ?>
                    <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
                        <div class="form-body">
                            <div class="row">
                                <?php echo render_elements_form($elements_change_pass); ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?php echo render_button_form();?>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div> 
    </div>

<?= $this->endSection() ?>
