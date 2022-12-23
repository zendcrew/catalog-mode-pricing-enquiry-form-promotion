<?php

if ( !class_exists( 'WModes_Admin_Condition_Types' ) ) {

    require_once (dirname( __FILE__ ) . '/condition-types-customer.php');
    require_once (dirname( __FILE__ ) . '/condition-types-customer-value.php');
    require_once (dirname( __FILE__ ) . '/condition-types-datetime.php');
    require_once (dirname( __FILE__ ) . '/condition-types-page.php');
    require_once (dirname( __FILE__ ) . '/condition-types-cart.php');
    require_once (dirname( __FILE__ ) . '/condition-types-cart-weight.php');
    require_once (dirname( __FILE__ ) . '/condition-types-cart-totals.php');
    require_once (dirname( __FILE__ ) . '/condition-types-cart-items.php');
    require_once (dirname( __FILE__ ) . '/condition-types-cart-items-subtotals.php');
    require_once (dirname( __FILE__ ) . '/condition-types-cart-items-quantity.php');
    require_once (dirname( __FILE__ ) . '/condition-types-geolocation.php');
    require_once (dirname( __FILE__ ) . '/condition-types-billing-address.php');
    require_once (dirname( __FILE__ ) . '/condition-types-billing.php');
    require_once (dirname( __FILE__ ) . '/condition-types-shipping-address.php');
    require_once (dirname( __FILE__ ) . '/condition-types-shipping.php');
    require_once (dirname( __FILE__ ) . '/condition-types-purchase-history.php');
    require_once (dirname( __FILE__ ) . '/condition-types-purchase-history-subtotal.php');
    require_once (dirname( __FILE__ ) . '/condition-types-purchase-history-quantity.php');
                
    class WModes_Admin_Condition_Types {

        public static function get_groups( $args ) {

            return apply_filters( 'wmodes-admin/get-condition-groups', array(), $args );
        }

        public static function get_conditions( $group_id, $args ) {

            return apply_filters( 'wmodes-admin/get-' . $group_id . '-group-conditions', array(), $args );
        }

        public static function get_condition_fields( $condition_id, $args ) {

            return apply_filters( 'wmodes-admin/get-' . $condition_id . '-condition-fields', array(), $args );
        }

    }

}
