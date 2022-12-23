<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Catalog_Mode_Types_Shop' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Catalog_Mode_Types_Shop {

        public static function init() {

            add_filter( 'wmodes-admin/catalog-modes/get-shop-mode-types', array( new self(), 'get_types' ), 10, 2 );

            add_filter( 'wmodes-admin/catalog-modes/get-mode-type-shop-fields', array( new self(), 'get_fields' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'shop' ] = array(
                'title' => esc_html__( 'Shop Page Settings', 'zcwm-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args = array() ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( '"Add to Cart" Settings', 'zcwm-tdm' ),
                'desc' => esc_html__( 'Use these settings to control "Add to Cart" on shop page', 'zcwm-tdm' ),
                'field_css_class' => array( 'rn-first', 'wmodes_locations_title' ),
                'fields' => self::get_add_to_cart_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'merge_fields' => false,
                'fields' => self::get_add_to_cart_url_fields( $args ),
                'fold' => array(
                    'target' => 'add_to_cart_customize',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'fields' => self::get_add_to_cart_textblock_fields( $args ),
                'fold' => array(
                    'target' => 'add_to_cart_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( 'Price Settings', 'zcwm-tdm' ),
                'desc' => esc_html__( 'Use these settings to control price on shop page', 'zcwm-tdm' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_price_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'fields' => self::get_price_textblock_fields( $args ),
                'fold' => array(
                    'target' => 'price_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( 'Stars Rating Settings', 'zcwm-tdm' ),
                'desc' => esc_html__( 'Use these settings to control stars rating on shop page', 'zcwm-tdm' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_rating_fields( $args ),
            );

            if ( $args[ 'is_global' ] ) {

                $in_fields[] = array(
                    'id' => 'any_ids',
                    'type' => 'columns-field',
                    'columns' => 1,
                    'full_width' => true,
                    'center_head' => true,
                    'merge_fields' => false,
                    'title' => esc_html__( 'Products', 'zcwm-tdm' ),
                    'desc' => esc_html__( 'List of product, empty list will include all products', 'zcwm-tdm' ),
                    'field_css_class' => array( 'wmodes_locations_title' ),
                    'fields' => self::get_products_fields( $args ),
                );
            }

            return $in_fields;
        }

        private static function get_add_to_cart_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable_add_to_cart',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( '"Add to Cart" Visibility', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" visibility on shop page', 'zcwm-tdm' ),
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__( 'Show "Add to Cart"', 'zcwm-tdm' ),
                    'hide' => esc_html__( 'Hide "Add to Cart"', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'shop_add_to_cart'
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_replace',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Replace With', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" replacement on shop page', 'zcwm-tdm' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'no' => esc_html__( 'Nothing', 'zcwm-tdm' ),
                    'prem_1' => esc_html__( 'Label (Premium)', 'zcwm-tdm' ),
                    'prem_2' => esc_html__( 'Link Button (Premium)', 'zcwm-tdm' ),
                    'replace_textblock' => esc_html__( 'Text Block', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'add_to_cart_replace',
                'fold' => array(
                    'target' => 'shop_add_to_cart',
                    'attribute' => 'value',
                    'value' => array( 'hide' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_customize',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Customize "Add to Cart"', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" text on shop page', 'zcwm-tdm' ),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__( 'No', 'zcwm-tdm' ),
                    'yes' => esc_html__( 'Yes', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'add_to_cart_customize',
                'fold' => array(
                    'target' => 'shop_add_to_cart',
                    'attribute' => 'value',
                    'value' => array( 'show' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_text',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( '"Add to Cart" Text', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" text', 'zcwm-tdm' ),
                'default' => esc_html__( 'Add to Enquiry', 'zcwm-tdm' ),
                'placeholder' => esc_html__( 'Type here...', 'zcwm-tdm' ),
                'rows' => 1,
                'width' => '100%',
                'fold' => array(
                    'target' => 'add_to_cart_customize',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            if ( $args[ 'is_global' ] ) {

                $in_fields[] = array(
                    'id' => 'is_any',
                    'type' => 'textblock',
                    'column_size' => 1,
                    'column_title' => esc_html__( 'Variable "Add to Cart" Text', 'zcwm-tdm' ),
                    'tooltip' => esc_html__( 'Controls "Add to Cart" text on variable products', 'zcwm-tdm' ),
                    'show_box' => true,
                    'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                    'width' => '100%',
                    'fold' => array(
                        'target' => 'add_to_cart_customize',
                        'attribute' => 'value',
                        'value' => array( 'yes' ),
                        'oparator' => 'eq',
                        'clear' => false,
                    ),
                );
            }

            $in_fields[] = array(
                'id' => 'add_to_cart_textblock_ui_id',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - UI Design', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Controls the text block's UI design on the shop page", 'zcwm-tdm' ),
                'default' => '2234343',
                'data' => 'wmodes:textblock_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'add_to_cart_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_add_to_cart_url_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'add_to_cart_link_type',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Link Type', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" link type', 'zcwm-tdm' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'no' => esc_html__( 'Add to Cart link', 'zcwm-tdm' ),
                    'prem_1' => esc_html__( 'Blog post page link (Premium)', 'zcwm-tdm' ),
                    'prem_2' => esc_html__( 'Page link (Premium)', 'zcwm-tdm' ),
                    'url' => esc_html__( 'Page URL', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'add_to_cart_link_type',
                'fold' => array(
                    'target' => 'add_to_cart_customize',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_url',
                'type' => 'textbox',
                'column_size' => 2,
                'column_title' => esc_html__( 'Destination URL', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'This controls the destination web page URL that the "Add to Cart" should link to', 'zcwm-tdm' ),
                'default' => '',
                'placeholder' => 'Type url here....',
                'fold' => array(
                    'target' => 'add_to_cart_link_type',
                    'attribute' => 'value',
                    'value' => 'url',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Target', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines whether or not the link should open in a new browser tab', 'zcwm-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
                'fold' => array(
                    'target' => 'add_to_cart_link_type',
                    'attribute' => 'value',
                    'value' => 'no',
                    'oparator' => 'neq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_add_to_cart_textblock_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'add_to_cart_textblock',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - Content', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Determines text block's contents", 'zcwm-tdm' ),
                'default' => esc_html__( 'Text Block', 'zcwm-tdm' ),
                'placeholder' => esc_html__( 'Type here...', 'zcwm-tdm' ),
                'rows' => 2,
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_price_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable_price',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Price Visibility', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls price visibility on shop page', 'zcwm-tdm' ),
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__( 'Show price', 'zcwm-tdm' ),
                    'hide' => esc_html__( 'Hide price', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'shop_price'
            );

            $in_fields[] = array(
                'id' => 'price_replace',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Replace With', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls price replacement on shop page', 'zcwm-tdm' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'no' => esc_html__( 'Nothing', 'zcwm-tdm' ),
                    'prem_1' => esc_html__( 'Label (Premium)', 'zcwm-tdm' ),
                    'prem_2' => esc_html__( 'Link Button (Premium)', 'zcwm-tdm' ),
                    'replace_textblock' => esc_html__( 'Text Block', 'zcwm-tdm' ),
                ),
                'width' => '100%',
                'fold_id' => 'price_replace',
                'fold' => array(
                    'target' => 'shop_price',
                    'attribute' => 'value',
                    'value' => array( 'hide' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'prices_textblock_ui_id',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - UI Design', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Controls the text block's UI design on the shop page", 'zcwm-tdm' ),
                'default' => '2234343',
                'data' => 'wmodes:textblock_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'price_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_price_textblock_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'price_textblock',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - Content', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Determines text block's contents", 'zcwm-tdm' ),
                'default' => esc_html__( 'Text Block', 'zcwm-tdm' ),
                'placeholder' => esc_html__( 'Type here...', 'zcwm-tdm' ),
                'rows' => 2,
                'width' => '100%',
            );


            return $in_fields;
        }

        private static function get_rating_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'show_box' => false,
                'column_size' => 1,
                'text' => WModes_Admin_Page::get_premium_messages(),
                'width' => '100%',
                'box_width' => '100%',
                'column_attributes' => array(
                    'style' => 'text-align: center;'
                ),
            );

            return $in_fields;
        }

        private static function get_products_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'show_box' => false,
                'column_size' => 1,
                'text' => WModes_Admin_Page::get_premium_messages(),
                'width' => '100%',
                'box_width' => '100%',
                'column_attributes' => array(
                    'style' => 'text-align: center;'
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Catalog_Mode_Types_Shop::init();
}
