<?php

/*  

Plugin Name: Bulk Products From Media

Description: Plugin allow to make products from media library by bulk action. *Updated Verision* : Display in row actions , Uncategorized problem solved , explode problem solved , Accurate counter notice , Get Existing Products Names BUGS FIXED.

Author: Yousseif Ahmed 

Version: 1.8

*/

// First, we get product details

function generate_product_from_media_library($attachId) {
	
 $attachTitle = get_the_title($attachId);
 $product_name = $attachTitle;

  // Fetch the product if it already exists; otherwise, create a new product with the requested details
  $found_product = post_exists($product_name, '', '', 'product');

  if (!$found_product) {
  
      // Create a new product as a draft
      $product_data = array(
          'post_type'    => 'product',
          'post_title'   => $product_name,
          'post_content' => $product_name,
          'post_status'  => 'draft',
      );

      // Insert the post and retrieve the product ID
      $product_id = wp_insert_post($product_data);

      // Set product meta data
      update_post_meta($product_id, '_thumbnail_id', $attachId);

      $attach = array(
        'ID'           => $attachId,
        'post_parent'   => $product_id
    );
      wp_update_post($attach);
      // give true value to count
     return true;

  }

    else {

     // give false value to count
     return false;

         }
  
  return $attachId;
}

// Display a notice after generating products with counts
function admin_notice_product_generated() {

if (!empty($_REQUEST['generated'])) {

  $generated_count = intval($_REQUEST['generated']);

  printf(
    '<div id="message" class="updated notice is-dismissable"><p>' . __('Generated %d new product(s).', 'txtdomain') . '</p></div>', 
    $generated_count
  );

}

if (!empty($_REQUEST['existing'])) {
  $product_fetching_array = explode(',', $_REQUEST['product_fetching']);

  $existing_count = intval($_REQUEST['existing']);

  printf(
      '<div id="message" class="notice notice-warning is-dismissable"><p>' . __('Skipped %d existing product(s): %s', 'txtdomain') . '</p></div>',
        $existing_count, implode(', ', array_map('esc_html', $product_fetching_array))
  );

}

}

// Add a "Generate Product(s)" option to the bulk actions dropdown

function generate_product_from_media_library_bulk_action($actions) {
  $actions['generate_product_from_media_library'] = 'Generate Product(s)';
  return $actions;
}

// Handle the bulk action of generating products
 function ($redirect_url, $action, $post_ids) {

  if ($action == 'generate_product_from_media_library') {

      $generated_ids = [];
      $existing_ids = [];
      $product_fetching = [];

foreach ($post_ids as $post_id) {

$product_boolean = generate_product_from_media_library($post_id);
  $product = get_post($post_id);



if ($product_boolean) {
  $generated_ids[] = $product_boolean;
}

else {
  $existing_ids[] = $product_boolean;
  $product_fetching[] = $product->post_title;
}

}

// add existing/generated numbers to url slug for admin notice redirection

$redirect_url = add_query_arg(array(

'generated' => count($generated_ids),
'existing' => count($existing_ids),
'product_fetching' => implode(',', array_map('esc_html', preg_replace('/[$&+#^]/', '%', $product_fetching))),


 ), $redirect_url);


}
     return $redirect_url;
}


// Add Generate Product for single image in row actions


function add_generate_product_action($actions, $post) {

  $actions['generate_product_from_media_library'] = '<a href="' . wp_nonce_url(admin_url('admin-ajax.php?action=generate_product_from_media&id=' . $post->ID . '&item=' . $post->ID), 'generate-product-' . $post->ID) . '">Generate Product</a>';

  return $actions;

}

// Calling the generate product from media library function after redirect


function generate_product_from_media_ajax() {

  // Check nonce and get ID
    $id = $_GET['id'];


  if ( isset($_GET['item']) ) {

    $id = $_GET['item'];

  }

  $generated = generate_product_from_media_library($id);

  if ($generated) {

    set_transient('product_generated_' . $id, true, 30);

  } 
  
    else {

      set_transient('product_generated_error_' . $id, true, 30); 

  }

  // Redirect back to Media page
  $redirect_url = admin_url('upload.php?item=' . $id);

  wp_safe_redirect($redirect_url);

  exit;

}

// Display notice on Media page
function media_generated_product_notice() {

	$item_id = isset($_GET['item']) ? $_GET['item'] : 0;

	
  if ( get_transient( 'product_generated_' . $item_id ) ) {

    // Success notice
    printf('<div id="message" class="notice notice-warning is-dismissable"><p>' . __('Successfully Product Has Been Generated', 'txtdomain') . '</p></div>');


  } 
  
    else if ( get_transient( 'product_generated_error_' . $item_id ) ) {
   
    // Error notice
    printf('<div id="message" class="notice notice-warning is-dismissable"><p>' . __('Cannot Generate, Product Already Existed', 'txtdomain') . '</p></div>');

    }

  // Delete transient
    delete_transient('product_generated_' . $item_id );  
    delete_transient('product_generated_error_' . $item_id);

}

add_action('admin_notices', 'media_generated_product_notice');
