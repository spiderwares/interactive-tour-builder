<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;

if ( ! class_exists( 'INTB_Tour_Builder_Meta_Box' ) ) :

    class INTB_Tour_Builder_Meta_Box {

        public $fields;

        public function __construct() {
            $this->event_handler();
        }
        
        public function event_handler(){            
            add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
            add_action( 'save_post', [ $this, 'save_meta_box_data' ] );
        }

        public function add_meta_boxes() {
            add_meta_box(
                'intb_tour_meta_box',
                esc_html__( 'Tour Builder Steps', 'interactive-tour-builder' ),
                [ $this, 'repeater_meta_box' ],
                'intb_tour',
                'normal',
                'high'
            );

            add_meta_box(
                'intb_tour_options_meta_box',
                esc_html__( 'Interactive Tour Builder Options', 'interactive-tour-builder' ),
                [ $this, 'options_meta_box' ],
                'intb_tour',
                'normal',
                'default'
            );

        }

        public function repeater_meta_box( $post ) {
            $meta_data = get_post_meta( $post->ID, '_intb_tour_meta_fields', true );
            $meta_data = is_array( $meta_data ) ? $meta_data : [];

            intb_get_template(
                'fields/intb-repeter.php',
                array(
                    'meta_data' => $meta_data
                )
            );
        }

        public function intb_option_meta_fields() {
            $this->fields = array(
                'intb_style' => array(
                    'name'       => __( 'Select Style', 'interactive-tour-builder' ),
                    'field_type' => 'intbselect',
                    'default'    => 'style1',
                    'options'    => array(
                        'style1'    => __( 'Style 1', 'interactive-tour-builder' ),
                        'style2'    => __( 'Style 2', 'interactive-tour-builder' ),
                        'style3'    => __( 'Style 3', 'interactive-tour-builder' ),
                        'style4'    => __( 'Style 4', 'interactive-tour-builder' ),
                        'style5'    => __( 'Style 5', 'interactive-tour-builder' ),
                    ),
                    'desc'       => __( 'Choose a style for the tour.', 'interactive-tour-builder' ),
                    'disabled_options' => array('style2', 'style3', 'style4', 'style5'),
                ),
                'intb_other_style' => array(
                    'name'       => __( 'More Style', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => '#',
                    'button_text'=> __( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => __( 'To enable more styles, you need to purchase the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),
                'intb_animate' => array(
                    'name'       => __( 'Enable Animation', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'no'
                ),
                'intb_smooth_scroll' => array(
                    'name'       => __( 'Enable Smooth Scroll', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_allow_keyboard_control' => array(
                    'name'       => __( 'Allow Keyboard Control', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes',
                ),
                'intb_show_progress' => array(
                    'name'       => __( 'Enable Progress', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'no'
                ),
                'intb_enable_next_button' => array(
                    'name'       => __( 'Enable Next Button', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_enable_previous_button' => array(
                    'name'       => __( 'Enable Previous Button', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_show_close_button' => array(
                    'name'       => __( 'Show Close Button', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_next_button_text' => array(
                    'name'       => __( 'Next Button Text', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => __( 'Next', 'interactive-tour-builder' ),
                ),
                'intb_previous_button_text' => array(
                    'name'       => __( 'Previous Button Text', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => __( 'Previous', 'interactive-tour-builder' )
                ),
                'intb_done_button_text' => array(
                    'name'       => __( 'Done Button Text', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => __( 'Done', 'interactive-tour-builder' )
                ),
                'intb_pop_over_class' => array(
                    'name'       => __( 'Popup Over Class', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => __( 'driverjs-theme', 'interactive-tour-builder' )
                ),
                'intb_popover_offset' => array(
                    'name'       => __( 'Popover Offset', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 10,
                    'step'       => 1, 
                    'min'        => 0, 
                    'max'        => 100
                ),
                'intb_overlay_color' => array(
                    'name'       => __( 'Select Overlay Color', 'interactive-tour-builder' ),
                    'field_type' => 'intbcolor',
                    'default'    => '#000000'
                ),
                'intb_overlay_opacity' => array(
                    'name'       => __( 'Overlay Opacity', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 0.5,
                    'step'       => 0.1,
                    'min'        => 0,
                    'max'        => 1
                ),
                'intb_stage_padding' => array(
                    'name'       => __( 'Stage Padding', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 10,
                    'step'       => 1,
                    'min'        => 0,
                    'max'        => 100
                ),
                'intb_stage_radius' => array(
                    'name'       => __( 'Stage Radius', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 5,
                    'step'       => 1,
                    'min'        => 0,
                    'max'        => 100
                ),
                'intb_enable_cookie' => array(
                    'name'       => __( 'Enable Cookie Limit', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes',
                    'desc'       => __( 'Enable this option to set a cookie limit for the tour. When enabled, the tour will only show once per user for a specified period (e.g., 30 days).', 'interactive-tour-builder' )
                ),
                'intb_display_limit' => array(
                    'name'       => __( 'Display Limit', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 5,
                    'step'       => 1,
                    'min'        => 1,
                    'max'        => 100,
                    'desc'       => __( 'Set the maximum number of steps to be displayed in the tour. The tour will stop once this limit is reached.', 'interactive-tour-builder' ),
                ),
                'intb_display_scroll' => array(
                    'name'       => __( 'Display on Scroll from Top', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => '#',
                    'button_text'=> __( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => __( 'Enable the tour to display when the user scrolls to a specific position on the page. Unlock this feature by upgrading to the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),

                'intb_display_after_second' => array(
                    'name'       => __( 'Display After Seconds', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => '#',
                    'button_text'=> __( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => __( 'Trigger the tour to display after a specified number of seconds. Unlock this feature by upgrading to the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),
                'intb_element_to_click' => array(
                    'name'       => __( 'Display After Click to Element', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => '#',
                    'button_text'=> __( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => __( 'Show the tour after the user clicks on a specific element. Unlock this feature by upgrading to the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),
            );
            
            $this->fields = apply_filters( 'intb_option_meta_fields', $this->fields );

        }

        public function options_meta_box( $post ) {
            $this->intb_option_meta_fields();
            $options = get_post_meta( $post->ID, 'intb_options', true );
            $options = is_array( $options ) ? $options : [];

            intb_get_template(
                'metabox/tour-builder-options.php',
                array(
                    'metaKey' => 'intb_tour_options_meta_box',
                    'fields'  => $this->fields,
                    'options' => $options,
                )
            );
        }

        public function save_meta_box_data( $post_id ) {

            // Check for autosave or invalid nonce
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
                return $post_id;
            endif;

            if ( ! isset( $_POST['intb_tour_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['intb_tour_nonce'] ) ), 'save_intb_tour_meta_box' ) ) :
                return $post_id;
            endif;
       

            // Save repeater fields
            if ( isset( $_POST['intb_tour_meta_fields'] ) &&  is_array( $_POST['intb_tour_meta_fields'] ) ) :
                $meta_data = wp_unslash( $_POST['intb_tour_meta_fields'] ) ;

                foreach ( $meta_data as $key => $field ) :
                    $meta_data[ $key ]['title']          = isset( $field['title'] ) ? sanitize_text_field( $field['title'] ) : '';
                    $meta_data[ $key ]['target_element'] = isset( $field['target_element'] ) ? sanitize_text_field( $field['target_element'] ) : '';
                    $meta_data[ $key ]['description']    = isset( $field['description'] ) ? sanitize_textarea_field( $field['description'] ) : '';
                    $meta_data[ $key ]['side']           = isset( $field['side'] ) ? sanitize_text_field( $field['side'] ) : '';
                    $meta_data[ $key ]['align']          = isset( $field['align'] ) ? sanitize_text_field( $field['align'] ) : '';
                endforeach;

                update_post_meta( $post_id, '_intb_tour_meta_fields', $meta_data );
            endif;

            if ( isset( $_POST['intb_options'] ) && is_array( $_POST['intb_options'] ) ) :
                $options_data = wp_unslash( $_POST['intb_options'] );

                foreach ( $this->fields as $key => $field ) :
                    $options_data[ $key ] = isset( $options_data[ $key ] ) ? true : false;
                endforeach;

                update_post_meta( $post_id, 'intb_options', $options_data );
            endif;
            
        }
    }

    new INTB_Tour_Builder_Meta_Box();

endif;
