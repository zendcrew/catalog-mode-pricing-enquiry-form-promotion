<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Filter_Type_Weights' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Filter_Type_Weights {

        public static function init() {

            add_filter( 'wmodes-admin/get-product-filter-groups', array( new self(), 'get_groups' ), 30, 2 );
            add_filter( 'wmodes-admin/get-weights-group-product-filters', array( new self(), 'get_filters' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $unit = get_option( 'woocommerce_weight_unit' );

            $in_groups[ 'weights' ] = sprintf( esc_html__( 'Product Weights', 'wmodes-tdm' ), $unit );

            return $in_groups;
        }

        public static function get_filters( $in_list, $args ) {

            $unit = get_option( 'woocommerce_weight_unit' );

            $in_list[ 'prem_1' ] = sprintf( esc_html__( 'Product Weight - Weight (%s) (Premium)', 'wmodes-tdm' ), $unit );
            $in_list[ 'prem_2' ] = sprintf( esc_html__( 'Product Weight - Weight Calculator (%s) (Premium)', 'wmodes-tdm' ), $unit );

            return $in_list;
        }

    }

    WModes_Admin_Product_Filter_Type_Weights::init();
}
