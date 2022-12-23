<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_Cart' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_Cart {

        public static function init() {

            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 50, 2 );

            add_filter( 'wmodes-admin/get-cart-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );

            add_filter( 'wmodes-admin/get-cart_line_count-condition-fields', array( new self(), 'get_line_count_fields' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'cart' ] = esc_html__( 'Cart', 'zcwm-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'Cart Total Quantity (Premium)', 'zcwm-tdm' );
            $in_list[ 'cart_line_count' ] = esc_html__( 'Number Of Cart Items', 'zcwm-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'Applied Coupons (Premium)', 'zcwm-tdm' );

            return $in_list;
        }

        public static function get_line_count_fields( $in_fields, $args ) {

            $in_fields[] = array(
                'id' => 'compare',
                'type' => 'select2',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'default' => '>=',
                'options' => array(
                    'prem_1' => esc_html__( 'Between (Premium)', 'zcwm-tdm' ),
                    '>=' => esc_html__( 'More than or equal to', 'zcwm-tdm' ),
                    '>' => esc_html__( 'More than', 'zcwm-tdm' ),
                    '<=' => esc_html__( 'Less than or equal to', 'zcwm-tdm' ),
                    '<' => esc_html__( 'Less than', 'zcwm-tdm' ),
                    'prem_2' => esc_html__( 'Equal to (Premium)', 'zcwm-tdm' ),
                    'prem_3' => esc_html__( 'Not equal to (Premium)', 'zcwm-tdm' ),
                ),
                'width' => '99%',
                'box_width' => '44%',
            );

            $in_fields[] = array(
                'id' => 'line_count',
                'type' => 'textbox',
                'input_type' => 'number',
                'default' => '0',
                'placeholder' => esc_html__( '0', 'zcwm-tdm' ),
                'width' => '100%',
                'box_width' => '56%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Condition_Type_Cart::init();
}