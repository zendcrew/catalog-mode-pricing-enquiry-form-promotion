<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Prices_Types_Regular' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Prices_Types_Regular {

        public static function init() {

            add_filter( 'wmodes-admin/product-pricing/get-mode-types', array( new self(), 'get_modes' ), 10, 2 );
        }

        public static function get_modes( $in_modes, $args ) {

            $in_modes[ 'prem_1' ] = esc_html__( 'Regular / Sale Price Adjustment (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_modes[ 'prem_2' ] = esc_html__( 'Regular Price Adjustment (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_modes;
        }

    }

    WModes_Admin_Product_Prices_Types_Regular::init();
}