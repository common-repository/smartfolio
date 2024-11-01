<?php 
/**
Template Name: myAccount
 * 
 * smartFolio v3.0
 * 
 * Creates the login and registered user area
 * Allows clients to view category and gallery you've created for them.
 * 
**/
?><?php

if (isset($_GET['logout'] ) != 'true'){

	if (isset($_POST['clientnamep'] ) != "" && @$_COOKIE['smf_client'] == ""){ $clientname = $_POST['clientnamep']; }
	if (isset($_POST['clientnamep'] ) == "" && @$_COOKIE['smf_client'] != ""){ $clientname = $_COOKIE['smf_client']; }
	if (isset($_POST['clientnamep'] ) != "" && @$_COOKIE['smf_client'] != ""){ $clientname = $_POST['smf_client']; }
	if (isset($_POST['clientpassp'] ) != "" && @$_COOKIE['smf_pass'] == ""){ $clientpass = $_POST['clientpassp']; }
	if (isset($_POST['clientpassp'] ) == "" && @$_COOKIE['smf_pass'] != ""){ $clientpass = $_COOKIE['smf_pass']; }
	if (isset($_POST['clientpassp'] ) != "" && @$_COOKIE['smf_pass'] != ""){ $clientpass = $_POST['smf_pass']; }
	
	$proposal = get_posts('post_type=gallery&numposts=-1&meta_key=client&meta_value=' . @$clientname);
	$invoice = get_posts('post_type=category&numposts=-1&meta_key=client&meta_value=' . @$clientname);
	
	$client_post = get_post_by_title(@$clientname);
	$client_custom = get_post_custom(@$client_post->ID);
	$password = @$client_custom['password'][0];
	$company_options = get_option('smf_company');
	$smf_settings = get_option('smf_settings');
	
	$case = 0;
	
	if (isset($client_post) && @$clientpass == @$password){
	setcookie('smf_client', @$clientname, 0, '/');
	setcookie('smf_pass', @$clientpass, 0, '/');
	$case = 1;
	}
	if (@$clientname == "" && @$clientpass == ""){$case = 0;}
	if (@$clientname != "" && @$clientpass == ""){
	$error_message_a = __("Please enter both a username and a password to continue",'smartfolio');
	$case = 0;
	}
	if (@$clientname == "" && @$clientpass != ""){
	$error_message_a = __("Please enter both a username and a password to continue",'smartfolio');
	$case = 0;
	}
	if (@$clientname != "" && $clientpass != "" && $clientpass != $password){
	$error_message_a = __("Your username was not found or your password is not valid. Please try again:",'smartfolio');
	$case = 0;
	}
}else{
$case = 3;
}
?>

<?php get_header(); ?>


<?php

//Add Additional Stylesheet to Plugin Generated Pages and Posts
$smf_pluginsurl = plugins_url();
?>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo $smf_pluginsurl ?>/smartfolio/themefiles/additional_style.css" />

<div id="banner">
	<div class="banner_inside">
		<h1><?php _e("myAccount",'smartfolio'); ?> <?php if ($case == 1) : ?>  for: <strong><?php echo $clientname; ?></strong><?php endif;?></h1>		
	</div>
</div> <!--end of index_banner-->
		
		
		
<div id="content">
	<div class="content_inside">
		<div class="content_shadow">
			
		<?php if ($case == 0) : // Nothing entered or incorrect user/pass ?>  
			<div class="contact_form" id="password">
				<span style="color:red;" ><?php echo @$error_message_a ; ?></span><br/>
				<h3><?php _e("Welcome",'smartfolio'); ?></h3>
				<p><?php _e("Please enter your username and password:",'smartfolio'); ?></p><br/>
				<form action="" name="myAccount" method="POST">
				<fieldset>
				<label><?php _e("Name",'smartfolio'); ?>:</label>
				<input name="clientnamep" class="input_txt" type="text" value ="<?php echo @$_POST['clientnamep']; ?>"/>
				<label><?php _e("Password",'smartfolio'); ?>:</label>
				<input name="clientpassp" class="input_txt" type="password" value=""/>
				<input type="submit" name="submit" class="input_send" value="<?php _e("Login",'smartfolio'); ?>" />
				</fieldset>
				</form>	
							</div>	
		<?php endif; ?>
		
		<?php if ($case == 1) : // Successful name/pass login ?>

<?php if ($clientname != "" && (isset($_GET['logout'])) != 'true') :?><a href="<?php echo bloginfo('url') . '/myaccount?logout=true' ; ?>"><?php _e("Logout",'smartfolio'); ?></a></li><?php endif; ?>
			<?php if(isset($invoice[0])) :?>
				<br/><br/>
				<div class="proposal_table">
					<table>
					  <tr>
						<th id="th_inv"><?php _e("Invoices",'smartfolio'); ?></th>
						<th id="th_invnum"><?php _e("Invoice",'smartfolio'); ?> #</th>
						<th id="th_status"><?php _e("Status",'smartfolio'); ?></th>
						<th id="th_due"><?php _e("Due Date",'smartfolio'); ?></th>
						<th id="th_view"><?php _e("View",'smartfolio'); ?></th>
					  </tr>
					<?php $smfint = 0; ?>
					<?php foreach($invoice as $smfvalue) : ?>
		    		<?php $custom = get_post_custom($smfvalue->ID);	?>
		    		   
		    		  <tr <?php if (!is_int($smfint/2)){ echo 'class="even"'; } ?> >
					  	<td><a href="<?php echo get_permalink($smfvalue->ID); ?>" ><?php echo $smfvalue->post_title; ?></a></td>
						<td><?php if ($custom['inv_number'][0] == ""){ echo $smfvalue->ID; }else{ echo $custom['inv_number'][0]; } ?></td>
						<td><?php echo ($custom['invoice_status'][0]); ?></td>
						<td><?php echo ($custom['due_date'][0]); ?></td>
						<td><a href="<?php echo get_permalink($smfvalue->ID); ?>" ><?php _e("View",'smartfolio'); ?></a></td>
					  </tr>
					 <?php $smfint = $smfint + 1; ?>
					<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
				
			
			<?php if(isset($proposal[0])):?>
				<br/><br/><br/>
				<div class="proposal_table">
					<table>
					  <tr>
						<th id="th_prop"><?php _e("Proposals",'smartfolio'); ?></th>
						<th class="th_prop2"><?php _e("Proposal",'smartfolio'); ?> #</th>
						<th class="th_prop2"><?php _e("Status",'smartfolio'); ?></th>
						<th class="th_prop2"><?php _e("View",'smartfolio'); ?></th>
					  </tr>
					<?php $smfint = 0; ?>
					<?php foreach($proposal as $smfvalue) : ?>
		    		<?php $custom = get_post_custom($smfvalue->ID);	?>
					  <tr <?php if (!is_int($smfint/2)) { echo 'class="even"'; } ?> >
					  	<td><a href="<?php echo get_permalink($smfvalue->ID); ?>" ><?php echo $smfvalue->post_title; ?></a></td>
						<td><?php if ($custom['pro_number'][0] == ""){ echo $smfvalue->ID; }else{ echo $custom['pro_number'][0]; } ?></td>
						<td><?php echo $custom['gallerytatus'][0]; ?></td>
						<td><a href="<?php echo get_permalink($smfvalue->ID); ?>" ><?php _e("View Proposal",'smartfolio'); ?></a></td>
					  </tr>
					 <?php $smfint = $smfint + 1; ?>
					<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
			
			<?php if ($client_custom['file1'][0] != '' || $client_custom['file2'][0] != '' || $client_custom['file3'][0] != '' || $client_custom['file4'][0] != '' || $client_custom['file5'][0] != '') : ?>
				<br/><br/><br/>
				<div class="proposal_table">
					<table>
					  <tr>
						<th width="75%"><?php _e("Files",'smartfolio'); ?></th>
						<th width="25%"><?php _e("Download",'smartfolio'); ?></th>
					  </tr>
					  <?php if ($client_custom['file1'][0] != '') : ?>
					  <tr>
					  	<td><a href="<?php echo $client_custom['file1'][0]; ?>" ><?php echo $client_custom['file1n'][0]; ?></a></td>
					  	<td><a href="<?php echo $client_custom['file1'][0]; ?>" ><?php _e("Download",'smartfolio'); ?></a></td>
					  </tr>
					  <?php endif ; ?>
					  <?php if ($client_custom['file2'][0] != '') : ?>
					  <tr>
					  	<td><a href="<?php echo $client_custom['file2'][0]; ?>" ><?php echo $client_custom['file2n'][0]; ?></a></td>
					  	<td><a href="<?php echo $client_custom['file2'][0]; ?>" ><?php _e("Download",'smartfolio'); ?></a></td>
					  </tr>
					  <?php endif ; ?>
					  <?php if ($client_custom['file3'][0] != '') : ?>
					  <tr>
					  	<td><a href="<?php echo $client_custom['file3'][0]; ?>" ><?php echo $client_custom['file3n'][0]; ?></a></td>
					  	<td><a href="<?php echo $client_custom['file3'][0]; ?>" ><?php _e("Download",'smartfolio'); ?></a></td>
					  </tr>
					  <?php endif ; ?>
					  <?php if ($client_custom['file4'][0] != '') : ?>
					  <tr>
					  	<td><a href="<?php echo $client_custom['file4'][0]; ?>" ><?php echo $client_custom['file4n'][0]; ?></a></td>
					  	<td><a href="<?php echo $client_custom['file4'][0]; ?>" ><?php _e("Download",'smartfolio'); ?></a></td>
					  </tr>
					  <?php endif ; ?>
					  <?php if ($client_custom['file5'][0] != '') : ?>
					  <tr>
					  	<td><a href="<?php echo $client_custom['file5'][0]; ?>" ><?php echo $client_custom['file5n'][0]; ?></a></td>
					  	<td><a href="<?php echo $client_custom['file5'][0]; ?>" ><?php _e("Download",'smartfolio'); ?></a></td>
					  </tr>
					  <?php endif ; ?>
					</table>
				</div>
			<?php endif ; ?>
			
			<?php if(!isset($invoice[0]) && !isset($proposal[0])): ?>
			<br/><br/>
			<div class="contact_form" id="password">
				<h3><?php _e("myAccount for",'smartfolio'); ?> <?php echo $clientname; ?></h3>
				<p><?php _e("You've successfully logged in to your account, however, we don't have anything to show you at this point. Please check back later and there is sure to be more information.",'smartfolio'); ?></p><br/>

			</div>	
			<?php endif; ?>

		<?php endif; ?>
		
		<?php if ($case == 3) : // Logged out user on this page
		 ?>  
				<div class="contact_form" id="password">
					<h3><?php _e("You have logged out",'smartfolio'); ?></h3>
					<p><a href="<?php echo bloginfo('url') . strtok($_SERVER['REQUEST_URI'], '?'); ?>"><?php _e("<strong>Click here</strong></a> if you would like to log back in again.",'smartfolio'); ?></p><br/>
				</div>	
		<?php endif; ?>
				
		</div> <!--end of content_shadow-->
	</div>
</div> <!--end of content-->


<?php get_footer(); ?>
