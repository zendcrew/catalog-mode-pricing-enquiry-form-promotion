<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Catalog_Mode_Types_Cart' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Catalog_Mode_Types_Cart {

        public static function init() {

            add_filter( 'wmodes-admin/catalog-modes/get-cart-mode-types', array( new self(), 'get_types' ), 10, 2 );

            add_filter( 'wmodes-admin/catalog-modes/get-mode-type-cart-fields', array( new self(), 'get_fields' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            if ( !$args[ 'is_global' ] ) {

                return $in_options;
            }

            $in_options[ 'cart' ] = array(
                'title' => esc_html__( 'Cart Page Settings', 'wmodes-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args = array() ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 3,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'field_css_class' => array( 'rn-first' ),
                'fields' => self::get_settings_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'fields' => self::get_prices_fields( $args ),
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 3,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'fields' => self::get_enquiry_button_fields( $args ),
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_settings_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'restrict_cart',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Restrict Access', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Restricts access to "Cart" page and disable all cart functions', 'wmodes-tdm' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'wmodes-tdm' ),
                    'no' => esc_html__( 'No', 'wmodes-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'restrict_cart'
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Restriction Mode', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Determines how the "Cart" page should be restricted', 'wmodes-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'yes',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Remove Subtotals', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Disables subtotals on "Cart" page', 'wmodes-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Remove Cross Sells', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Disables "Cross Sells" products on "Cart" page', 'wmodes-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_prices_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'cart_hide_prices',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Hide Product Prices', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Hides product prices and totals on "Cart" page', 'wmodes-tdm' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'prem_1' => esc_html__( 'Yes (Premium)', 'wmodes-tdm' ),
                    'prem_2' => esc_html__( 'Yes, hide product prices/totals columns (Premium)', 'wmodes-tdm' ),
                    'no' => esc_html__( 'No', 'wmodes-tdm' ),
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_enquiry_button_fields( $args ) {

            $in_fields = array();
           
            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Remove Coupons', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Disables coupons on "Cart" and "Checkout" pages', 'wmodes-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );
            
            $in_fields[] = array(
                'id' => 'cart_enquiry',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Enable Cart Enquiry', 'wmodes-tdm' ),
                'tooltip' => esc_html__( 'Enables cart enquiry functions on "Cart" page', 'wmodes-tdm' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'prem_1' => esc_html__( 'Yes (Premium)', 'wmodes-tdm' ),
                    'no' => esc_html__( 'No', 'wmodes-tdm' ),
                ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'restrict_cart',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );


            return $in_fields;
        }

    }

    WModes_Admin_Catalog_Mode_Types_Cart::init();
}