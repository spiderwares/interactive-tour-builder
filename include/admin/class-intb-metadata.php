<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;

if ( ! class_exists( 'INTB_Tour_Builder_Meta_Box' ) ) :

    class INTB_Tour_Builder_Meta_Box {

        public $fields;
        public $role_fields;

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

            add_meta_box(
                'intb_tour_role_condition_meta_box',
                esc_html__( 'Interactive Tour Builder Role Condition', 'interactive-tour-builder' ),
                [ $this, 'role_condition_meta_box' ],
                'intb_tour',
                'normal',
                'low'
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
                    'name'       => esc_html__( 'Select Style', 'interactive-tour-builder' ),
                    'field_type' => 'intbselect',
                    'default'    => 'style1',
                    'options'    => array(
                        'style1'    => esc_html__( 'Style 1', 'interactive-tour-builder' ),
                        'style2'    => esc_html__( 'Style 2', 'interactive-tour-builder' ),
                        'style3'    => esc_html__( 'Style 3', 'interactive-tour-builder' ),
                        'style4'    => esc_html__( 'Style 4', 'interactive-tour-builder' ),
                        'style5'    => esc_html__( 'Style 5', 'interactive-tour-builder' ),
                    ),
                    'desc'       => esc_html__( 'Choose a style for the tour.', 'interactive-tour-builder' ),
                    'disabled_options' => array('style2', 'style3', 'style4', 'style5'),
                ),
                'intb_other_style' => array(
                    'name'       => '',
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => INTB_UPGRADE_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => esc_html__( 'To enable more styles, you need to purchase the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),
                'intb_animate' => array(
                    'name'       => esc_html__( 'Enable Animation', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'no'
                ),
                'intb_smooth_scroll' => array(
                    'name'       => esc_html__( 'Enable Smooth Scroll', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_allow_keyboard_control' => array(
                    'name'       => esc_html__( 'Allow Keyboard Control', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes',
                ),
                'intb_show_progress' => array(
                    'name'       => esc_html__( 'Enable Progress', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'no'
                ),
                'intb_enable_next_button' => array(
                    'name'       => esc_html__( 'Enable Next Button', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_enable_previous_button' => array(
                    'name'       => esc_html__( 'Enable Previous Button', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_show_close_button' => array(
                    'name'       => esc_html__( 'Show Close Button', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes'
                ),
                'intb_next_button_text' => array(
                    'name'       => esc_html__( 'Next Button Text', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => esc_html__( 'Next', 'interactive-tour-builder' ),
                ),
                'intb_previous_button_text' => array(
                    'name'       => esc_html__( 'Previous Button Text', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => esc_html__( 'Previous', 'interactive-tour-builder' )
                ),
                'intb_done_button_text' => array(
                    'name'       => esc_html__( 'Done Button Text', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => esc_html__( 'Done', 'interactive-tour-builder' )
                ),
                'intb_pop_over_class' => array(
                    'name'       => esc_html__( 'Popup Over Class', 'interactive-tour-builder' ),
                    'field_type' => 'intbtext',
                    'default'    => esc_html__( 'driverjs-theme', 'interactive-tour-builder' )
                ),
                'intb_popover_offset' => array(
                    'name'       => esc_html__( 'Popover Offset', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 10,
                    'step'       => 1, 
                    'min'        => 0, 
                    'max'        => 100
                ),
                'intb_overlay_color' => array(
                    'name'       => esc_html__( 'Select Overlay Color', 'interactive-tour-builder' ),
                    'field_type' => 'intbcolor',
                    'default'    => '#000000'
                ),
                'intb_overlay_opacity' => array(
                    'name'       => esc_html__( 'Overlay Opacity', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 0.5,
                    'step'       => 0.1,
                    'min'        => 0,
                    'max'        => 1
                ),
                'intb_stage_padding' => array(
                    'name'       => esc_html__( 'Stage Padding', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 10,
                    'step'       => 1,
                    'min'        => 0,
                    'max'        => 100
                ),
                'intb_stage_radius' => array(
                    'name'       => esc_html__( 'Stage Radius', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 5,
                    'step'       => 1,
                    'min'        => 0,
                    'max'        => 100
                ),
                'intb_enable_cookie' => array(
                    'name'       => esc_html__( 'Enable Cookie Limit', 'interactive-tour-builder' ),
                    'field_type' => 'intbswitch',
                    'default'    => 'yes',
                    'desc'       => esc_html__( 'Enable this option to set a cookie limit for the tour. When enabled, the tour will only show once per user for a specified period (e.g., 30 days).', 'interactive-tour-builder' )
                ),
                'intb_display_limit' => array(
                    'name'       => esc_html__( 'Display Limit', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 5,
                    'step'       => 1,
                    'min'        => 1,
                    'max'        => 100,
                    'desc'       => esc_html__( 'Set the maximum number of steps to be displayed in the tour. The tour will stop once this limit is reached.', 'interactive-tour-builder' ),
                ),
                'intb_display_after_second' => array(
                    'name'       => esc_html__( 'Display after second', 'interactive-tour-builder' ),
                    'field_type' => 'intbnumber',
                    'default'    => 2,
                    'step'       => 1,
                    'min'        => 0,
                    'max'        => 20,
                    'desc'       =>  esc_html__( 'Set the number of seconds after which the tour step will be displayed. Adjust the time based on your desired delay before showing the next step.', 'interactive-tour-builder' ),
                ),
                'intb_display_scroll' => array(
                    'name'       => esc_html__( 'Display on Scroll from Top', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => INTB_UPGRADE_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => esc_html__( 'Enable the tour to display when the user scrolls to a specific position on the page. Unlock this feature by upgrading to the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),
                'intb_element_to_click' => array(
                    'name'       => esc_html__( 'Display After Click to Element', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => INTB_UPGRADE_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => esc_html__( 'Show the tour after the user clicks on a specific element. Unlock this feature by upgrading to the Pro version.', 'interactive-tour-builder' ),
                    'row_class'  => 'intb-pro-row',
                ),
                'intb_enable_wp_admin' => array(
                    'name'       => esc_html__( 'Enable On Wordpress admin', 'interactive-tour-builder' ),
                    'field_type' => 'intbbutton',
                    'default'    => '',
                    'pro_link'   => INTB_UPGRADE_URL,
                    'button_text'=> esc_html__( 'Buy Pro', 'interactive-tour-builder' ),
                    'desc'       => esc_html__( 'Enable guided tours for the WordPress admin dashboard. Upgrade to the Pro version to activate this feature.', 'interactive-tour-builder' ),
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

        public function intb_user_role_meta_fields() {
            $this->role_fields['guest'] = array(
                'name'       => esc_html__( 'Display User Role Based', 'interactive-tour-builder' ),
                'field_type' => 'intbbutton',
                'default'    => '',
                'pro_link'   => INTB_UPGRADE_URL,
                'button_text'=> esc_html__( 'Buy Pro', 'interactive-tour-builder' ),
                'desc'       => esc_html__( 'Enable guided tours with user role conditions. Upgrade to the Pro version to unlock this feature.', 'interactive-tour-builder' ),
                'row_class'  => 'intb-pro-row',
            );
        
            $this->role_fields = apply_filters( 'intb_user_role_meta_fields', $this->role_fields );
        }


        public function role_condition_meta_box( $post ) {
            $this->intb_user_role_meta_fields();
            $options = get_post_meta( $post->ID, 'intb_role_condition', true );
            $options = is_array( $options ) ? $options : [];

            intb_get_template(
                'metabox/tour-builder-options.php',
                array(
                    'metaKey' => 'intb_role_condition_meta_box',
                    'fields'  => $this->role_fields,
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
                $meta_data = array_map( function( $value ) {
                    return is_array( $value ) ? array_map( 'sanitize_text_field', wp_unslash( $value ) ) : sanitize_text_field( wp_unslash( $value ) );
                }, wp_unslash( $_POST['intb_tour_meta_fields'] ) );

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
                $options_data = array_map( function( $value ) {
                    return is_array( $value ) ? array_map( 'sanitize_text_field', wp_unslash( $value ) ) : sanitize_text_field( wp_unslash( $value ) );
                }, wp_unslash( $_POST['intb_options'] ) );

                foreach ( $this->fields as $key => $field ) :
                    $options_data[ $key ] = isset( $options_data[ $key ] ) ? true : false;
                endforeach;

                update_post_meta( $post_id, 'intb_options', $options_data );
            endif;

            if ( isset( $_POST['intb_role'] ) && is_array( $_POST['intb_role'] ) ) :
                $role_data = array_map( 'sanitize_text_field', wp_unslash( $_POST['intb_role'] ) );
            
                update_post_meta( $post_id, 'intb_role_condition', $role_data );
            endif;
            
        }

        public function sanitize_recursive($data) {
            return is_array($data) 
                ? array_map('sanitize_recursive', $data) 
                : sanitize_text_field($data);
        }
    }

    new INTB_Tour_Builder_Meta_Box();

endif;
