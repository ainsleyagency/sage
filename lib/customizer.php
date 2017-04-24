<?php

namespace Roots\Sage\Customizer;

use Roots\Sage\Assets;

/**
 * Add postMessage support
 */
function customize_register( $wp_customize ) {
  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
}

add_action( 'customize_register', __NAMESPACE__ . '\\customize_register' );


/**
 * Ainsley Customizer Options
 *
 * @param $wp_customize
 */
function ainsley_customize( $wp_customize ) {

  /*
  * ****** Miscellaneous Section *******
  */
  $wp_customize->add_section( 'misc_settings', [
    'priority'   => 25,
    'capability' => 'edit_theme_options',
    'title'      => __( 'Miscellaneous', 'sage' )
  ] );

  // Hide Show ACF (if ACF is active)
  if(class_exists('acf')) :

    $wp_customize->add_setting( 'acf_visibility', array(
      'default' => 'show'
    ) );

    $wp_customize->add_control( 'acf_visibility', array(
      'type'    => 'radio',
      'section' => 'misc_settings',
      'label'   => __( 'Hide / Show the ACF menu' ),
      'choices' => array(
        'hide' => __( 'Hide' ),
        'show' => __( 'Show' ),
      ),
    ) );

  endif;

  // end ainsley_customize
}
add_action( 'customize_register', __NAMESPACE__ . '\\ainsley_customize' );

/**
 * Customizer JS
 */
function customize_preview_js() {
  wp_enqueue_script( 'sage/customizer', Assets\asset_path( 'scripts/customizer.js' ), [ 'customize-preview' ], null, true );
}

add_action( 'customize_preview_init', __NAMESPACE__ . '\\customize_preview_js' );
