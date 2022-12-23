<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Options_Page' ) ) {

    class WModes_Admin_Product_Options_Page {

        public static function init() {
            $option_name = WModes_Admin_Page::get_option_name();
            add_filter( 'get-option-page-' . $option_name . 'section-product_options-fields', array( new self(), 'get_page_fields' ), 10, 2 );
            add_filter( 'reon/get-repeater-field-product_options-templates', array( new self(), 'get_templates' ), 10, 2 );
            add_filter( 'roen/get-repeater-template-product_options-product_option-fields', array( new self(), 'get_fields' ), 10, 2 );
            add_filter( 'roen/get-repeater-template-product_options-product_option-head-fields', array( new self(), 'get_head_fields' ), 10, 2 );
        }

        public static function get_page_fields( $in_fields, $section_id ) {

            $in_fields[] = array(
                'id' => 'product_option_settings',
                'type' => 'panel',
                'last' => true,
                'white_panel' => false,
                'panel_size' => 'smaller',
                'width' => '100%',
                'field_css_class' => array( 'wmodes_apply_mode' ),
                'fields' => array(
                    array(
                        'id' => 'catalog_modes_any_id',
                        'type' => 'columns-field',
                        'columns' => 1,
                        'merge_fields' => false,
                        'fields' => array(
                            array(
                                'id' => 'mode',
                                'type' => 'select2',
                                'column_size' => 3,
                                'column_title' => esc_html__( 'Apply Method', 'zcwm-tdm' ),
                                'tooltip' => esc_html__( 'Controls product option apply method', 'zcwm-tdm' ),
                                'default' => 'all',
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'options' => self::get_apply_method(),
                                'width' => '100%',
                            ),
                        ),
                    ),
                ),
            );



            $max_sections = 1;
            if ( defined( 'WMODES_PREMIUM_ADDON' ) ) {
                $max_sections = 99999;
            }

            $in_fields[] = array(
                'id' => 'product_options',
                'type' => 'repeater',
                'white_repeater' => false,
                'repeater_size' => 'small',
                'accordions' => true,
                'buttons_sep' => false,
                'delete_button' => true,
                'clone_button' => true,
                'width' => '100%',
                'max_sections' => $max_sections,
                'max_sections_msg' => esc_html__( 'Please upgrade to premium version in order to add more settings', 'zcwm-tdm' ),
                'field_css_class' => array( 'wmodes_options' ),
                'css_class' => 'wmodes_extension_options',
                'auto_expand' => array(
                    'new_section' => true,
                    'cloned_section' => true,
                ),
                'sortable' => array(
                    'enabled' => true,
                ),
                'template_adder' => array(
                    'position' => 'right',
                    'show_list' => false,
                    'button_text' => esc_html__( 'New Product Settings', 'zcwm-tdm' ),
                ),
            );

            return $in_fields;
        }

        public static function get_templates( $in_templates, $repeater_args ) {
            if ( $repeater_args[ 'screen' ] == 'option-page' && $repeater_args[ 'option_name' ] == WModes_Admin_Page::get_option_name() ) {

                $in_templates[] = array(
                    'id' => 'product_option',
                    'head' => array(
                        'title' => '',
                        'defaut_title' => esc_html__( 'Product Settings', 'zcwm-tdm' ),
                        'title_field' => 'admin_note',
                    )
                );
            }

            return $in_templates;
        }

        public static function get_fields( $in_fields, $repeater_args ) {
            if ( $repeater_args[ 'screen' ] == 'option-page' && $repeater_args[ 'option_name' ] == WModes_Admin_Page::get_option_name() ) {
                return apply_filters( 'wmodes-admin/product-options/get-panels', array() );
            }
            return $in_fields;
        }

        public static function get_head_fields( $in_fields, $repeater_args ) {
            if ( $repeater_args[ 'screen' ] == 'option-page' && $repeater_args[ 'option_name' ] == WModes_Admin_Page::get_option_name() ) {
                $in_fields[] = array(
                    'id' => 'any_id',
                    'type' => 'group-field',
                    'position' => 'right',
                    'width' => '100%',
                    'merge_fields' => false,
                    'fields' => array(
                        array(
                            'id' => 'apply_mode',
                            'type' => 'select2',
                            'default' => 'with_others',
                            'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                            'options' => self::get_apply_modes(),
                            'width' => '320px',
                        ),
                        array(
                            'id' => 'enable',
                            'type' => 'select2',
                            'default' => 'yes',
                            'options' => array(
                                'yes' => esc_html__( 'Enable', 'zcwm-tdm' ),
                                'no' => esc_html__( 'Disable', 'zcwm-tdm' ),
                            ),
                            'width' => '95px',
                        ),
                    ),
                );
            }

            return $in_fields;
        }

        private static function get_apply_method() {


            $apply_methods = array(
                'all' => esc_html__( 'Apply all valid product settings', 'zcwm-tdm' ),
            );

            if ( !defined( 'WMODES_PREMIUM_ADDON' ) ) {
                $apply_methods[ 'prem_1' ] = esc_html__( 'Apply first valid product settings (Premium)', 'zcwm-tdm' );
                $apply_methods[ 'prem_2' ] = esc_html__( 'Apply last valid product settings (Premium)', 'zcwm-tdm' );
            }

            $apply_methods = apply_filters( 'wmodes-admin/product-options/get-apply-methods', $apply_methods );

            $apply_methods[ 'no' ] = esc_html__( 'Do not apply any product settings', 'zcwm-tdm' );

            return $apply_methods;
        }

        private static function get_apply_modes() {

            $apply_modes = array(
                'with_others' => esc_html__( 'Apply this and other product settings', 'zcwm-tdm' ),
            );

            if ( !defined( 'WMODES_PREMIUM_ADDON' ) ) {
                $apply_modes[ 'prem_1' ] = esc_html__( 'Apply only this product settings (Premium)', 'zcwm-tdm' );
                $apply_modes[ 'prem_2' ] = esc_html__( 'Apply if other product settings are valid (Premium)', 'zcwm-tdm' );
                $apply_modes[ 'prem_3' ] = esc_html__( 'Apply if no other valid product settings (Premium)', 'zcwm-tdm' );
            }

            return apply_filters( 'wmodes-admin/product-options/get-apply-modes', $apply_modes );
        }

    }

}