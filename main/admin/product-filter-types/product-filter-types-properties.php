<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Filter_Type_Properties' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Filter_Type_Properties {

        public static function init() {

            add_filter( 'wmodes-admin/get-product-filter-groups', array( new self(), 'get_groups' ), 50, 2 );
            add_filter( 'wmodes-admin/get-properties-group-product-filters', array( new self(), 'get_filters' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'properties' ] = esc_html__( 'Product Properties', 'wmodes-tdm' );

            return $in_groups;
        }

        public static function get_filters( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Product Is Virtual (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Product Is Downloadable (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_3' ] = esc_html__( 'Product Is Featured (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_4' ] = esc_html__( 'Product Total Number Of Sales (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_5' ] = esc_html__( 'Product Is On Sale (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_6' ] = esc_html__( 'Product Stock Status (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_7' ] = esc_html__( 'Product Stock Quantity (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_8' ] = esc_html__( 'Product Shipping Class (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_9' ] = esc_html__( 'Product Is Taxable (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_10' ] = esc_html__( 'Product Tax Class (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_11' ] = esc_html__( 'Product Meta Field (Premium)', 'wmodes-tdm' );

            return $in_list;
        }

    }

    WModes_Admin_Product_Filter_Type_Properties::init();
}