<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;

if ( ! class_exists( 'Intb_Shortcode' ) ) :

    class Intb_Shortcode {

        public function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_driver_js'));
            add_shortcode( 'interactive_tour_script', array( $this, 'interactive_tour_script' ) );
        }
        
        public function enqueue_driver_js() {
            wp_enqueue_script( 'driver-script', INTB_URL . 'assets/js/intb-driver-script.js', array(), INTB_VERSION, false );
            wp_enqueue_script( 'intb-tour-helper', INTB_URL . 'assets/js/intb-tour-helper.js', array( 'jquery' ), INTB_VERSION, true );
            wp_enqueue_style( 'driver-style', INTB_URL . 'assets/css/intb-driver-style.css', array(), INTB_VERSION, false );
        }


        public function interactive_tour_script( $attr ) {
            if ( isset( $attr['id']) && !empty( $attr['id'] ) ) :
                $post_id = $attr['id'];

                if ( get_post_status( $post_id ) !== 'publish' ) :
                    return;
                endif;

                $js_file_path = INTB_URL. 'assets/js/intb-tour-' . $post_id . '.js';
                wp_enqueue_script( 'intb_tour_js_' . $post_id, $js_file_path, array( 'jquery' ), time(), true );

            endif;

        }
        

    }

    new Intb_Shortcode();
endif;