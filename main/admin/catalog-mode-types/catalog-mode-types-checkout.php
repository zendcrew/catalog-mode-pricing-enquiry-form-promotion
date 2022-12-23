<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Catalog_Mode_Types_Checkout' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Catalog_Mode_Types_Checkout {

        public static function init() {

            add_filter( 'wmodes-admin/catalog-modes/get-cart-mode-types', array( new self(), 'get_types' ), 10, 2 );

            add_filter( 'wmodes-admin/catalog-modes/get-mode-type-checkout-fields', array( new self(), 'get_fields' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            if ( !$args[ 'is_global' ] ) {

                return $in_options;
            }

            $in_options[ 'checkout' ] = array(
                'title' => esc_html__( 'Checkout Page Settings', 'zcwm-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args = array() ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 2,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'field_css_class' => array( 'rn-first' ),
                'fields' => self::get_settings_fields( $args ),
            );

            return $in_fields;
        }

        private static function get_settings_fields( $args ) {

            $in_fields = array();


            $in_fields[] = array(
                'id' => 'restrict_checkout',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Restrict Access', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Restricts access to "Checkout" page and disable all checkout functions', 'zcwm-tdm' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'zcwm-tdm' ),
                    'no' => esc_html__( 'No', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'restrict_checkout'
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Restriction Mode', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines how the "Checkout" page should be restricted', 'zcwm-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'restrict_checkout',
                    'attribute' => 'value',
                    'value' => 'yes',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Catalog_Mode_Types_Checkout::init();
}

