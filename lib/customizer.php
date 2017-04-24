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
  if ( class_exists( 'acf' ) ) :

    $wp_customize->add_setting( 'acf_visibility', array(
      'default' => 'show'
    ) );

    $wp_customize->add_control( 'acf_visibility', array(
      'type'     => 'radio',
      'section'  => 'misc_settings',
      'settings' => 'acf_visibility',
      'label'    => __( 'Hide / Show the ACF menu' ),
      'choices'  => array(
        'hide' => __( 'Hide' ),
        'show' => __( 'Show' ),
      ),
    ) );

  endif;

  $wp_customize->add_setting( 'tracking_type', array(
    'default' => 'none'
  ) );

  $wp_customize->add_control( 'tracking_type', array(
    'type'     => 'radio',
    'section'  => 'misc_settings',
    'settings' => 'tracking_type',
    'label'    => __( 'Tracking Type' ),
    'choices'  => array(
      'none' => __( 'None' ),
      'gtm'  => __( 'Google Tag Manager' ),
      'ga'   => __( 'Google Analytics' ),
    ),
  ) );

  $wp_customize->add_setting( 'gtm_id', [
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field'
  ] );
  $wp_customize->add_control( 'gtm_id', [
    'label'    => __( 'Google Tag Manager ID', 'sage' ),
    'section'  => 'misc_settings',
    'settings' => 'gtm_id',
    'type'     => 'text'
  ] );

  $wp_customize->add_setting( 'ga_id', [
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field'
  ] );
  $wp_customize->add_control( 'ga_id', [
    'label'    => __( 'Google Analytics ID', 'sage' ),
    'section'  => 'misc_settings',
    'settings' => 'ga_id',
    'type'     => 'text'
  ] );


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
