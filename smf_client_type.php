<?php 
/**
 * 
 * CashPress v3.0
 * Custom post type and admin input fields for client data
 * 
**/

add_action('init', 'clients');

function clients(){
  $labels = array(
    'name' => _x('Clients', 'post type general name'),
    'singular_name' => _x('Client', 'post type singular name'),
    'add_new' => _x('New Client', 'client'),
    'add_new_item' => __('Create New Client'),
    'edit_item' => __('Edit Client'),
    'new_item' => __('New Client'),
    'view_item' => __('View Client'),
    'search_items' => __('Search Clients'),
    'not_found' =>  __('No clients found'),
    'not_found_in_trash' => __('No clients found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 25,
    'menu_icon' => plugins_url() . '/cashpress/images/client.gif',
    'supports' => array('')
  ); 
  register_post_type('clients',$args);
}

// Add filter to insure the client is displayed when user updates a client

add_filter('post_updated_messages', 'client_updated_messages');
function client_updated_messages( $messages ) {

  $messages['clients'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Client updated. <a href="%s">View Client</a>'), esc_url( get_permalink(@$post_id) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Client updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Client restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Client published. <a href="%s">View client</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('Client saved.'),
    8 => sprintf( __('Client submitted. <a target="_blank" href="%s">Preview client</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
    9 => sprintf( __('Client scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview client</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( @$post->post_date ) ), esc_url( get_permalink(@$post_ID) ) ),
    10 => sprintf( __('Client draft updated. <a target="_blank" href="%s">Client</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
  );

  return @$messages;
}

  
/*========================= First Custom Field Section ========================*/
	function client_metadata(){  
        global $post; 
        $custom = get_post_custom($post->ID);  
        $csp_client_username = $custom["csp_client_username"][0]; 
        $company = $custom["company"][0]; 
        $client_name = $custom["client_name"][0]; 
        $address1 = $custom["address1"][0]; 
        $address2 = $custom["address2"][0]; 
        $address3 = $custom["address3"][0]; 
        $phone = $custom["phone"][0]; 
        $notes = $custom["notes"][0]; 
        $email = $custom["email"][0];
        $password = $custom["password"][0];

        
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
?>  
<div class="client_metadata">

    <label><?php _e("Username:",'cashpress'); ?></label><input name="csp_client_username" value="<?php echo $csp_client_username; ?>" /><br/> 
    <label><?php _e("Company:",'cashpress'); ?></label><input name="company" value="<?php echo $company; ?>" /><br/> 
    <label><?php _e("Client Name:",'cashpress'); ?></label><input name="client_name" value="<?php echo $client_name; ?>" /><br/>
    <label><?php _e("Address 1:",'cashpress'); ?></label><input name="address1" value="<?php echo $address1; ?>" /><br/>
    <label><?php _e("Address 2:",'cashpress'); ?></label><input name="address2" value="<?php echo $address2; ?>" /><br/>
    <label><?php _e("Address 3:",'cashpress'); ?></label><input name="address3" value="<?php echo $address3; ?>" /><br/>
    <label><?php _e("Phone:",'cashpress'); ?></label><input name="phone" value="<?php echo $phone; ?>" /><br/>
    <label><?php _e("Email Address:",'cashpress'); ?></label><input name="email" value="<?php echo $email; ?>" /><br/>
    <label><?php _e("Client Password:",'cashpress'); ?></label><input name="password" value="<?php echo $password; ?>" /><br/> 
    <div class="right"><label><?php _e("Private Notes:",'cashpress'); ?></label><br/><textarea name="notes"><?php echo $notes; ?></textarea></div>
      

</div>

<?php  
}  
    
function add_client_metadata(){  
        add_meta_box('client_metadata', __('Client Details', 'csp_client_metadata'), 'client_metadata', 'clients', 'normal', 'low');  
} 
    
add_action('admin_init', 'add_client_metadata'); 
   

/*========================= Second Custom Field Section ========================*/
	function client_metadata2(){  
        global $post; 
        $custom = get_post_custom($post->ID);  
        $file1 = $custom["file1"][0];
        $file2 = $custom["file2"][0]; 
        $file3 = $custom["file3"][0]; 
        $file4 = $custom["file4"][0]; 
        $file5 = $custom["file5"][0];
        $file1n = $custom["file1n"][0];
        $file2n = $custom["file2n"][0]; 
        $file3n = $custom["file3n"][0]; 
        $file4n = $custom["file4n"][0]; 
        $file5n = $custom["file5n"][0];
        $pubnotes = $custom["pubnotes"][0]; 
        
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
?>  
<div class="client_metadata">

    <?php _e("Enter the name and URL of any files you would like to share with your client (use the wordpress media uploader and copy the url). These files will technically be public, so create a unique name to make sure nobody can find them:",'cashpress'); ?><br/>&nbsp;<br/>&nbsp;<br/>

		    <label><?php _e("File 1 Name:",'cashpress'); ?></label><input name="file1n" value="<?php echo $file1n; ?>" /><br/><label><?php _e("File 1 URL:",'cashpress'); ?></label><input name="file1" value="<?php echo $file1; ?>" />


<a href="media-upload.php?type=image&TB_iframe=true" target="_blank" title='Add an Image'> <img src='images/media-button-image.gif' alt='Add an Image' /></a> 

<a href="media-upload.php?type=video&amp;TB_iframe=true" target="_blank" title='Add Video'><img src='images/media-button-video.gif' alt='Add Video' /></a> 

<a href="media-upload.php?type=audio&amp;TB_iframe=true" target="_blank" title='Add Audio'><img src='images/media-button-music.gif' alt='Add Audio' /></a> 

<a href="media-upload.php?TB_iframe=true" target="_blank" title='Add Media'><img src='images/media-button-other.gif' alt='Add Media' /></a><br/><br/>
		    
		    <label><?php _e("File 2 Name:",'cashpress'); ?></label><input name="file2n" value="<?php echo $file2n; ?>" /><br/>
		    <label><?php _e("File 2 URL:",'cashpress'); ?></label><input name="file2" value="<?php echo $file2; ?>" /><br/><br/>


<a href="media-upload.php?type=image&TB_iframe=true" target="_blank" title='Add an Image'> <img src='images/media-button-image.gif' alt='Add an Image' /></a> 

<a href="media-upload.php?type=video&amp;TB_iframe=true" target="_blank" title='Add Video'><img src='images/media-button-video.gif' alt='Add Video' /></a> 

<a href="media-upload.php?type=audio&amp;TB_iframe=true" target="_blank" title='Add Audio'><img src='images/media-button-music.gif' alt='Add Audio' /></a> 

<a href="media-upload.php?TB_iframe=true" target="_blank" title='Add Media'><img src='images/media-button-other.gif' alt='Add Media' /></a><br/><br/>

		    
		    <label><?php _e("File 3 Name:",'cashpress'); ?></label><input name="file3n" value="<?php echo $file3n; ?>" /><br/>
		    <label><?php _e("File 3 URL:",'cashpress'); ?></label><input name="file3" value="<?php echo $file3; ?>" /><br/><br/>


<a href="media-upload.php?type=image&TB_iframe=true" target="_blank" title='Add an Image'> <img src='images/media-button-image.gif' alt='Add an Image' /></a> 

<a href="media-upload.php?type=video&amp;TB_iframe=true" target="_blank" title='Add Video'><img src='images/media-button-video.gif' alt='Add Video' /></a> 

<a href="media-upload.php?type=audio&amp;TB_iframe=true" target="_blank" title='Add Audio'><img src='images/media-button-music.gif' alt='Add Audio' /></a> 

<a href="media-upload.php?TB_iframe=true" target="_blank" title='Add Media'><img src='images/media-button-other.gif' alt='Add Media' /></a><br/><br/>
		    
		    <label><?php _e("File 4 Name:",'cashpress'); ?></label><input name="file4n" value="<?php echo $file4n; ?>" /><br/>
		    <label><?php _e("File 4 URL:",'cashpress'); ?></label><input name="file4" value="<?php echo $file4; ?>" /><br/><br/>


<a href="media-upload.php?type=image&TB_iframe=true" target="_blank" title='Add an Image'> <img src='images/media-button-image.gif' alt='Add an Image' /></a> 

<a href="media-upload.php?type=video&amp;TB_iframe=true" target="_blank" title='Add Video'><img src='images/media-button-video.gif' alt='Add Video' /></a> 

<a href="media-upload.php?type=audio&amp;TB_iframe=true" target="_blank" title='Add Audio'><img src='images/media-button-music.gif' alt='Add Audio' /></a> 

<a href="media-upload.php?TB_iframe=true" target="_blank" title='Add Media'><img src='images/media-button-other.gif' alt='Add Media' /></a><br/><br/>
		    
		    <label><?php _e("File 5 Name:",'cashpress'); ?></label><input name="file5n" value="<?php echo $file5n; ?>" /><br/>
			<label><?php _e("File 5 URL:",'cashpress'); ?></label><input name="file5" value="<?php echo $file5; ?>" /><br/>


<a href="media-upload.php?type=image&TB_iframe=true" target="_blank" title='Add an Image'> <img src='images/media-button-image.gif' alt='Add an Image' /></a> 

<a href="media-upload.php?type=video&amp;TB_iframe=true" target="_blank" title='Add Video'><img src='images/media-button-video.gif' alt='Add Video' /></a> 

<a href="media-upload.php?type=audio&amp;TB_iframe=true" target="_blank" title='Add Audio'><img src='images/media-button-music.gif' alt='Add Audio' /></a> 

<a href="media-upload.php?TB_iframe=true" target="_blank" title='Add Media'><img src='images/media-button-other.gif' alt='Add Media' /></a><br/><br/>
    
    <div class="right"><label><?php _e("Public Notes:",'cashpress'); ?></label><br/><textarea name="pubnotes"><?php echo $pubnotes; ?></textarea></div>

</div>

<?php  
}  


function add_client_metadata2(){  
        add_meta_box('client_metadata2', __('Client Files & Notes', 'csp_client_metadata2'), 'client_metadata2', 'clients', 'normal', 'low');  
} 
    
add_action('admin_init', 'add_client_metadata2'); 
	
/*===================== Create Post Titles Using Meta Data=================*/
   

function create_doc_title_meta($meta_data_title){
     global $post;
     if ($post->post_type == 'clients') {
	 $meta_data_title = @$_POST['csp_client_username'];
     }
     elseif ($post->post_type == 'invoices') {
         $meta_data_title = '#' . @$_POST['inv_number'];
     }     
     elseif ($post->post_type == 'proposals') {
         $meta_data_title = '#' . @$_POST['pro_number'];
     }
     return $meta_data_title;
}
add_filter('title_save_pre','create_doc_title_meta');


/*====================== Saves all Custom Field Data ======================*/    
function save_meta_client($post_id){  
		
		if (!wp_verify_nonce(@$_POST['csp-nonce'], 'cs-p')) return $post_id;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		update_post_meta(@$post_id, "csp_client_username", @$_POST["csp_client_username"]);
	   	update_post_meta(@$post_id, "company", @$_POST["company"]);
		update_post_meta(@$post_id, "client_name", @$_POST["client_name"]); 
	   	update_post_meta(@$post_id, "address1", @@$_POST["address1"]);  
	   	update_post_meta(@$post_id, "address2", @$_POST["address2"]);  
	   	update_post_meta(@$post_id, "address3", @$_POST["address3"]);  
	   	update_post_meta($post_id, "phone", @$_POST["phone"]);  
	   	update_post_meta($post_id, "notes", @$_POST["notes"]);  
	   	update_post_meta($post_id, "password", @$_POST["password"]); 
	   	update_post_meta($post_id, "email", @$_POST["email"]); 
	   	update_post_meta($post_id, "pubnotes", @$_POST["pubnotes"]); 
	   	update_post_meta($post_id, "file1", @$_POST["file1"]); 
	   	update_post_meta($post_id, "file2", @$_POST["file2"]); 
	   	update_post_meta($post_id, "file3", @$_POST["file3"]); 
	   	update_post_meta($post_id, "file4", @$_POST["file4"]); 
	   	update_post_meta($post_id, "file5", @$_POST["file5"]); 
	        update_post_meta($post_id, "file1n", @$_POST["file1n"]); 
	   	update_post_meta($post_id, "file2n", @$_POST["file2n"]); 
	   	update_post_meta($post_id, "file3n", @$_POST["file3n"]); 
	   	update_post_meta($post_id, "file4n", @$_POST["file4n"]); 
	   	update_post_meta($post_id, "file5n", @$_POST["file5n"]); 
	      
}  
	
	
add_action('save_post', 'save_meta_client'); 


// Creating the column layout when viewing list of Clients in the backend
add_action("manage_posts_custom_column",  "clients_custom_columns");
add_filter("manage_edit-clients_columns", "clients_edit_columns");
 
function clients_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Username",
    "password" => "Password",
    "address1" => "Client Address",
    "address2" => "City State Zip",
    "phone" => "Phone",
    "email" => "Email",
  );
 
  return $columns;
}

function clients_custom_columns($column)
{
	global $post;
	$custom = get_post_custom($post->ID);
	
	if ("ID" == $column) echo $post->ID; //displays title
	elseif ("password" == $column) echo $custom['password'][0] ; //displays the content excerpt
	elseif ("address1" == $column) echo $custom['address1'][0] ; //displays the content excerpt
	elseif ("address2" == $column) echo $custom['address2'][0] ; //displays the content excerpt
	elseif ("phone" == $column) echo $custom['phone'][0] ; //displays the content excerpt
	elseif ("email" == $column) echo $custom['email'][0] ; //shows up our post thumbnail that we previously created.
}


?>
