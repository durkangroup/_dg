<?php


// ADD A CUSTOM CSS FILE TO WP ADMIN AREA
function _pc_admin_style() {
  wp_register_style('adminstyle', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0', 'all');
  wp_enqueue_style('adminstyle');
}
add_action('admin_enqueue_scripts', '_pc_admin_style');


// ADMIN FAVICON
function _pc_admin_favicon(){
  echo '<link rel="icon" href="'.get_bloginfo('template_directory').'/assets/img/favicon-wp.ico">';
}
add_action( 'admin_head', '_pc_admin_favicon' );


// CUSTOM FOOTER
function _pc_admin_footer() {
  _e( '<span id="dg-info"></span>', '_pc' );
}
add_filter( 'admin_footer_text', '_pc_admin_footer' );



// http://tinymce.moxiecode.com/wiki.php/Configuration
// DON'T REMOVE ADDITIONAL LINE BREAKS IN EDITOR
function custom_tinymce_config( $init ) {
    // Remove line breaks
    $init['remove_linebreaks'] = false;
    // Pass $init back to WordPress
    return $init;
}
add_filter('tiny_mce_before_init', 'custom_tinymce_config');


// REMOVE REVISIONS META BOX AND RECREATE ON RIGHT SIDE FOR ALL POST TYPES
function relocate_revisions_metabox() {
  $args = array(
  'public'   => true,
  '_builtin' => false
  );
  $output = 'names'; // names or objects
  $post_types = get_post_types($args,$output);
  foreach ($post_types  as $post_type) {
    remove_meta_box('revisionsdiv',$post_type,'normal');
    add_meta_box('revisionssidediv2', __('Revisions'), 'post_revisions_meta_box', $post_type, 'side', 'low');
    remove_meta_box('authordiv',$post_type,'normal');
    add_meta_box('authorsidediv2', __('Author'), 'post_author_meta_box', $post_type, 'side', 'low');
  }

  // PAGE
  remove_meta_box('revisionsdiv','page','normal');
  add_meta_box('revisionssidediv2', __('Revisions'), 'post_revisions_meta_box', 'page', 'side', 'low');
  remove_meta_box('authordiv','page','normal');
  add_meta_box('authorsidediv2', __('Author'), 'post_author_meta_box', 'page', 'side', 'low');

  // POST
  remove_meta_box('revisionsdiv','post','normal');
  add_meta_box('revisionssidediv2', __('Revisions'), 'post_revisions_meta_box', 'post', 'side', 'low');
  remove_meta_box('authordiv','post','normal');
  add_meta_box('authorsidediv2', __('Author'), 'post_author_meta_box', 'post', 'side', 'low');

}
add_action('admin_init','relocate_revisions_metabox');



// POST SCREEN EDITS
if (is_admin()) {

  $prefix = 'post_';
  $post_type = 'post';

  // hide admin post panels
  function post_metaboxes() {
    remove_meta_box('trackbacksdiv','post','normal');
    remove_meta_box('postcustom','post','normal');
    remove_meta_box('commentstatusdiv','post','normal');
    remove_meta_box('commentsdiv','post','normal');
    // remove_meta_box('authordiv','post','normal');
    // remove_meta_box('tagsdiv-post_tag','post','side');
  }
  add_action('admin_init','post_metaboxes');

}

// PAGE SCREEN EDITS
if (is_admin()) {

  $prefix = 'page_';
  $post_type = 'page';

  // hide admin page panels
  function page_metaboxes() {
    remove_meta_box('trackbacksdiv','page','normal');
    remove_meta_box('postcustom','page','normal');
    remove_meta_box('commentstatusdiv','page','normal');
    remove_meta_box('commentsdiv','page','normal');
    remove_meta_box('authordiv','page','normal');
    remove_meta_box('pageauthordiv','page','normal');
    remove_meta_box('tagsdiv','page','side');
  }
  add_action('admin_init','page_metaboxes');

}


// CUSTOM LOGIN PAGE

function _pc_login_css() {
  wp_enqueue_style('adminstyle', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0', 'all');
}

// changing the logo link from wordpress.org to your site
function _pc_login_url() { return home_url(); }

// changing the alt text on the logo to show your site name
function _pc_login_title() { return get_option( 'blogname' ); }

function _pc_lostpwd_page() { return home_url() . '/wp-login.php?action=lostpassword'; }

// calling it only on the login page
add_action( 'login_enqueue_scripts', '_pc_login_css', 10 );
add_filter( 'login_headerurl', '_pc_login_url' );
add_filter( 'login_headertitle', '_pc_login_title' );
add_filter( 'lostpassword_url', '_pc_lostpwd_page' );


/*
// ADD CUSTOM LOGO TO LOGIN PAGE
// image size 310x70
function _pc_login_logo() {
  echo '<style>.login h1 a { background:url("'.get_bloginfo('template_directory').'/assets/img/logo.png") no-repeat center top; width:auto; }</style>';
}
add_action('login_head', '_pc_login_logo');



// CUSTOM LOGIN PAGE

function indo_login_css() {
  wp_enqueue_style( 'indo_login_css', BASE_ASSETS_DIR . 'css/admin/login.css', false );
}

// changing the logo link from wordpress.org to your site
function indo_login_url() { return home_url(); }

// changing the alt text on the logo to show your site name
function indo_login_title() { return get_option( 'blogname' ); }

function indo_lostpwd_page() { return home_url() . '/wp-login.php?action=lostpassword'; }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'indo_login_css', 10 );
add_filter( 'login_headerurl', 'indo_login_url' );
add_filter( 'login_headertitle', 'indo_login_title' );
add_filter( 'lostpassword_url', 'indo_lostpwd_page' );


// Adds a custom logo to the Dashboard

function dashboard_logo() {
    ?>
    <!-- Custom Dashboard Logo -->
    <style type="text/css">
    .index-php .wrap h2:nth-child(2) {
        visibility: hidden;
        line-height: 1px;
    }
    .index-php #icon-index {
        background-image:url("<?php echo $this->logo_path; ?>") !important;
        background-size: <?php echo $this->logo_width; ?>px <?php echo $this->logo_height ?>px !important;
        background-position: 0px 0px !important;
        height: <?php echo $this->logo_height ?>px !important;
        width: <?php echo $this->logo_width; ?>px !important;
        float: none !important;
        margin-top: 15px !important;
    }
    </style>
    <!--/ Custom Dashboard Logo -->
    <?php
}
*/

// REMOVE WORDPRESS LOGO
function remove_wp_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );

// CUSTOM LOGO MENU
function custom_adminbar_menu( $meta = TRUE ) {
  global $wp_admin_bar;
    if ( !is_user_logged_in() ) { return; }
    if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }
  $wp_admin_bar->add_menu( array(
    'id' => '_pc_logo',
    'title' => __( '<i class="_pcicon-d-sq"></i>' ) )
  );
  $wp_admin_bar->add_menu( array(
    'parent' => '_pc_logo',
    'id'     => 'custom_link1',
    'title' => __( 'About Durkan Group'),
    'href' => 'http://durkangroup.com',
    'meta'  => array( 'target' => '_blank' ) )
  );
  /* menu links */
  $wp_admin_bar->add_menu( array(
    'parent'    => '_pc_logo',
    'id'     => 'custom_link2',
    'title'     => 'Send Support Request',
    'href'  => 'mailto:support@durkangroup.com',
    'meta'  => array( 'target' => '_blank' ) )
  );

}
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );


// REMOVE ADMIN BAR
function remove_admin_bar() {
  return false;
}
add_filter('show_admin_bar', 'remove_admin_bar');


// REMOVE USELESS DASHBOARD WIDGETS
function remove_dashboard_widgets() {
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', 'remove_dashboard_widgets');


// ADD AN EDITOR STYLE
function _pc_editor_style() {
  add_editor_style( get_template_directory_uri() . '/assets/css/editor-style.css' );
}
add_action('init', '_pc_editor_style');

// ADD/REMOVE CLASSES FROM THE STYLE PROPERTIES DROP DOWN
function add_styleselect_classes($initArray) {
  // add style dropdown
  $initArray['theme_advanced_buttons2_add_before'] = "styleselect";
  // base
  $initArray['theme_advanced_styles'] = "Align Center=aligncenter;Align Left=alignleft;Align Right=alignright";
  // new
  $initArray['theme_advanced_styles'] .= ";Button=button";
  return $initArray;
}
add_filter('tiny_mce_before_init', 'add_styleselect_classes');