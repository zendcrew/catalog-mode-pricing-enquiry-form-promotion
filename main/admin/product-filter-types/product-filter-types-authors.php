<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Filter_Type_Authors' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Filter_Type_Authors {

        public static function init() {

            add_filter( 'wmodes-admin/get-product-filter-groups', array( new self(), 'get_groups' ), 60, 2 );
            add_filter( 'wmodes-admin/get-product_authors-group-product-filters', array( new self(), 'get_filters' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'product_authors' ] = esc_html__( 'Product Authors (Multi Vendor)', 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_groups;
        }

        public static function get_filters( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Product Authors (Premium)', 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_2' ] = esc_html__( "Product Author's Roles (Premium)", 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_3' ] = esc_html__( "Product Author's Capabilities (Premium)", 'catalog-mode-pricing-enquiry-forms-promotions' );
            $in_list[ 'prem_4' ] = esc_html__( "Product Author's Meta Fields (Premium)", 'catalog-mode-pricing-enquiry-forms-promotions' );

            return $in_list;
        }

    }

    WModes_Admin_Product_Filter_Type_Authors::init();
}