<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'INTB_Tour_JS_Generator' ) ) :

    class INTB_Tour_JS_Generator {


        private $js_dir;

        public function __construct() {
            $this->js_dir = INTB_PATH . 'assets/js';

            $this->event_handler();
        }
        
        private function event_handler() {
            add_action( 'save_post', array( $this, 'handle_post_save' ), 10, 3 );
            add_action( 'before_delete_post', array( $this, 'delete_js_file_for_post' ) );
        }
        
        public function handle_post_save( $post_id, $post, $update ) {
            if ( $post->post_type !== 'intb_tour' ) :
                return;
            endif;

            if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) :
                return;
            endif;

            if ( $post->post_status === 'publish' ) :
                $this->generate_js_file_for_post( $post_id, $post );
            endif;
        }
        
        private function generate_js_file_for_post( $post_id, $post ) {
            if ( ! file_exists( $this->js_dir ) ) {
                wp_mkdir_p( $this->js_dir );
            }

            if ( ! isset( $_POST['intb_tour_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['intb_tour_nonce'] ) ), 'save_intb_tour_meta_box' ) ) :
                return $post_id;
            endif;

            $file_name      = 'intb-tour-' . $post_id . '.js';
            $file_path      = $this->js_dir . '/' . $file_name;
            $options_data   = isset( $_POST['intb_options'] ) ? wp_unslash( $_POST['intb_options'] ) : [];
            $meta_data      = isset( $_POST['intb_tour_meta_fields'] ) ? wp_unslash( $_POST['intb_tour_meta_fields'] ) : [];

            ob_start();

                intb_get_template(
                    'script/intb-script.php',
                    array(
                        'post_id'       => $post_id,
                        'options_data'  => $options_data,
                        'meta_data'     => $meta_data,
                    )
                );

            $js_content = ob_get_clean();

            file_put_contents( $file_path, $js_content );

        }


        public function delete_js_file_for_post( $post_id ) {
            $post = get_post( $post_id );

            if ( $post && $post->post_type === 'intb_tour' ) :
                $file_name = 'intb-tour-' . $post_id . '.js';
                $file_path = $this->js_dir . '/' . $file_name;

                if ( file_exists( $file_path ) ) :
                    wp_delete_file( $file_path );
                endif;
            endif;
        }
    }

    new INTB_Tour_JS_Generator();

endif;