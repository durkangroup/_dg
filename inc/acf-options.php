<?php

if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title'  => 'Global Theme Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'global-theme-settings',
    'capability'  => 'edit_posts',
    'icon_url'    => '',
    'redirect'    => false

  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Header Settings',
    'menu_title'  => 'Header',
    'parent_slug' => 'global-theme-settings',
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Footer Settings',
    'menu_title'  => 'Footer',
    'parent_slug' => 'global-theme-settings',
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Site Social Links',
    'menu_title'  => 'Social Links',
    'parent_slug' => 'global-theme-settings',

  ));

}
