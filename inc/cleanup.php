<?php

// CLEAN UP OUTPUT OF STYLESHEET <LINK> TAGS
function clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  // ONLY DISPLAY MEDIA IF IT IS MEANINGFUL
  $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}


// CLEAN UP OUTPUT OF <SCRIPT> TAGS
function clean_script_tag($input) {
  $input = str_replace("type='text/javascript' ", '', $input);
  return str_replace("'", '"', $input);
}


// REMOVE WP VERSION PARAM FROM ANY ENQUEUED SCRIPTS
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}


// REMOVE THE <DIV> SURROUNDING THE DYNAMIC NAVIGATION TO CLEANUP MARKUP
function my_wp_nav_menu_args($args = '') {
  $args['container'] = false;
  return $args;
}


// REMOVE INVALID REL ATTRIBUTE VALUES IN THE CATEGORYLIST
function remove_category_rel_from_category_list($thelist) {
  return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}


// REMOVE WP_HEAD() INJECTED RECENT COMMENT STYLES
function my_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action('wp_head', array(
    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
    'recent_comments_style'
  ));
}


// REMOVE 'TEXT/CSS' FROM OUR ENQUEUED STYLESHEET
function _pc_style_remove($tag) {
  return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// REMOVE UNNECESSARY SELF-CLOSING TAGS
function remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}

// NO P TAGS AROUND IMG
function filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '<figure> \1\2\3 </figure>', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// Disable W3TC footer comment for all users
add_filter( 'w3tc_can_print_comment', function( $w3tc_setting ) { return false; }, 10, 1 );


// REMOVE THUMBNAIL WIDTH AND HEIGHT DIMENSIONS THAT PREVENT FLUID IMAGES IN THE_THUMBNAIL
function remove_thumbnail_dimensions( $html ) {
  $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
  return $html;
}

// REMOVE WORDPRESS EMOJIS
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

// ACTIONS
add_action( 'widgets_init', 'my_remove_recent_comments_style');
add_action( 'after_setup_theme', 'default_attachment_display_settings' );
add_action( 'init', 'disable_emojis' );

// REMOVES
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// NEW IN 4.4
remove_action('wp_head', 'wp_oembed_add_discovery_links'); // DISCOVERY LINK TAGS IN HEAD
remove_action('wp_head','wp_oembed_add_host_js'); // REMOVE OEMBED JS FILE FROM FOOTER
remove_action('wp_head','rest_output_link_wp_head'); // REMOVE REST JSON URL FROM HEAD

// FILTERS
add_filter('style_loader_tag', 'clean_style_tag');
add_filter('script_loader_tag', 'clean_script_tag');
add_filter('style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter('script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter('widget_text', 'shortcode_unautop');
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');
add_filter('the_category', 'remove_category_rel_from_category_list');
add_filter('the_excerpt', 'shortcode_unautop');
add_filter('the_excerpt', 'do_shortcode');
add_filter('style_loader_tag', '_pc_style_remove');
add_filter('image_size_names_choose', 'add_image_insert_override');
// add_filter('image_send_to_editor', '_pc_insert_image', 10, 9 );
add_filter('get_avatar', 'remove_self_closing_tags');
add_filter('comment_id_fields', 'remove_self_closing_tags');
add_filter('post_thumbnail_html', 'remove_self_closing_tags');
// add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
// add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
add_filter('wp_calculate_image_srcset_meta', '__return_null'); // DISABLE RESPONSIVE IMAGES

// REMOVE FILTERS
remove_filter('the_excerpt', 'wpautop');

