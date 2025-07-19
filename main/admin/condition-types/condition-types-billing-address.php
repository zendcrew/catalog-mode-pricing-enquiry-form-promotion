<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Billing_Address' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Billing_Address {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 120, 2 );

            add_filter( 'wmodes-admin/get-billing_address-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'billing_address' ] = esc_html__( 'Billing Address', 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Billing Continents (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_2' ] = esc_html__( 'Billing Countries (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_3' ] = esc_html__( 'Billing States (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_4' ] = esc_html__( 'Billing Cities (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_5' ] = esc_html__( 'Billing Postcode / ZIP (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Billing_Address::init();
}

