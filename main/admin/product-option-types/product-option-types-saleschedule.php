<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Option_Type_SaleSchedule' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Option_Type_SaleSchedule {

        public static function init() {

            add_filter( 'wmodes-admin/product-options/get-settings-option-types', array( new self(), 'get_types' ), 20, 2 );

            add_filter( 'wmodes-admin/product-options/get-option-type-sale_schedule-fields', array( new self(), 'get_fields' ), 10, 2 );

            add_filter( 'wmodes-admin/product-options/get-type-requires-variations', array( new self(), 'get_requires_variations' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'sale_schedule' ] = array(
                'title' => esc_html__( 'Sale Schedule', 'zcwm-tdm' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 11,
                'merge_fields' => false,
                'fields' => self::get_panel_fields(),
            );

            return $in_fields;
        }

        public static function get_requires_variations( $in_options, $args ) {

            $in_options[] = 'sale_schedule';

            return $in_options;
        }

        private static function get_panel_fields() {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'mode',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Schedule Mode', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Controls sale schedule mode', 'zcwm-tdm' ),
                'disabled_list_filter' => 'wmodes-admin/get-disabled-grouped-list',
                'options' => self::get_mode(),
                'width' => '100%',
                'fold_id' => 'sale_schedule_mode',
            );

            return self::get_date_fields( $in_fields );
        }

        private static function get_date_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'date',
                'type' => 'date',
                'column_size' => 4,
                'column_title' => esc_html__( 'Specific Date', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'Enter a specific date to schedule sale', 'zcwm-tdm' ),
                'number_of_months' => 1,
                'show_button_panel' => false,
                'change_month' => true,
                'change_year' => true,
                'first_day' => 0,
                'default' => '',
                'placeholder' => esc_html__( 'yy-mm-dd', 'zcwm-tdm' ),
                'date_format' => 'yy-mm-dd',
                'fold' => array(
                    'target' => 'sale_schedule_mode',
                    'attribute' => 'value',
                    'value' => 'date',
                    'oparator' => 'eq',
                    'clear' => true,
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'from_date',
                'type' => 'date',
                'column_size' => 4,
                'column_title' => esc_html__( 'From Date', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'User role to apply', 'zcwm-tdm' ),
                'number_of_months' => 1,
                'show_button_panel' => false,
                'change_month' => true,
                'change_year' => true,
                'first_day' => 0,
                'default' => '',
                'placeholder' => esc_html__( 'yy-mm-dd', 'zcwm-tdm' ),
                'date_format' => 'yy-mm-dd',
                'fold' => array(
                    'target' => 'sale_schedule_mode',
                    'attribute' => 'value',
                    'value' => array( 'from_date', 'range_date' ),
                    'oparator' => 'eq',
                    'clear' => true,
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'to_date',
                'type' => 'date',
                'column_size' => 4,
                'column_title' => esc_html__( 'To Date', 'zcwm-tdm' ),
                'tooltip' => esc_html__( 'User role to apply', 'zcwm-tdm' ),
                'number_of_months' => 1,
                'show_button_panel' => false,
                'change_month' => true,
                'change_year' => true,
                'first_day' => 0,
                'default' => '',
                'placeholder' => esc_html__( 'yy-mm-dd', 'zcwm-tdm' ),
                'date_format' => 'yy-mm-dd',
                'fold' => array(
                    'target' => 'sale_schedule_mode',
                    'attribute' => 'value',
                    'value' => array( 'to_date', 'range_date' ),
                    'oparator' => 'eq',
                    'clear' => true,
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_mode() {

            $options = array(
                'date' => array(
                    'label' => esc_html__( 'Date', 'zcwm-tdm' ),
                    'options' => array(
                        'date' => esc_html__( 'Specific Date', 'zcwm-tdm' ),
                        'from_date' => esc_html__( 'From Date', 'zcwm-tdm' ),
                        'to_date' => esc_html__( 'To Date', 'zcwm-tdm' ),
                        'range_date' => esc_html__( 'Between Date', 'zcwm-tdm' ),
                    )
                ),
                'time' => array(
                    'label' => esc_html__( 'Time', 'zcwm-tdm' ),
                    'options' => array(
                        'prem_1' => esc_html__( 'From Time (Premium)', 'zcwm-tdm' ),
                        'prem_2' => esc_html__( 'To Time (Premium)', 'zcwm-tdm' ),
                        'prem_3' => esc_html__( 'Between Time (Premium)', 'zcwm-tdm' ),
                    )
                ),
                'date_time' => array(
                    'label' => esc_html__( 'Date &amp; Time', 'zcwm-tdm' ),
                    'options' => array(
                        'prem_1' => esc_html__( 'Specific Date &amp; Time (Premium)', 'zcwm-tdm' ),
                        'prem_2' => esc_html__( 'From Date &amp; Time (Premium)', 'zcwm-tdm' ),
                        'prem_3' => esc_html__( 'To Date &amp; Time (Premium)', 'zcwm-tdm' ),
                        'prem_4' => esc_html__( 'Between Date &amp; Time (Premium)', 'zcwm-tdm' ),
                    )
                ),
                'days_months' => array(
                    'label' => esc_html__( 'Days &amp; Months', 'zcwm-tdm' ),
                    'options' => array(
                        'prem_1' => esc_html__( 'Days of Week (Premium)', 'zcwm-tdm' ),
                        'prem_2' => esc_html__( 'Days of Month (Premium)', 'zcwm-tdm' ),
                        'prem_3' => esc_html__( 'Months of Year (Premium)', 'zcwm-tdm' ),
                    )
                ),
            );

            return $options;
        }

    }

    WModes_Admin_Product_Option_Type_SaleSchedule::init();
}
