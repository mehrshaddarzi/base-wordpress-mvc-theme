<?php
    /**
     * The template for the header sticky bar.
     * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
     *
     * @author        Redux Framework
     * @package       ReduxFramework/Templates
     * @version:      3.5.7.8
     */
?>
<div id="redux-sticky">
    <div id="info_bar">

       

        <div class="redux-action_bar">
            <span class="spinner"></span>
            <?php if ( false === $this->parent->args['hide_save'] ) { ?>
                <?php submit_button( esc_attr__( 'ثبت تغییرات', 'redux-framework' ), 'primary', 'redux_save', false ); ?>
            <?php } ?>
            
            <?php if ( false === $this->parent->args['hide_reset'] ) { ?>
                <?php submit_button( esc_attr__( 'ریست تنظیمات بخش', 'redux-framework' ), 'secondary', $this->parent->args['opt_name'] . '[defaults-section]', false, array( 'id' => 'redux-defaults-section' ) ); ?>
                <?php submit_button( esc_attr__( 'بازیابی کل تنظیمات', 'redux-framework' ), 'secondary', $this->parent->args['opt_name'] . '[defaults]', false, array( 'id' => 'redux-defaults' ) ); ?>
            <?php } ?>
        </div>
        <div class="redux-ajax-loading" alt="<?php esc_attr_e( 'Working...', 'redux-framework' ) ?>">&nbsp;</div>
        <div class="clear"></div>
    </div>

    <!-- Notification bar -->
    <div id="redux_notification_bar">
        <?php $this->notification_bar(); ?>
    </div>


</div>