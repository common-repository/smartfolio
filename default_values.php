<?php 
/**
 * 
 * CashPress
 * Creates the default theme settings upon installation
 *
**/


if (get_option('csp_defaults_installed') != 'yes') {

if(!defined('BLOG_URL')) {
define( 'BLOG_URL', get_bloginfo('url'));
}

add_action('after_setup_theme', 'csp_default_values' );

function csp_default_values(){

	$csp_set_new = get_option('csp_settings');
	$csp_comp_new = get_option('csp_company');
	

	$csp_set_new['usepaypal'] = 'yes';
	$csp_set_new['invoiceterms'] = 'Please pay within 5 business days of invoice receipt. Payment is requested through Cash, Check, or Paypal.';
	$csp_set_new['useapprove'] = 'yes';
	$csp_set_new['allowcomments'] = 'yes';
	$csp_set_new['proposalterms'] = 'Thank you for giving us the opportunity to present this proposal. The terms and conditions are as follows:';
	$csp_set_new['desctype'] = 'lightbox';
	$csp_set_new['displaytype'] = 'grid';
	$csp_set_new['captcha'] = 'nothing';
	$csp_set_new['botquestion'] = 'Are you a real person or a spammer?';
	$csp_set_new['botanswer'] = 'real person';
	$csp_set_new['proposal_password'] = 'yes';
	$csp_set_new['invoice_password'] = 'yes';
	
	
	$csp_comp_new['businessname'] = 'CashPress';
	$csp_comp_new['logofile'] = WP_PLUGIN_URL . '/images/logo.png';
	$csp_comp_new['paypalemail'] = '';
	$csp_comp_new['contactemail'] = '';
	$csp_comp_new['phone'] = '(555) 555-5555';
	$csp_comp_new['address1'] = '14 Sample St';
	$csp_comp_new['address2'] = 'Palo Alto, CA 94301';
	$csp_comp_new['address3'] = 'USA';
	$csp_comp_new['social1'] = 'Facebook';
	$csp_comp_new['social2'] = 'Twitter';
	$csp_comp_new['social3'] = 'LinkedIn';
	$csp_comp_new['socialurl1'] = 'http://www.facebook.com';
	$csp_comp_new['socialurl2'] = 'http://www.twitter.com';
	$csp_comp_new['socialurl3'] = 'http://www.linkedin.com';
	
	
		
	//Update & save everything
	update_option('permalink_structure', '/%postname%');
	update_option('csp_settings', $csp_set_new);
	update_option('csp_company', $csp_comp_new);
	add_option('csp_defaults_installed', 'yes');

} // End function

} // End conditional statement
			
?>
