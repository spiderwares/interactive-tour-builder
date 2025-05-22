<?php

/**
 * Installation related functions and actions.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'INTB_install' ) ) :

    /**
     * INTB_install Class
     *
     * Handles installation processes like creating database tables,
     * setting up roles, and creating necessary pages on plugin activation.
     */
    class INTB_install {

        /**
         * Hook into WordPress actions and filters.
         */
        public static function init() {
            add_filter( 'plugin_action_links_' . INTB_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
        }

        /**
         * Install plugin.
         *
         * Creates tables, roles, and necessary pages on plugin activation.
         */
        public static function install() {
            if ( ! is_blog_installed() ) :
                return;
            endif;
            
        }

        /**
         * Add plugin action links.
         *
         * @param array $links Array of action links.
         * @return array Modified array of action links.
         */

        public static function plugin_action_links( $links ) {
            $action_links = array(
                'settings' => sprintf(
                    '<a href="%s" aria-label="%s">%s</a>',
                    admin_url( 'edit.php?post_type=intb_tour' ), // Updated link to CPT page
                    esc_attr__( 'Manage Interactive Tours', 'interactive-tour-builder-pro' ), // Updated title
                    esc_html__( 'Manage Tours', 'interactive-tour-builder-pro' ) // Updated button text
                ),
            );
        
            return array_merge( $action_links, $links );
        }

    }

    // Initialize the installation process
    INTB_install::init();

endif;
