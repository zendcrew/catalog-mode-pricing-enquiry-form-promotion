<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Options_Panel_Options' ) ) {

    class WModes_Admin_Product_Options_Panel_Options {

        private static $template_added = array();
        private static $require_products = array();

        public static function init() {
            add_filter( 'wmodes-admin/product-options/get-panel-options-fields', array( new self(), 'get_Panel_fields' ), 10 );
            add_filter( 'wmodes-admin/product-options/get-panels', array( new self(), 'get_Panel' ), 10 );
            add_filter( 'reon/get-repeater-field-wmodes-options-templates', array( new self(), 'get_option_templates' ), 10, 2 );
            add_filter( 'reon/get-repeater-field-wmodes-options-template-groups', array( new self(), 'get_option_template_groups' ), 10, 2 );
        }

        public static function get_Panel( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'panel',
                'full_width' => true,
                'center_head' => true,
                'white_panel' => false,
                'panel_size' => 'smaller',
                'width' => '100%',
                'merge_fields' => false,
                'css_class' => 'wmodes_option_list',
                'field_css_class' => array( 'wmodes_option_list_field' ),
                'last' => true,
                'fields' => apply_filters( 'wmodes-admin/product-options/get-panel-options-fields', array() ),
            );

            return $in_fields;
        }

        public static function get_Panel_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'panel',
                'full_width' => true,
                'center_head' => true,
                'white_panel' => true,
                'panel_size' => 'smaller',
                'width' => '100%',
                'last' => true,
                'css_class' => 'wmodes_list_title',
                'fields' => array(
                    array(
                        'id' => 'any_id',
                        'type' => 'paneltitle',
                        'full_width' => true,
                        'center_head' => true,
                        'title' => esc_html__( 'Settings', 'wmodes-tdm' ),
                        'desc' => esc_html__( 'List of product settings to apply, empty list will not apply any settings', 'wmodes-tdm' ),
                    )
                ),
            );


            $in_fields[] = array(
                'id' => 'options',
                'filter_id' => 'wmodes-options',
                'type' => 'repeater',
                'white_repeater' => true,
                'repeater_size' => 'smaller',
                'section_type_id' => 'option_type',
                'collapsible' => false,
                'accordions' => false,
                'buttons_sep' => false,
                'delete_button' => true,
                'clone_button' => false,
                'css_class' => 'wmodes_list',
                'field_css_class' => array( 'wmodes_list_field' ),
                'width' => '100%',
                'auto_expand' => array(
                    'all_section' => true,
                    'new_section' => true,
                    'default_section' => true,
                    'cloned_section' => true,
                ),
                'sortable' => array(
                    'enabled' => true,
                ),
                'template_adder' => array(
                    'position' => 'right',
                    'show_list' => true,
                    'list_icon' => 'fa fa-list',
                    'list_width' => '236px',
                    'button_text' => esc_html__( 'Add Settings', 'wmodes-tdm' ),
                ),
            );

            return $in_fields;
        }

        public static function get_option_templates( $in_templates, $repeater_args ) {

            if ( $repeater_args[ 'screen' ] == 'option-page' && $repeater_args[ 'option_name' ] == WModes_Admin_Page::get_option_name() ) {

                $args = array(
                    'module' => 'product-options',
                    'is_global' => true,
                );

                $options = WModes_Admin_Product_Option_Types::get_types( $args );

                foreach ( $options as $key => $option ) {
                    if ( !isset( $option[ 'title' ] ) ) {
                        $option[ 'title' ] = $option[ 'list_title' ];
                    }

                    $template = array(
                        'id' => $key,
                        'list_label' => $option[ 'list_title' ],
                        'head' => array(
                            'title' => $option[ 'title' ],
                        )
                    );

                    if ( isset( $option[ 'group_id' ] ) ) {
                        $template[ 'group_id' ] = $option[ 'group_id' ];
                    }
                    if ( isset( $option[ 'tooltip' ] ) ) {
                        $template[ 'head' ][ 'tooltip' ] = $option[ 'tooltip' ];
                    }

                    $in_templates[] = $template;

                    if ( !in_array( $key, self::$template_added ) ) {
                        add_filter( 'roen/get-repeater-template-wmodes-options-' . $key . '-fields', array( new self(), 'get_option_fields' ), 10, 2 );
                        self::$template_added[] = $key;
                    }
                }
            }

            return $in_templates;
        }

        public static function get_option_template_groups( $in_groups, $repeater_args ) {

            if ( $repeater_args[ 'screen' ] == 'option-page' && $repeater_args[ 'option_name' ] == WModes_Admin_Page::get_option_name() ) {

                $args = array(
                    'module' => 'product-options',
                    'is_global' => true,
                );

                $in_groups = WModes_Admin_Product_Option_Types::get_groups( $args );
            }


            return $in_groups;
        }

        public static function get_option_fields( $in_fields, $repeater_args ) {

            $template_id = $repeater_args[ 'id' ];

            $args = array(
                'module' => 'product-options',
                'is_global' => true,
            );

            $in_fields[] = array(
                'id' => 'id',
                'type' => 'autoid',
                'autoid' => 'wmodes',
            );

            $in_flds = apply_filters( 'wmodes-admin/product-options/get-option-type-' . $template_id . '-fields', array(), $args );

            foreach ( $in_flds as $flds ) {
                
                $in_fields[] = $flds;
            }

            $requires_products = self::get_requires_products( $args );

            if ( in_array( $template_id, $requires_products ) ) {

                return WModes_Admin_Logic_Types_Product_Filters::get_fields( $in_fields, $args );
            }

            return $in_fields;
        }

        private static function get_requires_products( $args ) {

            if ( count( self::$require_products ) > 0 ) {
                return self::$require_products;
            }

            $options = WModes_Admin_Product_Option_Types::get_types( $args );

            $option_keys = array_keys( $options );

            $ex_keys = apply_filters( 'wmodes-admin/product-options/get-type-requires-ex-products', array(), $args );


            foreach ( $option_keys as $option_key ) {

                if ( !in_array( $option_key, $ex_keys ) ) {

                    self::$require_products[] = $option_key;
                }
            }

            return self::$require_products;
        }

    }

    WModes_Admin_Product_Options_Panel_Options::init();
}
