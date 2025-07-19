<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Weight' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Weight {

        public static function init() {
            
            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 60, 2 );

            add_filter( 'wmodes-admin/get-weight-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $unit = get_option( 'woocommerce_weight_unit' );

            /* translators: 1: weight unit */
            $in_groups[ 'weight' ] = sprintf( esc_html__( 'Cart Weights (%s)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $unit );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $unit = get_option( 'woocommerce_weight_unit' );

            /* translators: 1: weight unit */
            $in_list[ 'prem_1' ] = sprintf( esc_html__( 'Cart Weight - Weight (%s) (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $unit );
            /* translators: 1: weight unit */
            $in_list[ 'prem_2' ] = sprintf( esc_html__( 'Cart Weight - Weight Calculator (%s) (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $unit );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Weight::init();
}
