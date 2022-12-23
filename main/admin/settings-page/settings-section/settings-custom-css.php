<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Custom_CSS_Settings' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Custom_CSS_Settings {

        public static function init() {

            $option_name = WModes_Admin_Page::get_option_name();

            add_filter( 'wmodes-admin/get-settings-section-panels', array( new self(), 'get_panel' ), 80 );

            add_filter( 'reon/sanitize-' . $option_name . '-custom_css', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
        }

        public static function get_panel( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'panel',
                'last' => true,
                'white_panel' => false,
                'panel_size' => 'smaller',
                'width' => '100%',
                'field_css_class' => array( 'wmodes_setting_panel' ),
                'merge_fields' => false,
                'fields' => self::get_fields( array() ),
            );

            return $in_fields;
        }

        private static function get_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Style Sheet &amp; Font Icons', 'zcwm-tdm' ),
                'desc' => esc_html__( 'Use these settings to control the cascaded style sheet (CSS) and font icons', 'zcwm-tdm' ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 2,
                'full_width' => true,
                'merge_fields' => false,
                'fields' => self::get_panel_fields( array() ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'full_width' => true,
                'merge_fields' => false,
                'fields' => self::get_custom_css_fields( array() ),
            );

            return $in_fields;
        }

        private static function get_panel_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'use_external_css',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Use External CSS', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines whether or no to use external css', 'zcwm-tdm' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'zcwm-tdm' ),
                    'no' => esc_html__( 'No', 'zcwm-tdm' ),
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'column_size' => 1,
                'column_title' => esc_html__( 'Include Font Awesome Icons', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Determines or no the font awesome icon should be included on the front-end pages', 'zcwm-tdm' ),
                'show_box' => true,
                'text' => WModes_Admin_Page::get_premium_messages( 'short' ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_custom_css_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'custom_css',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Custom CSS', 'zcwm-tdm' ),
                'tooltip' => esc_html__( "Adds additional custom stylesheet to the plugin's components", 'zcwm-tdm' ),
                'default' => '',
                'placeholder' => esc_html__( 'Type here...', 'zcwm-tdm' ),
                'rows' => 5,
                'width' => '100%',
            );

            return $in_fields;
        }

    }

}