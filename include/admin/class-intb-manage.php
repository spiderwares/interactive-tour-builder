<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/**
 * Manage Tour Builder post type
 */

if ( ! class_exists( 'INTB_Tour_Builder_Manager' ) ) : 

    class INTB_Tour_Builder_Manager {

        public function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_action( 'init', [ __CLASS__, 'register_post_type' ], 10 );
            add_action( 'admin_enqueue_scripts', array($this, 'enqueue_intb_tour_builder_scripts') );
        }

        public function enqueue_intb_tour_builder_scripts() {
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'select2', INTB_URL . 'assets/js/intb-select2.js', array('jquery'), INTB_VERSION, true );
            wp_enqueue_style( 'select2', INTB_URL . 'assets/css/intb-select2.css', array(), INTB_VERSION, false );
            wp_enqueue_script( 'intb-tour-builder', INTB_URL . 'assets/js/intb-admin.js', array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker', 'select2' ), INTB_VERSION, true );
            wp_enqueue_style( 'intb-admin-styles', INTB_URL . 'assets/css/intb-admin.css', array(), INTB_VERSION, false );
        }
        
        public static function register_post_type() {
            $args = array(
                'label'               => esc_html__( 'Tour Builder', 'interactive-tour-builder' ),
                'labels'              => array(
                    'name'               => esc_html__( 'Tour Builders', 'interactive-tour-builder' ),
                    'singular_name'      => esc_html__( 'Tour Builder', 'interactive-tour-builder' ),
                    'menu_name'          => esc_html__( 'Tour Builders', 'interactive-tour-builder' ),
                    'add_new'            => esc_html__( 'Add New Tour', 'interactive-tour-builder' ),
                    'add_new_item'       => esc_html__( 'Add New Tour', 'interactive-tour-builder' ),
                    'edit_item'          => esc_html__( 'Edit Tour', 'interactive-tour-builder' ),
                    'new_item'           => esc_html__( 'New Tour', 'interactive-tour-builder' ),
                    'view_item'          => esc_html__( 'View Tour', 'interactive-tour-builder' ),
                    'search_items'       => esc_html__( 'Search Tours', 'interactive-tour-builder' ),
                    'not_found'          => esc_html__( 'No Tours found', 'interactive-tour-builder' ),
                    'not_found_in_trash' => esc_html__( 'No Tours found in Trash', 'interactive-tour-builder' ),
                ),
                'supports'            => array( 'title', 'thumbnail' ),
                'hierarchical'        => true,
                'public'              => true,
                'show_ui'             => true,
                'show_in_rest'        => true,
                'show_in_menu'        => true,
                'menu_position'       => 10,
                'menu_icon'           => 'dashicons-lightbulb',
                'show_in_admin_bar'   => false,
                'show_in_nav_menus'   => false,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'capability_type'     => 'page',
                'rewrite'             => false,  // Disable the slug
            );
            register_post_type( 'intb_tour', $args );
        }        

    }

    new INTB_Tour_Builder_Manager();

endif;
