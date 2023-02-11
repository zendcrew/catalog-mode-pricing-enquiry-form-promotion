<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Cart_Items_Quantity' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Cart_Items_Quantity {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 100, 2 );

            add_filter( 'wmodes-admin/get-cart_items_quantities-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'cart_items_quantities' ] = esc_html__( 'Cart Item Quantities', 'wmodes-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Products Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Variations Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Categories Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Tags Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_5' ] = esc_html__( 'Attributes Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_6' ] = esc_html__( 'Tax Classes Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_7' ] = esc_html__( 'Shipping Classes Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_8' ] = esc_html__( 'Product Meta Fields Quantity (Premium)', 'wmodes-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Cart_Items_Quantity::init();
}
