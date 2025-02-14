<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/**
 * Manage Tour Builder Shotcode columns
 */

if ( ! class_exists( 'INTB_ShortCode_Column' ) ) : 

    class INTB_ShortCode_Column{

        public function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_filter( 'manage_intb_tour_posts_columns', array( $this, 'add_shortcode_column' ) );
            add_action( 'manage_intb_tour_posts_custom_column', array( $this, 'populate_shortcode_column' ), 1, 2 );
            add_action( 'add_meta_boxes', array( $this, 'add_shortcode_metabox' ) );
        }

        public function add_shortcode_column( $columns ) {
            $new_columns = array();
            foreach ( $columns as $key => $value ) {
                if ( $key === 'title' ) {
                    $new_columns[ $key ] = $value; 
                    $new_columns['shortcode'] = __( 'Shortcode', 'interactive-tour-builder' );
                } else {
                    $new_columns[ $key ] = $value; 
                }
            }
            return $new_columns;
        }

        public function populate_shortcode_column($column, $post_id) {
            if ($column === 'shortcode') {
                $shortcode = sprintf("[interactive_tour_script id='%d']", $post_id);
                echo sprintf(
                    '<div class="intb-shortcode-column">%s</div>',
                    esc_html($shortcode)
                );
            }
        }
        
        public function add_shortcode_metabox() {
            add_meta_box(
                'intb_shortcode_metabox',
                __( 'Tour Shortcode', 'interactive-tour-builder' ),
                array( $this, 'render_shortcode_metabox' ), 
                'intb_tour', 
                'normal',
                'high'
            );
        }

        public function render_shortcode_metabox( $post ) {
            $shortcode = sprintf( "[interactive_tour_script id='%d']", $post->ID );

            echo '<p class="intb-shortcode-title">' . esc_html( __( 'Use the shortcode below to display this Interactive Tour Builder', 'interactive-tour-builder' ) ) . '</p>';
            echo '<input type="text" class="intb-shortcode-field" readonly value="' . esc_attr( $shortcode ) . '" />';
        }

    }

    new INTB_ShortCode_Column();

endif;
