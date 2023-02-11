<?php

if ( !class_exists( 'WModes_Admin_Condition_Type_Cart_Totals' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Cart_Totals {

        public static function init() {
            
            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 70, 2 );

            add_filter( 'wmodes-admin/get-cart_totals-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $unit = get_option( 'woocommerce_weight_unit' );

            $in_groups[ 'cart_totals' ] = sprintf( esc_html__( 'Cart Totals', 'wmodes-tdm' ), $unit );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Subtotals Including Tax (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Subtotals Excluding Tax (Premium)', 'wmodes-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Cart_Totals::init();
}