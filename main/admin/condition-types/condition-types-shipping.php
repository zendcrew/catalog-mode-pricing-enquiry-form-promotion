<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Shipping' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Shipping {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 150, 2 );

            add_filter( 'wmodes-admin/get-shipping-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'shipping' ] = esc_html__( 'Shipping', 'zcwm-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Needs Shipping (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Shipping Zones (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Shipping Methods (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Shipping Rates (Premium)', 'zcwm-tdm' );


            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Shipping::init();
}

