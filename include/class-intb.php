<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'INTB' ) ) :

    /**
     * Main INTB Class
     *
     * @class INTB
     * @version 1.0.0
     */
    final class INTB {

        /**
         * The single instance of the class.
         *
         * @var INTB
         */
        protected static $instance = null;

        /**
         * Constructor for the class.
         */
        public function __construct() {
            $this->register_hooks();
            $this->includes();
        }

        /**
         * Initialize hooks and filters.
         */
        private function register_hooks() {
            // Register plugin activation hook.
            register_activation_hook( INTB_FILE, array( $this, 'plugin_activation' ) );

            // Hook to initialize the plugin after other plugins are loaded.
            add_action( 'plugins_loaded', array( $this, 'initialize_plugin' ), 11 );
        }

        /**
         * Main INTB Instance.
         *
         * Ensures only one instance of INTB is loaded or can be loaded.
         *
         * @static
         * @return INTB - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();

                // Fire a custom action after the plugin is successfully loaded.
                do_action( 'intb_plugin_loaded' );
            }

            return self::$instance;
        }

        /**
         * Plugin activation hook callback.
         */
        public function plugin_activation() {
            // Perform plugin activation tasks, such as database setup.
            do_action( 'intb_activate' );
        }

        /**
         * Initialize the plugin after WordPress is fully loaded.
         */
        public function initialize_plugin() {
            do_action( 'intb_init' );
        }

        /**
         * Include required files.
         *
         * @access private
         */
        public function includes() {
            require_once INTB_PATH . 'include/intb-functions.php';
            require_once INTB_PATH . 'include/public/class-intb-script.php';

            if ( is_admin() ) {
                $this->includes_admin();
            }
        }

        /**
         * Include Admin required files.
         *
         * @access private
         */
        private function includes_admin() {
            require_once INTB_PATH . 'include/admin/class-intb-manage.php';
            require_once INTB_PATH . 'include/admin/class-intb-metadata.php';
            require_once INTB_PATH . 'include/admin/class-intb-page.php';
        }

    }

endif;
