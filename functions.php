<?php


// SET UP THEME DEFAULTS
if ( ! function_exists( '_dg_setup' ) ) :
function _dg_setup() {

  $content_width = 760;

  load_theme_textdomain( '_dg', get_template_directory() . '/languages' );

  add_theme_support( 'automatic-feed-links' );

  add_theme_support('menus');

  add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

  // add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

  add_theme_support('post-thumbnails', array('post'));

  set_post_thumbnail_size(160, 160, true);

  add_image_size('post-small', 200, 9999);
  add_image_size('post-half', 400, 9999);
  add_image_size('post-size', 800, 9999);
  add_image_size('post-wide', 1000, 9999);
  add_image_size('post-full', 1600, 800, true);

  add_image_size('post-featured-xs', 480, 240, true);
  add_image_size('post-featured-sm', 640, 320, true);
  add_image_size('post-featured-md', 800, 400, true);
  add_image_size('post-featured-lg', 1280, 640, true);
  add_image_size('post-featured-xl', 1600, 800, true);

  add_image_size('article-cover', 1600, 900, true);

}
endif;


// ENQUEUE STYLES
function _dg_styles() {

  wp_register_style('fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), '1.0', 'all');
  wp_enqueue_style('fonts');

  wp_register_style('style', get_template_directory_uri() . '/assets/css/style.css?'. filemtime(get_stylesheet_directory() . '/assets/css/style.css'));
  wp_enqueue_style('style');

}

// ENQUEUE SCRIPTS
function _dg_scripts() {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    // FOOT
    wp_register_script('vendor', get_template_directory_uri() . '/assets/js/vendor.js?'. filemtime(get_stylesheet_directory() . '/assets/js/vendor.js'), array(), '1.0', true );
    wp_enqueue_script('vendor');

    wp_register_script('app', get_template_directory_uri() . '/assets/js/app.js?'. filemtime(get_stylesheet_directory() . '/assets/js/app.js'), array('vendor'), '1.0', true );
    wp_enqueue_script('app');

  }
}


// ENQUEUE CONDITIONAL SCRIPTS
// function _dg_conditional_scripts() {
//   if (is_page('pagenamehere')) {
//     wp_register_script('scriptname', get_template_directory_uri() . '/assets/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
//     wp_enqueue_script('scriptname');
//   }
// }


// ACTIONS
add_action( 'after_setup_theme', '_dg_setup' );
add_action( 'wp_enqueue_scripts', '_dg_styles' );
add_action( 'wp_enqueue_scripts', '_dg_scripts' );
// add_action( 'wp_print_scripts', '_dg_conditional_scripts' );


// CUSTOM INCLUDED FUNCTIONS
include_once(TEMPLATEPATH.'/inc/cleanup.php');
include_once(TEMPLATEPATH.'/inc/extras.php');
include_once(TEMPLATEPATH.'/inc/admin.php');
include_once(TEMPLATEPATH.'/inc/template-tags.php');
include_once(TEMPLATEPATH.'/inc/menus.php');
include_once(TEMPLATEPATH.'/inc/navwalker.php');
include_once(TEMPLATEPATH.'/inc/sidebars.php');
include_once(TEMPLATEPATH.'/inc/widgets.php');
include_once(TEMPLATEPATH.'/inc/excerpts.php');
include_once(TEMPLATEPATH.'/inc/gravityforms.php');
include_once(TEMPLATEPATH.'/inc/shortcode-slick.php');

include_once(TEMPLATEPATH.'/plugins/bs-shortcodes.php');

// SMOOTH STATE ANIMATION
$smoothAnimation = "scene_element--fadein";