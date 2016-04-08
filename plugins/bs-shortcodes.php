<?php

/**
 * Shortcodes to create responsive columns in the WordPress content, using Twitter Bootstrap.
 * For further details about sizes, offset and clearfix, take a look at http://getbootstrap.com/css/#grid
 */

/**
 * Shortcode to add a row containing columns
 * Parameters:
 *  - classes: additional classes
 *  - element: element type, default: div
 */
function bootstrapRow($attributes, $content) {
  extract(shortcode_atts(array(
  "classes" => null,
  "element" => "div"
  ), $attributes));
  $result = "\n<$element class=\"row";
  if ($classes) $result .= " $classes";

  $result.= "\">\n";
  $result.=do_shortcode($content);
  $result.="\n</$element>\n";

  return $result;

}
add_shortcode("row", "bootstrapRow");

/**
 * Shortcode to display columns in the content
 * Parameters:
 *  - all: set every sizes at once, to be sure... Take a value between 1 and 12
 *  - xs: set size for device with small screen. Take a value between 1 and 12
 *  - sm
 *  - md
 *  - lg: set size for device with large screen
 *  - offset-all: set every offsets at once, to be sure...
 *  - offset-xs
 *  - offset-sm
 *  - offset-md
 *  - offset-lg
 *  - classes: additional classes
 *  - element: element type, default: div
 * Examples:
 *  [row][col all="6" offsetall="6"]This column width is the half of the total width,
 *    on the right side of the content, for every devices (small to large)[/col][/row]
 *  [row][col md="6" xs="12"]Full size for small devices, half width for
 *    others[/col][col md="6" xs="12"]Full size for small devices, half width
 *    for others[/col][/row]
 */
function bootstrapColumn($attributes, $content) {
  extract(shortcode_atts(array(
  "all" => null,
  "xs" => null,
  "sm" => null,
  "md" => null,
  "lg" => null,
  "offsetall" => null,
  "offsetxs" => null,
  "offsetsm" => null,
  "offsetmd" => null,
  "offsetlg" => null,
  "classes" => null,
  "element" => "div"
  ), $attributes));
  $result = "\n<$element class=\"";
  if ($all) {
    $result .= "col-xs-$all col-sm-$all col-md-$all col-lg-$all";
  } else {
    if ($xs) $result .= " col-xs-$xs";
    if ($sm) $result .= " col-sm-$sm";
    if ($md) $result .= " col-md-$md";
    if ($lg) $result .= " col-lg-$lg";
  }
  if ($offsetall) {
    $result .= " col-xs-offset-$offsetall col-sm-offset-$offsetall col-md-offset-$offsetall col-lg-offset-$offsetall";
  } else {
    if ($offsetxs) $result .= " col-xs-offset-$offsetxs";
    if ($offsetsm) $result .= " col-sm-offset-$offsetsm";
    if ($offsetmd) $result .= " col-md-offset-$offsetmd";
    if ($offsetlg) $result .= " col-lg-offset-$offsetlg";
  }
  if ($classes) $result .= " $classes";

  $result.= "\">\n";
  $result.=do_shortcode($content);
  $result.="\n</$element>\n";

  return $result;
}
add_shortcode("col", "bootstrapColumn");

/**
 * Shortcode to clearfix columns, i.e. push column to left despite the previous columns height
 * Parameters:
 *  - xs: enable clearfix for xs columns (take any value)
 *  - sm
 *  - md
 *  - lg
 *  - classes: additional classes
 *  - element: element type, default: div
 */
function bootstrapClearfix($attributes, $content) {
  extract(shortcode_atts(array(
  "xs" => null,
  "sm" => null,
  "md" => null,
  "lg" => null,
  "classes" => null,
  "element" => "div"
  ), $attributes));
  $result = "\n<$element class=\"clearfix";
  if ($xs) $result .= " visible-xs";
  if ($sm) $result .= " visible-sm";
  if ($md) $result .= " visible-md";
  if ($lg) $result .= " visible-lg";
  if ($classes) $result .= " $classes";

  $result.= "\">\n";
  $result.=do_shortcode($content);
  $result.="\n</$element>\n";

  return $result;
}
add_shortcode("clearfix", "bootstrapClearfix");

function remove_empty_tags_around_shortcodes( $content ){
    $tags = array(
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br>' => ']',
        '<br />' => '',
        ']<br />' => ']'
    );

    $content = strtr( $content, $tags );
    return $content;
}
add_filter( 'the_content', 'remove_empty_tags_around_shortcodes' );