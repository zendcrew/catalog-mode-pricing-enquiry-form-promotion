<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Option_Type_Downloads' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Option_Type_Downloads {

        public static function init() {

            add_filter( 'wmodes-admin/product-options/get-settings-option-types', array( new self(), 'get_types' ), 50, 2 );

            add_filter( 'wmodes-admin/product-options/get-option-type-prem_2-fields', array( new self(), 'get_fields' ), 10, 2 );

            add_filter( 'wmodes-admin/product-options/get-type-requires-ex-products', array( new self(), 'get_requires_ex_products' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'prem_2' ] = array(
                'title' => esc_html__( 'Downloads Settings (Premium)', 'wmodes-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args ) {

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'show_box' => false,
                'text' => WModes_Admin_Page::get_premium_messages(),
                'width' => '100%',
                'box_width' => '100%',
            );

            return $in_fields;
        }

        public static function get_requires_ex_products( $in_options, $args ) {

            $in_options[] = 'prem_2';

            return $in_options;
        }

    }

    WModes_Admin_Product_Option_Type_Downloads::init();
}