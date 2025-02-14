<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/**
 * Manage Tour Builder post type
 */

if ( ! class_exists( 'INTB_Enqueue_Script' ) ) : 

    class INTB_Enqueue_Script {

        public function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_action('wp_enqueue_scripts', array($this, 'intb_tour_enqueue_builder_scripts'));
        }

        public function intb_tour_enqueue_builder_scripts() {
            // Fetch all published posts of the 'intb_tour' post type
            $args = array(
                'post_type'      => 'intb_tour',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            );
        
            $intb_tours = get_posts( $args );
        
            if ( ! empty( $intb_tours ) ) :
                foreach ( $intb_tours as $post ) :

                    $selcted_pages      = get_post_meta( $post->ID, '_intb_selected_pages', true );
                    $saved_single_pages = get_post_meta( $post->ID, '_intb_selected_single_page', true );
                    $selcted_terms      = get_post_meta( $post->ID, '_intb_selected_taxonomies', true );

                    $js_file_path = INTB_URL. 'assets/js/intb-tour-' . $post->ID . '.js';                    
                    if ( !empty( $selcted_pages ) && is_page( $selcted_pages ) ) :
                        wp_enqueue_script( 'intb_tour_js_' . $post->ID, $js_file_path, array( 'jquery' ), time(), true );
                    endif;

                    if ( !empty( $saved_single_pages ) && is_singular( $saved_single_pages ) ) :
                        wp_enqueue_script( 'intb_tour_js_' . $post->ID, $js_file_path, array( 'jquery' ), time(), true );
                    endif;

                    if ( is_tax() && ! empty( $selcted_terms ) && is_array( $selcted_terms ) ) :
                        $current_term_id = get_queried_object()->term_id; // Get the current term ID
                        if ( in_array( $current_term_id, $selcted_terms ) ) :
                            wp_enqueue_script( 'intb_tour_js_' . $post->ID, $js_file_path, array( 'jquery' ), time(), true );
                        endif;
                    endif;                    

                endforeach;
            endif;
        }

    }

    new INTB_Enqueue_Script();

endif;
