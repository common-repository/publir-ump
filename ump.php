<?php
/**
 * Plugin Name: Publir UMP
 * Plugin URI: https://www.publir.com/wordpress-plugin/ump
 * Description: Manage your Publir settings from this page.
 * Version: 1.1.0
 * Author: Publir
 * Author URI: https://www.publir.com
 */

include( plugin_dir_path( __FILE__ ) . 'options.php');
include( plugin_dir_path( __FILE__ ) . 'functions.php');

add_shortcode('publir_login','publir_login_content');

if ( ! function_exists( 'publir_login_content' ) )  {
    function publir_login_content(){ 
        ob_start();
        $options = get_option('publir_wp_options');
        $loaderUrl = plugin_dir_url( __FILE__ ). 'assets/loader.gif';
        if( isset($_COOKIE['publir_subscriber'])) { ?>
            <h3><?php _e(esc_attr($options['publir_subs_programming']));?> Subscription</h3>
            <p>Thank you for subscribing</p>
            <p>Need to change your access code or update your card? For your security, please <a href="javascript:void(0);" id="logout-publir">re-login</a> to update your account.</p>
        <?php }else{
        ?>
        <h3><?php _e(esc_attr($options['publir_subs_programming']));?> Sign-in</h3>
        <form id="login-form" class="publir-login-form" action="<?php _e( esc_url( admin_url( 'admin-ajax.php' ) )); ?>" method="post" >
            <?php wp_nonce_field( "publr-login-form" ); ?>
            <input type="hidden" name="action" value="publir_login_action">
            <div class="login">
                <div class="publirump-login username">
                    <label>Email</label>
                    <input id="ump-username" type="text" name="username" placeholder="Enter Email" />
                </div>
                <div class="publirump-login password">
                    <label>Activation Code or Password</label>
                    <input id="ump-password" type="password" name="password" placeholder="Enter Password" />
                </div>
                <div class="publir-row">
                    <div class="publir-row publirump-login-response"></div>
                    <div class="publir-row">
                        <input class="publirump-login-button" type="submit" name="login" value="Submit" />
                        <div class="publir-login-loader">
                            <img src="<?php _e( esc_url_raw($loaderUrl) ); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php  
        }
        return ob_get_clean();
    }
}

add_shortcode('publir_update_password','publir_update_pwd_content');
if ( ! function_exists( 'publir_update_pwd_content' ) )  {
    function publir_update_pwd_content(){ 
        ob_start();
        $loaderUrl = plugin_dir_url( __FILE__ ). 'assets/loader.gif';
        ?>
        <h6 class="publirump-pb-15">Update Account</h6>
        <b class="publirump-pb-15">Change Password</b>
        <form id="update-pass" class="publir-update-pass" action="<?php _e(esc_url(admin_url( 'admin-ajax.php' ))); ?>" method="post" >
            <?php wp_nonce_field( "publr-updatepwd-form" ); ?>
            <input type="hidden" name="action" value="publir_update_password_action">
            <div class="login publir-row">
                <div class="publirump-login password">
                    
                    <input id="ump-password2" type="password" name="password" placeholder="Enter Old Password" />
                </div>
                <div class="publirump-login password">
                    
                    <input id="ump-newpassword" type="password" name="new-password" placeholder="Enter New Password" />
                </div>
                <div class="publirump-login password">
                    
                    <input id="ump-repassword" type="password" name="re-password" placeholder="Confirm New Password" />
                </div>
                <div class="publir-row">
                    <div class="publir-row pblr-update-response"></div>
                    <div class="publir-row">
                        <input class="publirump-login-button button" type="submit" name="change-password" value="Change Password" />
                        <div class="publir-update-pass-img"  style="display: none">
                            <img src="<?php _e( esc_url_raw($loaderUrl) ); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        
        return ob_get_clean();
    }
}

add_shortcode('publir_reset_password','publir_reset_password');
if ( ! function_exists( 'publir_reset_password' ) )  {
    function publir_reset_password(){
        ob_start();
        $loaderUrl = plugin_dir_url( __FILE__ ). 'assets/loader.gif';
     ?>
        <h3>Forgot Your Password?</h3>
        <form id="reset-form" class="publir-reset-form" action="<?php _e(esc_url(admin_url( 'admin-ajax.php' ))); ?>" method="post" >
            <?php wp_nonce_field( "publr-reset-form" ); ?>
            <input type="hidden" name="action" value="publir_check_email_action">
            <div class="login">
                <div class="publirump-login username ">
                    <label>Email</label>
                    <input id="ump-email" type="text" name="email" placeholder="Enter Email" />
                </div>
                <div class="publir-row"> 
                    <div class="publir-row pblr-reset-response"></div>
                    <div class="publir-row">
                        <input class="publirump-login-button button" type="submit" name="login" value="Submit" />
                        <div class="publir-reset-loader">
                            <img src="<?php _e( esc_url_raw($loaderUrl) ); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }
}

add_shortcode('publir_cancel_subscription','publir_cancel_account');

if ( ! function_exists( 'publir_cancel_account' ) )  {
    function publir_cancel_account(){ 
        ob_start();
        $loaderUrl = plugin_dir_url( __FILE__ ). 'assets/loader.gif';
        ?>
        <b class="publirump-pb-15"> Cancel Subscription </b>
        <form id="cancel-form" class="publir-cancel-form" action="<?php _e(esc_url(admin_url( 'admin-ajax.php' ))); ?>" method="post">
            <?php wp_nonce_field( "publr-cancel-form" ); ?>
            <input type="hidden" name="action" value="publir_cancel_subscription_action">
            <div class="form-group">
                <select class="publir-form-control publir-cancelReason" name="reason" id="cancelReason" onclick="show_cp_block()" required="">
                    <option value="" selected="">Reason for Cancellation</option>
                    <option>Do not visit this site often enough</option>
                    <option>Too many other subscriptions</option>
                    <option>Expensive compared to the value provided</option>
                    <option>Technical issues with the service</option>
                    <option>Other reasons</option>
                </select> 
            </div>
            <div class="form-group" style="display: none;" id="ca_confirm_password_block"> 
                <input type="password" name="ca_confirm_password" id="ca_confirm_password" placeholder="Confirm Password" value=""/>
            </div>
            <div class="login publir-row">
            <!-- <button class="publirump-login-button button" onclick="account_cancel_confirmation(event)"><?php _e('Suspend Account');?></button> -->
                <div class="publir-row pblr-cancel-response"></div>
                <div class="publir-row">
                    <input class="publirump-login-button button btn-secondary" onclick="account_cancel_confirmation(event)" type="submit" value="Suspend Account!" />
                    <div class="publir-cancel-loader">
                        <img src="<?php _e( esc_url_raw($loaderUrl) ); ?>" />
                    </div>
                </div>
            </div>
        </form>
        
    <?php 
        
        return ob_get_clean();
    }
}
add_shortcode('publir_register','publir_registeration_callback');
if ( ! function_exists( 'publir_registeration_callback' ) )  {
    function publir_registeration_callback(){
        ob_start();
        $loaderUrl = plugin_dir_url( __FILE__ ). 'assets/loader.gif';
        $siteSubData = publir_get_site_subs_data();
        $options = get_option('publir_wp_options');
        ?>
        <div class="panel publir-entry-content">
        <div class="publir-panel-heading">
            <h3 class="panel-title">Sign-up for <?php _e(esc_attr($options['publir_subs_programming']));?> Access!</h3>
        </div>
        <div class="publir-panel-body">
            <!-- Display errors returned by createToken -->
            <div id="paymentResponse"  style="display:none;"></div>
            <input type="hidden" id="publirStripePubKey" value="<?php _e( esc_attr( $siteSubData['stripePublicKey'])); ?>">
            <!-- Payment form -->
            <form action="<?php _e(esc_url(admin_url( 'admin-ajax.php' ))); ?>" method="POST" class="publir-paymentFrm" id="paymentFrm">
                <input type="hidden" name="action" value="publir_stripe_payment_action">
                <label for="customRadioInline1">Choose Plan  </label>
                <div class="form-group">
                    <?php 
                        if(!empty($siteSubData)){
                            $count = 1;
                            foreach ($siteSubData['plans'] as $key => $value) {
                                $planAmount = '';
                                $planType = esc_attr($value['frequency']);
                                $frequency = esc_attr($value['frequency']);
                                if($frequency == 'Life'){
                                    $planType = 'One Time'; 
                                }
                                if($frequency == 'Free'){
                                    $planType = 'Limited Access (Free)'; 
                                }
                                if($frequency != 'Free'){
                                    $planAmount = '('.esc_attr($siteSubData['currencySymbol']).esc_attr($value['value']).')';
                                }
                                ?>
                                <div class='publir-custom-control custom-radio publir-custom-control-inline' style="width:50%; float:left; margin-right:0 !important;">
                                <input type="radio" id="customRadioInline<?php _e(esc_attr($count)); ?>" name="plan" class="publir-form-control custom-control-input" onclick="plan_change(this)" value="<?php _e(esc_attr($frequency)); ?>"><label><?php _e( esc_attr( $planType) );  _e( esc_attr($planAmount )); ?></label>
                                </div>
                                <?php
                                $count++;
                                //$ChoosePlan .=  '<input type="radio" name="plan" onclick="plan_change(this)" class="form-control custom-control-input" value="'.$frequency.'"><label>'.$planType.$planAmount.'</label>';
                            }
                        }
                    ?>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="name" class="field autoDisable" placeholder="Full Name" autofocus="">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="field autoDisable" placeholder="Enter Email">
                </div>
                <div class="form-group" id="up_pass_show">
                    <label>Choose Password</label>
                    <input type="password" name="password" id="password" class="field autoDisable" placeholder="Password">
                </div>
                <div class="form-group" id="cup_pass_show">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" class="field autoDisable" placeholder="Confirm Password">
                </div>
                <div class="form-group" id="pubsubcardblock"> 
                    <label for="card-element">Enter Credit or Debit Card</label>
                    <div id="card-element" class="publir-form-control"></div>
                </div>
                <input type="hidden" name="stripeToken" value="" />
                <input type="hidden" name="stripeLast4" value="" />
                <input type="hidden" name="stripeBrand" value="" />
                <!--<button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button> -->
                <div class="publir-row">
                    <div class="publir-row publir-signup-response"></div>
                    <div class="publir-row">
                        <input class="publirump-login-button button" id="payBtn" type="submit" value="Submit Payment" />
                        <div class="publir-signup-loader">
                            <img style="width: 30px" src="<?php _e( esc_url_raw($loaderUrl) ); ?>" />
                        </div>
                    </div>
                </div>
                
                <p id="paymentNote">Please click the "Submit Payment" button only <br> once to prevent multiple charges.</p>
                
            </form>
        </div>
    </div>
    <?php
    return ob_get_clean();
    }
}
add_shortcode('publir_update_card','publir_update_card_callback');
if ( ! function_exists( 'publir_update_card_callback' ) )  {
    function publir_update_card_callback(){
        ob_start();
        $loaderUrl = plugin_dir_url( __FILE__ ). 'assets/loader.gif';
        $siteSubData = publir_get_site_subs_data();
        ?>
        <div class="panel container publir-entry-content">
            <div class="publirump-pb-15">
                <b class="">Update Card</b>
            </div>
            <div class="panel-body">
                <!-- Display errors returned by createToken -->
                <div id="paymentResponse"></div>
                <input type="hidden" id="publirStripePubKey" value="<?php _e( esc_attr( $siteSubData['stripePublicKey'])); ?>">
                <!-- Payment form -->
                <form action="<?php _e( esc_url(admin_url( 'admin-ajax.php' )) ); ?>" method="POST" class="publir-updateCardFrm" id="updateCardFrm">
                    <input type="hidden" name="action" value="publir_stripe_update_card_action">
                    <div class="form-group"> 
                        <div id="card-element" class="publir-form-control"></div>
                    </div>
                    <div class="form-group" style="display: none;" id="uc_confirm_password_block"> 
                        <input type="password" name="uc_confirm_password" id="uc_confirm_password" placeholder="Confirm Password" value=""/>
                    </div>
                    <input type="hidden" name="stripeToken" value="" />
                    <input type="hidden" name="stripeLast4" value="" />
                    <input type="hidden" name="stripeBrand" value="" />
                    <div class="publir-row">
                        <div class="publir-row pblr-card-response"></div>
                        <div class="publir-row">
                            <input class="publirump-login-button button" id="updateCardBtn" type="submit" value="Update Credit Card" />
                            <div class="publir-card-loader">
                                <img src="<?php _e( esc_url_raw($loaderUrl) ); ?>" />
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

//Login with Ajax
add_action( 'wp_ajax_publir_login_action', 'publir_login_action' );
add_action( 'wp_ajax_nopriv_publir_login_action', 'publir_login_action' );
if ( ! function_exists( 'publir_login_action' ) )  {
    function publir_login_action() {
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $publir_secret_key = sanitize_text_field($options['publir_secret_key']);
        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die(); 
        }
        $url  = 'https://subs-api.publir.com/publirsubscriptionsapi-dev-hello';
        if( empty($_POST['username']) ) {
            $return = json_encode(array('message'=>'Email required','status_code'=>201));
            wp_send_json( $return );
            wp_die();
        }
        $email = sanitize_email($_POST['username']);
        if( !$email ) {
            $return = json_encode(array('message'=>'Sorry, email is not valid.','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        }
        $password = '';
        if( empty($_POST['password']) ) {
            $return = json_encode(array('message'=>'Password required','status_code'=>201));
            wp_send_json( $return );
            wp_die();
        } 
        else 
            $password = sanitize_text_field($_POST['password']);
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"         => "login",
            "email"                 => $email,
            "up"                    => $password, 
            "siteId"                => $site_id,
            "siteName"              => $siteName
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => 45,
            'sslverify'   => false,
            'headers'     => array(
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json',
            ),
            'body'        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );

        $fixedJSON = publir_fix_json_response($response);
        
        $response = json_decode($fixedJSON, true);
        if ($response['type'] == 'success') {
            $renew_date = date('Y-m-d',$response['nextChargeDate']);
            $date1=date_create($renew_date);
            $date1->modify('+2 day'); 
            $date2=date_create(date('Y-m-d'));
            $diff=date_diff($date1,$date2);
            $cookie_name = "publir_subscriber";
            $cookie_value = 1;
            $days_to_expiry = $diff->format("%a");
            $root_domain = site_url();

            if ($date1 < $date2) {
                $days_to_expiry *= -1;
            }

            setcookie($cookie_name, $cookie_value, time() + (86400 * $days_to_expiry), "/", false,false,false); 

            $hashed_email = custom_encrypt($response['email'], $publir_secret_key);

            $data_to_save = array(
                'ehash' => $hashed_email,
                'sCustomerId' => $response['stripeCustomer'],
                'name' => $response['fullName'],
                'ncdate' => $response['nextChargeDate'],
                'card_type' => $response['card_type'],
                'card_last4' => $response['card_last4'],
                'plan_type' => $response['plan_type'],
                'amount' => $response['amount'],
                'status' => $response['status'],
            );
            $serialized_data = json_encode($data_to_save);

            setcookie('publir_subs_log', $serialized_data, time() + 300, "/", false, false, false);
            setcookie('publir_subscriber_status', $response['sid'], time() + (86400 * 1), "/", false,false,false); 

            $return = json_encode(array('message'=>'Login Successful!','status_code'=>200));
            
        }else{
            $return = json_encode(array('message'=>'Invalid login credential!','status_code'=>201)); 
        }
        wp_send_json($fixedJSON);
        wp_die();
    }
}
//Update Password with ajax function
add_action( 'wp_ajax_publir_update_password_action', 'publir_update_password_action' );
add_action( 'wp_ajax_nopriv_publir_update_password_action', 'publir_update_password_action' );

if ( ! function_exists( 'publir_update_password_action' ) )  {
    function publir_update_password_action() {
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $publir_secret_key = sanitize_text_field($options['publir_secret_key']);
        $email = '';
        if (isset($_COOKIE['publir_subs_log'])) {
            $pubCookieData = getCookieData();
            if(!empty($pubCookieData)){
                $email = custom_decrypt($pubCookieData['ehash'], $publir_secret_key);
            }
        }
        if(empty($email)){
            $return = json_encode(array('message'=>'Your session has expired. Please log in to continue where you left off.','status_code'=>401));
            wp_send_json(  $return );
            wp_die(); 
        }
        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        }
        $url  = 'https://subs-api.publir.com/publirsubscriptionsapi-dev-hello';
        if($_POST['new-password'] != $_POST['re-password']){
            $return = json_encode(array('message'=>'Password and Confirm password does not match!','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        }
        if( empty($_POST['password']) || empty($_POST['new-password']) || empty($_POST['re-password']) ) {
            $return = json_encode(array('message'=>'Passowrd Field can\'t empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        }
        else  {
            $password = sanitize_text_field($_POST['password']);
            $new_pssword = sanitize_text_field($_POST['new-password']);
        }
        if( empty($email) ) {
            $return = json_encode(array('message'=>'Email Field can\'t empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        } else    
            $email = sanitize_email($email);

        if( !$email ) {
            $return = json_encode(array('message'=>'Email is not valid','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        }
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"     => "change_pwd",
            "up"                => $password,
            "newPassword"       => $new_pssword,
            "email"             => $email, 
            "siteId"            => $site_id,
            "siteName"          => $siteName
        );
        $args = array(
            "method"      => "POST",
            "timeout"     => 45,
            "sslverify"   => false,
            "headers"     => array(
                "Accept" => "application/json",
                "Content-Type"  => "application/json",
            ),
            "body"        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );

        $fixedJSON = publir_fix_json_response($response);
        wp_send_json(  $fixedJSON );
        wp_die(); 
    }
}

//Check email is valid or not
add_action( 'wp_ajax_publir_check_email_action', 'publir_check_email_action' );
add_action( 'wp_ajax_nopriv_publir_check_email_action', 'publir_check_email_action' );
if ( ! function_exists( 'publir_check_email_action' ) )  {
    function publir_check_email_action() {
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $publir_subs_programming = isset($options['publir_subs_programming']) && !empty($options['publir_subs_programming']) ? sanitize_text_field($options['publir_subs_programming']) : 'Ad-Free';
        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die(); 
        }
        $url = "https://subs-api.publir.com/publirsubscriptionsapi-dev-hello";
        if( empty($_POST['email']) ) {
            $return = json_encode(array('message'=>'Email Field can\'t empty','status_code'=>201));
            wp_send_json( $return );
            wp_die(); 
        } 
        $email = sanitize_email($_POST['email']);
        if( !$email ) {
            $return = json_encode(array('message'=>'Email is not valid','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        }
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"     => "request_pwd", 
            "email"             => $email,
            "siteId"            => $site_id,
            "siteName"          => $siteName,
            "subs_programming"  => $publir_subs_programming,
        );

        $args = array(
            "method"      => "POST",
            "timeout"     => 45,
            "sslverify"   => false,
            "headers"     => array(
                "Accept" => "application/json",
                "Content-Type"  => "application/json",
            ),
            "body"        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );
        $fixedJSON = publir_fix_json_response($response);
        
        wp_send_json( $fixedJSON );
        wp_die(); 
    }
}

//Cancel Subscription
add_action( 'wp_ajax_publir_cancel_subscription_action', 'publir_cancel_subscription_action' );
add_action( 'wp_ajax_nopriv_publir_cancel_subscription_action', 'publir_cancel_subscription_action' );
if ( ! function_exists( 'publir_cancel_subscription_action' ) )  {
    function publir_cancel_subscription_action() {
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $publir_secret_key = sanitize_text_field($options['publir_secret_key']);
        $publir_subs_programming = isset($options['publir_subs_programming']) && !empty($options['publir_subs_programming']) ? sanitize_text_field($options['publir_subs_programming']) : 'Ad-Free';
        $subsData = array();
        if (isset($_COOKIE['publir_subs_log'])) {
            $subsData = getCookieData();
            if(!empty($subsData)){
                $email_val = custom_decrypt($subsData['ehash'], $publir_secret_key);
            }
        }
        if(empty($subsData) || empty($email_val)){
            $return = json_encode(array('message'=>'Your session has expired. Please log in to continue where you left off.','status_code'=>401));
            wp_send_json(  $return );
            wp_die(); 
        }

        $ca_confirm_password = '';
        if( empty($_POST['ca_confirm_password']) ) {
            $return = json_encode(array('message'=>'Confirm Password field is empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        }else $ca_confirm_password = sanitize_text_field($_POST['ca_confirm_password']);
        
        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die(); 
        }
        $url = "https://subs-api.publir.com/publirsubscriptionsapi-dev-hello";
        if( empty($email_val) ) {
            $return = json_encode(array('message'=>'Email is required','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        } else 
            $email = sanitize_email($email_val);
        if( !$email ) {
            $return = json_encode(array('message'=>'Email is not valid','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        }

        $reason = '';
        if( empty($_POST['reason']) ) {
            $return = json_encode(array('message'=>'Reason must be not empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        } else {
            $reason = sanitize_text_field($_POST['reason']);
        }
        $fullName = $subsData['name'];
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"     => "sub_cancel_account",    
            "email"             => $email, 
            "siteId"            => $site_id,
            "siteName"          => $siteName,
            "cancelReason"      => $reason,
            "fullName"          => $fullName,
            "password"          => $ca_confirm_password,
            "subs_programming"  => $publir_subs_programming,
        );

        $args = array(
            'method'      => 'POST',
            'timeout'     => 45,
            'sslverify'   => false,
            'headers'     => array(
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json',
            ),
            'body'        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );

        $fixedJSON = publir_fix_json_response($response);
        $response_data = json_decode($fixedJSON,true);
        if($response_data["type"] == "success"){
            $response_array["type"] = "success";
            $response_array["message"] = "Your subscription has been successfully cancelled!";
            setcookie('publir_subs_log', null, -1, '/');
        }else if($response_data["type"] == "danger"){
            $response_array["message"] = $response_data["message"];
        }else {
            $response_array["message"] = "Something went wrong, please try after some time";
        }
        wp_send_json( json_encode($response_array) );
        wp_die(); 
        // this is required to terminate immediately and return a proper response
    }
}
if( !function_exists('publir_send_reset_password_link') ) {
    function publir_send_reset_password_link($email){
        $url = "https://subs-api.publir.com/publirsubscriptionsapi-dev-hello";
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die(); 
        }
        $email = sanitize_email($email);
        if( !$email ) {
            $return = json_encode(array('message'=>'Email is not valid','status_code'=>201));
            wp_send_json( $return );
            wp_die();
        }
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"     => "request_pwd", 
            "email"             => $email,
            "siteId"            => $site_id,
            "siteName"          => $siteName
        );

        $args = array(
            "method"      => "POST",
            "timeout"     => 45,
            "sslverify"   => false,
            "headers"     => array(
                "Accept" => "application/json",
                "Content-Type"  => "application/json",
            ),
            "body"        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );
        $fixedJSON = publir_fix_json_response($response);
        $response_array = json_decode($fixedJSON,true);
        if($response_array['type'] == 'success'){
            $return = 200;
        }else{
            $return = 201;
        }
        wp_send_json( $return);
        wp_die();
    }
}
add_action( 'wp_ajax_publir_stripe_payment_action', 'publir_stripe_payment_action' );
add_action( 'wp_ajax_nopriv_publir_stripe_payment_action', 'publir_stripe_payment_action' );
if ( ! function_exists( 'publir_stripe_payment_action' ) )  {
    function publir_stripe_payment_action() {
        $url = "https://subs-api.publir.com/publirsubscriptionsapi-dev-hello";
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $siteSubData = publir_get_site_subs_data();
        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            //echo $return;
            wp_send_json(  $return );
            wp_die(); 
        }
        if( empty($_POST['email']) ) {
            $array = array('type'=>'danger','message'=>'Email required');
            wp_send_json(json_encode($array));
            wp_die(); 
        }
        if( empty( $_POST['plan'] ) ) {
            $array = array('type'=>'danger','message'=>'Plan is required');
            wp_send_json( json_encode($array) );
            wp_die(); 
        } else {
            $plan = sanitize_text_field($_POST['plan']);
        }
        $pass= "";
        if( !empty($_POST['password']) ) 
            $pass = sanitize_text_field( $_POST['password'] );
        else if( $plan != "Free" ){
            $array = array('type'=>'danger','message'=>'Password field is empty');
            wp_send_json( json_encode($array) );
            wp_die(); 
        }
        $cpass = "";
        if( !empty($_POST['confirm-password']) ) 
            $cpass = sanitize_text_field($_POST['confirm-password']);
        else if( $plan != "Free" ){
            $array = array('type'=>'danger','message'=>'Confirm Password field is empty');
            wp_send_json( json_encode($array) );
            wp_die(); 
        }
        if($_POST['password'] !== $_POST['confirm-password']  && $plan != "Free"){
            $array = array('type'=>'danger','message'=>'Password Not match');
            wp_send_json( json_encode($array) );
            wp_die(); 
        } 

        foreach ($siteSubData['plans'] as $keys => $values) {
            if ($values["frequency"] == $plan) {
                $plan_value = $values["value"];
            }
        }
     
        $email = sanitize_email($_POST['email']);
        if( !$email ) {
            $return = json_encode(array('message'=>'Email is not valid','status_code'=>201));
            wp_send_json( $return  );
            wp_die();
        }
        $name = sanitize_text_field($_POST['name']);
        $stripeToken = '';
        if( empty($_POST['stripeToken']) && $plan != "Free" ) {
            $array = array('type'=>'danger','message'=>'Stripe token missing', 'status_code'=>201);
            wp_send_json(  json_encode($array)  );
            wp_die(); 
            die();
        } else if( !empty( $_POST['stripeToken'] ) )
            $stripeToken = sanitize_text_field( $_POST['stripeToken'] );

        $stripelast4 = '';
        if( empty($_POST['stripeLast4']) && $plan != "Free" ) {
            $array = array('type'=>'danger','message'=>'Stripe last 4 digit missing', 'status_code'=>201);
            wp_send_json( json_encode($array) );
            wp_die(); 
        } else if( !empty( $_POST['stripeLast4'] ) )
            $stripelast4 = sanitize_text_field( $_POST['stripeLast4'] );

        $stripebrand = '';
        if( empty($_POST['stripeBrand']) && $plan != "Free" ) {
            $array = array('type'=>'danger','message'=>'Stripe brand missing', 'status_code'=>201);
            wp_send_json(  json_encode($array) );
            wp_die(); 
        } else if( !empty( $_POST['stripeBrand'] ) )
            $stripebrand = sanitize_text_field($_POST['stripeBrand']);
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"     => "register",
            "email"             => $email,
            "up"                => $pass, 
            "siteId"            => $site_id,
            "siteName"          => $siteName,
            "fullName"          => $name,
            "plan"              => $plan,
            "siteMode"          => $siteSubData['siteMode'],
            "value"             => $plan_value,
            "stripeCurrency"    => $siteSubData['currency'],
            "stripeToken"       => $stripeToken,
            "stripelast4"       => $stripelast4,
            "stripebrand"       => $stripebrand,
            "paymentType"       => 'stripe',
            "customerId"        => '',
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => 45,
            'sslverify'   => false,
            'headers'     => array(
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ),
            'body'        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );
        $fixedJSON = publir_fix_json_response($response);
        wp_send_json( $fixedJSON );
        wp_die();
    }
}
//Update card ajax
add_action( 'wp_ajax_publir_stripe_update_card_action', 'publir_stripe_update_card_action' );
add_action( 'wp_ajax_nopriv_publir_stripe_update_card_action', 'publir_stripe_update_card_action' );
if ( ! function_exists( 'publir_stripe_update_card_action' ) )  {
    function publir_stripe_update_card_action() {
        $url = "https://subs-api.publir.com/publirsubscriptionsapi-dev-hello";
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $publir_secret_key = sanitize_text_field($options['publir_secret_key']);
        $publir_subs_programming = isset($options['publir_subs_programming']) && !empty($options['publir_subs_programming']) ? sanitize_text_field($options['publir_subs_programming']) : 'Ad-Free';
        $siteSubData = publir_get_site_subs_data();
        $subsData = array();
        if (isset($_COOKIE['publir_subs_log'])) {
            $subsData = getCookieData();
            if(!empty($subsData)){
                $email_val = custom_decrypt($subsData['ehash'], $publir_secret_key);
            }
        }
        if(empty($subsData) || empty($email_val)){
            $return = json_encode(array('message'=>'Your session has expired. Please log in to continue where you left off.','status_code'=>401));
            wp_send_json(  $return );
            wp_die(); 
        }
        $uc_confirm_password = '';
        if( empty($_POST['uc_confirm_password']) ) {
            $return = json_encode(array('message'=>'Confirm Password field is empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        }else $uc_confirm_password = sanitize_text_field($_POST['uc_confirm_password']);

        if( empty($site_id) ) {
            $return = json_encode(array('message'=>'Site id is empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die(); 
        }
        $email = '';
        if( empty($email_val) ) {
            $return = json_encode(array('message'=>'Email field can\'t empty','status_code'=>201));
            wp_send_json(  $return  );
            wp_die();
        }
        else $email = sanitize_email($email_val);
        if( !$email ) {
            $return = json_encode(array('message'=>'Email is not valid','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        }

        $fullName = '';
        if( empty($subsData['name']) ) {
            $return = json_encode(array('message'=>'Full name is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die();
        }
        else $fullName = sanitize_text_field($subsData['name']);

        $customer = "";
        if( empty($subsData['sCustomerId']) ) {
            $return = json_encode(array('message'=>'Stripe customer is empty','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        }
        else 
            $customer = sanitize_text_field($subsData['sCustomerId']);
        $stripeToken = '';
        if( empty($_POST['stripeToken']) ) {
            $return = json_encode(array('message'=>'Stripe token is missing','status_code'=>201));
            wp_send_json(  $return );
            wp_die();
        } else $stripeToken = sanitize_text_field($_POST['stripeToken']);

        $stripelast4 = '';
        if( empty($_POST['stripeLast4']) ) {
            $return = json_encode(array('message'=>'Stripe last 4 digit is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die();
        } else $stripelast4 = sanitize_text_field($_POST['stripeLast4']);

        $stripeBrand = '';
        if( empty($_POST['stripeBrand']) ) {
            $return = json_encode(array('message'=>'Stripe brand is empty','status_code'=>201));
            wp_send_json( $return );
            wp_die();
        } else 
        $stripeBrand = sanitize_text_field($_POST['stripeBrand']);
        $siteName = get_bloginfo( 'name');
        $body = array(
            "publir_method"     => "sub_update_card",
            "email"             => $email,
            "siteId"            => $site_id,
            "siteName"          => $siteName,
            "fullName"          => $fullName,
            "siteMode"          => $siteSubData['siteMode'],
            "stripeCurrency"    => $siteSubData['currency'],
            "stripeToken"       => $stripeToken,
            "stripelast4"       => $stripelast4,
            "stripebrand"       => $stripeBrand,
            'stripeCustomer'    => $customer,
            "password"          => $uc_confirm_password,
            "subs_programming"  => $publir_subs_programming,
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => 45,
            'sslverify'   => false,
            'headers'     => array(
                'Accept' => 'application/json',
                'Content-Type'  => 'application/json',
            ),
            'body'        => json_encode($body),
        );

        $request = wp_remote_post( $url, $args );

        $response = wp_remote_retrieve_body( $request );
        $fixedJSON = publir_fix_json_response($response);
        $response_array = json_decode($fixedJSON,true);
        if($response_array["type"] == "success"){
            setcookie('publir_subs_log', null, -1, '/'); 
        }
        wp_send_json(  $fixedJSON  );
        wp_die();
    }
}
if ( ! function_exists( 'publir_fix_json_response' ) )  {
    function publir_fix_json_response($json) {
        $json = json_decode($json);
        $regex = <<<'REGEX'
~
"[^"\\]*(?:\\.|[^"\\]*)*"
(*SKIP)(*F)
| '([^'\\]*(?:\\.|[^'\\]*)*)'
~x
REGEX;
        return preg_replace_callback($regex, function($matches) {
            return '"' . preg_replace('~\\\\.(*SKIP)(*F)|"~', '\\"', $matches[1]) . '"';
        }, $json);
    }
}
add_action( 'wp_ajax_publir_logout_publir', 'publir_logout_publir' );
add_action( 'wp_ajax_nopriv_publir_logout_publir', 'publir_logout_publir' );

if ( ! function_exists( 'publir_logout_publir' ) )  {
    /**
    * Sets up theme defaults and registers support for various WordPress features
    *
    *  It is important to set up these functions before the init hook so that none of these
    *  features are lost.
    */
    function publir_logout_publir(){
        $cookie_name = "publir_subscriber";
            $cookie_value = "";
            $days_to_expiry = 1;
            $root_domain = site_url();
            setcookie($cookie_name, $cookie_value, time()-3600, "/", false,false,false); 
        if(isset($_COOKIE['publir_subscriber']) ) {
            unset($_COOKIE['publir_subscriber']); 
            setcookie('publir_subscriber', null, -1, '/'); 
        }
        setcookie('publir_subs_log', null, -1, '/'); 
        wp_send_json( "Logout From Publir Settings" );
        wp_die();
    }
}

add_action('wp_ajax_nopriv_publir_adblock_pAnalytics_callback_action', 'publir_adblock_pAnalytics_callback_action');
add_action('wp_ajax_publir_adblock_pAnalytics_callback_action', 'publir_adblock_pAnalytics_callback_action' );
if ( ! function_exists( 'publir_adblock_pAnalytics_callback_action' ) )  {
    function publir_adblock_pAnalytics_callback_action() { 
        $post = file_get_contents('php://input');
        $obj = json_decode($post);
        if ( isset( $obj->p_currentPage ) && isset( $obj->p_siteId ) ) {
            $p_currentPage = $obj->p_currentPage;
            $p_siteId = $obj->p_siteId;

            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = sanitize_text_field($_SERVER["HTTP_CF_CONNECTING_IP"]);
            }

            $wp_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
            $wp_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
            $pjson = $p_currentPage . " " .  $p_siteId . " " . $wp_ip ;

            $url = "https://l026e7vji8.execute-api.us-east-1.amazonaws.com/default/pAnalytics";
            $body = array( "p_currentPage"=> $p_currentPage,"p_siteId"=> $p_siteId,"p_ipAddress"=> $wp_ip,"p_userAgent"=> $wp_agent );

            $args = array(
                'method'      => 'POST',
                'timeout'     => 45,
                'sslverify'   => false,
                'headers'     => array(
                    'Accept' => 'application/json',
                    'Content-Type'  => 'application/json',
                ),
                'body'        => json_encode($body),
            );

            $request = wp_remote_post( $url, $args );
            $response = wp_remote_retrieve_body( $request );
            # Print response.
            wp_send_json( $response );
            wp_die();
        }
    }
}

if ( ! function_exists( 'publir_get_site_subs_data' ) )  {
    function publir_get_site_subs_data()
    {
        $options = get_option('publir_wp_options');
        $site_id = sanitize_text_field($options['publir_site_id']);
        $fileUrl = "https://a.publir.com/subscriptions/" . $site_id . ".json";
        $responseData = wp_remote_get($fileUrl);
        $response = wp_remote_retrieve_body( $responseData );
        $siteSubData = json_decode($response, true);
        return $siteSubData;
    }
}

if ( ! function_exists( 'custom_encrypt' ) )  {
    function custom_encrypt($data, $key) {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
}

if ( ! function_exists( 'custom_decrypt' ) )  {
    function custom_decrypt($encryptedValue, $key) {
        $cipher = "aes-256-cbc";
        $encryptedValue = base64_decode($encryptedValue);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($encryptedValue, -$ivlen);
        $encrypted = substr($encryptedValue, 0, -$ivlen);
        return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
    }
}

if ( ! function_exists( 'getCookieData' ) )  {
    function getCookieData(){
        $siteSubData = array();
        $decoded_cookie_value = stripslashes($_COOKIE['publir_subs_log']);
        $siteSubData = json_decode($decoded_cookie_value, true);
        return $siteSubData;
    }
}