<?php
/**
* 
* CashPress
* Proposal Template
* 
* Last Update: Version 1.2
* 
**/

$case = 0;
if (isset($_GET['logout']) != 'true'){

	// Universalize incoming login data
	if (isset($_POST['clientnamep'] ) != "" && @$_COOKIE['csp_client'] == ""){ $clientname = @$_POST['clientnamep']; }
	if (isset($_POST['clientnamep'] ) == "" && @$_COOKIE['csp_client'] != ""){ $clientname = @$_COOKIE['csp_client']; }
	if (isset($_POST['clientnamep'] ) != "" && @$_COOKIE['csp_client'] != ""){ $clientname = @$_POST['csp_client']; }
	if (isset($_POST['clientpassp'] ) != "" && @$_COOKIE['csp_pass'] == ""){ $clientpass = @$_POST['clientpassp']; }
	if (isset($_POST['clientpassp'] ) == "" && @$_COOKIE['csp_pass'] != ""){ $clientpass = @$_COOKIE['csp_pass']; }
	if (isset($_POST['clientpassp'] ) != "" && @$_COOKIE['csp_pass'] != ""){ $clientpass = @$_POST['csp_pass']; }
	
	// Retreive client-specific data
	$client_post_a = get_post_by_title(@$clientname);
	$client_custom_a = get_post_custom(@$client_post_a->ID);
	$password = @$client_custom_a['password'][0];
	
	// Test data for validity, etc...
	$case = 0;
	
	if (isset($client_post_a) && $clientpass == $password){
	setcookie('csp_client', $clientname, 0, '/');
	setcookie('csp_pass', $clientpass, 0, '/');
	$case = 1;
	}
	if (isset($clientname) == "" && @$clientpass == ""){$case = 0;}
	if (isset($clientname) != "" && @$clientpass == ""){
	$error_message_a = _e("Please enter both a name and a password to continue",'cashpress');
	$case = 0;
	}
	if (isset($clientname) == "" && @$clientpass != ""){
	$error_message_a = _e("Please enter both a name and a password to continue",'cashpress');
	$case = 0;
	}
	if (isset($clientname) != "" && @$clientpass != "" && $clientpass != $password){
	$error_message_a = _e("Your name was not found or your password is not valid. Please try again:",'cashpress');
	$case = 0;
	}
} else{
$case = 3;
}

?>

<?php get_header(); ?>


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php 

// Retrieve a MASSIVE list of custom field data
	$proposaltitle = $post->post_title;
	$custom = get_post_custom($post->ID);  
	$pro_number = @$custom["pro_number"][0]; 
    if ($pro_number == ""){$pro_number = $post->ID;}
    $proposalstatus = @$custom["proposalstatus"][0];
    $completiondate = @$custom["completiondate"][0]; 
    $proposalterms = @$custom["proposalterms"][0]; 
    $client = @$custom["client"][0]; 
    $clientname = get_posts('post_type=clients');
    $proposalnotes = @$custom["proposalnotes"][0]; 
    $csp_material_item = @$custom["csp_material_item"][0]; 
    $csp_material_cost = @$custom["csp_material_cost"][0];
    $csp_material_qty = @$custom["csp_material_qty"][0];
    $csp_material_item2 = @$custom["csp_material_item2"][0]; 
    $csp_material_cost2 = @$custom["csp_material_cost2"][0]; 
    $csp_material_qty2 = @$custom["csp_material_qty2"][0];
    $csp_material_item3 = @$custom["csp_material_item3"][0]; 
    $csp_material_cost3 = @$custom["csp_material_cost3"][0]; 
    $csp_material_qty3 = @$custom["csp_material_qty3"][0];
    $csp_material_item4 = @$custom["csp_material_item4"][0]; 
    $csp_material_cost4 = @$custom["csp_material_cost4"][0]; 
    $csp_material_qty4 = @$custom["csp_material_qty4"][0];
    $csp_material_item5 = @$custom["csp_material_item5"][0]; 
    $csp_material_cost5 = @$custom["csp_material_cost5"][0]; 
    $csp_material_qty5 = @$custom["csp_material_qty5"][0];
    $csp_material_item6 = @$custom["csp_material_item6"][0]; 
    $csp_material_cost6 = @$custom["csp_material_cost6"][0]; 
    $csp_material_qty6 = @$custom["csp_material_qty6"][0];
    $csp_material_item7 = @$custom["csp_material_item7"][0]; 
    $csp_material_cost7 = @$custom["csp_material_cost7"][0];
    $csp_material_qty7 = @$custom["csp_material_qty7"][0];
    $csp_material_item8 = @$custom["csp_material_item8"][0]; 
    $csp_material_cost8 = @$custom["csp_material_cost8"][0];
    $csp_material_qty8 = @$custom["csp_material_qty8"][0];
    $csp_material_item9 = @$custom["csp_material_item9"][0]; 
    $csp_material_cost9 = @$custom["csp_material_cost9"][0]; 
    $csp_material_qty9 = @$custom["csp_material_qty9"][0];
    $csp_material_item10 = @$custom["csp_material_item10"][0]; 
    $csp_material_cost10 = @$custom["csp_material_cost10"][0]; 
    $csp_material_qty10 = @$custom["csp_material_qty10"][0];
    $csp_material_item11 = @$custom["csp_material_item11"][0]; 
    $csp_material_cost11 = @$custom["csp_material_cost11"][0]; 
    $csp_material_qty11 = @$custom["csp_material_qty11"][0];
    $csp_material_item12 = @$custom["csp_material_item12"][0]; 
    $csp_material_cost12 = @$custom["csp_material_cost12"][0]; 
    $csp_material_qty12 = @$custom["csp_material_qty12"][0];
    $csp_material_item13 = @$custom["csp_material_item13"][0]; 
    $csp_material_cost13 = @$custom["csp_material_cost13"][0]; 
    $csp_material_qty13 = @$custom["csp_material_qty13"][0];
    $csp_material_item14 = @$custom["csp_material_item14"][0]; 
    $csp_material_cost14 = @$custom["csp_material_cost14"][0];
    $csp_material_qty14 = @$custom["csp_material_qty14"][0];
    $csp_material_item15 = @$custom["csp_material_item15"][0]; 
    $csp_material_cost15 = @$custom["csp_material_cost15"][0];
    $csp_material_qty15 = @$custom["csp_material_qty15"][0];
    $csp_material_item16 = @$custom["csp_material_item16"][0]; 
    $csp_material_cost16 = @$custom["csp_material_cost16"][0];
    $csp_material_qty16 = @$custom["csp_material_qty16"][0];
    $csp_material_item17 = @$custom["csp_material_item17"][0]; 
    $csp_material_cost17 = @$custom["csp_material_cost17"][0];
    $csp_material_qty17 = @$custom["csp_material_qty17"][0];
    $csp_material_item18 = @$custom["csp_material_item18"][0]; 
    $csp_material_cost18 = @$custom["csp_material_cost18"][0];
    $csp_material_qty18 = @$custom["csp_material_qty18"][0];
    $csp_material_item19 = @$custom["csp_material_item19"][0]; 
    $csp_material_cost19 = @$custom["csp_material_cost19"][0];
    $csp_material_qty19 = @$custom["csp_material_qty19"][0];
    $csp_material_item20 = @$custom["csp_material_item20"][0]; 
    $csp_material_cost20 = @$custom["csp_material_cost20"][0];
    $csp_material_qty20 = @$custom["csp_material_qty20"][0];
    $csp_labor_item = @$custom["csp_labor_item"][0]; 
    $csp_labor_cost = @$custom["csp_labor_cost"][0];
    $csp_labor_qty = @$custom["csp_labor_qty"][0];
    $csp_labor_item2 = @$custom["csp_labor_item2"][0]; 
    $csp_labor_cost2 = @$custom["csp_labor_cost2"][0]; 
    $csp_labor_qty2 = @$custom["csp_labor_qty2"][0];
    $csp_labor_item3 = @$custom["csp_labor_item3"][0]; 
    $csp_labor_cost3 = @$custom["csp_labor_cost3"][0]; 
    $csp_labor_qty3 = @$custom["csp_labor_qty3"][0];
    $csp_labor_item4 = @$custom["csp_labor_item4"][0]; 
    $csp_labor_cost4 = @$custom["csp_labor_cost4"][0]; 
    $csp_labor_qty4 = @$custom["csp_labor_qty4"][0];
    $csp_labor_item5 = @$custom["csp_labor_item5"][0]; 
    $csp_labor_cost5 = @$custom["csp_labor_cost5"][0]; 
    $csp_labor_qty5 = @$custom["csp_labor_qty5"][0];
    $csp_labor_item6 = @$custom["csp_labor_item6"][0]; 
    $csp_labor_cost6 = @$custom["csp_labor_cost6"][0]; 
    $csp_labor_qty6 = @$custom["csp_labor_qty6"][0];
    $csp_labor_item7 = @$custom["csp_labor_item7"][0]; 
    $csp_labor_cost7 = @$custom["csp_labor_cost7"][0];
    $csp_labor_qty7 = @$custom["csp_labor_qty7"][0];
    $csp_labor_item8 = @$custom["csp_labor_item8"][0]; 
    $csp_labor_cost8 = @$custom["csp_labor_cost8"][0];
    $csp_labor_qty8 = @$custom["csp_labor_qty8"][0];
    $csp_labor_item9 = @$custom["csp_labor_item9"][0]; 
    $csp_labor_cost9 = @$custom["csp_labor_cost9"][0]; 
    $csp_labor_qty9 = @$custom["csp_labor_qty9"][0];
    $csp_labor_item10 = @$custom["csp_labor_item10"][0]; 
    $csp_labor_cost10 = @$custom["csp_labor_cost10"][0]; 
    $csp_labor_qty10 = @$custom["csp_labor_qty10"][0];
    $csp_labor_item11 = @$custom["csp_labor_item11"][0]; 
    $csp_labor_cost11 = @$custom["csp_labor_cost11"][0]; 
    $csp_labor_qty11 = @$custom["csp_labor_qty11"][0];
    $csp_labor_item12 = @$custom["csp_labor_item12"][0]; 
    $csp_labor_cost12 = @$custom["csp_labor_cost12"][0]; 
    $csp_labor_qty12 = @$custom["csp_labor_qty12"][0];
    $csp_labor_item13 = @$custom["csp_labor_item13"][0]; 
    $csp_labor_cost13 = @$custom["csp_labor_cost13"][0]; 
    $csp_labor_qty13 = @$custom["csp_labor_qty13"][0];
    $csp_labor_item14 = @$custom["csp_labor_item14"][0]; 
    $csp_labor_cost14 = @$custom["csp_labor_cost14"][0];
    $csp_labor_qty14 = @$custom["csp_labor_qty14"][0];
    $csp_labor_item15 = @$custom["csp_labor_item15"][0]; 
    $csp_labor_cost15 = @$custom["csp_labor_cost15"][0];
    $csp_labor_qty15 = @$custom["csp_labor_qty15"][0];
    $csp_labor_item16 = @$custom["csp_labor_item16"][0]; 
    $csp_labor_cost16 = @$custom["csp_labor_cost16"][0];
    $csp_labor_qty16 = @$custom["csp_labor_qty16"][0];
    $csp_labor_item17 = @$custom["csp_labor_item17"][0]; 
    $csp_labor_cost17 = @$custom["csp_labor_cost17"][0];
    $csp_labor_qty17 = @$custom["csp_labor_qty17"][0];
    $csp_labor_item18 = @$custom["csp_labor_item18"][0]; 
    $csp_labor_cost18 = @$custom["csp_labor_cost18"][0];
    $csp_labor_qty18 = @$custom["csp_labor_qty18"][0];
    $csp_labor_item19 = @$custom["csp_labor_item19"][0]; 
    $csp_labor_cost19 = @$custom["csp_labor_cost19"][0];
    $csp_labor_qty19 = @$custom["csp_labor_qty19"][0];
    $csp_labor_item20 = @$custom["csp_labor_item20"][0]; 
    $csp_labor_cost20 = @$custom["csp_labor_cost20"][0];
    $csp_labor_qty20 = @$custom["csp_labor_qty20"][0];
    $csp_taxrate = @$custom["csp_taxrate"][0];
    $csp_total_adjustment = @$custom["csp_total_adjustment"][0];
    $client = @$custom["client"][0];  
    
// Get CashPress admin settings
    $homepage_options = get_option('csp_homepage');
    $csp_settings = get_option('csp_settings');
    $company_options = get_option('csp_company');
    
// Get client information
    $client_post = get_post_by_title($client);
    $client_title = @$client_post->post_title;
    $client_custom = get_post_custom(@$client_post->ID);  
    $address1 = @$client_custom["address1"][0];
    $address2 = @$client_custom["address2"][0];
    $address3 = @$client_custom["address3"][0];
    $phone = @$client_custom["phone"][0];
    $client_custom_pass = @$client_custom['password']['0'];
    
// Two more quick authenticity checks
if (isset($_GET['logout'] ) != 'true'){
	if (isset($case) == 1 && @$client_post_a->ID != @$client_post->ID){
	$error_message_a = _e("This page seems to belong to a different client. Please make sure you are accessing the correct content.",'cashpress');
	$case = 0;
	}
	if ($csp_settings['proposal_password'] == 'no'){$case = 1;}
}

 // Calculate proposal totals
    $labortotal[1] = ($csp_labor_cost*$csp_labor_qty);
    $labortotal[2] = ($csp_labor_cost2*$csp_labor_qty2);
    $labortotal[3] = ($csp_labor_cost3*$csp_labor_qty3);
    $labortotal[4] = ($csp_labor_cost4*$csp_labor_qty4);
    $labortotal[5] = ($csp_labor_cost5*$csp_labor_qty5);
    $labortotal[6] = ($csp_labor_cost6*$csp_labor_qty6);
    $labortotal[7] = ($csp_labor_cost7*$csp_labor_qty7);
    $labortotal[8] = ($csp_labor_cost8*$csp_labor_qty8);
    $labortotal[9] = ($csp_labor_cost9*$csp_labor_qty9);
    $labortotal[10] = ($csp_labor_cost10*$csp_labor_qty10);
    $labortotal[11] = ($csp_labor_cost11*$csp_labor_qty11);
    $labortotal[12] = ($csp_labor_cost12*$csp_labor_qty12);
    $labortotal[13] = ($csp_labor_cost13*$csp_labor_qty13);
    $labortotal[14] = ($csp_labor_cost14*$csp_labor_qty14);
    $labortotal[15] = ($csp_labor_cost15*$csp_labor_qty15);   
    $labortotal[16] = ($csp_labor_cost16*$csp_labor_qty16);
    $labortotal[17] = ($csp_labor_cost17*$csp_labor_qty17);
    $labortotal[18] = ($csp_labor_cost18*$csp_labor_qty18);
    $labortotal[19] = ($csp_labor_cost19*$csp_labor_qty19);
    $labortotal[20] = ($csp_labor_cost20*$csp_labor_qty20);
    $materialtotal[1] = ($csp_material_cost*$csp_material_qty);
    $materialtotal[2] = ($csp_material_cost2*$csp_material_qty2);
    $materialtotal[3] = ($csp_material_cost3*$csp_material_qty3);
    $materialtotal[4] = ($csp_material_cost4*$csp_material_qty4);
    $materialtotal[5] = ($csp_material_cost5*$csp_material_qty5);
    $materialtotal[6] = ($csp_material_cost6*$csp_material_qty6);
    $materialtotal[7] = ($csp_material_cost7*$csp_material_qty7);
    $materialtotal[8] = ($csp_material_cost8*$csp_material_qty8);
    $materialtotal[9] = ($csp_material_cost9*$csp_material_qty9);
    $materialtotal[10] = ($csp_material_cost10*$csp_material_qty10);
    $materialtotal[11] = ($csp_material_cost11*$csp_material_qty11);
    $materialtotal[12] = ($csp_material_cost12*$csp_material_qty12);
    $materialtotal[13] = ($csp_material_cost13*$csp_material_qty13);
    $materialtotal[14] = ($csp_material_cost14*$csp_material_qty14);
    $materialtotal[15] = ($csp_material_cost15*$csp_material_qty15);
    $materialtotal[16] = ($csp_material_cost16*$csp_material_qty16);
    $materialtotal[17] = ($csp_material_cost17*$csp_material_qty17);
    $materialtotal[18] = ($csp_material_cost18*$csp_material_qty18);
    $materialtotal[19] = ($csp_material_cost19*$csp_material_qty19);
    $materialtotal[20] = ($csp_material_cost20*$csp_material_qty20);
    $materialsubtotal = array_sum($materialtotal);
    $laborsubtotal = array_sum($labortotal);    
    $csp_totaltax = ($materialsubtotal*$csp_taxrate);
    $grandtotal = (round($materialsubtotal + $laborsubtotal + $csp_totaltax + $csp_total_adjustment, 2));

    
// Currency Changer
if ($csp_settings['currencysymbol'] == ""){$csp_settings['currencysymbol'] = '$';}
if(!defined('csp_CURRENCY')) {
define( 'csp_CURRENCY', $csp_settings['currencysymbol']);
}

// Set default email message if no post data yet
if (empty($_POST['form_type'])) {
if ($csp_settings['invoice_password'] == 'yes'){ $csp_login_info = "\n" . __("Username: ",'cashpress') . "$client" . "\n" . __("Password: ",'cashpress') . "$client_custom_pass";}
if (is_email(@$client_custom['email'][0])){$_POST['visitor_email'] = $client_custom['email'][0];}
$_POST['mail_subject'] = __("New proposal from ",'cashpress') . $company_options['businessname'];
if ($csp_settings['proposal_password'] == 'yes') {$_POST['invoice_message'] = __("A new proposal has been prepared for you by ",'cashpress') . $company_options['businessname'] .
  						  __(". You can access your proposal with the following information:",'cashpress') . "\n\n" . get_permalink($post->ID) .
						  $csp_login_info . "\n\n" . __("Best Regards,",'cashpress') . "\n" . $company_options['businessname'];}
if ($csp_settings['proposal_password'] == 'no') {$_POST['invoice_message'] = __("A new proposal has been prepared for you by ",'cashpress') . $company_options['businessname'] .
  						  __(". You can access your proposal with the following information:",'cashpress') . "\n\n" . get_permalink($post->ID) .
						   "\n\n" . __("Best Regards,",'cashpress') . "\n" . $company_options['businessname'];}
}
    
?> 

<?php

//Add Additional Stylesheet to Plugin Generated Pages and Posts
$csp_pluginsurl = plugins_url();
?>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $csp_pluginsurl ?>/cashpress/themefiles/additional_style.css" />
<link rel="stylesheet" type="text/css" media="print" href="<?php echo $csp_pluginsurl ?>/cashpress/themefiles/print.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $csp_pluginsurl ?>/cashpress/js/prettyPhoto.css" />
<script type="text/javascript" src="<?php echo $csp_pluginsurl ?>/cashpress/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="<?php echo $csp_pluginsurl ?>/cashpress/js/jcarousellite_1.0.1.min.js"></script>
		<script type="text/javascript" src="<?php echo $csp_pluginsurl ?>/cashpress/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="<?php echo $csp_pluginsurl ?>/cashpress/js/jquery.prettyPhoto.js"></script>
		
<script type="text/javascript">
$(document).ready(function(){
	$("a[rel^='prettyPhoto']").prettyPhoto({theme:'facebook'});
		$('#contact_success').trigger('click');
		});
</script>



<div id="banner" class="gallery">
		<div class="banner_inside">
			<h1><?php _e("Currently viewing proposal",'cashpress'); ?> <strong>#<?php echo $pro_number; ?></h1>
			<?php if ($case == 1) : // Successful login ?> 
<?php if ($clientname != "" && @$_GET['logout'] != 'true') :?><a class="btn_approve" href="<?php echo bloginfo('url') . '/myaccount.html?logout=true' ; ?>"><?php _e("Logout",'cashpress'); ?></a></li><?php endif; ?>  
				<?php  if (@$csp_settings[useapprove] == 'yes') : ?>
					<?php if ($proposalstatus == 'Approved') : ?>
			<p class="btn_approve"><?php _e("Status: Approved",'cashpress'); ?></p>
					<?php elseif ($proposalstatus == 'Closed') : ?>
			<p class="btn_approve"><?php _e("Status: Closed",'cashpress'); ?></p>
					<?php else : ?>
			<a href="#galleryitem2" class="btn_approve" rel="prettyPhoto"><?php _e("Approve Proposal",'cashpress'); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
</div> <!--end of index_banner-->
		
		
		
		<div id="content">
		<div class="content_inside">		
			<div class="content_shadow">
			
			<?php if ($case == 0) : // Nothing entered or incorrect user/pass ?>  
				<div class="contact_form" id="password">
					<span style="color:red;" ><?php echo @$error_message_a ; ?></span><br/>
					<h3><?php _e("Enter Your Login Information",'cashpress'); ?></h3>
					<p><?php _e("Please enter your name (or company name) and the corresponding password to view this proposal:",'cashpress'); ?></p><br/>
					<form action="" name="client_area" method="POST">
					<fieldset>
					<label><?php _e("Name:",'cashpress'); ?></label>
					<input name="clientnamep" class="input_txt" type="text" value ="<?php echo @$_POST['clientnamep']; ?>"/>
					<label><?php _e("Password:",'cashpress'); ?></label>
					<input name="clientpassp" class="input_txt" type="password" value=""/>
					<input type="submit" name="submit" class="input_send" value="<?php _e("Login",'cashpress'); ?>" />
					</fieldset>
					</form>	
								</div>	
			<?php endif; ?>
			
			<?php if ($case == 1) : // Successful login ?>
				<div class="proposal_info">
					<div class="pro_logo"><img src="<?php bloginfo( 'template_url' ); ?>/images/resize/timthumb.php?src=<?php  echo $company_options[logofile]; ?>&amp;w=200px" alt="" /></div>
					<div class="pro_txt">
						<p><strong><?php  echo @$company_options[businessname]; ?></strong></p>
						<p><?php  echo @$company_options[address1]; ?></p>
						<p><?php  echo @$company_options[address2]; ?></p>
						<p><?php  echo @$company_options[address3]; ?></p>
					</div>
					<div class="pro_btns">
<?php if (function_exists("wpptopdf_display_icon")) echo '<a class="wpptopdf" title="Download PDF" href="?format=pdf" rel="noindex,nofollow" target="_blank" class="wpptopdf">Print to PDF</a>' ?>

				<a href="#galleryitem1" rel="prettyPhoto" class="btn_email" title=""><?php _e("Email Proposal",'cashpress'); ?></a>
						<a href="" onclick="window.print();return false;" class="btn_print"><?php _e("Print this page",'cashpress'); ?></a>
					</div>
				</div> <!--end of proposal_info-->
				
				<div class="gap_line">gap line</div>
				
				<div class="proposal_cont">
				
				<div class="pro_cont"><?php echo csp_content_filter($post->post_content) ; ?></div>
				
				<?php if ($completiondate != ""): ?>
				<div class="complite_date">
						<h2><?php _e("Completion Date",'cashpress'); ?></h2>
						<div class="proposal_sum">
							<h3><?php _e("All work to be completed by",'cashpress'); ?></h3>
							<p><?php echo $completiondate ?></p>
						</div>
						<div class="complite_date_bottom">bottom</div>
				</div> <!--end of complite_date-->
				<?php endif; ?>
					
					<div class="small_terms_box">
						<h3><?php _e("Terms &amp; Conditions of Project Proposal",'cashpress'); ?></h3>
						<p><?php if ($proposalterms != ""){echo $proposalterms;} else {echo $csp_settings['proposalterms'] ;}	?></p>
					</div>
					
				</div>
				
				<div class="gap_line">gap line</div>
				
				<div class="proposal_total">
					<div class="proposal_to">
						<p><strong><?php _e("To:",'cashpress'); ?></strong></p>
						<p class="p1"><?php echo $client_title ?></p>
						<p><?php echo $address1 ?></p>
						<p><?php echo $address2 ?></p>
						<p><?php echo $address3 ?></p>
					</div>
					<div class="proposal_count">
						<p><strong><?php _e("Proposal",'cashpress'); ?></strong> #<?php echo $pro_number; ?></p>
						<p class="p2"><?php echo $completiondate ?></p>
						<p><strong><?php _e("Proposal Total:",'cashpress'); ?></strong></p>
						<p class="p3"><?php echo csp_CURRENCY . $grandtotal ?></p>
					</div>
				</div> <!--end of proposal_total-->
								
				
				<div class="gap_line">gap line</div>
				
								
				<div class="proposal_table">
					<table>
					  <tr>
						<th id="itmdesc"><?php _e("Item Description",'cashpress'); ?></th>
						<th id="qty"><?php _e("Qty",'cashpress'); ?></th>
						<th id="uprice"><?php _e("Unit Price",'cashpress'); ?></th>
						<th id="ptotal"><?php _e("Total",'cashpress'); ?></th>
					  </tr>
					  <tr>
						<td><?php echo $csp_material_item ?></td>
						<td><?php echo $csp_material_qty ?></td>
						<td><?php echo csp_CURRENCY . $csp_material_cost ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[1]; ?></td>
					  </tr>
					  <?php if ($csp_material_item2 != ""): ?>					  
					  <tr class="even">
						<td><?php echo $csp_material_item2 ?></td>
						<td><?php echo $csp_material_qty2 ?></td>
						<td><?php echo csp_CURRENCY . $csp_material_cost2 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[2]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item3 != ""): ?>
					  <tr>
						<td><?php echo $csp_material_item3 ?></td>
						<td><?php echo $csp_material_qty3 ?></td>
						<td><?php echo csp_CURRENCY . $csp_material_cost3 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[3]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item4 != ""): ?>
					  <tr class="even">
						<td><?php echo $csp_material_item4 ?></td>
						<td><?php echo $csp_material_qty4 ?></td>
						<td><?php echo csp_CURRENCY . $csp_material_cost4 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[4]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item5 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item5 ?></td>
					  	<td><?php echo $csp_material_qty5 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost5 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[5]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item6 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item6 ?></td>
					  	<td><?php echo $csp_material_qty6 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost6 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[6]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item7 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item7 ?></td>
					  	<td><?php echo $csp_material_qty7 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost7 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[7]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item8 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item8 ?></td>
					  	<td><?php echo $csp_material_qty8 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost8 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[8]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item9 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item9 ?></td>
					  	<td><?php echo $csp_material_qty9 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost9 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[9]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item10 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item10 ?></td>
					  	<td><?php echo $csp_material_qty10 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost10 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[10]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item11 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item11 ?></td>
					  	<td><?php echo $csp_material_qty11 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost11 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[11]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item12 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item12 ?></td>
					  	<td><?php echo $csp_material_qty12 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost12 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[12]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item13 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item13 ?></td>
					  	<td><?php echo $csp_material_qty13 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost13 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[13]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item14 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item14 ?></td>
					  	<td><?php echo $csp_material_qty14 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost14 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[14]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item15 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item15 ?></td>
					  	<td><?php echo $csp_material_qty15 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost15 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[15]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item16 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item16 ?></td>
					  	<td><?php echo $csp_material_qty16 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost16 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[16]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item17 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item17 ?></td>
					  	<td><?php echo $csp_material_qty17 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost17 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[17]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item18 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item18 ?></td>
					  	<td><?php echo $csp_material_qty18 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost18 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[18]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item19 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_material_item19 ?></td>
					  	<td><?php echo $csp_material_qty19 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost19 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[19]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_material_item20 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_material_item20 ?></td>
					  	<td><?php echo $csp_material_qty20 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_material_cost20 ?></td>
						<td><?php echo csp_CURRENCY . $materialtotal[20]; ?></td>
					  </tr>
					  <?php endif; ?>
					  					  
						<tr>
						<th colspan="4" class="th_total"><?php _e("Material Sub Total:",'cashpress'); ?>  <?php echo csp_CURRENCY . $materialsubtotal ?></th>
					  </tr>
					</table>
					
				</div>	
<div class="proposal_table">
					<table>
					  <tr>
						<th id="itmdesc"><?php _e("Item Description",'cashpress'); ?></th>
						<th id="qty"><?php _e("Qty",'cashpress'); ?></th>
						<th id="uprice"><?php _e("Unit Price",'cashpress'); ?></th>
						<th id="ptotal"><?php _e("Total",'cashpress'); ?></th>
					  </tr>
					  <tr>
						<td><?php echo $csp_labor_item ?></td>
						<td><?php echo $csp_labor_qty ?></td>
						<td><?php echo csp_CURRENCY . $csp_labor_cost ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[1]; ?></td>
					  </tr>
					  <?php if ($csp_labor_item2 != ""): ?>					  
					  <tr class="even">
						<td><?php echo $csp_labor_item2 ?></td>
						<td><?php echo $csp_labor_qty2 ?></td>
						<td><?php echo csp_CURRENCY . $csp_labor_cost2 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[2]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item3 != ""): ?>
					  <tr>
						<td><?php echo $csp_labor_item3 ?></td>
						<td><?php echo $csp_labor_qty3 ?></td>
						<td><?php echo csp_CURRENCY . $csp_labor_cost3 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[3]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item4 != ""): ?>
					  <tr class="even">
						<td><?php echo $csp_labor_item4 ?></td>
						<td><?php echo $csp_labor_qty4 ?></td>
						<td><?php echo csp_CURRENCY . $csp_labor_cost4 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[4]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item5 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item5 ?></td>
					  	<td><?php echo $csp_labor_qty5 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost5 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[5]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item6 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item6 ?></td>
					  	<td><?php echo $csp_labor_qty6 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost6 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[6]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item7 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item7 ?></td>
					  	<td><?php echo $csp_labor_qty7 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost7 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[7]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item8 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item8 ?></td>
					  	<td><?php echo $csp_labor_qty8 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost8 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[8]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item9 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item9 ?></td>
					  	<td><?php echo $csp_labor_qty9 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost9 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[9]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item10 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item10 ?></td>
					  	<td><?php echo $csp_labor_qty10 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost10 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[10]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item11 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item11 ?></td>
					  	<td><?php echo $csp_labor_qty11 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost11 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[11]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item12 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item12 ?></td>
					  	<td><?php echo $csp_labor_qty12 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost12 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[12]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item13 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item13 ?></td>
					  	<td><?php echo $csp_labor_qty13 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost13 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[13]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item14 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item14 ?></td>
					  	<td><?php echo $csp_labor_qty14 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost14 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[14]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item15 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item15 ?></td>
					  	<td><?php echo $csp_labor_qty15 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost15 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[15]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item16 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item16 ?></td>
					  	<td><?php echo $csp_labor_qty16 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost16 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[16]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item17 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item17 ?></td>
					  	<td><?php echo $csp_labor_qty17 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost17 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[17]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item18 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item18 ?></td>
					  	<td><?php echo $csp_labor_qty18 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost18 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[18]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item19 != ""): ?>
					  <tr>
					  	<td><?php echo $csp_labor_item19 ?></td>
					  	<td><?php echo $csp_labor_qty19 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost19 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[19]; ?></td>
					  </tr>
					  <?php endif; ?>
					  <?php if ($csp_labor_item20 != ""): ?>
					  <tr class="even">
					  	<td><?php echo $csp_labor_item20 ?></td>
					  	<td><?php echo $csp_labor_qty20 ?></td>
					  	<td><?php echo csp_CURRENCY . $csp_labor_cost20 ?></td>
						<td><?php echo csp_CURRENCY . $labortotal[20]; ?></td>
					  </tr>
					  <?php endif; ?>
					  					  
						<tr>
						<th colspan="4" class="th_total"><?php _e("Labor Sub Total:",'cashpress'); ?>  <?php echo csp_CURRENCY . $laborsubtotal ?></th>
					  </tr>
					</table>
</div>
<div class="proposal_table">
					<table>
					  <tr>
						<th width="70"><?php _e("Total Labor",'cashpress'); ?></th>
						<th width="70"><?php _e("Total Material(s)",'cashpress'); ?></th>
						<th width="43"><?php _e("Tax",'cashpress'); ?></th>
						<?php if ($csp_total_adjustment != ""): ?>
						<th width="43"><?php _e("Adjustments",'cashpress'); ?></th>
						<?php endif; ?>
						<th width="70"><?php _e("Project Total",'cashpress'); ?></th>
					  </tr>
					  <tr>
						<td><?php echo csp_CURRENCY . $laborsubtotal ?></td>
						<td><?php echo csp_CURRENCY . $materialsubtotal ?></td>
						<td><?php echo csp_CURRENCY . $csp_totaltax ?></td>
						<?php if ($csp_total_adjustment != ""): ?>
							<td><?php echo csp_CURRENCY . $csp_total_adjustment ?></td>
						<?php endif; ?>
						<td><strong><?php echo csp_CURRENCY . $grandtotal ?></strong></td>
					  </tr>

					</table>
				</div>
			
				
				<?php if ($proposalnotes != ""): ?>
					<div class="terms_box proposal">
						<h3><?php _e("Proposal Notes",'cashpress'); ?></h3>
						<p><?php echo $proposalnotes ?></p>
					

</div>
				<?php endif; ?>	
				
					<div class="gap_line">gap line</div>
						<?php  if (@$csp_settings[useapprove] == 'yes') : ?>
							<?php if ($proposalstatus == 'Approved') : ?>
					<p class="proposalstatus"><?php _e("Status: Approved",'cashpress'); ?></p>
							<?php elseif ($proposalstatus == 'Closed') : ?>
					<p class="proposalstatus"><?php _e("Status: Closed",'cashpress'); ?></p>
							<?php else : ?>
					<a href="#galleryitem2" class="btn_approve" rel="prettyPhoto"><?php _e("Approve Proposal",'cashpress'); ?></a>
							<?php endif; ?>
						<?php endif; ?>
			<?php endif; ?><!--end of long password protection-->
			
			<?php if ($case == 3) : // Logged out user on this page 
			?>
				<div class="contact_form" id="password">
					<h3><?php _e("You have logged out",'cashpress'); ?></h3>
					<p><a href="<?php echo bloginfo('url') . strtok($_SERVER['REQUEST_URI'], '?'); ?>"><?php _e("<strong>Click here</strong></a> if you would like to log back in again.",'cashpress'); ?></p><br/>
				</div>	
			<?php endif; ?>
			
			</div> <!--end of content_shadow-->
			
			
			<div id="contact_form_container" >	 
					<!--  START FORM SCRIPTS -->
					<?php if (@$_POST['form_type'] =="send_invoice") : ?>
					<a style="display:none;" id="contact_success" href="#contactreturn" rel="prettyPhoto"></a>
					<a style="display:none;" id="contact_fail" href="#galleryitem1" rel="prettyPhoto"></a>
					<div id="contactreturn" style="display:none;">
					<?php csp_email($_POST); ?>
					</div>
					<?php endif; ?>
					<!--  END FORM SCRIPTS -->
					
					<div id="galleryitem1" style="display:none;padding:30px;">
					<?php if ($_POST['error_message'] != "") : ?>
					<?php echo $_POST['error_message']; ?>
					<br/>
					<?php else :?>
					<h3><?php _e("Send Proposal for",'cashpress'); ?> <strong><?php the_title(); ?></strong></h3>
					<?php endif; ?>
					
					<?php if ($case == 1) : // Successful login 
					?>
					<form action="" class="contact_form" method="post">
					<fieldset>
						<label><?php _e("Send Proposal To:",'cashpress'); ?></label>
						<input type="text" class="input_txt" name="visitor_email" value="<?php echo $_POST['visitor_email'] ; ?>" />
						
						<label><?php _e("Subject:",'cashpress'); ?></label>
						<input type="text" class="input_txt" name="mail_subject" value="<?php echo $_POST['mail_subject'] ; ?>"/>
						
						<label><?php _e("Your message:",'cashpress'); ?></label>
						<textarea name="invoice_message" cols="40" rows="10"><?php echo $_POST['invoice_message'] ; ?></textarea>
						
						<input type="hidden" name="form_type" value="send_invoice" />
						<label style="display:none;"> Leave this blank -></label><input type="text" style="display:none;" name="name" value="" />
						<input type="hidden" name="visitor_name" value="invoice" />
						
						<input type="hidden" name="message_test" value ="<?php $nonce = wp_create_nonce('csp-contact-form'); echo $nonce; ?>" />
						
						<?php if ($csp_settings['captcha'] == 'question') :?>
						<label><?php echo $csp_settings['botquestion']; ?></label><input type="text" class="input_txt" name="botquestion" value=""/>
						<?php endif; ?>
						
						
						<input type="submit" value="<?php _e("Send Proposal",'cashpress'); ?>" class="input_send" />
					</fieldset>
					</form>	
					<?php endif; ?>
			</div>
			</div>
				
				
			<?php if ($case == 1) : // Successful login 
			?>  
				<!-- <div class="btn_row">
					<a href="#" class="btn_save">Save As PDF</a>
					<a href="#" onclick="window.print();return false;" class="btn_print"><?php _e("Print this page",'cashpress'); ?></a>
				</div> -->
			
				<?php  if (@$csp_settings[allowcomments] == 'yes') : ?>
				<div class="proposal_comments">
				<?php comments_template( '', true ); ?>
				</div>
				<?php endif; ?>
			<?php endif; ?>
			
		
		 </div>
	</div> <!--end of content-->
	
	<div id="contact_form" >	 
		<!--  START FORM SCRIPTS -->
		<?php if (@$_POST['form_type'] =="Proposal Approved:") : ?>
		<a style="display:none;" id="contact_success" href="#contactreturn" rel="prettyPhoto"></a>
		<a style="display:none;" id="contact_fail" href="#galleryitem2" rel="prettyPhoto"></a>
		<div id="contactreturn" style="display:none;">
		<?php csp_email($_POST); ?>
		</div>
		<?php endif; ?>
		<!--  END FORM SCRIPTS -->


	<div id="galleryitem2" style="display:none;padding:30px;">
		<?php if ($_POST['error_message'] != "") : ?>
		<?php echo $_POST['error_message']; ?>
		<br/>
		<?php else :?>
		<h3><?php _e("Approve Proposal for",'cashpress'); ?> <strong><?php the_title(); ?></strong></h3>
		<?php endif; ?>
		
		<form action="" class="contact_form" method="post">
		<fieldset>
			<label><?php _e("Your name:",'cashpress'); ?></label>
			<input type="text" class="input_txt" name="visitor_name" value="<?php echo $_POST['visitor_name'] ; ?>" />
			
			<label><?php _e("Your email:",'cashpress'); ?></label>
			<input type="text" class="input_txt" name="visitor_email" value="<?php echo $_POST['visitor_email'] ; ?>"/>
			
			<label><?php _e("Your message:*",'cashpress'); ?></label>
			<textarea name="visitor_message"><?php echo $_POST['visitor_message'] ; ?></textarea>
			
			<input type="hidden" name="form_type" value="Proposal Approved:" />
			<input type="hidden" name="proposal_title" value="<?php the_title(); ?>" />
			<input type="hidden" name="grandtotal" value="<?php echo $grandtotal ?>" />
			
			<input type="hidden" name="message_test" value ="<?php $nonce = wp_create_nonce('csp-contact-form'); echo $nonce; ?>" />
			
			<?php if ($csp_settings['captcha'] == 'question') :?>
			<label><?php echo $csp_settings['botquestion']; ?></label><input type="text" class="input_txt" name="botquestion" value=""/>
			<?php endif; ?>	
			
			<input type="submit" value="<?php _e("Approve",'cashpress'); ?>" class="input_send approve" />
		</fieldset>
		</form>	
	</div>
	</div>
<div id="contact_form" >	 
		<!--  START FORM SCRIPTS -->
		<?php if ($_POST['form_type'] =="Proposal Approved:") : ?>
		<a style="display:none;" id="contact_success" href="#contactreturn" rel="prettyPhoto"></a>
		<a style="display:none;" id="contact_fail" href="#galleryitem2" rel="prettyPhoto"></a>
		<div id="contactreturn" style="display:none;">
		<?php csp_email($_POST); ?>
		</div>
		<?php endif; ?>
		<!--  END FORM SCRIPTS -->


	<div id="galleryitem2" style="display:none;padding:30px;">
		<?php if ($_POST['error_message'] != "") : ?>
		<?php echo $_POST['error_message']; ?>
		<br/>
		<?php else :?>
		<h3><?php _e("Approve Proposal for",'cashpress'); ?> <strong><?php the_title(); ?></strong></h3>
		<?php endif; ?>
		
		<form action="" class="contact_form" method="post">
		<fieldset>
			<label><?php _e("Your name:",'cashpress'); ?></label>
			<input type="text" DISABLED class="input_txt" name="visitor_name" value="<?php echo $_POST['visitor_name'] ; ?>" />
			
			<label><?php _e("Your email:",'cashpress'); ?></label>
			<input type="text" DISABLED class="input_txt" name="visitor_email" value="<?php echo $_POST['visitor_email'] ; ?>"/>
			
			<label><?php _e("Your message:*",'cashpress'); ?></label>
			<textarea name="visitor_message"><?php echo $_POST['visitor_message'] ; ?></textarea>
			
			<input type="hidden" name="form_type" value="Proposal Approved:" />
			<input type="hidden" name="proposal_title" value="<?php the_title(); ?>" />
			<input type="hidden" name="grandtotal" value="<?php echo $grandtotal ?>" />
			
			<input type="hidden" name="message_test" value ="<?php $nonce = wp_create_nonce('csp-contact-form'); echo $nonce; ?>" />
			
			<?php if ($csp_settings['captcha'] == 'question') :?>
			<label><?php echo $csp_settings['botquestion']; ?></label><input type="text" DISABLED class="input_txt" name="botquestion" value=""/>
			<?php endif; ?>	
			
			<input type="submit" value="<?php _e("Approve",'cashpress'); ?>" class="input_send approve" />
		</fieldset>
		</form>	
	</div>
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
