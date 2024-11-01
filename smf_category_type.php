<?php 
/**
 * 
 * CashPress
 * Custom post type and admin input fields for invoices and related features
 * 
**/

add_action('init', 'invoices');

function invoices() 
{
  $labels = array(
    'name' => _x('Invoices', 'post type general name'),
    'singular_name' => _x('Invoice', 'post type singular name'),
    'add_new' => _x('New Invoice', 'invoice'),
    'add_new_item' => __('Create New Invoice'),
    'edit_item' => __('Edit Invoice'),
    'new_item' => __('New Invoice'),
    'view_item' => __('View Invoice'),
    'search_items' => __('Search Invoices'),
    'not_found' =>  __('No invoices found'),
    'not_found_in_trash' => __('No invoices found in Trash'), 
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
    'menu_position' => 27,
    'menu_icon' => plugins_url() . '/cashpress/images/invoice.gif',
    'supports' => array('')
  ); 
  register_post_type('invoices',$args);
}

// Add filter to insure the invoice is displayed when user updates an invoice
add_filter('post_updated_messages', 'invoice_updated_messages');

function invoice_updated_messages( $messages ) {

$messages['invoices'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Invoice updated. <a href="%s">View invoice</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Invoice updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Invoice restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Invoice published. <a href="%s">View invoice</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('Invoice saved.'),
    8 => sprintf( __('Invoice submitted. <a target="_blank" href="%s">Preview invoice</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Invoice scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview invoice</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Invoice draft updated. <a target="_blank" href="%s">Preview invoice</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// Remove "Protected" from titles
function title_trim($title)
{
$pattern[0] = '/Protected:/';
$pattern[1] = '/Private:/';
$replacement[0] = ''; // Enter some text to put in place of Protected:
$replacement[1] = ''; // Enter some text to put in place of Private:

return preg_replace($pattern, $replacement, $title);
}

add_filter('the_title', 'title_trim');

  
/*========================= First Custom Field Section ========================*/
	function invoice_metadata(){  
        global $post; 
        $custom = get_post_custom($post->ID); 
        $inv_number = $custom["inv_number"][0];  
        $due_date = $custom["due_date"][0];
	$csp_jobsiteaddress1 = $custom["csp_jobsiteaddress1"][0]; 
        $csp_jobsiteaddress2 = $custom["csp_jobsiteaddress2"][0]; 
        $client = $custom["client"][0]; 
        $invoice_status = $custom["invoice_status"][0];
        $clientname = get_posts('post_type=clients&numberposts=-1');
        
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
?>  <body onmousemove="getGLabTotal(); getGMatTotal();">
	<div class="invoice_metadata">
	<label><?php _e("Invoice Number:",'clientmachine'); ?></label><input name="inv_number" value="<?php if ($inv_number == ""){ echo $post->ID; }else{ echo $inv_number; } ?>" /><br/>
    <label><?php _e("Due Date:",'clientmachine'); ?></label><input name="due_date" value="<?php echo $due_date; ?>" /><br/>
    <label><?php _e("Jobsite Street Address",'clientmachine'); ?></label><input name="csp_jobsiteaddress1" value="<?php echo $csp_jobsiteaddress1; ?>" /><br/> 
    <br/>
<label><?php _e("Jobsite City, State, Zip",'clientmachine'); ?></label><input name="csp_jobsiteaddress2" value="<?php echo $csp_jobsiteaddress2; ?>" /><br/> 
    <br/>
 
    <label><?php _e("Client:",'clientmachine'); ?></label>
    <select name="client">
    	<option selected="yes" ><?php echo $client; ?></option>
    	<?php 
    	foreach($clientname as $cspvalue){
    	echo '<option>' . $cspvalue->post_title . '</option>' ."\n";
    	}
		?>
    </select>
    <br/>
    <label><?php _e("Invoice Status:",'clientmachine'); ?></label>
    <select name="invoice_status">
    	<option selected="yes" ><?php echo $invoice_status; ?></option>
    	<option>Draft</option>
    	<option>Sent</option>
    	<option>Overdue</option>
    	<option>Paid</option>
    </select>
    </div>
<?php  
}  
    
function add_invoice_metadata(){  
        add_meta_box('invoice_metadata', __('Invoice Options', 'csp_invoice_metadata'), 'invoice_metadata', 'invoices', 'side', 'low');  
} 
    
add_action('admin_init', 'add_invoice_metadata'); 
    
    

/*====================== Second Custom Field Section ======================*/    
function invoice_details(){  
            global $post; 
                $custom = get_post_custom($post->ID);  
                $csp_material_item = $custom["csp_material_item"][0]; 
            $csp_material_cost = $custom["csp_material_cost"][0];
            $csp_material_qty = $custom["csp_material_qty"][0];
            $csp_material_item2 = $custom["csp_material_item2"][0]; 
            $csp_material_cost2 = $custom["csp_material_cost2"][0]; 
            $csp_material_qty2 = $custom["csp_material_qty2"][0];
            $csp_material_item3 = $custom["csp_material_item3"][0]; 
            $csp_material_cost3 = $custom["csp_material_cost3"][0]; 
            $csp_material_qty3 = $custom["csp_material_qty3"][0];
            $csp_material_item4 = $custom["csp_material_item4"][0]; 
            $csp_material_cost4 = $custom["csp_material_cost4"][0]; 
            $csp_material_qty4 = $custom["csp_material_qty4"][0];
            $csp_material_item5 = $custom["csp_material_item5"][0]; 
            $csp_material_cost5 = $custom["csp_material_cost5"][0]; 
            $csp_material_qty5 = $custom["csp_material_qty5"][0];
            $csp_material_item6 = $custom["csp_material_item6"][0]; 
            $csp_material_cost6 = $custom["csp_material_cost6"][0]; 
            $csp_material_qty6 = $custom["csp_material_qty6"][0];
            $csp_material_item7 = $custom["csp_material_item7"][0]; 
            $csp_material_cost7 = $custom["csp_material_cost7"][0];
            $csp_material_qty7 = $custom["csp_material_qty7"][0];  
            $csp_material_item8 = $custom["csp_material_item8"][0]; 
            $csp_material_cost8 = $custom["csp_material_cost8"][0];
            $csp_material_qty8 = $custom["csp_material_qty8"][0];  
            $csp_material_item9 = $custom["csp_material_item9"][0]; 
            $csp_material_cost9 = $custom["csp_material_cost9"][0];
            $csp_material_qty9 = $custom["csp_material_qty9"][0];  
	    $csp_material_item10 = $custom["csp_material_item10"][0]; 
            $csp_material_cost10 = $custom["csp_material_cost10"][0];
            $csp_material_qty10 = $custom["csp_material_qty10"][0];
	    $csp_material_item11 = $custom["csp_material_item11"][0]; 
            $csp_material_cost11 = $custom["csp_material_cost11"][0];
            $csp_material_qty11 = $custom["csp_material_qty11"][0];
            $csp_material_item12 = $custom["csp_material_item12"][0]; 
            $csp_material_cost12 = $custom["csp_material_cost12"][0]; 
            $csp_material_qty12 = $custom["csp_material_qty12"][0];
            $csp_material_item13 = $custom["csp_material_item13"][0]; 
            $csp_material_cost13 = $custom["csp_material_cost13"][0]; 
            $csp_material_qty13 = $custom["csp_material_qty13"][0];
            $csp_material_item14 = $custom["csp_material_item14"][0]; 
            $csp_material_cost14 = $custom["csp_material_cost14"][0]; 
            $csp_material_qty14 = $custom["csp_material_qty14"][0];
            $csp_material_item15 = $custom["csp_material_item15"][0]; 
            $csp_material_cost15 = $custom["csp_material_cost15"][0]; 
            $csp_material_qty15 = $custom["csp_material_qty15"][0];
            $csp_material_item16 = $custom["csp_material_item16"][0]; 
            $csp_material_cost16 = $custom["csp_material_cost16"][0]; 
            $csp_material_qty16 = $custom["csp_material_qty16"][0];
            $csp_material_item17 = $custom["csp_material_item17"][0]; 
            $csp_material_cost17 = $custom["csp_material_cost17"][0];
            $csp_material_qty17 = $custom["csp_material_qty17"][0];  
            $csp_material_item18 = $custom["csp_material_item18"][0]; 
            $csp_material_cost18 = $custom["csp_material_cost18"][0];
            $csp_material_qty18 = $custom["csp_material_qty18"][0];  
            $csp_material_item19 = $custom["csp_material_item19"][0]; 
            $csp_material_cost19 = $custom["csp_material_cost19"][0];
            $csp_material_qty19 = $custom["csp_material_qty19"][0];  
	    $csp_material_item20 = $custom["csp_material_item20"][0]; 
            $csp_material_cost20 = $custom["csp_material_cost20"][0];
            $csp_material_qty20 = $custom["csp_material_qty20"][0];  
	    $csp_taxrate = $custom["csp_taxrate"][0];  
            $csp_total_adjustment = $custom["csp_total_adjustment"][0]; 
    	    $csp_material_total[1] = ($custom['csp_material_cost'][0]*$custom['csp_material_qty'][0]);
    	    $csp_material_total[2] = ($custom['csp_material_cost2'][0]*$custom['csp_material_qty2'][0]);
    	    $csp_material_total[3] = ($custom['csp_material_cost3'][0]*$custom['csp_material_qty3'][0]);
    	    $csp_material_total[4] = ($custom['csp_material_cost4'][0]*$custom['csp_material_qty4'][0]);
    	    $csp_material_total[5] = ($custom['csp_material_cost5'][0]*$custom['csp_material_qty5'][0]);
    	    $csp_material_total[6] = ($custom['csp_material_cost6'][0]*$custom['csp_material_qty6'][0]);
    	    $csp_material_total[7] = ($custom['csp_material_cost7'][0]*$custom['csp_material_qty7'][0]);
    	    $csp_material_total[8] = ($custom['csp_material_cost8'][0]*$custom['csp_material_qty8'][0]);
    	    $csp_material_total[9] = ($custom['csp_material_cost9'][0]*$custom['csp_material_qty9'][0]);
    	    $csp_material_total[10] = ($custom['csp_material_cost10'][0]*$custom['csp_material_qty10'][0]);
    	    $csp_material_total[11] = ($custom['csp_material_cost11'][0]*$custom['csp_material_qty11'][0]);
    	    $csp_material_total[12] = ($custom['csp_material_cost12'][0]*$custom['csp_material_qty12'][0]);
    	    $csp_material_total[13] = ($custom['csp_material_cost13'][0]*$custom['csp_material_qty13'][0]);
    	    $csp_material_total[14] = ($custom['csp_material_cost14'][0]*$custom['csp_material_qty14'][0]);
    	    $csp_material_total[15] = ($custom['csp_material_cost15'][0]*$custom['csp_material_qty15'][0]);
    	    $csp_material_total[16] = ($custom['csp_material_cost16'][0]*$custom['csp_material_qty16'][0]);
    	    $csp_material_total[17] = ($custom['csp_material_cost17'][0]*$custom['csp_material_qty17'][0]);
    	    $csp_material_total[18] = ($custom['csp_material_cost18'][0]*$custom['csp_material_qty18'][0]);
    	    $csp_material_total[19] = ($custom['csp_material_cost19'][0]*$custom['csp_material_qty19'][0]);
    	    $csp_material_total[20] = ($custom['csp_material_cost20'][0]*$custom['csp_material_qty20'][0]);
    	    $csp_material_subtotal = array_sum($csp_material_total);
    	    $csp_total_tax = ($csp_material_subtotal*$csp_taxrate);
            $mat_total = ($csp_material_subtotal + $csp_total_tax + $csp_total_adjustment);
    
            
            
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
            
    ?>  
    <div class="proposal_check">
   <script type="text/javascript">
	function getMatTotal() {    
    		var userInput = document.getElementById('csp_material_cost').value * document.getElementById('csp_material_qty').value;
	document.getElementById('csp_item_subtotal').value = userInput;
	}
	function getMatTotal2() {    
    		var userInput = document.getElementById('csp_material_cost2').value * document.getElementById('csp_material_qty2').value;
	document.getElementById('csp_item_subtotal2').value = userInput;
	}
	function getMatTotal3() {    
    		var userInput = document.getElementById('csp_material_cost3').value * document.getElementById('csp_material_qty3').value;
	document.getElementById('csp_item_subtotal3').value = userInput;
	}
	function getMatTotal4() {    
    		var userInput = document.getElementById('csp_material_cost4').value * document.getElementById('csp_material_qty4').value;
	document.getElementById('csp_item_subtotal4').value = userInput;
	}
	function getMatTotal5() {    
    		var userInput = document.getElementById('csp_material_cost5').value * document.getElementById('csp_material_qty5').value;
	document.getElementById('csp_item_subtotal5').value = userInput;
	}
	function getMatTotal6() {    
    		var userInput = document.getElementById('csp_material_cost6').value * document.getElementById('csp_material_qty6').value;
	document.getElementById('csp_item_subtotal6').value = userInput;
	}
	function getMatTotal7() {    
    		var userInput = document.getElementById('csp_material_cost7').value * document.getElementById('csp_material_qty7').value;
	document.getElementById('csp_item_subtotal7').value = userInput;
	}
	function getMatTotal8() {    
    		var userInput = document.getElementById('csp_material_cost8').value * document.getElementById('csp_material_qty8').value;
	document.getElementById('csp_item_subtotal8').value = userInput;
	}
	function getMatTotal9() {    
    		var userInput = document.getElementById('csp_material_cost9').value * document.getElementById('csp_material_qty9').value;
	document.getElementById('csp_item_subtotal9').value = userInput;
	}
	function getMatTotal10() {    
    		var userInput = document.getElementById('csp_material_cost10').value * document.getElementById('csp_material_qty10').value;
	document.getElementById('csp_item_subtotal10').value = userInput;
	}
	function getMatTotal11() {    
    		var userInput = document.getElementById('csp_material_cost11').value * document.getElementById('csp_material_qty11').value;
	document.getElementById('csp_item_subtotal11').value = userInput;
	}
	function getMatTotal12() {    
    		var userInput = document.getElementById('csp_material_cost12').value * document.getElementById('csp_material_qty12').value;
	document.getElementById('csp_item_subtotal12').value = userInput;
	}
	function getMatTotal13() {    
    		var userInput = document.getElementById('csp_material_cost13').value * document.getElementById('csp_material_qty13').value;
	document.getElementById('csp_item_subtotal13').value = userInput;
	}
	function getMatTotal14() {    
    		var userInput = document.getElementById('csp_material_cost14').value * document.getElementById('csp_material_qty14').value;
	document.getElementById('csp_item_subtotal14').value = userInput;
	}
	function getMatTotal15() {    
    		var userInput = document.getElementById('csp_material_cost15').value * document.getElementById('csp_material_qty15').value;
	document.getElementById('csp_item_subtotal15').value = userInput;
	}
	function getMatTotal16() {    
    		var userInput = document.getElementById('csp_material_cost16').value * document.getElementById('csp_material_qty16').value;
	document.getElementById('csp_item_subtotal16').value = userInput;
	}
	function getMatTotal17() {    
    		var userInput = document.getElementById('csp_material_cost17').value * document.getElementById('csp_material_qty17').value;
	document.getElementById('csp_item_subtotal17').value = userInput;
	}
	function getMatTotal18() {    
    		var userInput = document.getElementById('csp_material_cost18').value * document.getElementById('csp_material_qty18').value;
	document.getElementById('csp_item_subtotal18').value = userInput;
	}
	function getMatTotal19() {    
    		var userInput = document.getElementById('csp_material_cost19').value * document.getElementById('csp_material_qty19').value;
	document.getElementById('csp_item_subtotal19').value = userInput;
	}
	function getMatTotal20() {    
    		var userInput = document.getElementById('csp_material_cost20').value * document.getElementById('csp_material_qty20').value;
	document.getElementById('csp_item_subtotal20').value = userInput;
	}
	function getMatTotalTax() {    
    		var userInput = document.getElementById('csp_taxrate').value * document.getElementById('mat_subtotal').value;
	document.getElementById('csp_total_tax').value = userInput; document.getElementById('csp_total_tax2').value = userInput;
	}	
	function getGMatTotal() {    
    		A = document.getElementById('csp_item_subtotal').value
		B = document.getElementById('csp_item_subtotal2').value 
		C = document.getElementById('csp_item_subtotal3').value  
		D = document.getElementById('csp_item_subtotal4').value
		E = document.getElementById('csp_item_subtotal5').value 
		F = document.getElementById('csp_item_subtotal6').value
		G = document.getElementById('csp_item_subtotal7').value 
		H = document.getElementById('csp_item_subtotal8').value
		I = document.getElementById('csp_item_subtotal9').value
		J = document.getElementById('csp_item_subtotal10').value 
		K = document.getElementById('csp_item_subtotal11').value 
		L = document.getElementById('csp_item_subtotal12').value 
		M = document.getElementById('csp_item_subtotal13').value 
		N = document.getElementById('csp_item_subtotal14').value 
		O = document.getElementById('csp_item_subtotal15').value 
		P = document.getElementById('csp_item_subtotal16').value 
		Q = document.getElementById('csp_item_subtotal17').value 
		R = document.getElementById('csp_item_subtotal18').value
		S = document.getElementById('csp_item_subtotal19').value
		T = document.getElementById('csp_item_subtotal20').value
		U = document.getElementById('csp_total_tax').value
		V = document.getElementById('csp_total_adjustment').value
		A = Number(A)
		B = Number(B)
		C = Number(C)
		D = Number(D)
		E = Number(E)
		F = Number(F)
		G = Number(G)
		H = Number(H)
		I = Number(I)
		J = Number(J)
		K = Number(K)
		L = Number(L)
		M = Number(M)
		N = Number(N)
		O = Number(O)
		P = Number(P)
		Q = Number(Q)
		R = Number(R)
		S = Number(S)
		T = Number(T)
		U = Number(U)
		V = Number(V)
		W = (A + B + C + D + E + F + G + H + I + J + K + L + M + N + O + P + Q + R + S + T)		
		X = (A + B + C + D + E + F + G + H + I + J + K + L + M + N + O + P + Q + R + S + T + U + V)		
		document.getElementById('mat_subtotal').value = W
		document.getElementById('mat_subtotal2').value = W
		document.getElementById('csp_total_mat').value = X

	}
	function getLabTotal() {    
    		var userInput = document.getElementById('csp_labor_cost').value * document.getElementById('csp_labor_qty').value;
	document.getElementById('csp_labor_item_subtotal').value = userInput;
	}
	function getLabTotal2() {    
    		var userInput = document.getElementById('csp_labor_cost2').value * document.getElementById('csp_labor_qty2').value;
	document.getElementById('csp_labor_item_subtotal2').value = userInput;
	}
	function getLabTotal3() {    
    		var userInput = document.getElementById('csp_labor_cost3').value * document.getElementById('csp_labor_qty3').value;
	document.getElementById('csp_labor_item_subtotal3').value = userInput;
	}
	function getLabTotal4() {    
    		var userInput = document.getElementById('csp_labor_cost4').value * document.getElementById('csp_labor_qty4').value;
	document.getElementById('csp_labor_item_subtotal4').value = userInput;
	}
	function getLabTotal5() {    
    		var userInput = document.getElementById('csp_labor_cost5').value * document.getElementById('csp_labor_qty5').value;
	document.getElementById('csp_labor_item_subtotal5').value = userInput;
	}
	function getLabTotal6() {    
    		var userInput = document.getElementById('csp_labor_cost6').value * document.getElementById('csp_labor_qty6').value;
	document.getElementById('csp_labor_item_subtotal6').value = userInput;
	}
	function getLabTotal7() {    
    		var userInput = document.getElementById('csp_labor_cost7').value * document.getElementById('csp_labor_qty7').value;
	document.getElementById('csp_labor_item_subtotal7').value = userInput;
	}
	function getLabTotal8() {    
    		var userInput = document.getElementById('csp_labor_cost8').value * document.getElementById('csp_labor_qty8').value;
	document.getElementById('csp_labor_item_subtotal8').value = userInput;
	}
	function getLabTotal9() {    
    		var userInput = document.getElementById('csp_labor_cost9').value * document.getElementById('csp_labor_qty9').value;
	document.getElementById('csp_labor_item_subtotal9').value = userInput;
	}
	function getLabTotal10() {    
    		var userInput = document.getElementById('csp_labor_cost10').value * document.getElementById('csp_labor_qty10').value;
	document.getElementById('csp_labor_item_subtotal10').value = userInput;
	}
	function getLabTotal11() {    
    		var userInput = document.getElementById('csp_labor_cost11').value * document.getElementById('csp_labor_qty11').value;
	document.getElementById('csp_labor_item_subtotal11').value = userInput;
	}
	function getLabTotal12() {    
    		var userInput = document.getElementById('csp_labor_cost12').value * document.getElementById('csp_labor_qty12').value;
	document.getElementById('csp_labor_item_subtotal12').value = userInput;
	}
	function getLabTotal13() {    
    		var userInput = document.getElementById('csp_labor_cost13').value * document.getElementById('csp_labor_qty13').value;
	document.getElementById('csp_labor_item_subtotal13').value = userInput;
	}
	function getLabTotal14() {    
    		var userInput = document.getElementById('csp_labor_cost14').value * document.getElementById('csp_labor_qty14').value;
	document.getElementById('csp_labor_item_subtotal14').value = userInput;
	}
	function getLabTotal15() {    
    		var userInput = document.getElementById('csp_labor_cost15').value * document.getElementById('csp_labor_qty15').value;
	document.getElementById('csp_labor_item_subtotal15').value = userInput;
	}
	function getLabTotal16() {    
    		var userInput = document.getElementById('csp_labor_cost16').value * document.getElementById('csp_labor_qty16').value;
	document.getElementById('csp_labor_item_subtotal16').value = userInput;
	}
	function getLabTotal17() {    
    		var userInput = document.getElementById('csp_labor_cost17').value * document.getElementById('csp_labor_qty17').value;
	document.getElementById('csp_labor_item_subtotal17').value = userInput;
	}
	function getLabTotal18() {    
    		var userInput = document.getElementById('csp_labor_cost18').value * document.getElementById('csp_labor_qty18').value;
	document.getElementById('csp_labor_item_subtotal18').value = userInput;
	}
	function getLabTotal19() {    
    		var userInput = document.getElementById('csp_labor_cost19').value * document.getElementById('csp_labor_qty19').value;
	document.getElementById('csp_labor_item_subtotal19').value = userInput;
	}
	function getLabTotal20() {    
    		var userInput = document.getElementById('csp_labor_cost20').value * document.getElementById('csp_labor_qty20').value;
	document.getElementById('csp_labor_item_subtotal20').value = userInput;
	}
	function getGLabTotal() {    
    		A = document.getElementById('csp_labor_item_subtotal').value
		B = document.getElementById('csp_labor_item_subtotal2').value 
		C = document.getElementById('csp_labor_item_subtotal3').value  
		D = document.getElementById('csp_labor_item_subtotal4').value
		E = document.getElementById('csp_labor_item_subtotal5').value 
		F = document.getElementById('csp_labor_item_subtotal6').value
		G = document.getElementById('csp_labor_item_subtotal7').value 
		H = document.getElementById('csp_labor_item_subtotal8').value
		I = document.getElementById('csp_labor_item_subtotal9').value
		J = document.getElementById('csp_labor_item_subtotal10').value 
		K = document.getElementById('csp_labor_item_subtotal11').value 
		L = document.getElementById('csp_labor_item_subtotal12').value 
		M = document.getElementById('csp_labor_item_subtotal13').value 
		N = document.getElementById('csp_labor_item_subtotal14').value 
		O = document.getElementById('csp_labor_item_subtotal15').value 
		P = document.getElementById('csp_labor_item_subtotal16').value 
		Q = document.getElementById('csp_labor_item_subtotal17').value 
		R = document.getElementById('csp_labor_item_subtotal18').value
		S = document.getElementById('csp_labor_item_subtotal19').value
		T = document.getElementById('csp_labor_item_subtotal20').value
		U = document.getElementById('mat_subtotal').value
		V = document.getElementById('csp_total_tax').value
		W = document.getElementById('csp_total_adjustment').value
		A = Number(A)
		B = Number(B)
		C = Number(C)
		D = Number(D)
		E = Number(E)
		F = Number(F)
		G = Number(G)
		H = Number(H)
		I = Number(I)
		J = Number(J)
		K = Number(K)
		L = Number(L)
		M = Number(M)
		N = Number(N)
		O = Number(O)
		P = Number(P)
		Q = Number(Q)
		R = Number(R)
		S = Number(S)
		T = Number(T)
		U = Number(U)
		V = Number(V)
		W = Number(W)
		Y = (A + B + C + D + E + F + G + H + I + J + K + L + M + N + O + P + Q + R + S + T)		
		Z = (A + B + C + D + E + F + G + H + I + J + K + L + M + N + O + P + Q + R + S + T + U + V + W)	
		document.getElementById('csp_total_adjustment2').value = W
		document.getElementById('laborsubtotal').value = Y
		document.getElementById('csp_total_pro').value = Z

	}
    </script> 	
<table>
  <tr>
    <th scope="col"><p></p></th>
    <th scope="col">Item/Description:</th>
    <th scope="col">Quantity</th>
    <th scope="col">Cost</th>
    <th scope="col">Subtotal</th>
  </tr>
  <tr>
<th scope="row">1.)</th>
    <td align="center"><input id="csp_material_item" name="csp_material_item" value="<?php echo $csp_material_item; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty" name="csp_material_qty" value="<?php echo $csp_material_qty; ?>" class="quantity" onkeyup="getMatTotal()" onkeyup="getMatTotal()"/></td>    
    <td align="center"><input id="csp_material_cost" name="csp_material_cost" value="<?php echo $csp_material_cost; ?>" class="cost" onkeyup="getMatTotal()" onkeyup="getMatTotal()"/></td>
    <td align="center"><input id="csp_item_subtotal" name="item_subtotal" value="<?php echo $csp_material_total[1]; ?>" DISABLED class="cost" onkeyup="getMatTotal()"/></td>    
</tr>

  <tr>
<th scope="row">2.)</th>
    <td align="center"><input id="csp_material_item2" name="csp_material_item2" value="<?php echo $csp_material_item2; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty2"name="csp_material_qty2" value="<?php echo $csp_material_qty2; ?>" class="quantity" onkeyup="getMatTotal2()"/></td>    
    <td align="center"><input id="csp_material_cost2" name="csp_material_cost2" value="<?php echo $csp_material_cost2; ?>" class="cost" onkeyup="getMatTotal2()"/></td>
    <td align="center"><input id="csp_item_subtotal2" name="item_subtotal" value="<?php echo $csp_material_total[2]; ?>" DISABLED class="cost" onkeyup="getMatTotal2()"/></td>    
</tr>

  <tr>
<th scope="row">3.)</th>
    <td align="center"><input id="csp_material_item3" name="csp_material_item3" value="<?php echo $csp_material_item3; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty3" name="csp_material_qty3" value="<?php echo $csp_material_qty3; ?>" class="quantity" onkeyup="getMatTotal3()"/></td>    
    <td align="center"><input id="csp_material_cost3" name="csp_material_cost3" value="<?php echo $csp_material_cost3; ?>" class="cost" onkeyup="getMatTotal3()"/></td>    
    <td align="center"><input id="csp_item_subtotal3" name="item_subtotal" value="<?php echo $csp_material_total[3]; ?>" DISABLED class="cost" onkeyup="getMatTotal3()"/></td>    
</tr>

  <tr>
<th scope="row">4.)</th>
    <td align="center"><input id="csp_material_item4" name="csp_material_item4" value="<?php echo $csp_material_item4; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty4" name="csp_material_qty4" value="<?php echo $csp_material_qty4; ?>" class="quantity" onkeyup="getMatTotal4()"/></td>    
    <td align="center"><input id="csp_material_cost4" name="csp_material_cost4" value="<?php echo $csp_material_cost4; ?>" class="cost" onkeyup="getMatTotal4()"/></td>    
    <td align="center"><input id="csp_item_subtotal4" name="item_subtotal" value="<?php echo $csp_material_total[4]; ?>" DISABLED class="cost" onkeyup="getMatTotal4()"/></td>    
</tr>

  <tr>
<th scope="row">5.)</th>
    <td align="center"><input id="csp_material_item5" name="csp_material_item5" value="<?php echo $csp_material_item5; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty5" name="csp_material_qty5" value="<?php echo $csp_material_qty5; ?>" class="quantity" onkeyup="getMatTotal5()"/></td>    
    <td align="center"><input id="csp_material_cost5" name="csp_material_cost5" value="<?php echo $csp_material_cost5; ?>" class="cost" onkeyup="getMatTotal5()"/></td>
    <td align="center"><input id="csp_item_subtotal5" name="item_subtotal" value="<?php echo $csp_material_total[5]; ?>" DISABLED class="cost" onkeyup="getMatTotal5()"/></td>    
</tr>

  <tr>
<th scope="row">6.)</th>
    <td align="center"><input id="csp_material_item6" name="csp_material_item6" value="<?php echo $csp_material_item6; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty6" name="csp_material_qty6" value="<?php echo $csp_material_qty6; ?>" class="quantity" onkeyup="getMatTotal6()"/></td>    
    <td align="center"><input id="csp_material_cost6" name="csp_material_cost6" value="<?php echo $csp_material_cost6; ?>" class="cost" onkeyup="getMatTotal6()"/></td>   
    <td align="center"><input id="csp_item_subtotal6" name="item_subtotal" value="<?php echo $csp_material_total[6]; ?>" DISABLED class="cost" onkeyup="getMatTotal6()"/></td>    
</tr>

  <tr>
<th scope="row">7.)</th>
    <td align="center"><input id="csp_material_item7" name="csp_material_item7" value="<?php echo $csp_material_item7; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty7" name="csp_material_qty7" value="<?php echo $csp_material_qty7; ?>" class="quantity" onkeyup="getMatTotal7()"/></td>    
    <td align="center"><input id="csp_material_cost7" name="csp_material_cost7" value="<?php echo $csp_material_cost7; ?>" class="cost" onkeyup="getMatTotal7()"/></td>
    <td align="center"><input id="csp_item_subtotal7" name="item_subtotal" value="<?php echo $csp_material_total[7]; ?>" DISABLED class="cost" onkeyup="getMatTotal7()"/></td>    
</tr>

  <tr>
<th scope="row">8.)</th>
    <td align="center"><input id="csp_material_item8" name="csp_material_item8" value="<?php echo $csp_material_item8; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty8" name="csp_material_qty8" value="<?php echo $csp_material_qty8; ?>" class="quantity" onkeyup="getMatTotal8()"/></td>    
    <td align="center"><input id="csp_material_cost8" name="csp_material_cost8" value="<?php echo $csp_material_cost8; ?>" class="cost" onkeyup="getMatTotal8()"/></td>
    <td align="center"><input id="csp_item_subtotal8" name="item_subtotal" value="<?php echo $csp_material_total[8]; ?>" DISABLED class="cost" onkeyup="getMatTotal8()"/></td>  
</tr>

  <tr>
<th scope="row">9.)</th>
    <td align="center"><input id="csp_material_item9" name="csp_material_item9" value="<?php echo $csp_material_item9; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty9" name="csp_material_qty9" value="<?php echo $csp_material_qty9; ?>" class="quantity" onkeyup="getMatTotal9()"/></td>    
    <td align="center"><input id="csp_material_cost9" name="csp_material_cost9" value="<?php echo $csp_material_cost9; ?>" class="cost" onkeyup="getMatTotal9()"/></td>    
    <td align="center"><input id="csp_item_subtotal9" name="item_subtotal" value="<?php echo $csp_material_total[9]; ?>" DISABLED class="cost" onkeyup="getMatTotal9()"/></td>    

</tr>

  <tr>
<th scope="row">10.)</th>
    <td align="center"><input id="csp_material_item10" name="csp_material_item10" value="<?php echo $csp_material_item10; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty10" name="csp_material_qty10" value="<?php echo $csp_material_qty10; ?>" class="quantity" onkeyup="getMatTotal10()"/></td>    
    <td align="center"><input id="csp_material_cost10" name="csp_material_cost10" value="<?php echo $csp_material_cost10; ?>" class="cost" onkeyup="getMatTotal10()"/></td>    
    <td align="center"><input id="csp_item_subtotal10" name="item_subtotal" value="<?php echo $csp_material_total[10]; ?>" DISABLED class="cost" onkeyup="getMatTotal10()"/></td>    
</tr>

  <tr>
<th scope="row">11.)</th>
    <td align="center"><input id="csp_material_item11" name="csp_material_item11" value="<?php echo $csp_material_item11; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty11" name="csp_material_qty11" value="<?php echo $csp_material_qty11; ?>" class="quantity" onkeyup="getMatTotal11()"/></td>    
    <td align="center"><input id="csp_material_cost11" name="csp_material_cost11" value="<?php echo $csp_material_cost11; ?>" class="cost" onkeyup="getMatTotal11()"/></td>
    <td align="center"><input id="csp_item_subtotal11" name="item_subtotal" value="<?php echo $csp_material_total[11]; ?>" DISABLED class="cost" onkeyup="getMatTotal11()"/></td>    

</tr>

  <tr>
<th scope="row">12.)</th>
    <td align="center"><input id="csp_material_item12" name="csp_material_item12" value="<?php echo $csp_material_item12; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty12" name="csp_material_qty12" value="<?php echo $csp_material_qty12; ?>" class="quantity" onkeyup="getMatTotal12()"/></td>    
    <td align="center"><input id="csp_material_cost12" name="csp_material_cost12" value="<?php echo $csp_material_cost12; ?>" class="cost" onkeyup="getMatTotal12()"/></td>   
    <td align="center"><input id="csp_item_subtotal12" name="item_subtotal" value="<?php echo $csp_material_total[12]; ?>" DISABLED class="cost" onkeyup="getMatTotal12()"/></td>    

</tr>
  <tr>
<th scope="row">13.)</th>
    <td align="center"><input id="csp_material_item13" name="csp_material_item13" value="<?php echo $csp_material_item13; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty13" name="csp_material_qty13" value="<?php echo $csp_material_qty13; ?>" class="quantity" onkeyup="getMatTotal13()"/></td>    
    <td align="center"><input id="csp_material_cost13" name="csp_material_cost13" value="<?php echo $csp_material_cost13; ?>" class="cost" onkeyup="getMatTotal13()"/></td>    
    <td align="center"><input id="csp_item_subtotal13" name="item_subtotal" value="<?php echo $csp_material_total[13]; ?>" DISABLED class="cost" onkeyup="getMatTotal13()"/></td>    

</tr>

  <tr>
<th scope="row">14.)</th>
    <td align="center"><input id="csp_material_item14" name="csp_material_item14" value="<?php echo $csp_material_item14; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty14" name="csp_material_qty14" value="<?php echo $csp_material_qty14; ?>" class="quantity" onkeyup="getMatTotal14()"/></td>    
    <td align="center"><input id="csp_material_cost14" name="csp_material_cost14" value="<?php echo $csp_material_cost14; ?>" class="cost" onkeyup="getMatTotal14()"/></td>
    <td align="center"><input id="csp_item_subtotal14" name="item_subtotal" value="<?php echo $csp_material_total[14]; ?>" DISABLED class="cost" onkeyup="getMatTotal14()"/></td>    
</tr>

  <tr>
<th scope="row">15.)</th>
    <td align="center"><input id="csp_material_item15" name="csp_material_item15" value="<?php echo $csp_material_item15; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty15" name="csp_material_qty15" value="<?php echo $csp_material_qty15; ?>" class="quantity" onkeyup="getMatTotal15()"/></td>    
    <td align="center"><input id="csp_material_cost15" name="csp_material_cost15" value="<?php echo $csp_material_cost15; ?>" class="cost" onkeyup="getMatTotal15()"/></td>    
    <td align="center"><input id="csp_item_subtotal15" name="item_subtotal" value="<?php echo $csp_material_total[15]; ?>" DISABLED class="cost" onkeyup="getMatTotal15()"/></td>    
</tr>

  <tr>
<th scope="row">16.)</th>
    <td align="center"><input id="csp_material_item16" name="csp_material_item16" value="<?php echo $csp_material_item16; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty16" name="csp_material_qty16" value="<?php echo $csp_material_qty16; ?>" class="quantity" onkeyup="getMatTotal16()"/></td>    
    <td align="center"><input id="csp_material_cost16" name="csp_material_cost16" value="<?php echo $csp_material_cost16; ?>" class="cost" onkeyup="getMatTotal16()"/></td>    
    <td align="center"><input id="csp_item_subtotal16" name="item_subtotal" value="<?php echo $csp_material_total[16]; ?>" DISABLED class="cost" onkeyup="getMatTotal16()"/></td>    

</tr>

  <tr>
<th scope="row">17.)</th>
    <td align="center"><input id="csp_material_item17" name="csp_material_item17" value="<?php echo $csp_material_item17; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty17" name="csp_material_qty17" value="<?php echo $csp_material_qty17; ?>" class="quantity" onkeyup="getMatTotal17()"/></td>    
    <td align="center"><input id="csp_material_cost17" name="csp_material_cost17" value="<?php echo $csp_material_cost17; ?>" class="cost" onkeyup="getMatTotal17()"/></td>
    <td align="center"><input id="csp_item_subtotal17" name="item_subtotal" value="<?php echo $csp_material_total[17]; ?>" DISABLED class="cost" onkeyup="getMatTotal17()"/></td>    
</tr>

  <tr>
<th scope="row">18.)</th>
    <td align="center"><input id="csp_material_item18" name="csp_material_item18" value="<?php echo $csp_material_item18; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty18" name="csp_material_qty18" value="<?php echo $csp_material_qty18; ?>" class="quantity" onkeyup="getMatTotal18()"/></td>    
    <td align="center"><input id="csp_material_cost18" name="csp_material_cost18" value="<?php echo $csp_material_cost18; ?>" class="cost" onkeyup="getMatTotal18()"/></td>   
    <td align="center"><input id="csp_item_subtotal18" name="item_subtotal" value="<?php echo $csp_material_total[18]; ?>" DISABLED class="cost" onkeyup="getMatTotal18()"/></td>    

</tr>

  <tr>
<th scope="row">19.)</th>
    <td align="center"><input id="csp_material_item19" name="csp_material_item19" value="<?php echo $csp_material_item19; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty19" name="csp_material_qty19" value="<?php echo $csp_material_qty19; ?>" class="quantity" onkeyup="getMatTotal19()"/></td>    
    <td align="center"><input id="csp_material_cost19" name="csp_material_cost19" value="<?php echo $csp_material_cost19; ?>" class="cost" onkeyup="getMatTotal19()"/></td>    
    <td align="center"><input id="csp_item_subtotal19" name="item_subtotal" value="<?php echo $csp_material_total[19]; ?>" DISABLED class="cost" onkeyup="getMatTotal19()"/></td>    
</tr>

  <tr>
<th scope="row">20.)</th>
    <td align="center"><input id="csp_material_item20" name="csp_material_item20" value="<?php echo $csp_material_item20; ?>" class="description"/></td>
    <td align="center"><input id="csp_material_qty20" name="csp_material_qty20" value="<?php echo $csp_material_qty20; ?>" class="quantity" onkeyup="getMatTotal20()"/></td>    
    <td align="center"><input id="csp_material_cost20" name="csp_material_cost20" value="<?php echo $csp_material_cost20; ?>" class="cost" onkeyup="getMatTotal20()"/></td>
    <td align="center"><input id="csp_item_subtotal20" name="item_subtotal" value="<?php echo $csp_material_total[20]; ?>" DISABLED class="cost" onkeyup="getMatTotal20()"/></td>    
</tr>

  <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Material Subtotal</td>
    <td align="center"><input id="mat_subtotal" name="mat_subtotal" value="<?php echo $csp_material_subtotal ?>" DISABLED class="cost" onkeyup="getGMatTotal()"/></td>
</tr>

  <tr>
<th scope="row"></th>
    <td align="center">Sales Tax Rate ex. 0.07</td>
    <td align="center"><input id="csp_taxrate" name="csp_taxrate" value="<?php echo $csp_taxrate; ?>" class="quantity" onkeyup="getMatTotalTax()"/></td>
    <td align="center">Sales Tax</td>
    <td align="center"><input id="csp_total_tax" name="total_tax" value="<?php echo $csp_total_tax ?>" DISABLED class="cost" onkeyup="getMatTotalTax()"/></td>
</tr>
  
  <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Adjustment ex. -250.00</td>
    <td align="center"><input id="csp_total_adjustment" name="csp_total_adjustment" value="<?php echo $csp_total_adjustment; ?>" class="quantity" onkeyup="getGMatTotal()" style="width:70px;" /></td>
</tr>
  
  <tr>
   <th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
 <td align="center">Total Materials</td>
    <td align="center"><input id="csp_total_mat" name="total_mat" value="<?php echo $mat_total ?>" DISABLED class="cost" onkeyup="getMatTotal()"/></td>
</tr>      

</table>    
</div>   

        <?php  
            }  
            
        function add_invoice_details(){
            add_meta_box('invoice_details', __('Material Items', 'csp_invoice_details'), 'invoice_details', 'invoices', 'normal', 'high');  
        }
        add_action('admin_init', 'add_invoice_details');  

/*====================== Labor Custom Field Section ======================*/    
function invoicelabor_details(){  
            global $post; 
            $custom = get_post_custom($post->ID); 
    	    $csp_material_item = $custom["csp_material_item"][0]; 
            $csp_material_cost = $custom["csp_material_cost"][0];
            $csp_material_qty = $custom["csp_material_qty"][0];
            $csp_material_item2 = $custom["csp_material_item2"][0]; 
            $csp_material_cost2 = $custom["csp_material_cost2"][0]; 
            $csp_material_qty2 = $custom["csp_material_qty2"][0];
            $csp_material_item3 = $custom["csp_material_item3"][0]; 
            $csp_material_cost3 = $custom["csp_material_cost3"][0]; 
            $csp_material_qty3 = $custom["csp_material_qty3"][0];
            $csp_material_item4 = $custom["csp_material_item4"][0]; 
            $csp_material_cost4 = $custom["csp_material_cost4"][0]; 
            $csp_material_qty4 = $custom["csp_material_qty4"][0];
            $csp_material_item5 = $custom["csp_material_item5"][0]; 
            $csp_material_cost5 = $custom["csp_material_cost5"][0]; 
            $csp_material_qty5 = $custom["csp_material_qty5"][0];
            $csp_material_item6 = $custom["csp_material_item6"][0]; 
            $csp_material_cost6 = $custom["csp_material_cost6"][0]; 
            $csp_material_qty6 = $custom["csp_material_qty6"][0];
            $csp_material_item7 = $custom["csp_material_item7"][0]; 
            $csp_material_cost7 = $custom["csp_material_cost7"][0];
            $csp_material_qty7 = $custom["csp_material_qty7"][0];  
            $csp_material_item8 = $custom["csp_material_item8"][0]; 
            $csp_material_cost8 = $custom["csp_material_cost8"][0];
            $csp_material_qty8 = $custom["csp_material_qty8"][0];  
            $csp_material_item9 = $custom["csp_material_item9"][0]; 
            $csp_material_cost9 = $custom["csp_material_cost9"][0];
            $csp_material_qty9 = $custom["csp_material_qty9"][0];  
	    $csp_material_item10 = $custom["csp_material_item10"][0]; 
            $csp_material_cost10 = $custom["csp_material_cost10"][0];
            $csp_material_qty10 = $custom["csp_material_qty10"][0];
	    $csp_material_item11 = $custom["csp_material_item11"][0]; 
            $csp_material_cost11 = $custom["csp_material_cost11"][0];
            $csp_material_qty11 = $custom["csp_material_qty11"][0];
            $csp_material_item12 = $custom["csp_material_item12"][0]; 
            $csp_material_cost12 = $custom["csp_material_cost12"][0]; 
            $csp_material_qty12 = $custom["csp_material_qty12"][0];
            $csp_material_item13 = $custom["csp_material_item13"][0]; 
            $csp_material_cost13 = $custom["csp_material_cost13"][0]; 
            $csp_material_qty13 = $custom["csp_material_qty13"][0];
            $csp_material_item14 = $custom["csp_material_item14"][0]; 
            $csp_material_cost14 = $custom["csp_material_cost14"][0]; 
            $csp_material_qty14 = $custom["csp_material_qty14"][0];
            $csp_material_item15 = $custom["csp_material_item15"][0]; 
            $csp_material_cost15 = $custom["csp_material_cost15"][0]; 
            $csp_material_qty15 = $custom["csp_material_qty15"][0];
            $csp_material_item16 = $custom["csp_material_item16"][0]; 
            $csp_material_cost16 = $custom["csp_material_cost16"][0]; 
            $csp_material_qty16 = $custom["csp_material_qty16"][0];
            $csp_material_item17 = $custom["csp_material_item17"][0]; 
            $csp_material_cost17 = $custom["csp_material_cost17"][0];
            $csp_material_qty17 = $custom["csp_material_qty17"][0];  
            $csp_material_item18 = $custom["csp_material_item18"][0]; 
            $csp_material_cost18 = $custom["csp_material_cost18"][0];
            $csp_material_qty18 = $custom["csp_material_qty18"][0];  
            $csp_material_item19 = $custom["csp_material_item19"][0]; 
            $csp_material_cost19 = $custom["csp_material_cost19"][0];
            $csp_material_qty19 = $custom["csp_material_qty19"][0];  
	    $csp_material_item20 = $custom["csp_material_item20"][0]; 
            $csp_material_cost20 = $custom["csp_material_cost20"][0];
            $csp_material_qty20 = $custom["csp_material_qty20"][0];  
	    $csp_taxrate = $custom["csp_taxrate"][0];  
            $csp_total_adjustment = $custom["csp_total_adjustment"][0]; 
    	    $csp_material_total[1] = ($custom['csp_material_cost'][0]*$custom['csp_material_qty'][0]);
    	    $csp_material_total[2] = ($custom['csp_material_cost2'][0]*$custom['csp_material_qty2'][0]);
    	    $csp_material_total[3] = ($custom['csp_material_cost3'][0]*$custom['csp_material_qty3'][0]);
    	    $csp_material_total[4] = ($custom['csp_material_cost4'][0]*$custom['csp_material_qty4'][0]);
    	    $csp_material_total[5] = ($custom['csp_material_cost5'][0]*$custom['csp_material_qty5'][0]);
    	    $csp_material_total[6] = ($custom['csp_material_cost6'][0]*$custom['csp_material_qty6'][0]);
    	    $csp_material_total[7] = ($custom['csp_material_cost7'][0]*$custom['csp_material_qty7'][0]);
    	    $csp_material_total[8] = ($custom['csp_material_cost8'][0]*$custom['csp_material_qty8'][0]);
    	    $csp_material_total[9] = ($custom['csp_material_cost9'][0]*$custom['csp_material_qty9'][0]);
    	    $csp_material_total[10] = ($custom['csp_material_cost10'][0]*$custom['csp_material_qty10'][0]);
    	    $csp_material_total[11] = ($custom['csp_material_cost11'][0]*$custom['csp_material_qty11'][0]);
    	    $csp_material_total[12] = ($custom['csp_material_cost12'][0]*$custom['csp_material_qty12'][0]);
    	    $csp_material_total[13] = ($custom['csp_material_cost13'][0]*$custom['csp_material_qty13'][0]);
    	    $csp_material_total[14] = ($custom['csp_material_cost14'][0]*$custom['csp_material_qty14'][0]);
    	    $csp_material_total[15] = ($custom['csp_material_cost15'][0]*$custom['csp_material_qty15'][0]);
    	    $csp_material_total[16] = ($custom['csp_material_cost16'][0]*$custom['csp_material_qty16'][0]);
    	    $csp_material_total[17] = ($custom['csp_material_cost17'][0]*$custom['csp_material_qty17'][0]);
    	    $csp_material_total[18] = ($custom['csp_material_cost18'][0]*$custom['csp_material_qty18'][0]);
    	    $csp_material_total[19] = ($custom['csp_material_cost19'][0]*$custom['csp_material_qty19'][0]);
    	    $csp_material_total[20] = ($custom['csp_material_cost20'][0]*$custom['csp_material_qty20'][0]);
    	    $csp_material_subtotal = array_sum($csp_material_total);
    	    $csp_total_tax = ($csp_material_subtotal*$csp_taxrate);
            $mat_total = ($csp_material_subtotal + $csp_total_tax + $csp_total_adjustment);
    
	    $csp_labor_item = $custom["csp_labor_item"][0]; 
            $csp_labor_cost = $custom["csp_labor_cost"][0];
            $csp_labor_qty = $custom["csp_labor_qty"][0];
            $csp_labor_item2 = $custom["csp_labor_item2"][0]; 
            $csp_labor_cost2 = $custom["csp_labor_cost2"][0]; 
            $csp_labor_qty2 = $custom["csp_labor_qty2"][0];
            $csp_labor_item3 = $custom["csp_labor_item3"][0]; 
            $csp_labor_cost3 = $custom["csp_labor_cost3"][0]; 
            $csp_labor_qty3 = $custom["csp_labor_qty3"][0];
            $csp_labor_item4 = $custom["csp_labor_item4"][0]; 
            $csp_labor_cost4 = $custom["csp_labor_cost4"][0]; 
            $csp_labor_qty4 = $custom["csp_labor_qty4"][0];
            $csp_labor_item5 = $custom["csp_labor_item5"][0]; 
            $csp_labor_cost5 = $custom["csp_labor_cost5"][0]; 
            $csp_labor_qty5 = $custom["csp_labor_qty5"][0];
            $csp_labor_item6 = $custom["csp_labor_item6"][0]; 
            $csp_labor_cost6 = $custom["csp_labor_cost6"][0]; 
            $csp_labor_qty6 = $custom["csp_labor_qty6"][0];
            $csp_labor_item7 = $custom["csp_labor_item7"][0]; 
            $csp_labor_cost7 = $custom["csp_labor_cost7"][0];
            $csp_labor_qty7 = $custom["csp_labor_qty7"][0];  
            $csp_labor_item8 = $custom["csp_labor_item8"][0]; 
            $csp_labor_cost8 = $custom["csp_labor_cost8"][0];
            $csp_labor_qty8 = $custom["csp_labor_qty8"][0];  
            $csp_labor_item9 = $custom["csp_labor_item9"][0]; 
            $csp_labor_cost9 = $custom["csp_labor_cost9"][0];
            $csp_labor_qty9 = $custom["csp_labor_qty9"][0];  
	    $csp_labor_item10 = $custom["csp_labor_item10"][0]; 
            $csp_labor_cost10 = $custom["csp_labor_cost10"][0];
            $csp_labor_qty10 = $custom["csp_labor_qty10"][0];
	    $csp_labor_item11 = $custom["csp_labor_item11"][0]; 
            $csp_labor_cost11 = $custom["csp_labor_cost11"][0];
            $csp_labor_qty11 = $custom["csp_labor_qty11"][0];
            $csp_labor_item12 = $custom["csp_labor_item12"][0]; 
            $csp_labor_cost12 = $custom["csp_labor_cost12"][0]; 
            $csp_labor_qty12 = $custom["csp_labor_qty12"][0];
            $csp_labor_item13 = $custom["csp_labor_item13"][0]; 
            $csp_labor_cost13 = $custom["csp_labor_cost13"][0]; 
            $csp_labor_qty13 = $custom["csp_labor_qty13"][0];
            $csp_labor_item14 = $custom["csp_labor_item14"][0]; 
            $csp_labor_cost14 = $custom["csp_labor_cost14"][0]; 
            $csp_labor_qty14 = $custom["csp_labor_qty14"][0];
            $csp_labor_item15 = $custom["csp_labor_item15"][0]; 
            $csp_labor_cost15 = $custom["csp_labor_cost15"][0]; 
            $csp_labor_qty15 = $custom["csp_labor_qty15"][0];
            $csp_labor_item16 = $custom["csp_labor_item16"][0]; 
            $csp_labor_cost16 = $custom["csp_labor_cost16"][0]; 
            $csp_labor_qty16 = $custom["csp_labor_qty16"][0];
            $csp_labor_item17 = $custom["csp_labor_item17"][0]; 
            $csp_labor_cost17 = $custom["csp_labor_cost17"][0];
            $csp_labor_qty17 = $custom["csp_labor_qty17"][0];  
            $csp_labor_item18 = $custom["csp_labor_item18"][0]; 
            $csp_labor_cost18 = $custom["csp_labor_cost18"][0];
            $csp_labor_qty18 = $custom["csp_labor_qty18"][0];  
            $csp_labor_item19 = $custom["csp_labor_item19"][0]; 
            $csp_labor_cost19 = $custom["csp_labor_cost19"][0];
            $csp_labor_qty19 = $custom["csp_labor_qty19"][0];  
	    $csp_labor_item20 = $custom["csp_labor_item20"][0]; 
            $csp_labor_cost20 = $custom["csp_labor_cost20"][0];
            $csp_labor_qty20 = $custom["csp_labor_qty20"][0];  
	    $csp_taxrate = $custom["csp_taxrate"][0];  
            $csp_total_adjustment = $custom["csp_total_adjustment"][0]; 
    	    $csp_labor_total[1] = ($custom['csp_labor_cost'][0]*$custom['csp_labor_qty'][0]);
    	    $csp_labor_total[2] = ($custom['csp_labor_cost2'][0]*$custom['csp_labor_qty2'][0]);
    	    $csp_labor_total[3] = ($custom['csp_labor_cost3'][0]*$custom['csp_labor_qty3'][0]);
    	    $csp_labor_total[4] = ($custom['csp_labor_cost4'][0]*$custom['csp_labor_qty4'][0]);
    	    $csp_labor_total[5] = ($custom['csp_labor_cost5'][0]*$custom['csp_labor_qty5'][0]);
    	    $csp_labor_total[6] = ($custom['csp_labor_cost6'][0]*$custom['csp_labor_qty6'][0]);
    	    $csp_labor_total[7] = ($custom['csp_labor_cost7'][0]*$custom['csp_labor_qty7'][0]);
    	    $csp_labor_total[8] = ($custom['csp_labor_cost8'][0]*$custom['csp_labor_qty8'][0]);
    	    $csp_labor_total[9] = ($custom['csp_labor_cost9'][0]*$custom['csp_labor_qty9'][0]);
    	    $csp_labor_total[10] = ($custom['csp_labor_cost10'][0]*$custom['csp_labor_qty10'][0]);
    	    $csp_labor_total[11] = ($custom['csp_labor_cost11'][0]*$custom['csp_labor_qty11'][0]);
    	    $csp_labor_total[12] = ($custom['csp_labor_cost12'][0]*$custom['csp_labor_qty12'][0]);
    	    $csp_labor_total[13] = ($custom['csp_labor_cost13'][0]*$custom['csp_labor_qty13'][0]);
    	    $csp_labor_total[14] = ($custom['csp_labor_cost14'][0]*$custom['csp_labor_qty14'][0]);
    	    $csp_labor_total[15] = ($custom['csp_labor_cost15'][0]*$custom['csp_labor_qty15'][0]);
    	    $csp_labor_total[16] = ($custom['csp_labor_cost16'][0]*$custom['csp_labor_qty16'][0]);
    	    $csp_labor_total[17] = ($custom['csp_labor_cost17'][0]*$custom['csp_labor_qty17'][0]);
    	    $csp_labor_total[18] = ($custom['csp_labor_cost18'][0]*$custom['csp_labor_qty18'][0]);
    	    $csp_labor_total[19] = ($custom['csp_labor_cost19'][0]*$custom['csp_labor_qty19'][0]);
    	    $csp_labor_total[20] = ($custom['csp_labor_cost20'][0]*$custom['csp_labor_qty20'][0]);
    	    $laborsubtotal = array_sum($csp_labor_total);
    	    $csp_total_tax = ($csp_material_subtotal*$csp_taxrate);
            $labor_total = ($laborsubtotal + $csp_total_tax + $csp_total_adjustment);
	    $grandtotal = ($csp_material_subtotal + $laborsubtotal + $csp_total_tax + $csp_total_adjustment);

    
  echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
                
        ?>  
        <div class="proposal_check">
<table>
  <tr>
    <th scope="col"><p></p></th>
    <th scope="col">Item/Description:</th>
    <th scope="col">Quantity</th>
    <th scope="col">Cost</th>
    <th scope="col">Subtotal</th>
  </tr>
  <tr>
<th scope="row">1.)</th>
    <td align="center"><input id="csp_labor_item" name="csp_labor_item" value="<?php echo $csp_labor_item; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty" name="csp_labor_qty" value="<?php echo $csp_labor_qty; ?>" class="quantity" onkeyup="getLabTotal()"/></td>    
    <td align="center"><input id="csp_labor_cost" name="csp_labor_cost" value="<?php echo $csp_labor_cost; ?>" class="cost" onkeyup="getLabTotal()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal" name="csp_labor_item_subtotal" value="<?php echo $csp_labor_total[1]; ?>" DISABLED class="cost" onkeyup="getLabTotal()"/></td>    
</tr>

  <tr>
<th scope="row">2.)</th>
    <td align="center"><input id="csp_labor_item2" name="csp_labor_item2" value="<?php echo $csp_labor_item2; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty2" name="csp_labor_qty2" value="<?php echo $csp_labor_qty2; ?>" class="quantity" onkeyup="getLabTotal2()"/></td>    
    <td align="center"><input id="csp_labor_cost2" name="csp_labor_cost2" value="<?php echo $csp_labor_cost2; ?>" class="cost" onkeyup="getLabTotal2()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal2" name="csp_labor_item_subtotal2" value="<?php echo $csp_labor_total[2]; ?>" DISABLED class="cost" onkeyup="getLabTotal2()"/></td>    
</tr>

  <tr>
<th scope="row">3.)</th>
    <td align="center"><input id="csp_labor_item3" name="csp_labor_item3" value="<?php echo $csp_labor_item3; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty3" name="csp_labor_qty3" value="<?php echo $csp_labor_qty3; ?>" class="quantity" onkeyup="getLabTotal3()"/></td>    
    <td align="center"><input id="csp_labor_cost3" name="csp_labor_cost3" value="<?php echo $csp_labor_cost3; ?>" class="cost" onkeyup="getLabTotal3()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal3" name="csp_labor_item_subtotal3" value="<?php echo $csp_labor_total[3]; ?>" DISABLED class="cost" onkeyup="getLabTotal3()"/></td>    
</tr>

  <tr>
<th scope="row">4.)</th>
    <td align="center"><input id="csp_labor_item4" name="csp_labor_item4" value="<?php echo $csp_labor_item4; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty4" name="csp_labor_qty4" value="<?php echo $csp_labor_qty4; ?>" class="quantity" onkeyup="getLabTotal4()"/></td>    
    <td align="center"><input id="csp_labor_cost4" name="csp_labor_cost4" value="<?php echo $csp_labor_cost4; ?>" class="cost" onkeyup="getLabTotal4()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal4" name="csp_labor_item_subtotal4" value="<?php echo $csp_labor_total[4]; ?>" DISABLED class="cost" onkeyup="getLabTotal4()"/></td>    
</tr>

  <tr>
<th scope="row">5.)</th>
    <td align="center"><input id="csp_labor_item5" name="csp_labor_item5" value="<?php echo $csp_labor_item5; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty5" name="csp_labor_qty5" value="<?php echo $csp_labor_qty5; ?>" class="quantity" onkeyup="getLabTotal5()"/></td>    
    <td align="center"><input id="csp_labor_cost5" name="csp_labor_cost5" value="<?php echo $csp_labor_cost5; ?>" class="cost" onkeyup="getLabTotal5()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal5" name="csp_labor_item_subtotal5" value="<?php echo $csp_labor_total[5]; ?>" DISABLED class="cost" onkeyup="getLabTotal5()"/></td>    
</tr>

  <tr>
<th scope="row">6.)</th>
    <td align="center"><input id="csp_labor_item6" name="csp_labor_item6" value="<?php echo $csp_labor_item6; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty6" name="csp_labor_qty6" value="<?php echo $csp_labor_qty6; ?>" class="quantity" onkeyup="getLabTotal6()"/></td>    
    <td align="center"><input id="csp_labor_cost6" name="csp_labor_cost6" value="<?php echo $csp_labor_cost6; ?>" class="cost" onkeyup="getLabTotal6()"/></td>   
    <td align="center"><input id="csp_labor_item_subtotal6" name="csp_labor_item_subtotal6" value="<?php echo $csp_labor_total[6]; ?>" DISABLED class="cost" onkeyup="getLabTotal6()"/></td>    
</tr>

  <tr>
<th scope="row">7.)</th>
    <td align="center"><input id="csp_labor_item7" name="csp_labor_item7" value="<?php echo $csp_labor_item7; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty7" name="csp_labor_qty7" value="<?php echo $csp_labor_qty7; ?>" class="quantity" onkeyup="getLabTotal7()"/></td>    
    <td align="center"><input id="csp_labor_cost7" name="csp_labor_cost7" value="<?php echo $csp_labor_cost7; ?>" class="cost" onkeyup="getLabTotal7()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal7" name="csp_labor_item_subtotal7" value="<?php echo $csp_labor_total[7]; ?>" DISABLED class="cost" onkeyup="getLabTotal7()"/></td>    
</tr>

  <tr>
<th scope="row">8.)</th>
    <td align="center"><input id="csp_labor_item8" name="csp_labor_item8" value="<?php echo $csp_labor_item8; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty8" name="csp_labor_qty8" value="<?php echo $csp_labor_qty8; ?>" class="quantity" onkeyup="getLabTotal8()"/></td>    
    <td align="center"><input id="csp_labor_cost8" name="csp_labor_cost8" value="<?php echo $csp_labor_cost8; ?>" class="cost" onkeyup="getLabTotal8()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal8" name="csp_labor_item_subtotal8" value="<?php echo $csp_labor_total[8]; ?>" DISABLED class="cost" onkeyup="getLabTotal8()"/></td>  
</tr>

  <tr>
<th scope="row">9.)</th>
    <td align="center"><input id="csp_labor_item9" name="csp_labor_item9" value="<?php echo $csp_labor_item9; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty9" name="csp_labor_qty9" value="<?php echo $csp_labor_qty9; ?>" class="quantity" onkeyup="getLabTotal9()"/></td>    
    <td align="center"><input id="csp_labor_cost9" name="csp_labor_cost9" value="<?php echo $csp_labor_cost9; ?>" class="cost" onkeyup="getLabTotal9()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal9" name="csp_labor_item_subtotal9" value="<?php echo $csp_labor_total[9]; ?>" DISABLED class="cost" onkeyup="getLabTotal9()"/></td>    

</tr>

  <tr>
<th scope="row">10.)</th>
    <td align="center"><input id="csp_labor_item10" name="csp_labor_item10" value="<?php echo $csp_labor_item10; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty10" name="csp_labor_qty10" value="<?php echo $csp_labor_qty10; ?>" class="quantity" onkeyup="getLabTotal10()"/></td>    
    <td align="center"><input id="csp_labor_cost10" name="csp_labor_cost10" value="<?php echo $csp_labor_cost10; ?>" class="cost" onkeyup="getLabTotal10()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal10" name="csp_labor_item_subtotal10" value="<?php echo $csp_labor_total[10]; ?>" DISABLED class="cost" onkeyup="getLabTotal10()"/></td>    
</tr>

  <tr>
<th scope="row">11.)</th>
    <td align="center"><input id="csp_labor_item11" name="csp_labor_item11" value="<?php echo $csp_labor_item11; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty11" name="csp_labor_qty11" value="<?php echo $csp_labor_qty11; ?>" class="quantity" onkeyup="getLabTotal11()"/></td>    
    <td align="center"><input id="csp_labor_cost11" name="csp_labor_cost11" value="<?php echo $csp_labor_cost11; ?>" class="cost" onkeyup="getLabTotal11()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal11" name="csp_labor_item_subtotal11" value="<?php echo $csp_labor_total[11]; ?>" DISABLED class="cost" onkeyup="getLabTotal11()"/></td>    

</tr>

  <tr>
<th scope="row">12.)</th>
    <td align="center"><input id="csp_labor_item12" name="csp_labor_item12" value="<?php echo $csp_labor_item12; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty12" name="csp_labor_qty12" value="<?php echo $csp_labor_qty12; ?>" class="quantity" onkeyup="getLabTotal12()"/></td>    
    <td align="center"><input id="csp_labor_cost12" name="csp_labor_cost12" value="<?php echo $csp_labor_cost12; ?>" class="cost" onkeyup="getLabTotal12()"/></td>   
    <td align="center"><input id="csp_labor_item_subtotal12" name="csp_labor_item_subtotal12" value="<?php echo $csp_labor_total[12]; ?>" DISABLED class="cost" onkeyup="getLabTotal12()"/></td>    

</tr>
  <tr>
<th scope="row">13.)</th>
    <td align="center"><input id="csp_labor_item13" name="csp_labor_item13" value="<?php echo $csp_labor_item13; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty13" name="csp_labor_qty13" value="<?php echo $csp_labor_qty13; ?>" class="quantity" onkeyup="getLabTotal13()"/></td>    
    <td align="center"><input id="csp_labor_cost13" name="csp_labor_cost13" value="<?php echo $csp_labor_cost13; ?>" class="cost" onkeyup="getLabTotal13()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal13" name="csp_labor_item_subtotal13" value="<?php echo $csp_labor_total[13]; ?>" DISABLED class="cost" onkeyup="getLabTotal13()"/></td>    

</tr>

  <tr>
<th scope="row">14.)</th>
    <td align="center"><input id="csp_labor_item14" name="csp_labor_item14" value="<?php echo $csp_labor_item14; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty14" name="csp_labor_qty14" value="<?php echo $csp_labor_qty14; ?>" class="quantity" onkeyup="getLabTotal14()"/></td>    
    <td align="center"><input id="csp_labor_cost14" name="csp_labor_cost14" value="<?php echo $csp_labor_cost14; ?>" class="cost" onkeyup="getLabTotal14()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal14" name="csp_labor_item_subtotal14" value="<?php echo $csp_labor_total[14]; ?>" DISABLED class="cost" onkeyup="getLabTotal14()"/></td>    
</tr>

  <tr>
<th scope="row">15.)</th>
    <td align="center"><input id="csp_labor_item15" name="csp_labor_item15" value="<?php echo $csp_labor_item15; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty15" name="csp_labor_qty15" value="<?php echo $csp_labor_qty15; ?>" class="quantity" onkeyup="getLabTotal15()"/></td>    
    <td align="center"><input id="csp_labor_cost15" name="csp_labor_cost15" value="<?php echo $csp_labor_cost15; ?>" class="cost" onkeyup="getLabTotal15()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal15" name="csp_labor_item_subtotal15" value="<?php echo $csp_labor_total[15]; ?>" DISABLED class="cost" onkeyup="getLabTotal15()"/></td>    
</tr>

  <tr>
<th scope="row">16.)</th>
    <td align="center"><input id="csp_labor_item16" name="csp_labor_item16" value="<?php echo $csp_labor_item16; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty16" name="csp_labor_qty16" value="<?php echo $csp_labor_qty16; ?>" class="quantity" onkeyup="getLabTotal16()"/></td>    
    <td align="center"><input id="csp_labor_cost16" name="csp_labor_cost16" value="<?php echo $csp_labor_cost16; ?>" class="cost" onkeyup="getLabTotal16()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal16" name="csp_labor_item_subtotal16" value="<?php echo $csp_labor_total[16]; ?>" DISABLED class="cost" onkeyup="getLabTotal16()"/></td>    

</tr>

  <tr>
<th scope="row">17.)</th>
    <td align="center"><input id="csp_labor_item17" name="csp_labor_item17" value="<?php echo $csp_labor_item17; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty17" name="csp_labor_qty17" value="<?php echo $csp_labor_qty17; ?>" class="quantity" onkeyup="getLabTotal17()"/></td>    
    <td align="center"><input id="csp_labor_cost17" name="csp_labor_cost17" value="<?php echo $csp_labor_cost17; ?>" class="cost" onkeyup="getLabTotal17()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal17" name="csp_labor_item_subtotal17" value="<?php echo $csp_labor_total[17]; ?>" DISABLED class="cost" onkeyup="getLabTotal17()"/></td>    
</tr>

  <tr>
<th scope="row">18.)</th>
    <td align="center"><input id="csp_labor_item18" name="csp_labor_item18" value="<?php echo $csp_labor_item18; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty18" name="csp_labor_qty18" value="<?php echo $csp_labor_qty18; ?>" class="quantity" onkeyup="getLabTotal18()"/></td>    
    <td align="center"><input id="csp_labor_cost18" name="csp_labor_cost18" value="<?php echo $csp_labor_cost18; ?>" class="cost" onkeyup="getLabTotal18()"/></td>   
    <td align="center"><input id="csp_labor_item_subtotal18" name="csp_labor_item_subtotal18" value="<?php echo $csp_labor_total[18]; ?>" DISABLED class="cost" onkeyup="getLabTotal18()"/></td>    

</tr>

  <tr>
<th scope="row">19.)</th>
    <td align="center"><input id="csp_labor_item19" name="csp_labor_item19" value="<?php echo $csp_labor_item19; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty19" name="csp_labor_qty19" value="<?php echo $csp_labor_qty19; ?>" class="quantity" onkeyup="getLabTotal19()"/></td>    
    <td align="center"><input id="csp_labor_cost19" name="csp_labor_cost19" value="<?php echo $csp_labor_cost19; ?>" class="cost" onkeyup="getLabTotal19()"/></td>    
    <td align="center"><input id="csp_labor_item_subtotal19" name="csp_labor_item_subtotal19" value="<?php echo $csp_labor_total[19]; ?>" DISABLED class="cost" onkeyup="getLabTotal19()"/></td>    
</tr>

  <tr>
<th scope="row">20.)</th>
    <td align="center"><input id="csp_labor_item20" name="csp_labor_item20" value="<?php echo $csp_labor_item20; ?>" class="description"/></td>
    <td align="center"><input id="csp_labor_qty20" name="csp_labor_qty20" value="<?php echo $csp_labor_qty20; ?>" class="quantity" onkeyup="getLabTotal20()"/></td>    
    <td align="center"><input id="csp_labor_cost20" name="csp_labor_cost20" value="<?php echo $csp_labor_cost20; ?>" class="cost" onkeyup="getLabTotal20()"/></td>
    <td align="center"><input id="csp_labor_item_subtotal20" name="csp_labor_item_subtotal20" value="<?php echo $csp_labor_total[20]; ?>" DISABLED class="cost" onkeyup="getLabTotal20()"/></td>    
</tr>

  
  <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Labor Subtotal</td>
    <td align="center"><input id="laborsubtotal" name="laborsubtotal" value="<?php echo $laborsubtotal ?>" DISABLED class="cost" onkeyup="getGLabTotal()"/></td>
</tr>
  
  <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Material Subtotal</td>
    <td align="center"><input id="mat_subtotal2" name="csp_material_subtotal" value="<?php echo $csp_material_subtotal ?>" DISABLED class="cost" onkeyup="getGLabTotal()"/></td>
</tr>

  <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Sales Tax</td>
    <td align="center"><input id="csp_total_tax2" name="total_tax" value="<?php echo $csp_total_tax ?>" DISABLED class="cost" onkeyup="getGLabTotal()"/></td>
</tr>
     <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Adjustments</td>
    <td align="center"><input id="csp_total_adjustment2" name="csp_total_adjustment" value="<?php echo $csp_total_adjustment; ?>" DISABLED class="quantity" onkeyup="getGMatTotal()" style="width:70px;" /></td>
</tr>  
  <tr>
<th scope="row"></th>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center">Proposal Total</td>
    <td align="center"><input id="csp_total_pro" name="grandtotal" value="<?php echo $grandtotal ?>" DISABLED class="cost" onkeyup="getGLabTotal()"/></td>
</tr>      



</table>
</div>  
        <?php  
            }  
            
        function add_invoicelabor_details(){
            add_meta_box('invoicelabor_details', __('Labor Items', 'csp_invoicelabor_details'), 'invoicelabor_details', 'invoices', 'normal', 'high');  
        }
        add_action('admin_init', 'add_invoicelabor_details');  


 /*====================== Third Custom Field Section ======================*/    
     function invoice_terms(){  
             global $post; 
             $custom = get_post_custom($post->ID);  
             $terms_update = $custom["terms_update"][0];  
             
         echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
             
     ?>  
     <div class="terms_update">
         <p><?php _e("Leave this area blank if you want to use your default terms and conditions (found in the theme settings).",'clientmachine'); ?></p><textarea name="terms_update"><?php echo $terms_update; ?></textarea>
     </div>
     <?php  
         }  
         
     function add_invoice_terms(){
         add_meta_box('invoice_terms', __('Invoice Terms', 'csp_invoice_terms'), 'invoice_terms', 'invoices', 'normal', 'high');  
     }
     add_action('admin_init', 'add_invoice_terms');       

     
  /*====================== Fourth Custom Field Section ======================*/    
      function invoice_notes(){  
              global $post; 
              $custom = get_post_custom($post->ID);  
              $invoice_clientnotes = $custom["invoice_clientnotes"][0]; 
              $invoice_privatenotes = $custom["invoice_privatenotes"][0];   
              
          echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('cs-p'). '" />';
              
      ?>  
      <div class="terms_update">
          <label><?php _e("Notes for the Client:",'clientmachine'); ?></label><br/>
          <textarea name="invoice_clientnotes"><?php echo $invoice_clientnotes; ?></textarea>
          <br/>
          <label><?php _e("Private Notes:",'clientmachine'); ?></label><br/>
          <textarea name="invoice_privatenotes"><?php echo $invoice_privatenotes; ?></textarea>
      </div>
          
      <?php  
          }  
          
      function add_invoice_notes(){
          add_meta_box('invoice_notes', __('Invoice Notes', 'csp_invoice_notes'), 'invoice_notes', 'invoices', 'normal', 'low');  
      }
      add_action('admin_init', 'add_invoice_notes');      
       
  
/*====================== Saves all Custom Field Data ======================*/    
	function save_meta_invoice($post_id){  
		
		if (!wp_verify_nonce($_POST['csp-nonce'], 'cs-p')) return $post_id;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	   	update_post_meta($post_id, "inv_number", $_POST["inv_number"]);
		update_post_meta($post_id, "due_date", $_POST["due_date"]);
	   	update_post_meta($post_id, "csp_jobsiteaddress1", $_POST["csp_jobsiteaddress1"]);
		update_post_meta($post_id, "csp_jobsiteaddress2", $_POST["csp_jobsiteaddress2"]);
	   	update_post_meta($post_id, "client", $_POST["client"]); 
	   	update_post_meta($post_id, "invoice_status", $_POST["invoice_status"]); 
	    update_post_meta($post_id, "terms_update", $_POST["terms_update"]);   
	   	update_post_meta($post_id, "csp_material_item", $_POST["csp_material_item"]);
	   	update_post_meta($post_id, "csp_material_cost", $_POST["csp_material_cost"]);  
	   	update_post_meta($post_id, "csp_material_qty", $_POST["csp_material_qty"]);   
	  	update_post_meta($post_id, "csp_material_item2", $_POST["csp_material_item2"]);
	  	update_post_meta($post_id, "csp_material_cost2", $_POST["csp_material_cost2"]); 
	  	update_post_meta($post_id, "csp_material_qty2", $_POST["csp_material_qty2"]);   
	    update_post_meta($post_id, "csp_material_item3", $_POST["csp_material_item3"]);
	    update_post_meta($post_id, "csp_material_cost3", $_POST["csp_material_cost3"]);  
	    update_post_meta($post_id, "csp_material_qty3", $_POST["csp_material_qty3"]);   
	    update_post_meta($post_id, "csp_material_item4", $_POST["csp_material_item4"]);
	    update_post_meta($post_id, "csp_material_cost4", $_POST["csp_material_cost4"]); 
	    update_post_meta($post_id, "csp_material_qty4", $_POST["csp_material_qty4"]);    
	    update_post_meta($post_id, "csp_material_item5", $_POST["csp_material_item5"]);
	    update_post_meta($post_id, "csp_material_cost5", $_POST["csp_material_cost5"]); 
	    update_post_meta($post_id, "csp_material_qty5", $_POST["csp_material_qty5"]);    
	    update_post_meta($post_id, "csp_material_item6", $_POST["csp_material_item6"]);
	    update_post_meta($post_id, "csp_material_cost6", $_POST["csp_material_cost6"]);   
	    update_post_meta($post_id, "csp_material_qty6", $_POST["csp_material_qty6"]);  
	    update_post_meta($post_id, "csp_material_item7", $_POST["csp_material_item7"]);
	    update_post_meta($post_id, "csp_material_cost7", $_POST["csp_material_cost7"]);  
	    update_post_meta($post_id, "csp_material_qty7", $_POST["csp_material_qty7"]); 
	    update_post_meta($post_id, "csp_material_item8", $_POST["csp_material_item8"]);
	    update_post_meta($post_id, "csp_material_cost8", $_POST["csp_material_cost8"]);  
	    update_post_meta($post_id, "csp_material_qty8", $_POST["csp_material_qty8"]); 
	    update_post_meta($post_id, "csp_material_item9", $_POST["csp_material_item9"]);
	    update_post_meta($post_id, "csp_material_cost9", $_POST["csp_material_cost9"]);  
	    update_post_meta($post_id, "csp_material_qty9", $_POST["csp_material_qty9"]); 
	    update_post_meta($post_id, "csp_material_item10", $_POST["csp_material_item10"]);
	    update_post_meta($post_id, "csp_material_cost10", $_POST["csp_material_cost10"]);  
	    update_post_meta($post_id, "csp_material_qty10", $_POST["csp_material_qty10"]); 
            update_post_meta($post_id, "csp_material_item11", $_POST["csp_material_item11"]);
	    update_post_meta($post_id, "csp_material_cost11", $_POST["csp_material_cost11"]);  
	    update_post_meta($post_id, "csp_material_qty11", $_POST["csp_material_qty11"]);   
	    update_post_meta($post_id, "csp_material_item12", $_POST["csp_material_item12"]);
	    update_post_meta($post_id, "csp_material_cost12", $_POST["csp_material_cost12"]); 
	    update_post_meta($post_id, "csp_material_qty12", $_POST["csp_material_qty12"]);   
	    update_post_meta($post_id, "csp_material_item13", $_POST["csp_material_item13"]);
	    update_post_meta($post_id, "csp_material_cost13", $_POST["csp_material_cost13"]);  
	    update_post_meta($post_id, "csp_material_qty13", $_POST["csp_material_qty13"]);   
	    update_post_meta($post_id, "csp_material_item14", $_POST["csp_material_item14"]);
	    update_post_meta($post_id, "csp_material_cost14", $_POST["csp_material_cost14"]); 
	    update_post_meta($post_id, "csp_material_qty14", $_POST["csp_material_qty14"]);    
	    update_post_meta($post_id, "csp_material_item15", $_POST["csp_material_item15"]);
	    update_post_meta($post_id, "csp_material_cost15", $_POST["csp_material_cost15"]); 
	    update_post_meta($post_id, "csp_material_qty15", $_POST["csp_material_qty15"]);    
	    update_post_meta($post_id, "csp_material_item16", $_POST["csp_material_item16"]);
	    update_post_meta($post_id, "csp_material_cost16", $_POST["csp_material_cost16"]);   
	    update_post_meta($post_id, "csp_material_qty16", $_POST["csp_material_qty16"]);  
	    update_post_meta($post_id, "csp_material_item17", $_POST["csp_material_item17"]);
	    update_post_meta($post_id, "csp_material_cost17", $_POST["csp_material_cost17"]);  
	    update_post_meta($post_id, "csp_material_qty17", $_POST["csp_material_qty17"]); 
	    update_post_meta($post_id, "csp_material_item18", $_POST["csp_material_item18"]);
	    update_post_meta($post_id, "csp_material_cost18", $_POST["csp_material_cost18"]);  
	    update_post_meta($post_id, "csp_material_qty18", $_POST["csp_material_qty18"]); 
	    update_post_meta($post_id, "csp_material_item19", $_POST["csp_material_item19"]);
	    update_post_meta($post_id, "csp_material_cost19", $_POST["csp_material_cost19"]);  
	    update_post_meta($post_id, "csp_material_qty19", $_POST["csp_material_qty19"]); 
	    update_post_meta($post_id, "csp_material_item20", $_POST["csp_material_item20"]);
	    update_post_meta($post_id, "csp_material_cost20", $_POST["csp_material_cost20"]);  
	    update_post_meta($post_id, "csp_material_qty20", $_POST["csp_material_qty20"]); 
	     update_post_meta($post_id, "csp_labor_item", $_POST["csp_labor_item"]);
	   	update_post_meta($post_id, "csp_labor_cost", $_POST["csp_labor_cost"]);  
   		update_post_meta($post_id, "csp_labor_qty", $_POST["csp_labor_qty"]);   
   		update_post_meta($post_id, "csp_labor_item2", $_POST["csp_labor_item2"]);
   		update_post_meta($post_id, "csp_labor_cost2", $_POST["csp_labor_cost2"]); 
   		update_post_meta($post_id, "csp_labor_qty2", $_POST["csp_labor_qty2"]);   
	   	update_post_meta($post_id, "csp_labor_item3", $_POST["csp_labor_item3"]);
	   	update_post_meta($post_id, "csp_labor_cost3", $_POST["csp_labor_cost3"]);  
	   	update_post_meta($post_id, "csp_labor_qty3", $_POST["csp_labor_qty3"]);   
	   	update_post_meta($post_id, "csp_labor_item4", $_POST["csp_labor_item4"]);
	   	update_post_meta($post_id, "csp_labor_cost4", $_POST["csp_labor_cost4"]); 
	   	update_post_meta($post_id, "csp_labor_qty4", $_POST["csp_labor_qty4"]);    
	   	update_post_meta($post_id, "csp_labor_item5", $_POST["csp_labor_item5"]);
	   	update_post_meta($post_id, "csp_labor_cost5", $_POST["csp_labor_cost5"]); 
	   	update_post_meta($post_id, "csp_labor_qty5", $_POST["csp_labor_qty5"]); 
		update_post_meta($post_id, "csp_labor_item6", $_POST["csp_labor_item6"]);
	   	update_post_meta($post_id, "csp_labor_cost6", $_POST["csp_labor_cost6"]);  
   		update_post_meta($post_id, "csp_labor_qty6", $_POST["csp_labor_qty6"]);   
   		update_post_meta($post_id, "csp_labor_item7", $_POST["csp_labor_item7"]);
   		update_post_meta($post_id, "csp_labor_cost7", $_POST["csp_labor_cost7"]); 
   		update_post_meta($post_id, "csp_labor_qty7", $_POST["csp_labor_qty7"]);   
	   	update_post_meta($post_id, "csp_labor_item8", $_POST["csp_labor_item8"]);
	   	update_post_meta($post_id, "csp_labor_cost8", $_POST["csp_labor_cost8"]);  
	   	update_post_meta($post_id, "csp_labor_qty8", $_POST["csp_labor_qty8"]);   
	   	update_post_meta($post_id, "csp_labor_item9", $_POST["csp_labor_item9"]);
	   	update_post_meta($post_id, "csp_labor_cost9", $_POST["csp_labor_cost9"]); 
	   	update_post_meta($post_id, "csp_labor_qty9", $_POST["csp_labor_qty9"]);    
	   	update_post_meta($post_id, "csp_labor_item10", $_POST["csp_labor_item10"]);
	   	update_post_meta($post_id, "csp_labor_cost10", $_POST["csp_labor_cost10"]); 
	   	update_post_meta($post_id, "csp_labor_qty10", $_POST["csp_labor_qty10"]); 
		update_post_meta($post_id, "csp_labor_item11", $_POST["csp_labor_item11"]);
	   	update_post_meta($post_id, "csp_labor_cost11", $_POST["csp_labor_cost11"]);  
   		update_post_meta($post_id, "csp_labor_qty11", $_POST["csp_labor_qty11"]);   
   		update_post_meta($post_id, "csp_labor_item12", $_POST["csp_labor_item12"]);
   		update_post_meta($post_id, "csp_labor_cost12", $_POST["csp_labor_cost12"]); 
   		update_post_meta($post_id, "csp_labor_qty12", $_POST["csp_labor_qty12"]);   
	   	update_post_meta($post_id, "csp_labor_item13", $_POST["csp_labor_item13"]);
	   	update_post_meta($post_id, "csp_labor_cost13", $_POST["csp_labor_cost13"]);  
	   	update_post_meta($post_id, "csp_labor_qty13", $_POST["csp_labor_qty13"]);   
	   	update_post_meta($post_id, "csp_labor_item14", $_POST["csp_labor_item14"]);
	   	update_post_meta($post_id, "csp_labor_cost14", $_POST["csp_labor_cost14"]); 
	   	update_post_meta($post_id, "csp_labor_qty14", $_POST["csp_labor_qty14"]);    
	   	update_post_meta($post_id, "csp_labor_item15", $_POST["csp_labor_item15"]);
	   	update_post_meta($post_id, "csp_labor_cost15", $_POST["csp_labor_cost15"]); 
	   	update_post_meta($post_id, "csp_labor_qty15", $_POST["csp_labor_qty15"]); 
		update_post_meta($post_id, "csp_labor_item16", $_POST["csp_labor_item16"]);
	   	update_post_meta($post_id, "csp_labor_cost16", $_POST["csp_labor_cost16"]);  
   		update_post_meta($post_id, "csp_labor_qty16", $_POST["csp_labor_qty16"]);   
   		update_post_meta($post_id, "csp_labor_item17", $_POST["csp_labor_item17"]);
   		update_post_meta($post_id, "csp_labor_cost17", $_POST["csp_labor_cost17"]); 
   		update_post_meta($post_id, "csp_labor_qty17", $_POST["csp_labor_qty17"]);   
	   	update_post_meta($post_id, "csp_labor_item18", $_POST["csp_labor_item18"]);
	   	update_post_meta($post_id, "csp_labor_cost18", $_POST["csp_labor_cost18"]);  
	   	update_post_meta($post_id, "csp_labor_qty18", $_POST["csp_labor_qty18"]);   
	   	update_post_meta($post_id, "csp_labor_item19", $_POST["csp_labor_item19"]);
	   	update_post_meta($post_id, "csp_labor_cost19", $_POST["csp_labor_cost19"]); 
	   	update_post_meta($post_id, "csp_labor_qty19", $_POST["csp_labor_qty19"]);    
	   	update_post_meta($post_id, "csp_labor_item20", $_POST["csp_labor_item20"]);
	   	update_post_meta($post_id, "csp_labor_cost20", $_POST["csp_labor_cost20"]); 
	   	update_post_meta($post_id, "csp_labor_qty20", $_POST["csp_labor_qty20"]); 
		update_post_meta($post_id, "invoice_clientnotes", $_POST["invoice_clientnotes"]);  
	    update_post_meta($post_id, "invoice_privatenotes", $_POST["invoice_privatenotes"]); 
	    update_post_meta($post_id, "invoiceadjustment", $_POST["invoiceadjustment"]);  
	    update_post_meta($post_id, "invoicetax", $_POST["invoicetax"]);   
	      
	}  
	
	
add_action('save_post', 'save_meta_invoice'); 
    
    
// Creating the column layout when viewing list of Invoices in the backend
add_action("manage_posts_custom_column",  "invoices_custom_columns");
add_filter("manage_edit-invoices_columns", "invoices_edit_columns");
 

function invoices_edit_columns($columns){
	$columns = array(
	"cb" => "<input type=\"checkbox\" />",
	'title' => __('Invoice #', 'trans' ),
	"csp_jobsiteaddress1" => __( 'Jobsite Address', 'trans' ),
	"csp_jobsiteaddress2" => __( 'City State Zip', 'trans' ),   
	"client" => __( 'Client', 'trans' ),
	"status" => __( 'Status', 'trans' ),
	"totalz" => __( 'Total', 'trans' ),


  );
 
  return $columns;
}

function invoices_custom_columns($column)
{
	global $post;
	$custom = get_post_custom($post->ID);
        $invoicetax = $custom["invoicetax"][0];  
        $invoiceadjustment = $custom["invoiceadjustment"][0]; 
	$inv_number = $custom["inv_number"][0];  
        $due_date = $custom["due_date"][0];
	$csp_jobsiteaddress1 = $custom["csp_jobsiteaddress1"][0]; 
        $csp_jobsiteaddress2 = $custom["csp_jobsiteaddress2"][0]; 
        $client = $custom["client"][0]; 
        $invoice_status = $custom["invoice_status"][0]; 
            
    $labortotal[1] = ($custom['csp_labor_cost'][0]*$custom['csp_labor_qty'][0]);
    $labortotal[2] = ($custom['csp_labor_cost2'][0]*$custom['csp_labor_qty2'][0]);
    $labortotal[3] = ($custom['csp_labor_cost3'][0]*$custom['csp_labor_qty3'][0]);
    $labortotal[4] = ($custom['csp_labor_cost4'][0]*$custom['csp_labor_qty4'][0]);
    $labortotal[5] = ($custom['csp_labor_cost5'][0]*$custom['csp_labor_qty5'][0]);
    $labortotal[6] = ($custom['csp_labor_cost6'][0]*$custom['csp_labor_qty6'][0]);
    $labortotal[7] = ($custom['csp_labor_cost7'][0]*$custom['csp_labor_qty7'][0]);
    $labortotal[8] = ($custom['csp_labor_cost8'][0]*$custom['csp_labor_qty8'][0]);
    $labortotal[9] = ($custom['csp_labor_cost9'][0]*$custom['csp_labor_qty9'][0]);
    $labortotal[10] = ($custom['csp_labor_cost10'][0]*$custom['csp_labor_qty10'][0]);
    $labortotal[11] = ($custom['csp_labor_cost11'][0]*$custom['csp_labor_qty11'][0]);
    $labortotal[12] = ($custom['csp_labor_cost12'][0]*$custom['csp_labor_qty12'][0]);
    $labortotal[13] = ($custom['csp_labor_cost13'][0]*$custom['csp_labor_qty13'][0]);
    $labortotal[14] = ($custom['csp_labor_cost14'][0]*$custom['csp_labor_qty14'][0]);
    $labortotal[15] = ($custom['csp_labor_cost15'][0]*$custom['csp_labor_qty15'][0]);
    $labortotal[16] = ($custom['csp_labor_cost16'][0]*$custom['csp_labor_qty16'][0]);
    $labortotal[17] = ($custom['csp_labor_cost17'][0]*$custom['csp_labor_qty17'][0]);
    $labortotal[18] = ($custom['csp_labor_cost18'][0]*$custom['csp_labor_qty18'][0]);
    $labortotal[19] = ($custom['csp_labor_cost19'][0]*$custom['csp_labor_qty19'][0]);
    $labortotal[20] = ($custom['csp_labor_cost20'][0]*$custom['csp_labor_qty20'][0]);
    $materialtotal[1] = ($custom['csp_material_cost'][0]*$custom['csp_material_qty'][0]);
    $materialtotal[2] = ($custom['csp_material_cost2'][0]*$custom['csp_material_qty2'][0]);
    $materialtotal[3] = ($custom['csp_material_cost3'][0]*$custom['csp_material_qty3'][0]);
    $materialtotal[4] = ($custom['csp_material_cost4'][0]*$custom['csp_material_qty4'][0]);
    $materialtotal[5] = ($custom['csp_material_cost5'][0]*$custom['csp_material_qty5'][0]);
    $materialtotal[6] = ($custom['csp_material_cost6'][0]*$custom['csp_material_qty6'][0]);
    $materialtotal[7] = ($custom['csp_material_cost7'][0]*$custom['csp_material_qty7'][0]);
    $materialtotal[8] = ($custom['csp_material_cost8'][0]*$custom['csp_material_qty8'][0]);
    $materialtotal[9] = ($custom['csp_material_cost9'][0]*$custom['csp_material_qty9'][0]);
    $materialtotal[10] = ($custom['csp_material_cost10'][0]*$custom['csp_material_qty10'][0]);
    $materialtotal[11] = ($custom['csp_material_cost11'][0]*$custom['csp_material_qty11'][0]);
    $materialtotal[12] = ($custom['csp_material_cost12'][0]*$custom['csp_material_qty12'][0]);
    $materialtotal[13] = ($custom['csp_material_cost13'][0]*$custom['csp_material_qty13'][0]);
    $materialtotal[14] = ($custom['csp_material_cost14'][0]*$custom['csp_material_qty14'][0]);
    $materialtotal[15] = ($custom['csp_material_cost15'][0]*$custom['csp_material_qty15'][0]);
    $materialtotal[16] = ($custom['csp_material_cost16'][0]*$custom['csp_material_qty16'][0]);
    $materialtotal[17] = ($custom['csp_material_cost17'][0]*$custom['csp_material_qty17'][0]);
    $materialtotal[18] = ($custom['csp_material_cost18'][0]*$custom['csp_material_qty18'][0]);
    $materialtotal[19] = ($custom['csp_material_cost19'][0]*$custom['csp_material_qty19'][0]);
    $materialtotal[20] = ($custom['csp_material_cost20'][0]*$custom['csp_material_qty20'][0]);
    $materialsubtotal = array_sum($materialtotal);
    $laborsubtotal = array_sum($labortotal);    
    $totaltax = ($materialsubtotal*$invoicetax);
    $grandtotal = ($materialsubtotal + $laborsubtotal + $totaltax + $invoiceadjustment);
	
	$csp_settings = get_option('csp_settings');
	
	if ("ID" == $column) echo $post->ID; //displays title
elseif ('client' == $column) if ($client[-1] != ""){ echo $client[-1]; }
elseif ('csp_jobsiteaddress1' == $column) if ($csp_jobsiteaddress1[-1] != ""){ echo $csp_jobsiteaddress1[-1]; }
elseif ('csp_jobsiteaddress2' == $column) if ($csp_jobsiteaddress2[-1] != ""){ echo $csp_jobsiteaddress2[-1]; }
elseif ('status' == $column) if ($invoice_status[-1] != ""){ echo $invoice_status[-1]; }
elseif ('totaly' == $column) if ($$grandtotal[-1] != ""){ echo $csp_settings['currencysymbol'] . $grandtotal[-1] ; }


	}


function csp_inv_sortable_columns() {
return array(

'client'      => 'client',
'csp_jobsiteaddress1'      => 'csp_jobsiteaddress1',
'csp_jobsiteaddress2'      => 'csp_jobsiteaddress2',
'status'      => 'status',
'totaly'      => 'totaly',

   );
}

add_filter( "manage_edit-invoices_sortable_columns", "csp_inv_sortable_columns" );
  

