<?php
/*
Template Name:Publir Action

*/
$pubsubschekcer = '';
$siteSubData = array();
if( isset($_COOKIE['publir_subs_log'])) { 
    $decoded_cookie_value = stripslashes($_COOKIE['publir_subs_log']);
    $siteSubData = json_decode($decoded_cookie_value, true);
    header("refresh: 300;");
}
$options = get_option('publir_wp_options');
get_header();
?>
<div class="wrapper page-section">
    
    <div class="publir-tabset">
    <?php if(!empty($siteSubData)) { 
        ?>
        <input type="radio" name="tabset" aria-controls="home" checked> 
        <label for="tab1" class="publir-width-20 publir-home-tab">Home</label> 
        <input type="radio" name="tabset"  aria-controls="logout-publir"> 
        <label for="tab2" class="publir-width-20 publir-home-tab" id="logout-publir">Log Out</label> 
        <div class="publirump-tab-panels">
            <section id="home" class="publirump-tab-panel publirump-home">
        <?php
        if(isset($siteSubData['status']) &&  $siteSubData['status'] == 0){
            $plan_type = $siteSubData['plan_type'];
            if( $plan_type != "Free" ) {
                _e('<p>Your account has been cancelled, and you will no longer be charged going forward.</p>');
                _e('<p>You will still be able to access the site until your account expires on:'.esc_attr(date('M d, Y',$siteSubData['ncdate'])).'</p>');
                _e('<p>If you change your mind, you can always come back to this page to re-activate your account.</p> <br />');
                _e("<h6>Update your Card to activate your account</h6><br />");
                _e(do_shortcode('[publir_update_card]'));
             } else if( $plan_type == "Free" ) {
                _e('<p>Your account has been cancelled.</p>');
                _e('<p>If you change your mind, you can always come back to this page to re-activate your account.</p> <br />');
             } else {
                _e('<p>Somethings went wrong!</p>');
                _e('<p>Try <a href="javascript:void(0);" id="logout-publir">re-login</a> to update your account.</p></p>');
             }
        }else{ ?> 
            <h6><?php _e(esc_attr($options['publir_subs_programming']));?> Subscription</h6>
            <p>Thank you for subscribing.</p> <p>Your subscription details are as follows:</p>
            <?php
            if( isset($siteSubData['plan_type']) && $siteSubData['plan_type'] != 'Free' ) {
            	
                $card_type = sanitize_text_field($siteSubData['card_type']);
                
                $card_last4 = sanitize_text_field($siteSubData['card_last4']);
                
                $plan_type = sanitize_text_field($siteSubData['plan_type']);
                
                $amount = sanitize_text_field($siteSubData['amount']);
                
                $nextChargeDate = sanitize_text_field($siteSubData['ncdate']);
          
                $siteSubData = publir_get_site_subs_data();
                if( $plan_type == "Life" ) {
            ?>
            <br>
                <div class="publir-row">
                <div class="col-sm-5">
                <b>Billing Frequency</b>
                </div>
                <div class="col-sm-5">
                <p>One Time</p>    
                </div>
                </div>
                <br>
            <?php 
                _e(do_shortcode('[publir_update_password]') );
            } else { ?>
            <br>
            <div class="publir-row">
                <div class="col-sm-5">
                <b>Card Type</b>
                </div>
                <div class="col-sm-5">
                <p><?php _e(esc_attr($card_type));?> </p>
                </div>
                <div class="col-sm-5">
                <b>Last 4 Digits</b>
                </div>
                <div class="col-sm-5">
                <p><?php _e( esc_attr( $card_last4) ); ?> </p>
                </div>
                <div class="col-sm-5">
                <b>Billing Frequency</b>
                </div>
                <div class="col-sm-5">
                <p><?php _e( esc_attr ($plan_type) ); ?> </p>
                </div>
                <div class="col-sm-5">
                <b>Next Renewal Date</b>
                </div>
                <div class="col-sm-5">
                <p><?php _e( esc_attr( date('M d, Y', $nextChargeDate) ) );?> </p>
                </div>
                <div class="col-sm-5">
                <b>Next Renewal Amount</b>
                </div>
                <div class="col-sm-5">
                <p><?php _e( esc_attr ( $siteSubData['currencySymbol'] .''. $amount ) ); ?> </p>
                </div>
            </div>
            <br>
                <?php
                _e(do_shortcode('[publir_update_password]') );
                _e(do_shortcode('[publir_update_card]'));
                _e(do_shortcode('[publir_cancel_subscription]'));
            }
            } else if( $siteSubData['plan_type'] == 'Free' ) {
                $card_type = "";
                $card_last4 = "";
                $plan_type = "";
                $amount = "";
                $nextChargeDate = "";
            ?>
                <br>
                <div class="publir-row">
                <div class="col-sm-5">
                <b>Billing Frequency</b>
                </div>
                <div class="col-sm-5">
                <p>Limited Access (Free)</p>    
                </div>
                </div>
                <br>
            <?php
                _e(do_shortcode('[publir_update_password]') );
            }
            ?>
         </section>
        </div>
        <br>
        <?php
        
        }
        }else{ ?>
        

        <input type="radio" name="tabset" id="tab1" aria-controls="login" checked> 
        <label for="tab1">Login</label> 
        <input type="radio" name="tabset" id="tab2" aria-controls="register"> 
        <label for="tab2">Subscribe</label> 
        <input type="radio" name="tabset" id="tab3" aria-controls="reset-password"> 
        <label for="tab3">Forgot Password?</label>
    
        <div class="publirump-tab-panels">
            <section id="login" class="publirump-tab-panel">
            <?php _e(do_shortcode('[publir_login]'));?>
            <?php if(!isset($_COOKIE['publir_subscriber'])) { ?>
             <p>Not a subscriber yet? <a href="javascript:void();" class="signup">Sign-up.</a></p>
             <p>Misplaced your password? <a href="javascript:void();" class="request-passowrd">Request new password.</a></p>
             <?php } ?>
            </section>
            <section id="register" class="publirump-tab-panel"><?php _e(do_shortcode('[publir_register]'));?></section>
            <section id="reset-password" class="publirump-tab-panel"><?php _e(do_shortcode('[publir_reset_password]'));?> </section>
        </div>
    <?php } ?>
       
    </div>
</div>
<?php
get_footer();