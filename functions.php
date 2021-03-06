<?php
// Theme support options
require_once(get_template_directory().'/assets/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/assets/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/assets/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/assets/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/assets/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/assets/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/assets/functions/page-navi.php');

// Adds support for multiple languages
require_once(get_template_directory().'/assets/translation/translation.php'); 


/*****

/* Define the custom box */
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'myplugin_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function myplugin_add_custom_box() {
  global $post;
    if ( 'template-homepage-2017.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
          add_meta_box( 'wp_editor_test_8_box', 'DSA Feature Box', 'wp_editor_meta_box_8' );
          add_meta_box( 'wp_editor_test_4_box', 'Final Row', 'wp_editor_meta_box_4' );
          add_meta_box( 'wp_editor_test_11_box', 'DSA Alert Box', 'wp_editor_meta_box_11' );
    }
}

/* Prints the box content */
function wp_editor_meta_box_4( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  $field_value = get_post_meta( $post->ID, '_dsa_column_right', false );
  wp_editor( $field_value[0], '_dsa_column_right' );
}

function wp_editor_meta_box_8( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  $field_value = get_post_meta( $post->ID, '_dsa_feature_box', false );
  wp_editor( $field_value[0], '_dsa_feature_box' );
}

function wp_editor_meta_box_11( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  $field_value = get_post_meta( $post->ID, '_dsa_alert_box', false );
  wp_editor( $field_value[0], '_dsa_alert_box' );
}


/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {

  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( ( isset ( $_POST['myplugin_noncename'] ) ) && ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) ) )
      return;

  // Check permissions
  if ( ( isset ( $_POST['post_type'] ) ) && ( 'page' == $_POST['post_type'] )  ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }    
  }
  else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  // OK, we're authenticated: we need to find and save the data

  if ( isset ( $_POST['_dsa_column_right'] ) ) {
    update_post_meta( $post_id, '_dsa_column_right', $_POST['_dsa_column_right'] );
  }

  if ( isset ( $_POST['_dsa_feature_box'] ) ) {
    update_post_meta( $post_id, '_dsa_feature_box', $_POST['_dsa_feature_box'] );
  }
   if ( isset ( $_POST['_dsa_alert_box'] ) ) {
    update_post_meta( $post_id, '_dsa_alert_box', $_POST['_dsa_alert_box'] );
  }

}


/*****



// Remove 4.2 Emoji Support
// require_once(get_template_directory().'/assets/functions/disable-emoji.php'); 

// Adds site styles to the WordPress editor
//require_once(get_template_directory().'/assets/functions/editor-styles.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/assets/functions/related-posts.php'); 

// Use this as a template for custom post types
// require_once(get_template_directory().'/assets/functions/custom-post-type.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/assets/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/assets/functions/admin.php'); 