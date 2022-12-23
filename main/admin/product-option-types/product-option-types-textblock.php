<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WModes_Admin_Product_Option_Type_TextBlock' ) ) {

    class WModes_Admin_Product_Option_Type_TextBlock {

        public static function init() {

            $option_name = WModes_Admin_Page::get_option_name();

            $metabox_id = WModes_Admin_Product_Options_MetaBox_Tab::get_metabox_id();

            add_filter( 'wmodes-admin/product-options/get-promotions-option-types', array( new self(), 'get_types' ), 130, 2 );

            add_filter( 'wmodes-admin/product-options/get-option-type-textblock-fields', array( new self(), 'get_fields' ), 10, 2 );

            add_filter( 'reon/sanitize-' . $option_name . '-product_options-options-contents', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
            
            add_filter( 'reon/sanitize-' . $metabox_id . '-wmodes_product_options-options-contents', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'textblock' ] = array(
                'title' => esc_html__( 'Text Block', 'zcwm-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'field_css_class' => array( 'rn-first' ),
                'fields' => self::get_panel_fields(),
            );

            $in_fields[] = array(
                'id' => 'shop',
                'type' => 'columns-field',
                'columns' => ($args[ 'is_global' ]) ? 8 : 9,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => true,
                'title' => esc_html__( 'Shop Loops', 'zcwm-tdm' ),
                'desc' => esc_html__( "Use these settings to control the text block's visibility in shop loops", 'zcwm-tdm' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_shop_panel_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'shop_loop_args',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => true,
                'fields' => self::get_shop_loop_fields( $args ),
                'fold' => array(
                    'target' => 'shop_textblock_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'single_product',
                'type' => 'columns-field',
                'columns' => ($args[ 'is_global' ]) ? 8 : 9,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => true,
                'title' => esc_html__( 'Product Summary', 'zcwm-tdm' ),
                'desc' => esc_html__( "Use these settings to control the text block's visibility in product summary area", 'zcwm-tdm' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_product_panel_fields( $args ),
            );

            return $in_fields;
        }

        private static function get_panel_fields() {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'contents',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Contents', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Enter the text block's contents here", 'zcwm-tdm' ),
                'default' => esc_html__( 'Text Block', 'zcwm-tdm' ),
                'placeholder' => esc_html__( 'Type here...', 'zcwm-tdm' ),
                'rows' => 2,
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_shop_panel_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 2 : 3,
                'column_title' => esc_html__( 'Show In Shop Loops', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines whether or not the text block should be shown in shop loops', 'zcwm-tdm' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'zcwm-tdm' ),
                    'no' => esc_html__( 'No', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'shop_textblock_enable',
            );

            $in_fields[] = array(
                'id' => 'location',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Shop Loops - Location', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Controls the text block's location in the shop loops", 'zcwm-tdm' ),
                'default' => '',
                'data' => 'wmodes:view_locations:shop',
                'width' => '100%',
                'fold' => array(
                    'target' => 'shop_textblock_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'ui_id',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Shop Loops - UI Design', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Controls the text block's UI design in the shop loops", 'zcwm-tdm' ),
                'default' => '2234343',
                'data' => 'wmodes:textblock_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'shop_textblock_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_shop_loop_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'loops',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 3 : 2,
                'column_title' => esc_html__( 'Shop Loops', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines which of the shop loops the text block should be visible in', 'zcwm-tdm' ),
                'default' => array(),
                'multiple' => true,
                'minimum_results_forsearch' => 10,
                'placeholder' => esc_html__( 'Select shop loops', 'zcwm-tdm' ),
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => WModes_Admin_Product_Option_Types::get_shop_loop_types( $args ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'compare',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 1 : 2,
                'column_title' => esc_html__( 'Equals To', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Determines how to validate the shop loops for the text block's visibility", 'zcwm-tdm' ),
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__( 'Any in the list', 'zcwm-tdm' ),
                    'none' => esc_html__( 'Any NOT in the list', 'zcwm-tdm' ),
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_product_panel_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 2 : 3,
                'column_title' => esc_html__( 'Show In Product Summary', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines whether or not the text block should be shown in product summary area', 'zcwm-tdm' ),
                'default' => 'yes',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'zcwm-tdm' ),
                    'no' => esc_html__( 'No', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'product_textblock_enable',
            );

            $in_fields[] = array(
                'id' => 'location',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Product Summary - Location', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Controls the text block's location in the product summary area", 'zcwm-tdm' ),
                'default' => '',
                'data' => 'wmodes:view_locations:single-product',
                'width' => '100%',
                'fold' => array(
                    'target' => 'product_textblock_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'ui_id',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Product Summary - UI Design', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Controls the text block's UI design in the single product summary area", 'zcwm-tdm' ),
                'default' => '2234343',
                'data' => 'wmodes:textblock_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'product_textblock_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Product_Option_Type_TextBlock::init();
}