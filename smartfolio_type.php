<?php 
/**
 * 
 * smartFolio
 * Custom post type and admin input fields for smartFolio
 * 
**/

add_action('init', 'smartfolios');

function smartfolios() 
{
  $labels = array(
    'name' => _x('Albums', 'post type general name'),
    'singular_name' => _x('Album', 'post type singular name'),
    'add_new' => _x('New Album', 'smartfolio'),
    'add_new_title' => __('Create New Album'),
    'edit_title' => __('Edit Album'),
    'new_title' => __('New Album'),
    'view_title' => __('View Album'),
    'search_titles' => __('Search Albums'),
    'not_found' =>  __('No Album found'),
    'not_found_in_trash' => __('No Albums found in Trash'), 
    'parent_title_colon' => ''
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
    'menu_position' => 27,
    'menu_icon' => plugins_url() . '/smartfolio/images/photo-album.png',
    'supports' => array('')
  ); 
  register_post_type('smartfolios',$args);
}

// Add filter to insure the smartfolio is displayed when user updates an smartfolio
add_filter('post_updated_messages', 'smartfolio_updated_messages');

function smartfolio_updated_messages( $messages ) {

$messages['smartfolios'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('smartFolio updated. <a href="%s">View smartfolio</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('smartFolio updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('smartFolio restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('smartFolio published. <a href="%s">View smartfolio</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('smartFolio saved.'),
    8 => sprintf( __('smartFolio submitted. <a target="_blank" href="%s">Preview smartfolio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('smartFolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview smartfolio</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('smartFolio draft updated. <a target="_blank" href="%s">Preview smartfolio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// Remove "Protected" from titles
function sfm_title_trim($title)
{
$pattern[0] = '/Protected:/';
$pattern[1] = '/Private:/';
$replacement[0] = ''; // Enter some text to put in place of Protected:
$replacement[1] = ''; // Enter some text to put in place of Private:

return preg_replace($pattern, $replacement, $title);
}

add_filter('the_title', 'sfm_title_trim');

function create_album_title_meta($meta_data_title){
     global $post;
     if ($post->post_type == 'smartfolios') {
	 $meta_data_title = @$_POST['smf_album_title'];
     }
     return $meta_data_title;
}
add_filter('title_save_pre','create_album_title_meta');



 
function sfm_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL.'/smartfolio/js/mini.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
}
 
function sfm_admin_styles() {
wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'sfm_admin_scripts');
add_action('admin_print_styles', 'sfm_admin_styles');

function smartfolio_details(){  
            global $post; 
            $custom = get_post_custom($post->ID);  
            $smf_album_title = $custom["smf_album_title"][0]; 
            $smf_image_title = $custom["smf_image_title"][0]; 
            $smf_image_desc = $custom["smf_image_desc"][0];
            $smf_image_src = $custom["smf_image_src"][0];
            $smf_image_title2 = $custom["smf_image_title2"][0]; 
            $smf_image_desc2 = $custom["smf_image_desc2"][0]; 
            $smf_image_src2 = $custom["smf_image_src2"][0];
            $smf_image_title3 = $custom["smf_image_title3"][0]; 
            $smf_image_desc3 = $custom["smf_image_desc3"][0]; 
            $smf_image_src3 = $custom["smf_image_src3"][0];
            $smf_image_title4 = $custom["smf_image_title4"][0]; 
            $smf_image_desc4 = $custom["smf_image_desc4"][0]; 
            $smf_image_src4 = $custom["smf_image_src4"][0];
            $smf_image_title5 = $custom["smf_image_title5"][0]; 
            $smf_image_desc5 = $custom["smf_image_desc5"][0]; 
            $smf_image_src5 = $custom["smf_image_src5"][0];
            $smf_image_title6 = $custom["smf_image_title6"][0]; 
            $smf_image_desc6 = $custom["smf_image_desc6"][0]; 
            $smf_image_src6 = $custom["smf_image_src6"][0];
            $smf_image_title7 = $custom["smf_image_title7"][0]; 
            $smf_image_desc7 = $custom["smf_image_desc7"][0];
            $smf_image_src7 = $custom["smf_image_src7"][0];  
            $smf_image_title8 = $custom["smf_image_title8"][0]; 
            $smf_image_desc8 = $custom["smf_image_desc8"][0];
            $smf_image_src8 = $custom["smf_image_src8"][0];  
            $smf_image_title9 = $custom["smf_image_title9"][0]; 
            $smf_image_desc9 = $custom["smf_image_desc9"][0];
            $smf_image_src9 = $custom["smf_image_src9"][0];  
	    $smf_image_title10 = $custom["smf_image_title10"][0]; 
            $smf_image_desc10 = $custom["smf_image_desc10"][0];
            $smf_image_src10 = $custom["smf_image_src10"][0];
	    $smf_image_title11 = $custom["smf_image_title11"][0]; 
            $smf_image_desc11 = $custom["smf_image_desc11"][0];
            $smf_image_src11 = $custom["smf_image_src11"][0];
            $smf_image_title12 = $custom["smf_image_title12"][0]; 
            $smf_image_desc12 = $custom["smf_image_desc12"][0]; 
            $smf_image_src12 = $custom["smf_image_src12"][0];
            $smf_image_title13 = $custom["smf_image_title13"][0]; 
            $smf_image_desc13 = $custom["smf_image_desc13"][0]; 
            $smf_image_src13 = $custom["smf_image_src13"][0];
            $smf_image_title14 = $custom["smf_image_title14"][0]; 
            $smf_image_desc14 = $custom["smf_image_desc14"][0]; 
            $smf_image_src14 = $custom["smf_image_src14"][0];
            $smf_image_title15 = $custom["smf_image_title15"][0]; 
            $smf_image_desc15 = $custom["smf_image_desc15"][0]; 
            $smf_image_src15 = $custom["smf_image_src15"][0];
            $smf_image_title16 = $custom["smf_image_title16"][0]; 
            $smf_image_desc16 = $custom["smf_image_desc16"][0]; 
            $smf_image_src16 = $custom["smf_image_src16"][0];
            $smf_image_title17 = $custom["smf_image_title17"][0]; 
            $smf_image_desc17 = $custom["smf_image_desc17"][0];
            $smf_image_src17 = $custom["smf_image_src17"][0];  
            $smf_image_title18 = $custom["smf_image_title18"][0]; 
            $smf_image_desc18 = $custom["smf_image_desc18"][0];
            $smf_image_src18 = $custom["smf_image_src18"][0];  
            $smf_image_title19 = $custom["smf_image_title19"][0]; 
            $smf_image_desc19 = $custom["smf_image_desc19"][0];
            $smf_image_src19 = $custom["smf_image_src19"][0];  
	    $smf_image_title20 = $custom["smf_image_title20"][0]; 
            $smf_image_desc20 = $custom["smf_image_desc20"][0];
            $smf_image_src20 = $custom["smf_image_src20"][0];  
	    
    
            
            
        echo '<input type="hidden" name="smf-nonce" id="smf-nonce" value="' .wp_create_nonce('sm-f'). '" />';
            
    ?>  
    <div class="proposal_check">



<label><b>Album Title:</b></label><input id="smf_album_title" name="smf_album_title" value="<?php echo $smf_album_title; ?>" style="width:80%;"/><br><br><br><br>
 <table style="width:100%;">
  <tr>
    <th scope="col"><p></p></th>
    <th scope="col">Image Title:</th>
    <th scope="col">Image URL:</th>
    <th scope="col">Preview:</th>
    <th scope="col">Image Desc:</th>
  </tr>
  <tr>
<th scope="row">1.)</th>
    <td align="center"><input id="smf_image_title" name="smf_image_title" value="<?php echo $smf_image_title; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src" name="smf_image_src" value="<?php echo $smf_image_src; ?>" class="smf_image_src"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc" name="smf_image_desc" value="<?php echo $smf_image_desc; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">2.)</th>
    <td align="center"><input id="smf_image_title2" name="smf_image_title2" value="<?php echo $smf_image_title2; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src2" name="smf_image_src2" value="<?php echo $smf_image_src2; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src2; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc2" name="smf_image_desc2" value="<?php echo $smf_image_desc2; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">3.)</th>
    <td align="center"><input id="smf_image_title3" name="smf_image_title3" value="<?php echo $smf_image_title3; ?>" class="description"/></td>
<td align="center"><input id="smf_image_src3" name="smf_image_src3" value="<?php echo $smf_image_src3; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src3; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc3" name="smf_image_desc3" value="<?php echo $smf_image_desc3; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">4.)</th>
    <td align="center"><input id="smf_image_title4" name="smf_image_title4" value="<?php echo $smf_image_title4; ?>" class="description"/></td>
<td align="center"><input id="smf_image_src4" name="smf_image_src4" value="<?php echo $smf_image_src4; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src4; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc4" name="smf_image_desc4" value="<?php echo $smf_image_desc4; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">5.)</th>
    <td align="center"><input id="smf_image_title5" name="smf_image_title5" value="<?php echo $smf_image_title5; ?>" class="description"/></td>
<td align="center"><input id="smf_image_src5" name="smf_image_src5" value="<?php echo $smf_image_src5; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src5; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc5" name="smf_image_desc5" value="<?php echo $smf_image_desc5; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">6.)</th>
    <td align="center"><input id="smf_image_title6" name="smf_image_title6" value="<?php echo $smf_image_title6; ?>" class="description"/></td>
<td align="center"><input id="smf_image_src6" name="smf_image_src6" value="<?php echo $smf_image_src6; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src6; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc6" name="smf_image_desc6" value="<?php echo $smf_image_desc6; ?>" class="desc"/></td>   
</tr>

  <tr>
<th scope="row">7.)</th>
    <td align="center"><input id="smf_image_title7" name="smf_image_title7" value="<?php echo $smf_image_title7; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src7" name="smf_image_src7" value="<?php echo $smf_image_src7; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src7; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc7" name="smf_image_desc7" value="<?php echo $smf_image_desc7; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">8.)</th>
    <td align="center"><input id="smf_image_title8" name="smf_image_title8" value="<?php echo $smf_image_title8; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src8" name="smf_image_src8" value="<?php echo $smf_image_src8; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src8; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc8" name="smf_image_desc8" value="<?php echo $smf_image_desc8; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">9.)</th>
    <td align="center"><input id="smf_image_title9" name="smf_image_title9" value="<?php echo $smf_image_title9; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src9" name="smf_image_src9" value="<?php echo $smf_image_src9; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src9; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc9" name="smf_image_desc9" value="<?php echo $smf_image_desc9; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">10.)</th>
    <td align="center"><input id="smf_image_title10" name="smf_image_title10" value="<?php echo $smf_image_title10; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src10" name="smf_image_src10" value="<?php echo $smf_image_src10; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src10; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc10" name="smf_image_desc10" value="<?php echo $smf_image_desc10; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">11.)</th>
    <td align="center"><input id="smf_image_title11" name="smf_image_title11" value="<?php echo $smf_image_title11; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src11" name="smf_image_src11" value="<?php echo $smf_image_src11; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src11; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc11" name="smf_image_desc11" value="<?php echo $smf_image_desc11; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">12.)</th>
    <td align="center"><input id="smf_image_title12" name="smf_image_title12" value="<?php echo $smf_image_title12; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src12" name="smf_image_src12" value="<?php echo $smf_image_src12; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src12; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc12" name="smf_image_desc12" value="<?php echo $smf_image_desc12; ?>" class="desc"/></td>   
</tr>
  <tr>
<th scope="row">13.)</th>
    <td align="center"><input id="smf_image_title13" name="smf_image_title13" value="<?php echo $smf_image_title13; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src13" name="smf_image_src13" value="<?php echo $smf_image_src13; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src13; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc13" name="smf_image_desc13" value="<?php echo $smf_image_desc13; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">14.)</th>
    <td align="center"><input id="smf_image_title14" name="smf_image_title14" value="<?php echo $smf_image_title14; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src14" name="smf_image_src14" value="<?php echo $smf_image_src14; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src14; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc14" name="smf_image_desc14" value="<?php echo $smf_image_desc14; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">15.)</th>
    <td align="center"><input id="smf_image_title15" name="smf_image_title15" value="<?php echo $smf_image_title15; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src15" name="smf_image_src15" value="<?php echo $smf_image_src15; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src15; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc15" name="smf_image_desc15" value="<?php echo $smf_image_desc15; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">16.)</th>
    <td align="center"><input id="smf_image_title16" name="smf_image_title16" value="<?php echo $smf_image_title16; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src16" name="smf_image_src16" value="<?php echo $smf_image_src16; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src16; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc16" name="smf_image_desc16" value="<?php echo $smf_image_desc16; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">17.)</th>
    <td align="center"><input id="smf_image_title17" name="smf_image_title17" value="<?php echo $smf_image_title17; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src17" name="smf_image_src17" value="<?php echo $smf_image_src17; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src17; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc17" name="smf_image_desc17" value="<?php echo $smf_image_desc17; ?>" class="desc"/></td>
</tr>

  <tr>
<th scope="row">18.)</th>
    <td align="center"><input id="smf_image_title18" name="smf_image_title18" value="<?php echo $smf_image_title18; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src18" name="smf_image_src18" value="<?php echo $smf_image_src18; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src18; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc18" name="smf_image_desc18" value="<?php echo $smf_image_desc18; ?>" class="desc"/></td>   
</tr>

  <tr>
<th scope="row">19.)</th>
    <td align="center"><input id="smf_image_title19" name="smf_image_title19" value="<?php echo $smf_image_title19; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src19" name="smf_image_src19" value="<?php echo $smf_image_src19; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src19; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc19" name="smf_image_desc19" value="<?php echo $smf_image_desc19; ?>" class="desc"/></td>    
</tr>

  <tr>
<th scope="row">20.)</th>
    <td align="center"><input id="smf_image_title20" name="smf_image_title20" value="<?php echo $smf_image_title20; ?>" class="description"/></td>
    <td align="center"><input id="smf_image_src20" name="smf_image_src20" value="<?php echo $smf_image_src20; ?>" class="quantity"/>
	<input id="upload_image_button" class="upload_image_button" type="button" value="Upload Image" /></td>
<td><img src="<?php echo $smf_image_src20; ?>" style="float:left;width:90px;height:90px;"></td>
    <td align="center"><input id="smf_image_desc20" name="smf_image_desc20" value="<?php echo $smf_image_desc20; ?>" class="desc"/></td>
</tr>

</table>    
</div>   

        <?php  
            }  
            
        function add_smartfolio_details(){
            add_meta_box('smartfolio_details', __('smartFolio Items', 'smf_smartfolio_details'), 'smartfolio_details', 'smartfolios', 'normal', 'high');  
        }
        add_action('admin_init', 'add_smartfolio_details');  

/*====================== Saves all Custom Field Data ======================*/    
	function save_meta_smartfolio($post_id){  
		
		if (!wp_verify_nonce($_POST['smf-nonce'], 'sm-f')) return $post_id;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	    update_post_meta($post_id, "smf_album_title", $_POST["smf_album_title"]);
	    update_post_meta($post_id, "smf_image_title", $_POST["smf_image_title"]);
	    update_post_meta($post_id, "smf_image_desc", $_POST["smf_image_desc"]);  
	    update_post_meta($post_id, "smf_image_src", $_POST["smf_image_src"]);   
	    update_post_meta($post_id, "smf_image_title2", $_POST["smf_image_title2"]);
	    update_post_meta($post_id, "smf_image_desc2", $_POST["smf_image_desc2"]); 
	    update_post_meta($post_id, "smf_image_src2", $_POST["smf_image_src2"]);   
	    update_post_meta($post_id, "smf_image_title3", $_POST["smf_image_title3"]);
	    update_post_meta($post_id, "smf_image_desc3", $_POST["smf_image_desc3"]);  
	    update_post_meta($post_id, "smf_image_src3", $_POST["smf_image_src3"]);   
	    update_post_meta($post_id, "smf_image_title4", $_POST["smf_image_title4"]);
	    update_post_meta($post_id, "smf_image_desc4", $_POST["smf_image_desc4"]); 
	    update_post_meta($post_id, "smf_image_src4", $_POST["smf_image_src4"]);    
	    update_post_meta($post_id, "smf_image_title5", $_POST["smf_image_title5"]);
	    update_post_meta($post_id, "smf_image_desc5", $_POST["smf_image_desc5"]); 
	    update_post_meta($post_id, "smf_image_src5", $_POST["smf_image_src5"]);    
	    update_post_meta($post_id, "smf_image_title6", $_POST["smf_image_title6"]);
	    update_post_meta($post_id, "smf_image_desc6", $_POST["smf_image_desc6"]);   
	    update_post_meta($post_id, "smf_image_src6", $_POST["smf_image_src6"]);  
	    update_post_meta($post_id, "smf_image_title7", $_POST["smf_image_title7"]);
	    update_post_meta($post_id, "smf_image_desc7", $_POST["smf_image_desc7"]);  
	    update_post_meta($post_id, "smf_image_src7", $_POST["smf_image_src7"]); 
	    update_post_meta($post_id, "smf_image_title8", $_POST["smf_image_title8"]);
	    update_post_meta($post_id, "smf_image_desc8", $_POST["smf_image_desc8"]);  
	    update_post_meta($post_id, "smf_image_src8", $_POST["smf_image_src8"]); 
	    update_post_meta($post_id, "smf_image_title9", $_POST["smf_image_title9"]);
	    update_post_meta($post_id, "smf_image_desc9", $_POST["smf_image_desc9"]);  
	    update_post_meta($post_id, "smf_image_src9", $_POST["smf_image_src9"]); 
	    update_post_meta($post_id, "smf_image_title10", $_POST["smf_image_title10"]);
	    update_post_meta($post_id, "smf_image_desc10", $_POST["smf_image_desc10"]);  
	    update_post_meta($post_id, "smf_image_src10", $_POST["smf_image_src10"]); 
            update_post_meta($post_id, "smf_image_title11", $_POST["smf_image_title11"]);
	    update_post_meta($post_id, "smf_image_desc11", $_POST["smf_image_desc11"]);  
	    update_post_meta($post_id, "smf_image_src11", $_POST["smf_image_src11"]);   
	    update_post_meta($post_id, "smf_image_title12", $_POST["smf_image_title12"]);
	    update_post_meta($post_id, "smf_image_desc12", $_POST["smf_image_desc12"]); 
	    update_post_meta($post_id, "smf_image_src12", $_POST["smf_image_src12"]);   
	    update_post_meta($post_id, "smf_image_title13", $_POST["smf_image_title13"]);
	    update_post_meta($post_id, "smf_image_desc13", $_POST["smf_image_desc13"]);  
	    update_post_meta($post_id, "smf_image_src13", $_POST["smf_image_src13"]);   
	    update_post_meta($post_id, "smf_image_title14", $_POST["smf_image_title14"]);
	    update_post_meta($post_id, "smf_image_desc14", $_POST["smf_image_desc14"]); 
	    update_post_meta($post_id, "smf_image_src14", $_POST["smf_image_src14"]);    
	    update_post_meta($post_id, "smf_image_title15", $_POST["smf_image_title15"]);
	    update_post_meta($post_id, "smf_image_desc15", $_POST["smf_image_desc15"]); 
	    update_post_meta($post_id, "smf_image_src15", $_POST["smf_image_src15"]);    
	    update_post_meta($post_id, "smf_image_title16", $_POST["smf_image_title16"]);
	    update_post_meta($post_id, "smf_image_desc16", $_POST["smf_image_desc16"]);   
	    update_post_meta($post_id, "smf_image_src16", $_POST["smf_image_src16"]);  
	    update_post_meta($post_id, "smf_image_title17", $_POST["smf_image_title17"]);
	    update_post_meta($post_id, "smf_image_desc17", $_POST["smf_image_desc17"]);  
	    update_post_meta($post_id, "smf_image_src17", $_POST["smf_image_src17"]); 
	    update_post_meta($post_id, "smf_image_title18", $_POST["smf_image_title18"]);
	    update_post_meta($post_id, "smf_image_desc18", $_POST["smf_image_desc18"]);  
	    update_post_meta($post_id, "smf_image_src18", $_POST["smf_image_src18"]); 
	    update_post_meta($post_id, "smf_image_title19", $_POST["smf_image_title19"]);
	    update_post_meta($post_id, "smf_image_desc19", $_POST["smf_image_desc19"]);  
	    update_post_meta($post_id, "smf_image_src19", $_POST["smf_image_src19"]); 
	    update_post_meta($post_id, "smf_image_title20", $_POST["smf_image_title20"]);
	    update_post_meta($post_id, "smf_image_desc20", $_POST["smf_image_desc20"]);  
	    update_post_meta($post_id, "smf_image_src20", $_POST["smf_image_src20"]); 
	      
	}  
	
	
add_action('save_post', 'save_meta_smartfolio'); 
