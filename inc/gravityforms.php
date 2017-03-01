<?php

// MAKE SCRIPTS LOAD IN FOOTER
function wrap_gform_cdata_open( $content = '' ) {
  $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
  return $content;
}
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );

function wrap_gform_cdata_close( $content = '' ) {
  $content = ' }, false );';
  return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );


// THIS LOADS A FAKE JQUERY FILE AND REMOVES IT SO GRAVITY FORMS JS PRINTS
function gc_load_javascript_in_footer() {

  wp_enqueue_script( 'jquery', '//fake-jquery.js', array(), null );

  function fake_jquery($tag) {
    $tag = ( strpos($tag, 'fake-jquery') !== false ) ? '' : $tag;
    return $tag;
  }
  add_filter( 'script_loader_tag', 'fake_jquery' );
}
add_action('wp_footer', 'gc_load_javascript_in_footer');


// SWAP OUT GRAVITY FORM SUBMIT BUTTON
function grav_submit_button( $button, $form ){
  return '<button type="submit" id="gform_submit_button_'.$form["id"].'" class="btn--submit icon-change"><span>'.$form["button"]["text"].'</span> <i class="_pcicon-arrow-right"></i></button>';
}
add_filter( 'gform_submit_button', 'grav_submit_button', 10, 2 );


// CONFIRMATION ANCHOR
add_filter( 'gform_confirmation_anchor', function() {
  return false;
});