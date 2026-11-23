<?php
/**
 * Aram Zist theme bootstrap.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'ARAM_VERSION', '1.0.0' );
define( 'ARAM_DIR', get_template_directory() );
define( 'ARAM_URI', get_template_directory_uri() );

foreach ( array( 'setup', 'enqueue', 'customizer', 'template-functions', 'security', 'woocommerce' ) as $aram_file ) {
	require_once ARAM_DIR . '/inc/' . $aram_file . '.php';
}
