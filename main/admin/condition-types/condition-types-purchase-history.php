<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Purchase_History' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Purchase_History {

        public static function init() {
            
            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 160, 2 );

            add_filter( 'wmodes-admin/get-purchase_history-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'purchase_history' ] = esc_html__( 'Purchase History', 'wmodes-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Purchased Products (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Purchased Variations (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Purchased Categories (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Purchased Tags (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_5' ] = esc_html__( 'Purchased Attributes (Premium)', 'wmodes-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Purchase_History::init();
}
