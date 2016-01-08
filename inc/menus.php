<?php

function _dg_nav_header() {
  wp_nav_menu( array(
    'theme_location'  => 'header',
    'menu' => __( 'Header Menu', '_dg'),
    'container' => false,
    'menu_class' => 'menu-header',
    'menu_id' => '',
    'items_wrap' => '<ul class="menu-header">%3$s</ul>',
    'depth' => 0,
    'fallback_cb' => 'wp_navwalker::fallback',
    'walker' => new wp_navwalker()
  ));
}

function _dg_nav_footer() {
  wp_nav_menu( array(
    'theme_location'  => 'footer',
    'menu' => __( 'Footer Menu', '_dg'),
    'container' => false,
    'menu_class' => 'menu-footer',
    'menu_id' => '',
    'items_wrap' => '<ul class="menu-footer">%3$s</ul>',
    'depth' => 0,
    'fallback_cb' => 'wp_navwalker::fallback',
    'walker' => new wp_navwalker()
  ));
}


function register_dg_menu() {
  register_nav_menus(array(
    'header' => __('Header Menu', '_dg'),
    'footer' => __('Footer Menu', '_dg')
  ));
}
add_action( 'after_setup_theme', 'register_dg_menu' );
