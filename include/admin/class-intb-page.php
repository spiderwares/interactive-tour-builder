<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;

/**
 * Add a meta box to Pages with three dropdowns (multi-select).
 */

if ( ! class_exists( 'INTB_Page_MetaBox' ) ) : 

    class INTB_Page_MetaBox {

        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'add_page_metabox' ) );
            add_action( 'save_post', [ $this, 'save_page_select_meta' ] );
        }

        public function add_page_metabox(){
            add_meta_box(
                'intb_tour_pages_meta_box',
                esc_html__( 'Auto Populate On', 'interactive-tour-builder' ),
                [ $this, 'pages_meta_box' ],
                'intb_tour',
                'normal',
                'default'
            );
        }

        public function pages_meta_box( $post ) {

            // Set Multiselect For the Pages
            $args = array(
                'post_type'      => array( 'page'),
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            );
            $posts = get_posts( $args );
            $saved_pages = get_post_meta( $post->ID, '_intb_selected_pages', true );
            $saved_pages = is_array( $saved_pages ) ? $saved_pages : [];
        
            intb_get_template(
                'fields/multi-select-field.php',
                array(
                    'title'        => 'Select Page',
                    'posts'        => $posts,
                    'saved_pages'  => $saved_pages,
                    'key'          => 'intb_selected_pages',
                    'desc'         => 'Select the pages on which you want to add this tour.'
                )
            );


            $args_post_types = get_post_types( array( 'public' => true ), 'objects' );

            // Remove the 'page' and 'intb_tour' post types
            foreach ( $args_post_types as $post_type_key => $post_type_obj ) {
                if ( in_array( $post_type_key, array( 'page', 'intb_tour' ) ) ) {
                    unset( $args_post_types[$post_type_key] );
                }
            }
            
            // Create dropdown options for post types
            $options = array();
            foreach ( $args_post_types as $post_type_key => $post_type_obj ) {
                $options[] = array(
                    'value' => $post_type_key,
                    'label' => $post_type_obj->label
                );
            }

            intb_get_template(
                'fields/single-field.php',
                array(
                    'title'       => 'Select Post Type',
                    'options'     => $options,
                    'saved_value' => (array) get_post_meta( $post->ID, '_intb_selected_single_page', true ), // Ensure it's an array
                    'key'         => 'intb_selected_single_page',
                    'desc'        => 'Select the post type you want to display for this tour.'
                )
            );
            

            
            $intb_taxonomies = array();

            // Fetch public taxonomies
            $taxonomy_args = array( 'public' => true );
            $intb_objects = get_taxonomies( $taxonomy_args, 'objects' );
            
            // Loop through taxonomy objects
            foreach ( $intb_objects as $intb_taxonomy_slug => $intb_taxonomy_object ) {
                
                // Skip built-in (WP) private taxonomies (e.g., 'nav_menu', 'post_tag', etc.)
                if ( $intb_taxonomy_object->_builtin && ! $intb_taxonomy_object->public ) {
                    continue;
                }
            
                // Get terms for each taxonomy
                $intb_terms = get_terms( array(
                    'taxonomy'   => $intb_taxonomy_slug,
                    'hide_empty' => false,
                ));
            
                // Store terms for taxonomies
                if ( ! is_wp_error( $intb_terms ) && ! empty( $intb_terms ) ) {
                    $intb_taxonomies[ $intb_taxonomy_slug ] = array_map( function( $term ) {
                        return array(
                            'ID'   => $term->term_id,
                            'name' => $term->name
                        );
                    }, $intb_terms );
                }
            }
            
            // Fetch saved taxonomy terms for the post
            $saved_taxonomy_terms = get_post_meta( $post->ID, '_intb_selected_taxonomies', true );
            $saved_taxonomy_terms = is_array( $saved_taxonomy_terms ) ? $saved_taxonomy_terms : array();
            
            // Output multi-select field for taxonomies
            intb_get_template(
                'fields/term-field.php',
                array(
                    'title'        => 'Select Taxonomy Terms',
                    'posts'        => $intb_taxonomies,
                    'saved_pages'  => $saved_taxonomy_terms,
                    'key'          => 'intb_selected_taxonomies',
                    'desc'         => 'Select the taxonomy terms on which you want to add this tour.'
                )
            );
            
        }

        public function save_page_select_meta( $post_id ) {

            // Check for autosave or invalid nonce
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
                return $post_id;
            endif;

            if ( ! isset( $_POST['intb_tour_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['intb_tour_nonce'] )), 'save_intb_tour_meta_box' ) ) :
                return $post_id;
            endif;

            if ( isset( $_POST['intb_selected_pages'] ) ) :
                $selected_pages = array_map( 'intval', $_POST['intb_selected_pages'] );
                update_post_meta( $post_id, '_intb_selected_pages', $selected_pages );
            else :
                delete_post_meta( $post_id, '_intb_selected_pages' );
            endif;

            if ( isset( $_POST['intb_selected_single_page'] ) && is_array( $_POST['intb_selected_single_page'] ) ) :
                // Sanitize and validate the values (ensure they are strings)
                $selected_pages = array_map( 'sanitize_text_field', $_POST['intb_selected_single_page'] );
                
                // Update the post meta with the sanitized array of slugs
                update_post_meta( $post_id, '_intb_selected_single_page', $selected_pages );
            else :
                // If no pages were selected, delete the post meta
                delete_post_meta( $post_id, '_intb_selected_single_page' );
            endif;
            
            

            if ( isset( $_POST['intb_selected_taxonomies'] ) ) :
                $selected_pages = array_map( 'intval', $_POST['intb_selected_taxonomies'] );
                update_post_meta( $post_id, '_intb_selected_taxonomies', $selected_pages );
            else :
                delete_post_meta( $post_id, '_intb_selected_taxonomies' );
            endif;
            
        }

    }

    new INTB_Page_MetaBox();

endif;
