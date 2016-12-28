<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Admin Styles
 *
 * Helps to visually separate ACF blocks out when there's a lot of them.
 */
function admin_styles() {
  echo '<style>
    .acf-postbox h2.hndle {
      background: #ebebeb;
      color: #424242;
      font-size: 21px !important;
    }
    .acf-postbox.closed h2.hndle {
    background: #dbdbdb;
    }
  </style>';
}
add_action( 'admin_head', __NAMESPACE__ . '\\admin_styles' );

/**
 * Add the SVG Mime type to the uploader
 * @author Alain Schlesser (alain.schlesser@gmail.com)
 * @link https://gist.github.com/schlessera/1eed8503110fb3076e73
 *
 * @param  array $mimes list of mime types that are allowed by the
 * WordPress uploader
 *
 * @return array modified version of the $mimes array
 *
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
 * @see http://www.w3.org/TR/SVG/mimereg.html
 */
function as_svg_mime_type( $mimes ) {
  // add official SVG mime type definition to the array of allowed mime types
  $mimes['svg'] = 'image/svg+xml';
  // return the modified array
  return $mimes;
}
add_filter( 'upload_mimes', __NAMESPACE__ . '\\as_svg_mime_type' );

/**
 * Fix Gravity Form Tabindex Conflicts
 *
 * @see http://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
 *
 * @param $tab_index
 * @param bool $form
 *
 * @return int
 */
function gform_tabindexer( $tab_index, $form = false ) {
  $starting_index = 1000; // if you need a higher tabindex, update this number
  if ( $form ) {
    add_filter( 'gform_tabindex_' . $form['id'], __NAMESPACE__ . '\\gform_tabindexer' );
  }
  return \GFCommon::$tab_index >= $starting_index ? \GFCommon::$tab_index : $starting_index;
}
add_filter( 'gform_tabindex', __NAMESPACE__ . '\\gform_tabindexer', 10, 2 );
