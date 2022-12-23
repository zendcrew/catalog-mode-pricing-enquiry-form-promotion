<?php

if ( !class_exists( 'WModes_Cart_Session' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Cart_Session {

        private static $instance = null;
        private $cart_data;
        private $default_cart_data;
        private $cart;

        private function __construct() {

            $this->cart_data = array();
            $this->default_cart_data = array();


            add_action( 'woocommerce_load_cart_from_session', array( $this, 'load_cart_from_session' ) );
            add_action( 'woocommerce_cart_loaded_from_session', array( $this, 'loaded_cart_from_session' ) );
            add_action( 'woocommerce_cart_item_removed', array( $this, 'cart_item_removed' ), 10, 2 );
        }

        public static function get_instance(): self {

            if ( null == self::$instance ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function get_cart_data() {

            if ( !count( $this->cart_data ) ) {

                return $this->get_default_cart_data();
            }

            return $this->cart_data;
        }

        public function load_cart_from_session() {

            if ( !$this->is_checkout() ) {

                $this->cart_data = WC()->session->get( 'wmodes_cart_data', $this->get_default_cart_data() );
            }
        }

        public function loaded_cart_from_session( $cart ) {

            if ( !$this->is_checkout() ) {

                $this->cart_data = WC()->session->get( 'wmodes_cart_data', $this->get_default_cart_data() );
            }
        }

        public function cart_item_removed( $cart_item_key, $cart ) {

            if ( !$cart || $cart->is_empty() ) {

                WC()->session->set( 'wmodes_cart_data', $this->get_default_cart_data() );
            }
        }

        public function before_calculate_totals( $cart ) {

            $this->cart = $cart;

            $this->cart_data = $this->process_cart_data( array() );

            WC()->session->set( 'wmodes_cart_data', $this->cart_data );
        }

        private function get_default_cart_data() {

            if ( count( $this->default_cart_data ) ) {

                return $this->default_cart_data;
            }

            $default = array(
                'items' => array()
            );

            $this->default_cart_data = $this->process_customer( $default );

            return $this->default_cart_data;
        }

        private function process_cart_data( $cart_data ) {

            return $this->process_items( $cart_data );
        }

        private function process_items( $cart_data ) {

            $cart_items = array();

            foreach ( $this->cart->cart_contents as $key => $item ) {

                $cart_items[ $key ] = $this->process_item( $item );
            }

            $cart_data[ 'items' ] = $cart_items;

            return $this->process_customer( $cart_data );
        }

        private function process_item( $cart_item ) {

            $item_data = array(
                'key' => $cart_item[ 'product_id' ] . '_' . $cart_item[ 'variation_id' ],
                'product_id' => $cart_item[ 'product_id' ],
                'variation_id' => $cart_item[ 'variation_id' ],
                'quantity' => $cart_item[ 'quantity' ],
            );

            $product_data = $this->process_item_data( $cart_item );

            if ( !count( $product_data ) ) {

                return $item_data;
            }

            $item_data[ 'category_ids' ] = $product_data[ 'category_ids' ];
            $item_data[ 'tag_ids' ] = $product_data[ 'tag_ids' ];

            return $item_data;
        }

        private function process_item_data( $cart_item ) {

            if ( $cart_item[ 'variation_id' ] > 0 ) {

                $variation = $cart_item[ 'data' ];

                $product = WModes_Product::get_product( $cart_item[ 'product_id' ] );

                if ( $product ) {

                    return WModes_Product::get_data( $product, $variation );
                } else {

                    return array();
                }
            }

            return WModes_Product::get_data( $cart_item[ 'data' ] );
        }

        private function process_customer( $cart_data ) {

            $cart_data[ 'customer' ] = array();

            $customer = WC()->session->get( 'customer', false );

            if ( $customer ) {

                $cart_data[ 'customer' ] = array(
                    'id' => $customer[ 'id' ],
                    'email' => $customer[ 'email' ],
                );
            }

            return $cart_data;
        }

        private function is_checkout() {

            if ( is_checkout() ) {

                return true;
            }

            if ( defined( 'WOOCOMMERCE_CHECKOUT' ) ) {

                return true;
            }

            return false;
        }

    }

    WModes_Cart_Session::get_instance();
}
