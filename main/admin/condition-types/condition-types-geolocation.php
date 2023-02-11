<?php

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Condition_Type_GeoLocations' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Condition_Type_GeoLocations {

        public static function init() {
            
            add_filter( 'wmodes-admin/get-condition-groups', array( new self(), 'get_groups' ), 110, 2 );

            add_filter( 'wmodes-admin/get-geo_locations-group-conditions', array( new self(), 'get_conditions' ), 10, 2 );
        }

        public static function get_groups( $in_groups, $args ) {

            $in_groups[ 'geo_locations' ] = esc_html__( 'GeoIP Locations', 'wmodes-tdm' );

            return $in_groups;
        }

        public static function get_conditions( $in_list, $args ) {

            $in_list[ 'prem_1' ] = esc_html__( 'GeoIP Continents (Premium)', 'wmodes-tdm' );
            $in_list[ 'prem_2' ] = esc_html__( 'GeoIP Countries (Premium)', 'wmodes-tdm' );
           
            return $in_list;
        }
        
        
    }

    WModes_Admin_Condition_Type_GeoLocations::init();
}