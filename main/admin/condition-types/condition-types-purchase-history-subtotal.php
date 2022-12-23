<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Purchase_History_Subtotal' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Purchase_History_Subtotal {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 170, 2 );

            add_filter( 'wmodes-admin/get-purchase_history_subtotal-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'purchase_history_subtotal' ] = esc_html__( 'Purchase History Subtotals', 'zcwm-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Purchased Products Subtotal (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Purchased Variations Subtotal (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Purchased Categories Subtotal (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Purchased Tags Subtotal (Premium)', 'zcwm-tdm' );
            $in_list[ 'prem_5' ] = esc_html__( 'Purchased Attributes Subtotal (Premium)', 'zcwm-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Condition_Type_Purchase_History_Subtotal::init();
}

