<?php

/*
 * Plugin Name: WooCommerce Catalog Mode - Pricing, Enquiry Forms & Promotions
 * Plugin URI: https://codecanyon.net/user/zendcrew
 * Description: Implement various catalog modes, dynamic pricing, coundwown timers, product badges and other promotional settings based on product rules and conditions
 * Version: 1.0
 * Author: zendcrew
 * Author URI: https://codecanyon.net/user/zendcrew
 * Text Domain: zcwm-tdm
 * Domain Path: /languages/
 * Requires at least: 5.8
 * Tested up to: 6.1.1
 * Requires PHP: 5.6
 * 
 * WC requires at least: 5.6
 * WC tested up to: 7.1
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( is_admin() ) {

    require_once (dirname( __FILE__ ) . '/framework/reon_loader.php');
}

if ( !defined( 'WMODES_VERSION' ) ) {
    
    define( 'WMODES_VERSION', '1.0' );
}

if ( !defined( 'WMODES_MAIN_FILE' ) ) {

    define( 'WMODES_MAIN_FILE', __FILE__ );
}

if ( !class_exists( 'WModes_Init' ) ) {

    class WModes_Init {

        public function __construct() {

            add_action( 'plugins_loaded', array( $this, 'plugin_loaded' ), 1 );

            load_plugin_textdomain( 'zcwm-tdm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        public function plugin_loaded() {

            if ( function_exists( 'WC' ) ) { // Check if WooCommerce is active
                
                $this->main();
            } else {

                add_action( 'admin_notices', array( $this, 'missing_notice' ) );
            }
        }

        public function missing_notice() {

            echo '<div class="error"><p><strong>' . esc_html__( 'WooCommerce Catalog Mode - Pricing, Enquiry Forms & Promotions be installed and activated.', 'zcwm-tdm' ) . '</strong></p></div>';
        }

        private function main() {

            //WModes Main
            if ( !class_exists( 'WModes_Main' ) ) {

                include_once ('main/main.php');

                new WModes_Main();
            }
        }

    }

    new WModes_Init();
}
