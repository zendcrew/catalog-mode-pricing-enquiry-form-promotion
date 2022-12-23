<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Filter_Type_Dimensions' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Filter_Type_Dimensions {

        public static function init() {

            add_filter( 'wmodes-admin/get-product-filter-groups', array( new self(), 'get_groups' ), 40, 2 );
            add_filter( 'wmodes-admin/get-dimensions-group-product-filters', array( new self(), 'get_filters' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $dim_unit = get_option( 'woocommerce_dimension_unit' );

            $in_groups[ 'dimensions' ] = sprintf( esc_html__( 'Product Dimensions (%s)', 'zcwm-tdm' ), $dim_unit );

            return $in_groups;
        }

        public static function get_filters( $in_list, $args ) {

            $dim_unit = get_option( 'woocommerce_dimension_unit' );

            $in_list[ 'prem_1' ] = sprintf( esc_html__( 'Product Length (%s) (Premium)', 'zcwm-tdm' ), $dim_unit );
            $in_list[ 'prem_2' ] = sprintf( esc_html__( 'Product Width (%s) (Premium)', 'zcwm-tdm' ), $dim_unit );
            $in_list[ 'prem_3' ] = sprintf( esc_html__( 'Product Height (%s) (Premium)', 'zcwm-tdm' ), $dim_unit );
            $in_list[ 'prem_4' ] = sprintf( esc_html__( 'Product Surface Area (square %s) (Premium)', 'zcwm-tdm' ), $dim_unit );
            $in_list[ 'prem_5' ] = sprintf( esc_html__( 'Product Volume (cubic %s) (Premium)', 'zcwm-tdm' ), $dim_unit );

            return $in_list;
        }

    }

    WModes_Admin_Product_Filter_Type_Dimensions::init();
}
