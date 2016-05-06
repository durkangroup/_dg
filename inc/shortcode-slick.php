<?php

// wp_get_attachment() function:
function wp_get_attachment( $attachment_id ) {
  $attachment = get_post( $attachment_id );
  return array(
    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
    'caption' => $attachment->post_excerpt,
    'description' => $attachment->post_content,
    'href' => get_permalink( $attachment->ID ),
    'src' => $attachment->guid,
    'title' => $attachment->post_title
  );
}

// Remove hook for the default shortcode...
remove_shortcode('gallery', 'gallery_shortcode');

// .. and create a new shortcode with the default WordPress shortcode name (tag) for the gallery
add_shortcode('gallery', function($atts) {
  $attrs =
    shortcode_atts(array(
      'slider'              => md5(microtime().rand()), // Slider ID (is per default unique)
      'slider_class_name'   => '', // Optional slider css class
      'ids'                 => '', // Comma separated list of image ids
      'size'                => 'post-full', // Image format (could be an custom image format)
      'slides_to_show'      => 1,
      'slides_to_scroll'    => 1,
      'dots'                => false,
      'infinite'            => true,
      'speed'               => 300,
      'touch_move'          => true,
      'autoplay'            => false,
      'autoplay_speed'      => 2000,
      'accessibility'       => true,
      'arrows'              => true,
      'center_mode'         => true,
      'center_padding'      => '50px',
      'css_ease'            => 'ease',
      'dots_class'          => 'slick-dots',
      'draggable'           => true,
      'easing'              => 'linear',
      'fade'                => false,
      'focus_on_select'     => false,
      'lazy_load'           => 'ondemand',
      'on_before_change'    => null,
      'pause_on_hover'      => true,
      'pause_on_dots_hover' => false,
      'rtl'                 => false,
      'slide'               => 'div',
      'swipe'               => true,
      'touch_move'          => true,
      'touch_threshold'     => 5,
      'use_css'             => true,
      'vertical'            => false,
      'wait_for_animate'    => true
    ), $atts);

  extract($attrs);

  // Verify if the chosen image format really exist
  if( !in_array( $size, get_intermediate_image_sizes()) ) {
    echo 'Image Format <strong>'.$size.'</strong> Not Available!';
    exit;
  }

  // Iterate over attribute array, cleanup and make the array elements JavaScript ready
  foreach( $attrs as $key => $attr ) {

    // CamelCase the array keys
    $new_key_name = lcfirst(str_replace(array(' ', 'Css'), array('', 'CSS'), ucwords(str_replace('_', ' ', $key))));

    // Remove unnecessary array elements
    if( in_array($key, array('ids', 'slider_class_name')) || strpos($key, '_') !== false ) {
      unset($attrs[$key]);
    }

    // Fix the type before passing the array elements to JavaScript
    if( is_numeric($attr) ) {
      $attrs[$new_key_name] = (int) $attr;
    } else if ( is_bool($attr) || (strpos($attr, 'true') !== false || strpos($attr, 'false') !== false) ) {
      $attrs[$new_key_name] = filter_var($attr, FILTER_VALIDATE_BOOLEAN);
    } else if ( is_int($attr) ) {
      $attrs[$new_key_name] = filter_var($attr, FILTER_VALIDATE_INT);
    }
  }

  // Create an empty variable for return html content
  $html_output = '';

  // Check if the slider should be unique and do some unique stuff (*optional)
  if( ctype_xdigit($slider) && strlen($slider) === 32 ) {
    $is_unique = true;
  } else {
    $is_unique = false;
  }

  // Build the html slider structure (open)
  $html_output .= '<div data-slick class="'.$slider_class_name.' '.$slider.' slider wp-slick-slider '.$size.'">';

  // Iterate over the comma separated list of image ids and keep only the real numeric ids
  foreach( array_filter( array_map(function($id){ return (int) $id; }, explode(',', $ids)) ) as $media_id) {

    // Get the image by media id and build the html div group with the image source, width and height
    if( $image_data = wp_get_attachment_image_src( $media_id, $size ) ) {
      $image_meta = wp_get_attachment($media_id);

      if ( $image_meta['caption'] != '') {
        $captionclass = "has--caption";
      } else {
        $captionclass = "no--caption";
      }

      $html_output .= '<div><figure class="image"><img data-lazy="'.esc_url($image_data[0]).'"><figcaption class="'.$captionclass.'">'. $image_meta['caption'] .'</figcaption></figure></div>';
    }

  }

  // Close the html slider structure and return the html output
  return $html_output.'</div>';
});