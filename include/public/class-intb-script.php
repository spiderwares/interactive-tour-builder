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
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_driver_js' ) );
            
            if ( apply_filters( 'intb_enable_admin_scripts', false ) ) :
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_driver_js' ) );
            endif;

        }
        
        public function enqueue_driver_js() {
            wp_enqueue_script( 'driver-script', INTB_URL . 'assets/js/intb-driver-script.js', array(), INTB_VERSION, false );
            wp_enqueue_script('wp-hooks', includes_url('js/hooks.js'), array('jquery'), INTB_VERSION, true);
            wp_enqueue_script( 'intb-tour-helper', INTB_URL . 'assets/js/intb-tour-helper.js', array( 'jquery', 'wp-hooks' ), INTB_VERSION, true );
            wp_enqueue_style( 'driver-style', INTB_URL . 'assets/css/intb-driver-style.css', array(), INTB_VERSION, false );

            $tours = get_posts( array(
                'post_type'   => 'intb_tour',
                'post_status' => 'publish',
                'numberposts' => -1,
            ) );
        
            $tour_data = array();
            foreach ( $tours as $tour ) :
                $options_data       = get_post_meta( $tour->ID, 'intb_options', true );
                $meta_data          = get_post_meta( $tour->ID, '_intb_tour_meta_fields', true );
                $selcted_pages      = get_post_meta( $tour->ID, '_intb_selected_pages', true );
                $saved_single_pages = get_post_meta( $tour->ID, '_intb_selected_single_page', true );
                $selcted_terms      = get_post_meta( $tour->ID, '_intb_selected_taxonomies', true );

                if ( !empty( $selcted_pages ) && is_page( $selcted_pages ) ) :
                    $tour_data[] = array(
                        'id'          => $tour->ID,
                        'title'       => $tour->post_title,
                        'options'     => $options_data ? $options_data : array(),
                        'meta_fields' => $meta_data ? $meta_data : array(),
                    );
                endif;

                if ( !empty( $saved_single_pages ) && is_singular( $saved_single_pages ) ) :
                    $tour_data[] = array(
                        'id'          => $tour->ID,
                        'title'       => $tour->post_title,
                        'options'     => $options_data ? $options_data : array(),
                        'meta_fields' => $meta_data ? $meta_data : array(),
                    );
                endif;

                if ( is_tax() && ! empty( $selcted_terms ) && is_array( $selcted_terms ) ) :
                    $current_term_id = get_queried_object()->term_id;
                    if ( in_array( $current_term_id, $selcted_terms ) ) :
                        $tour_data[] = array(
                            'id'          => $tour->ID,
                            'title'       => $tour->post_title,
                            'options'     => $options_data ? $options_data : array(),
                            'meta_fields' => $meta_data ? $meta_data : array(),
                        );
                    endif;
                endif;

                if ( is_admin() && isset($options_data['intb_enable_wp_admin']) && $options_data['intb_enable_wp_admin'] === 'yes' ) :
                    $tour_data[] = array(
                        'id'          => $tour->ID,
                        'title'       => $tour->post_title,
                        'options'     => $options_data ? $options_data : array(),
                        'meta_fields' => $meta_data ? $meta_data : array(),
                    );
                endif;

            endforeach;

            $current_user    = wp_get_current_user();
            $user_data       = array(
                'username'     => $current_user->user_login,
                'user_email'   => $current_user->user_email,
                'display_name' => $current_user->display_name,
                'admin_email'  => get_option( 'admin_email' ),
            );

            wp_localize_script( 'intb-tour-helper', 'intbTourData', array(
                'tours'         => $tour_data,
                'user'          => $user_data,
                'intb_driver'   => null,
            ) );

        }        

    }

    new Intb_Shortcode();
endif;