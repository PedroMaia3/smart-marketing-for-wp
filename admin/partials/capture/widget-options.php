<?
// cria/atualiza widget
if (isset($_POST['action']) && ($_POST['action'])) {
    $post = $_POST;

    update_option($post['egoiform'], $post);
    
    echo get_notification('Widget', 'Widget guardado com sucesso.');
}

$opt_widget = get_option('egoi_widget');
$egoiwidget = $opt_widget['egoi_widget'];

if($egoiwidget['tag']!=''){
    $data = new Egoi_For_Wp();
    $info = $data->getTag($egoiwidget['tag']);
    $tag = $info['ID'];
}else{
    $tag = $egoiwidget['tag-egoi'];
}

$egoiwidget = array_map(
    function($str){
        return str_replace("\'", "'", $str);
    }, $egoiwidget);

if(!$egoiwidget['enabled']){
    $egoiwidget['enabled'] = 0;
}

include plugin_dir_path( __DIR__ ) . 'egoi-for-wp-admin-shortcodes.php';
$FORM_OPTION = get_optionsform($form_id);
?>

<form id="smsnf-widget-options" action="" method="post">
    <? settings_fields($FORM_OPTION); ?>

    <input type="hidden" name="widget" value="1">
    <input type="hidden" name="egoiform" value="egoi_widget">
    
    <!-- enable widget -->
    <div class="smsnf-input-group">
        <label for="enable-widget">Enable Widgets</label>
        <div class="form-group switch-yes-no">
            <label class="form-switch">
                <input id="enable-widget" name="egoi_widget[enabled]" value="1" <? checked($egoiwidget['enabled'], 1); ?> type="checkbox">
                <i class="form-icon"></i><div class="yes"><? _e( 'Yes', 'egoi-for-wp' ); ?></div><div class="no"><? _e( 'No', 'egoi-for-wp' ); ?></div>
            </label>
        </div>
    </div>
    <!-- / enable widget -->
    <!-- Double Opt-In -->
    <div class="smsnf-input-group">
        <label for="widget_double_optin"><? _e( 'Enable Double Opt-In?', 'egoi-for-wp' ); ?></label>
        <p class="subtitle"><?php _e( 'If you activate the double opt-in, a confirmation e-mail will be send to the subscribers.', 'egoi-for-wp' ); ?></p>
        <div class="form-group switch-yes-no">
            <label class="form-switch">
                <? $double_optin_enable = $egoiwidget['double_optin'] == 1 || $egoiwidget['list'] == 0 ?>
                <input id="widget_double_optin" name="egoi_widget[double_optin]" value="1" <? checked($double_optin_enable, 1); ?> type="checkbox">
                <i class="form-icon"></i><div class="yes"><? _e( 'Yes', 'egoi-for-wp' ); ?></div><div class="no"><? _e( 'No', 'egoi-for-wp' ); ?></div>
            </label>
        </div>
    </div>
    <!-- / Double Opt-In -->
    <!-- TAB -->
    <ul class="tab">
        <li class="tab-item active">
            <a href="#" tab-target="smsnf-configuration"><? _e( 'Settings', 'egoi-for-wp' ); ?></a>
        </li>
        <li class="tab-item">
            <a href="#" tab-target="smsnf-appearance"><? _e( 'Appearance', 'egoi-for-wp' ); ?></a>
        </li>
    </ul>
    <!-- / TAB -->
    <!-- Configuration -->
    <div id="smsnf-configuration" class="smsnf-tab-content smsnf-grid active">
        <div>
            <!-- LIST -->
            <? get_list_html( $egoiwidget['list'], 'egoi_widget[list]' ); ?>
            <!-- / LIST -->
            <!-- lang -->
            <? get_lang_html( $egoiwidget['lang'], 'egoi_widget[lang]', empty($egoiwidget['list']) ); ?>
            <!-- / lang -->
            <!-- tag -->
            <? get_tag_html($tag, ''); ?>
            <!-- / tag -->
            <!-- success msg -->
            <div class="smsnf-input-group ">
                <label for="widget-success-msg"><?= _e( 'Successfully subscribed', 'egoi-for-wp' ) ?></label>
                <input id="widget-success-msg" type="text" name="egoi_widget[msg_subscribed]" value="<?= esc_attr($egoiwidget['msg_subscribed']) ?>" placeholder="<?= _e( 'Your request has been successfully submitted. Thank you.', 'egoi-for-wp' ) ?>" autocomplete="off" />
            </div>
            <!-- / success msg -->
            <!-- error msg -->
            <div class="smsnf-input-group ">
                <label for="widget-error-msg"><?= _e( 'Invalid email address', 'egoi-for-wp' ) ?></label>
                <input id="widget-error-msg" type="text" name="egoi_widget[msg_invalid]" value="<?= esc_attr($egoiwidget['msg_invalid']) ?>" placeholder="<?= _e( 'Check, please, if you wrote your e-mail address correctly.', 'egoi-for-wp' ) ?>" autocomplete="off" />
            </div>
            <!-- / error msg -->
            <!-- empty email msg -->
            <div class="smsnf-input-group ">
                <label for="widget-empty-email-msg"><?= _e( 'Empty email address', 'egoi-for-wp' ) ?></label>
                <input id="widget-empty-email-msg" type="text" name="egoi_widget[msg_empty]" value="<?= esc_attr($egoiwidget['msg_empty']) ?>" placeholder="<?= _e( 'Your e-mail field is empty!', 'egoi-for-wp' ) ?>" autocomplete="off" />
            </div>
            <!-- / empty email msg -->
            <!-- already subscribed msg -->
            <div class="smsnf-input-group ">
                <label for="widget-already-subscribed-msg"><?= _e( 'Already subscribed', 'egoi-for-wp' ) ?></label>
                <input id="widget-already-subscribed-msg" type="text" name="egoi_widget[msg_exists_subscribed]" value="<?= esc_attr($egoiwidget['msg_exists_subscribed']) ?>" placeholder="<?= _e( 'The email address already exists in your list of contacts.', 'egoi-for-wp' ) ?>" autocomplete="off" />
                <p class="subtitle"><?php _e( 'The text that shows when the given email is already subscribed to the selected list.', 'egoi-for-wp' ); ?></p>
            </div>
            <!-- / already subscribed msg -->
            <!--  -->
            <div class="smsnf-input-group">
                <label for="widget-hide-form"><? _e( 'Hide form after successful sign-up', 'egoi-for-wp' ); ?></label>
                <p class="subtitle"><? _e( 'Select "yes" to hide the form after successful sign-up.', 'egoi-for-wp' ); ?></p>
                <div class="form-group switch-yes-no">
                    <label class="form-switch">
                        <input id="widget-hide-form" name="egoi_widget[hide_form]" value="1" <? checked($egoiwidget['hide_form'], 1); ?> type="checkbox">
                        <i class="form-icon"></i><div class="yes"><? _e( 'Yes', 'egoi-for-wp' ); ?></div><div class="no"><? _e( 'No', 'egoi-for-wp' ); ?></div>
                    </label>
                </div>
            </div>
            <!-- /  -->
            <!--  -->
            <div class="smsnf-input-group ">
                <label for="widget-redirect"><? _e( 'Redirect to URL after a successful sign-up', 'egoi-for-wp' ); ?></label>
                <p class="subtitle"><? _e( 'Leave empty for no redirect. Otherwise, use complete (absolute) URLs.', 'egoi-for-wp' ); ?></p>
                <input id="widget-redirect" type="text" name="egoi_widget[redirect]" value="<?= esc_attr($egoiwidget['redirect']) ?>" placeholder="<?= printf(__('Example: %s', 'egoi-for-wp'), esc_attr(site_url('/thank-you/'))) ?>" autocomplete="off" />
            </div>
            <!-- /  -->
        </div>
    </div>
    <!-- / Configuration -->
    <!-- appearance -->
    <div id="smsnf-appearance" class="smsnf-tab-content smsnf-grid">
        <div>
            <!-- Input Width -->
            <div class="smsnf-input-group ">
                <label for="widget-input-width"><?= _e( 'Input Width', 'egoi-for-wp' ) ?></label>
                <input id="widget-input-width" type="text" name="egoi_widget[input_width]" value="<?= esc_attr($egoiwidget['input_width']) ?>">
                <p class="subtitle"><? _e( 'Change the input width in px, otherwise leave empty if you want to 100%', 'egoi-for-wp' ); ?></p>
            </div>
            <!-- / Input Width -->
            <!-- Button Width -->
            <div class="smsnf-input-group ">
                <label for="widget-button-width"><?= _e( 'Button Width', 'egoi-for-wp' ) ?></label>
                <input id="widget-button-width" type="text" name="egoi_widget[btn_width]" value="<?= esc_attr($egoiwidget['btn_width']) ?>">
                <p class="subtitle"><?php _e( 'Change the subscriber button width in px', 'egoi-for-wp' ); ?></p>
            </div>
            <!-- / Button Width -->
            <!-- Border Color -->
            <div class="smsnf-input-group">
                <label for="bar-text-color"><?= _e( 'Border Color', 'egoi-for-wp' ) ?></label>
                <div class="colorpicker-wrapper">
                    <div style="background-color:<?= esc_attr($egoiwidget['bcolor']) ?>" class="view" ></div>
                    <input id="bar-text-color" type="text" name="egoi_widget[bcolor]" value="<?= esc_attr($egoiwidget['bcolor']) ?>"  autocomplete="off" />
                    <p><?= _e( 'Select Color', 'egoi-for-wp' ) ?></p>
                </div>
            </div>
            <!-- / Border Color -->
            <!-- Background Color on Success -->
            <div class="smsnf-input-group">
                <label for="bar-text-color"><?= _e( 'Background Color on Success', 'egoi-for-wp' ) ?></label>
                <div class="colorpicker-wrapper">
                    <div style="background-color:<?= esc_attr($egoiwidget['bcolor_success']) ?>" class="view" ></div>
                    <input id="bar-text-color" type="text" name="egoi_widget[bcolor_success]" value="<?= esc_attr($egoiwidget['bcolor_success']) ?>"  autocomplete="off" />
                    <p><?= _e( 'Select Color', 'egoi-for-wp' ) ?></p>
                </div>
                <p class="subtitle"><?php _e( 'Change the color of the Widget Success message', 'egoi-for-wp' ); ?></p>
            </div>
            <!-- / Background Color on Success -->
            <!-- Background Color on Error -->
            <div class="smsnf-input-group">
                <label for="bar-text-color"><?= _e( 'Background Color on Error', 'egoi-for-wp' ) ?></label>
                <div class="colorpicker-wrapper">
                    <div style="background-color:<?= esc_attr($egoiwidget['bcolor_error']) ?>" class="view" ></div>
                    <input id="bar-text-color" type="text" name="egoi_widget[bcolor_error]" value="<?= esc_attr($egoiwidget['bcolor_error']) ?>"  autocomplete="off" />
                    <p><?= _e( 'Select Color', 'egoi-for-wp' ) ?></p>
                </div>
                <p class="subtitle"><?php _e( 'Change the color of the Widget Error message', 'egoi-for-wp' ); ?></p>
            </div>
            <!-- / Background Color on Error -->
        </div>
    </div>
    <!-- / appearance -->
    <!-- SUBMIT -->
    <div class="smsnf-input-group">
        <input type="submit" value="<? _e('Save', 'egoi-for-wp');?>">
    </div>
    <!-- / SUBMIT -->
</form>