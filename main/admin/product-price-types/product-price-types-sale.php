<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Prices_Types_Sale' ) ) {

    class WModes_Admin_Product_Prices_Types_Sale {

        public static function init() {
            add_filter( 'wmodes-admin/product-pricing/get-mode-type-sale-fields', array( new self(), 'get_fields' ), 10, 2 );

            add_filter( 'wmodes-admin/product-pricing/get-mode-types', array( new self(), 'get_modes' ), 20, 2 );

            add_filter( 'wmodes-admin/product-pricing/get-adjustment-types', array( new self(), 'get_adjustment_types' ), 10, 2 );

            add_filter( 'wmodes-admin/product-pricing/get-adjustment-based-on-types', array( new self(), 'get_adjustment_based_on_types' ), 20, 2 );
        }

        public static function get_modes( $in_modes, $args ) {

            $in_modes[ 'sale' ] = esc_html__( 'Sale Price Adjustment', 'zcwm-tdm' );

            return $in_modes;
        }

        public static function get_fields( $in_fields, $args ) {

            $args[ 'mode-type' ] = 'sale';

            if ( $args[ 'is_global' ] == true ) {

                return self::get_global_fields( $in_fields, $args );
            }
            return self::get_mbx_fields( $in_fields, $args );
        }

        public static function get_adjustment_types( $adj_types, $args ) {

            if ( !defined( 'WMODES_PREMIUM_ADDON' ) ) {

                $adj_types[ 'fixed_price' ] = esc_html__( 'Fixed price', 'zcwm-tdm' );

                $adj_types[ 'prem_1' ] = esc_html__( 'Fixed discount amount (Premium)', 'zcwm-tdm' );
                $adj_types[ 'prem_2' ] = esc_html__( 'Fixed fee amount (Premium)', 'zcwm-tdm' );
                $adj_types[ 'prem_3' ] = esc_html__( 'Percentage price (Premium)', 'zcwm-tdm' );

                $adj_types[ 'per_discount' ] = esc_html__( 'Percentage discount amount', 'zcwm-tdm' );

                $adj_types[ 'prem_4' ] = esc_html__( 'Percentage fee amount (Premium)', 'zcwm-tdm' );
            }

            return $adj_types;
        }

        public static function get_adjustment_based_on_types( $based_on_types, $args ) {

            if ( !defined( 'WMODES_PREMIUM_ADDON' ) ) {

                $based_on_types[ 'prem_1' ] = esc_html__( 'Regular price (Premium)', 'zcwm-tdm' );

                $based_on_types[ 'sale_price' ] = esc_html__( 'Sale price', 'zcwm-tdm' );

                $based_on_types[ 'prem_2' ] = esc_html__( 'Previous regular price (Premium)', 'zcwm-tdm' );
                $based_on_types[ 'prem_3' ] = esc_html__( 'Previous sale price (Premium)', 'zcwm-tdm' );
            }

            return $based_on_types;
        }

        private static function get_global_fields( $in_fields, $args ) {
            $in_fields[] = array(
                'id' => 'sale_adj',
                'type' => 'columns-field',
                'columns' => 8,
                'fields' => array(
                    array(
                        'id' => 'adj_type',
                        'type' => 'select2',
                        'column_size' => 3,
                        'column_title' => esc_html__( 'Sale Price Adjustment', 'zcwm-tdm' ),
                        'tooltip' => esc_html__( 'Controls sale price adjusment mode', 'zcwm-tdm' ),
                        'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                        'default' => WModes_Admin_Product_Prices_Types::get_default_adjustment_types( $args ),
                        'options' => WModes_Admin_Product_Prices_Types::get_adjustment_types( $args ),
                        'width' => '100%',
                        'fold_id' => 'sale_adj_type',
                    ),
                    array(
                        'id' => 'amount',
                        'type' => 'textbox',
                        'input_type' => 'number',
                        'column_size' => 1,
                        'tooltip' => esc_html__( 'Controls sale adjusment amount to apply', 'zcwm-tdm' ),
                        'column_title' => esc_html__( 'Amount', 'zcwm-tdm' ),
                        'default' => '0.00',
                        'placeholder' => '0.00',
                        'attributes' => array(
                            'min' => '0',
                            'step' => '0.01',
                        ),
                        'width' => '100%',
                    ),
                    array(
                        'id' => 'cal_from',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Adjust Amount From', 'zcwm-tdm' ),
                        'tooltip' => esc_html__( 'Calculates sale price from original/previous product prices', 'zcwm-tdm' ),
                        'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                        'default' => 'sale_price',
                        'options' => WModes_Admin_Product_Prices_Types::get_adjustment_based_on_types( $args ),
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'sale_adj_type',
                            'attribute' => 'value',
                            'value' => WModes_Admin_Product_Prices_Types::get_calculate_from_visibility( $args ),
                            'oparator' => 'eq',
                        ),
                    ),
                    array(
                        'id' => 'based_on',
                        'type' => 'select2',
                        'column_size' => 2,
                        'column_title' => esc_html__( 'Percentage Based On', 'zcwm-tdm' ),
                        'tooltip' => esc_html__( 'Controls sale percentage adjusment amount based on the original/previous product prices', 'zcwm-tdm' ),
                        'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                        'default' => 'sale_price',
                        'options' => WModes_Admin_Product_Prices_Types::get_adjustment_based_on_types( $args ),
                        'width' => '100%',
                        'fold' => array(
                            'target' => 'sale_adj_type',
                            'attribute' => 'value',
                            'value' => WModes_Admin_Product_Prices_Types::get_adjustment_based_on_visibility( $args ),
                            'oparator' => 'eq',
                        ),
                    ),
                ),
                'fold' => array(
                    'target' => 'product_prices_mode',
                    'attribute' => 'value',
                    'value' => array( 'reg_sale', 'sale' ),
                    'oparator' => 'eq',
                ),
            );

            return $in_fields;
        }

        private static function get_mbx_fields( $in_fields, $args ) {


            $from_visible = WModes_Admin_Product_Prices_Types::get_calculate_from_visibility( $args );
            $per_visible = WModes_Admin_Product_Prices_Types::get_adjustment_based_on_visibility( $args );

            $all_visible = array_merge( $from_visible, $per_visible );

            $in_fields[] = array(
                'id' => 'sale_adj',
                'type' => 'panel',
                'full_width' => true,
                'center_head' => true,
                'white_panel' => true,
                'panel_size' => 'smaller',
                'width' => '100%',
                'last' => true,
                'fields' => array(
                    array(
                        'id' => 'any_id1',
                        'type' => 'columns-field',
                        'columns' => 3,
                        'merge_fields' => false,
                        'fields' => array(
                            array(
                                'id' => 'adj_type',
                                'type' => 'select2',
                                'column_size' => 2,
                                'column_title' => esc_html__( 'Sale Price Adjustment', 'zcwm-tdm' ),
                                'tooltip' => esc_html__( 'Controls sale price adjusment mode', 'zcwm-tdm' ),
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'default' => WModes_Admin_Product_Prices_Types::get_default_adjustment_types( $args ),
                                'options' => WModes_Admin_Product_Prices_Types::get_adjustment_types( $args ),
                                'width' => '100%',
                                'fold_id' => 'sale_adj_type',
                            ),
                            array(
                                'id' => 'amount',
                                'type' => 'textbox',
                                'input_type' => 'number',
                                'column_size' => 1,
                                'tooltip' => esc_html__( 'Controls sale adjusment amount to apply', 'zcwm-tdm' ),
                                'column_title' => esc_html__( 'Amount', 'zcwm-tdm' ),
                                'default' => '0.00',
                                'placeholder' => '0.00',
                                'attributes' => array(
                                    'min' => '0',
                                    'step' => '0.01',
                                ),
                                'width' => '100%',
                            ),
                        ),
                    ),
                    array(
                        'id' => 'any_id2',
                        'type' => 'columns-field',
                        'columns' => 2,
                        'merge_fields' => false,
                        'last' => true,
                        'fields' => array(
                            array(
                                'id' => 'cal_from',
                                'type' => 'select2',
                                'column_size' => 1,
                                'column_title' => esc_html__( 'Adjust Price From', 'zcwm-tdm' ),
                                'tooltip' => esc_html__( 'Calculates sale price from original/previous product prices', 'zcwm-tdm' ),
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'default' => 'sale_price',
                                'options' => WModes_Admin_Product_Prices_Types::get_adjustment_based_on_types( $args ),
                                'width' => '100%',
                                'fold' => array(
                                    'target' => 'sale_adj_type',
                                    'attribute' => 'value',
                                    'value' => $from_visible,
                                    'oparator' => 'eq',
                                ),
                            ),
                            array(
                                'id' => 'based_on',
                                'type' => 'select2',
                                'column_size' => 1,
                                'column_title' => esc_html__( 'Percentage Based On', 'zcwm-tdm' ),
                                'tooltip' => esc_html__( 'Controls sale percentage adjusment amount based on the original/previous product prices', 'zcwm-tdm' ),
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'default' => 'sale_price',
                                'options' => WModes_Admin_Product_Prices_Types::get_adjustment_based_on_types( $args ),
                                'width' => '100%',
                                'fold' => array(
                                    'target' => 'sale_adj_type',
                                    'attribute' => 'value',
                                    'value' => $per_visible,
                                    'oparator' => 'eq',
                                ),
                            ),
                        ),
                        'fold' => array(
                            'target' => 'sale_adj_type',
                            'attribute' => 'value',
                            'value' => $all_visible,
                            'oparator' => 'eq',
                        )
                    ),
                ),
                'fold' => array(
                    'target' => 'product_prices_mode',
                    'attribute' => 'value',
                    'value' => array( 'reg_sale', 'sale' ),
                    'oparator' => 'eq',
                )
            );


            return $in_fields;
        }

    }

    WModes_Admin_Product_Prices_Types_Sale::init();
}

