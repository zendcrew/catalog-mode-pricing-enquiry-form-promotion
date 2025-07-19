<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Customer_Value' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Customer_Value {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 20, 2 );

            add_filter( 'wmodes-admin/get-customers_value-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'customers_value' ] = esc_html__( 'Customer Values', 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $currency = get_woocommerce_currency_symbol( get_woocommerce_currency() );

            $in_list[ 'prem_1' ] = esc_html__( 'Coupons Used (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            /* translators: 1: currency symbol */
            $in_list[ 'prem_2' ] = sprintf( esc_html__( 'Totals Spent (%s) (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $currency );
            $in_list[ 'prem_3' ] = esc_html__( 'Last Order Date (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            /* translators: 1: currency symbol */
            $in_list[ 'prem_4' ] = sprintf( esc_html__( 'Last Order Totals (%s) (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $currency );
            /* translators: 1: currency symbol */
            $in_list[ 'prem_5' ] = sprintf( esc_html__( 'Average (%s) Per Order (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $currency );
            /* translators: 1: currency symbol */
            $in_list[ 'prem_6' ] = sprintf( esc_html__( 'Maximum (%s) Per Order (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $currency );
            /* translators: 1: currency symbol */
            $in_list[ 'prem_7' ] = sprintf( esc_html__( 'Minimum (%s) Per Order (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' ), $currency );
            /* translators: 1: currency symbol */
            $in_list[ 'prem_8' ] = esc_html__( 'Number Of Orders (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_9' ] = esc_html__( 'Number Of Reviews (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Customer_Value::init();
}