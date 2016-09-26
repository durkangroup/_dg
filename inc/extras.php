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


// convert the_content filter items to HTTPS
function filter_wp_content_for_ssl($content) {
  if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
    $wpurl = parse_url(get_bloginfo('wpurl'));
    $nonssl = 'http://'.$wpurl['host'];
    $ssl = 'https://'.$wpurl['host'];
    $content = str_replace($nonssl,$ssl,$content);
  }
  return $content;
}
add_filter('the_content', 'filter_wp_content_for_ssl', 100);

// filter acf items to HTTPS
add_filter('acf/format_value/type=wysiwyg', 'format_value_wysiwyg', 10, 3);
add_filter('acf/format_value_for_api/type=wysiwyg', 'format_value_wysiwyg', 10, 3);
function format_value_wysiwyg( $value, $post_id, $field ) {
  if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
    $wpurl = parse_url(get_bloginfo('wpurl'));
    $nonssl = 'http://'.$wpurl['host'];
    $ssl = 'https://'.$wpurl['host'];
    $value = str_replace($nonssl,$ssl,$value);
  }
  return $value;
}


// WRAP EMBEDDED VIDEOS
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="video-container"><div>' . $html . '</div></div>';
}


// ACF SYNC WITH FEATURED IMAGE
function acf_set_featured_image( $value, $post_id, $field  ){
  if($value != ''){
    // add_post_meta($post_id, '_thumbnail_id', $value);
    update_post_meta($post_id, '_thumbnail_id', $value);
  }
  return $value;
}
add_filter('acf/update_value/name=cover_image', 'acf_set_featured_image', 10, 3);


/*
//Save ACF field as post_content for front-end

add_action('acf/save_post', 'change_content_frontend');

function change_content_frontend($post_id) {
  if(get_post_type( $post_id ) == 'post'){
    $my_post = array();
    $my_post['ID'] = $post_id;
    $my_post['post_content'] = get_post_meta($post_id,'article_content',true);
    remove_action('acf/save_post', 'change_content_frontend');
      wp_update_post( $my_post );
    add_action('acf/save_post', 'change_content_frontend');
  }
}
*/

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
    'post-full' => __('Window Width'),
    'full'      => __('Full Size')
  );
  return $size_names;
};


// REMOVE IMAGE INSERT DEFAULTS
function default_attachment_display_settings() {
  update_option( 'image_default_align', 'none' );
  update_option( 'image_default_link_type', 'none' );
  update_option( 'image_default_size', 'post-size' );
}

/*
// INSERT IMAGES WITHIN FIGURE ELEMENT FROM MEDIA UPLOADER
function _dg_insert_image($html, $id, $caption, $title, $align, $url, $size, $alt) {
  $src  = wp_get_attachment_image_src( $id, $size, false );

  if ($align == 'none') {
    $html5 = "<figure>";
  } else if ($align == 'left') {
    $html5 = "<figure class='alignleft'>";
  } else if ($align == 'right') {
    $html5 = "<figure class='alignright'>";
  } else if ($align == 'center') {
    $html5 = "<figure class='aligncenter'>";
  } else {
    $html5 = "<figure>";
  }

  if ($caption) {
    $html5 .= "<img src='$src[0]' alt='$alt'><figcaption>$caption</figcaption>";
  } else {
    $html5 .= "<img src='$src[0]' alt='$alt'>";
  }
  $html5 .= "</figure>";
  return $html5;
}
*/


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