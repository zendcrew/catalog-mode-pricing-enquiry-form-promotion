<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Option_Type_Shipping' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Option_Type_Shipping {

        public static function init() {

            add_filter( 'wmodes-admin/product-options/get-settings-option-types', array( new self(), 'get_types' ), 30, 2 );

            add_filter( 'wmodes-admin/product-options/get-option-type-shipping-fields', array( new self(), 'get_fields' ), 10, 2 );

            add_filter( 'wmodes-admin/product-options/get-type-requires-variations', array( new self(), 'get_requires_variations' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'shipping' ] = array(
                'title' => esc_html__( 'Shipping Settings', 'zcwm-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'merge_fields' => false,
                'fields' => self::get_panel_fields(),
            );

            return $in_fields;
        }

        public static function get_requires_variations( $in_options, $args ) {

            $in_options[] = 'shipping';

            return $in_options;
        }

        private static function get_panel_fields() {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'is_virtual',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Is Virtual', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Makes the product a virtual product, virtual products are intangible and are not shipped', 'zcwm-tdm' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'zcwm-tdm' ),
                    'no' => esc_html__( 'No', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'is_virtual',
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Needs Shipping', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Makes the product shippable product on the frontend', 'zcwm-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'fold' => array(
                    'target' => 'is_virtual',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => true,
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 2,
                'column_title' => esc_html__( 'Shipping Class', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls the shipping class of the product on the frontend', 'zcwm-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'fold' => array(
                    'target' => 'is_virtual',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'eq',
                    'clear' => true,
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

    }

    WModes_Admin_Product_Option_Type_Shipping::init();
}
