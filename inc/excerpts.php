<?php

// Index page Excerpt, call using _dg_excerpt('_dg_index');
function _dg_index($length) {
  return 20;
}

// Custom Post Excerpt, call using _dg_excerpt('_dg_custom_post');
function _dg_model($length) {
  return 40;
}

// Create the Custom Excerpts callback
function _dg_excerpt($length_callback = '', $more_callback = '') {
  global $post;
  if (function_exists($length_callback)) {
      add_filter('excerpt_length', $length_callback);
  }
  if (function_exists($more_callback)) {
      add_filter('excerpt_more', $more_callback);
  }
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';
  echo $output;
}

// Custom View Article link to Post
function _dg_view_article($more) {
  global $post;
  return '...';
}
add_filter('excerpt_more', '_dg_view_article');
