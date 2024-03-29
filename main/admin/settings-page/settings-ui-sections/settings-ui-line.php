<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Settings_Styles_Line_Settings' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Settings_Styles_Line_Settings {

        public static function init() {

            add_filter( 'wmodes-admin/get-settings-styles-section-panels', array( new self(), 'get_panel' ), 130 );
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
                'title' => esc_html__( 'Horizantal Line Designs', 'wmodes-tdm' ),
                'desc' => esc_html__( 'Use these settings to create and manage horizontal line designs', 'wmodes-tdm' ),
            );

            $in_fields[] = array(
                'id' => 'is_any',
                'type' => 'textblock',
                'show_box' => false,
                'full_width' => true,
                'center_head' => true,
                'text' => WModes_Admin_Page::get_premium_messages(),
                'width' => '100%',
                'box_width' => '100%',
            );

            return $in_fields;
        }

    }

    WModes_Admin_Settings_Styles_Line_Settings::init();
}