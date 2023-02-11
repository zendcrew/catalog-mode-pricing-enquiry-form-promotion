<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Purchase_History_Quantity' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Purchase_History_Quantity {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 180, 2 );

            add_filter( 'wmodes-admin/get-purchase_history_quantity-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'purchase_history_quantity' ] = esc_html__( 'Purchase History Quantities', 'wmodes-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Purchased Products Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Purchased Variations Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Purchased Categories Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Purchased Tags Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_5' ] = esc_html__( 'Purchased Attributes Quantity (Premium)', 'wmodes-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Purchase_History_Quantity::init();
}