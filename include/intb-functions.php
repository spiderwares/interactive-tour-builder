<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/**
 * Simple Slideshow Core Functions
 *
 * General core functions available on both the front-end and admin.
 */

if( !function_exists( 'intb_get_template' ) ) : 
   
    function intb_get_template( $template_name, $args = array(), $template_path = '' ) {
        if( empty( $template_path ) ) :
            $template_path = INTB_PATH . '/templates/';
        endif;        
        
        $template = $template_path . $template_name;
        if ( ! file_exists( $template ) ) :
            return new WP_Error( 
                'error', 
                sprintf( 
                    esc_html( '%s does not exist.', 'interactive-tour-builder' ), 
                    '<code>' . $template . '</code>' 
                ) 
            );
        endif;

        do_action( 'intb_before_template_part', $template, $args, $template_path );

        if ( ! empty( $args ) && is_array( $args ) ) :
            extract( $args );
        endif;
        include $template;

        do_action( 'intb_after_template_part', $template, $args, $template_path );
    }

endif;