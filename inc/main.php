<?php
/**
 * 
 * Main Detector
 * 
 * */
function enstrdwpe_is_staging_dev(){
	$wpe_environment = getenv();
	$wpe_environment_account = $wpe_environment['WPENGINE_ACCOUNT'];
	$wpengine_staging_options = get_option( 'wpengine_staging_option_name' );
	$staging_development_environment_name_0 = $wpengine_staging_options['staging_development_environment_name_0'];
	if(!empty($staging_development_environment_name_0)){
		if($wpe_environment_account == $staging_development_environment_name_0){
			return true;
		}
	}
	return false;
}
function enstrdwpe_detector_main(){
	if (function_exists('is_wpe')) {
	    $settings = get_option("woocommerce_stripe_settings");
	    if(enstrdwpe_is_staging_dev()){
		    if($settings["testmode"] != "yes"){
		    	$settings["testmode"] = "yes";
		    	update_option("woocommerce_stripe_settings", $settings ); 
				delete_transient( 'wcstripe_account_data_live' );
				delete_transient( 'wcstripe_account_data_test' );
			}
		}
	}
}
add_action('init','enstrdwpe_detector_main');

function enstrdwpe_admin_notice__error() {
	if(enstrdwpe_is_staging_dev()){
		$class = 'notice notice-info';
		$message = __( 'Stripe test mode is enabled automatically as the WPEngine development/staging environment is detected.', 'enstrdwpe' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
	if (!function_exists('is_wpe')) {
		$class = 'notice notice-error';
		$message = __( 'Yikes! This is not a WPEngine enviorment.', 'enstrdwpe' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
}
add_action( 'admin_notices', 'enstrdwpe_admin_notice__error' );
