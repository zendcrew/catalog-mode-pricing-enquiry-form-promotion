<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Shipping_Address' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Shipping_Address {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 140, 2 );

            add_filter( 'wmodes-admin/get-shipping_address-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'shipping_address' ] = esc_html__( 'Shipping Address', 'zcwm-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Shipping Continents (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Shipping Countries (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Shipping States (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Shipping Cities (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_5' ] = esc_html__( 'Shipping Postcode / ZIP (Premium)', 'zcwm-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Shipping_Address::init();
}
