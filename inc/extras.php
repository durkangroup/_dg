<?php

// THREADED COMMENTS
// function enable_threaded_comments() {
//   if (!is_admin()) {
//     if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
//         wp_enqueue_script('comment-reply');
//     }
//   }
// }
// add_action('get_header', 'enable_threaded_comments');


// UPLOAD SVG
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// GET THE SLUG
function the_slug($echo=true){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}

// over-ride image_size_names_choose
function add_image_insert_override($size_names){

  global $_wp_additional_image_sizes;

 //default array with hardcoded values for add_image_size
  $size_names = array(
    'post-small'=> __('Small Width'),
    'post-half' => __('Half Width'),
    'post-size' => __('Post Width'),
    'post-wide' => __('Wide Width'),
    'post-full' => __('Window Width')
  );
  return $size_names;
};


// REMOVE IMAGE INSERT DEFAULTS
function default_attachment_display_settings() {
  update_option( 'image_default_align', 'none' );
  update_option( 'image_default_link_type', 'none' );
  update_option( 'image_default_size', 'post-size' );
}

//http://stackoverflow.com/questions/23812072/wordpress-3-9-x-remove-inline-width-from-figure-element
/** Register the html5 figure-non-responsive code fix. */
add_filter( 'img_caption_shortcode', 'myfix_img_caption_shortcode_filter', 10, 3 );

function myfix_img_caption_shortcode_filter($dummy, $attr, $content) {
$atts = shortcode_atts( array(
    'id'      => '',
    'align'   => 'alignnone',
    'width'   => '',
    'caption' => '',
    'class'   => '',
), $attr, 'caption' );

$atts['width'] = (int) $atts['width'];
if ( $atts['width'] < 1 || empty( $atts['caption'] ) )
    return $content;

if ( ! empty( $atts['id'] ) )
    $atts['id'] = 'id="' . esc_attr( $atts['id'] ) . '" ';

$class = trim( 'wp-caption ' . $atts['align'] . ' width-'.$atts['width']. ' ' . $atts['class'] );

if ( current_theme_supports( 'html5', 'caption' ) ) {
    return '<figure class="' . esc_attr( $class ) . '"><span>'
    . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></span></figure>';
}

// Return nothing to allow for default behaviour!!!
return '';
}