<?php 
/**
 * 
 * CashPress
 * Company setup and contact settings admin panel
 * 
**/

// Register new options/settings
add_action('admin_init', 'csp_company_info_init' );

function csp_company_info_init(){
	register_setting( 'csp_company_info', 'csp_company');
}


function csp_company_info()
	{
?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
		<h2><?php _e("Company Setup",'cashpress'); ?></h2>
	
<form method="post" action="options.php">
			<?php settings_fields('csp_company_info'); ?>
			<?php $options = get_option('csp_company'); ?>
			<?php $cspcount = 1 ; ?>
    
			<h3><?php _e("Branding",'cashpress'); ?></h3>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row"><label for="csp_company[businessname]" ><?php _e("Business Name*:",'cashpress'); ?></label></th>
							<td><input type="text" size="70" name="csp_company[businessname]" value="<?php echo $options['businessname']?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="csp_company[logofile]" ><?php _e("Logo URL:",'cashpress'); ?></label></th>
							<td><input type="text" size="70" name="csp_company[logofile]" value="<?php echo $options['logofile']?>" />
							<br/><div id="media-buttons" class="hide-if-no-js">
Upload/Insert <a href="media-upload.php?post_id=1&amp;type=image&amp;TB_iframe=1" id="add_image" class="thickbox" title="Add an Image"><img src="http://127.0.1.1:8080/wordpress/wp-admin/images/media-button-image.gif?ver=20100531" alt="Add an Image" onclick="return false;"></a></div><?php _e("Use a transparent PNG no taller than 120px and no wider than 300px. <br>If you don't have a logo, leave this blank and we'll just use your wordpress site title until your ready.",'cashpress'); ?></td>
						</tr>
					</tbody>
					</table>
					<br/>
					
			<h3><?php _e("Contact Information",'cashpress'); ?></h3>
			<p><?php _e("This information is primarily used on the invoice and proposal pages. Most of it is optional if you don't feel comfortable, however your invoices might not look as good :-)",'cashpress'); ?></p>
					<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row"><label for="csp_company[paypalemail]" ><?php _e("PayPal Email*:",'cashpress'); ?></label></th>
							<td><input type="text" size="50" name="csp_company[paypalemail]" value="<?php echo $options['paypalemail']?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="csp_company[contactemail]" ><?php _e("Contact Email*:",'cashpress'); ?></label></th>
							<td><input type="text" size="50" name="csp_company[contactemail]" value="<?php echo $options['contactemail']?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="csp_company[phone]" ><?php _e("Phone Number:",'cashpress'); ?></label></th>
							<td><input type="text" size="50" name="csp_company[phone]" value="<?php echo $options['phone']?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="csp_company[address1]" ><?php _e("Address Line 1:",'cashpress'); ?></label></th>
							<td><input type="text" size="70" name="csp_company[address1]" value="<?php echo $options['address1']?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="csp_company[address2]" ><?php _e("Address Line 2:",'cashpress'); ?></label></th>
							<td><input type="text" size="70" name="csp_company[address2]" value="<?php echo $options['address2']?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label for="csp_company[address3]" ><?php _e("Address Line 3:",'cashpress'); ?></label></th>
							<td><input type="text" size="70" name="csp_company[address3]" value="<?php echo $options['address3']?>" /></td>
						</tr>
					</tbody>
					</table>
					<br/>
										
  <p><input type="submit" name="search" value="Update Options" class="button" /></p>
</form>
    
<?php
}
?>
