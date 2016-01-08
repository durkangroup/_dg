<?php
/*
// REMOVE JQUERY FROM GRAVITY FORMS
add_action("gform_enqueue_scripts", "deregister_scripts");
function deregister_scripts(){
  wp_deregister_script("jquery");
}
*/

/*
// CHANGE AJAX SPINNER IMAGE
add_filter( 'gform_ajax_spinner_url', 'tgm_io_custom_gforms_spinner' );
function tgm_io_custom_gforms_spinner( $src ) {
	return get_stylesheet_directory_uri() . '/images/loading.gif';
}
*/

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

// SWAP OUT GRAVITY FORM SUBMIT BUTTON
function grav_submit_button( $button, $form ){
  return '<button type="submit" id="gform_submit_button_'.$form["id"].'" class="submit-button"><span><em>'.$form["button"]["text"].'</em> <i class="dgicon-arrow-r"></i></span></button>';
}
add_filter( 'gform_submit_button', 'grav_submit_button', 10, 2 );

// CONFIRMATION ANCHOR
function theme_gform_confirmation_anchor($enabled) {
  return false;
}
add_filter('gform_confirmation_anchor','theme_gform_confirmation_anchor');