<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* Intb repeater */
?>

<?php wp_nonce_field( 'save_intb_tour_meta_box', 'intb_tour_nonce' ); ?>
<ul id="intb_tour_meta_fields_wrapper">
    <?php foreach ( $meta_data as $index => $field_data ) :
        $title          = isset($field_data['title']) ? $field_data['title'] : '';
        $target_element = isset($field_data['target_element']) ? $field_data['target_element'] : '';
        $description    = isset($field_data['description']) ? $field_data['description'] : '';
        $side           = isset( $field_data['side'] ) ? $field_data['side'] : 'left';
        $align          = isset( $field_data['align'] ) ? $field_data['align'] : 'start'; ?>

        <li class="intb_tour_meta_field_group" data-index="<?php echo esc_attr( $index ); ?>">
        <a href="#" class="intb_remove_meta" data-index="<?php echo esc_attr( $index ); ?>"><span class="intb-close-sign">&#10005;</span></a>
        <a href="#" class="intb_move_meta" data-index="<?php echo esc_attr( $index ); ?>"><i class="dashicons dashicons-move"></i></a>
            <div class="intb_flex">
                <p>
                    <label for="intb_tour_title_<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Title', 'interactive-tour-builder' ); ?></label>
                    <input type="text" name="intb_tour_meta_fields[<?php echo esc_attr( $index ); ?>][title]" id="intb_tour_title_<?php echo esc_attr( $index ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
                </p>

                <p>
                    <label for="intb_tour_target_element_<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Target Element', 'interactive-tour-builder' ); ?></label>
                    <input type="text" name="intb_tour_meta_fields[<?php echo esc_attr( $index ); ?>][target_element]" id="intb_tour_target_element_<?php echo esc_attr( $index ); ?>" value="<?php echo esc_attr( $target_element ); ?>" class="widefat" />
                    <small><?php esc_html_e( 'Enter targer element like #your_id .your_class', 'interactive-tour-builder' ) ?></small>
                </p>

                <p>
                    <label for="intb_tour_side_<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Side', 'interactive-tour-builder' ); ?></label>
                    <select name="intb_tour_meta_fields[<?php echo esc_attr( $index ); ?>][side]" id="intb_tour_side_<?php echo esc_attr( $index ); ?>" class="widefat">
                        <option value="left" <?php selected( $side, 'left' ); ?>><?php esc_html_e( 'Left', 'interactive-tour-builder' ); ?></option>
                        <option value="right" <?php selected( $side, 'right' ); ?>><?php esc_html_e( 'Right', 'interactive-tour-builder' ); ?></option>
                        <option value="top" <?php selected( $side, 'top' ); ?>><?php esc_html_e( 'Top', 'interactive-tour-builder' ); ?></option>
                        <option value="bottom" <?php selected( $side, 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'interactive-tour-builder' ); ?></option>
                    </select>
                </p>

                <p>
                    <label for="intb_tour_align_<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Align', 'interactive-tour-builder' ); ?></label>
                    <select name="intb_tour_meta_fields[<?php echo esc_attr( $index ); ?>][align]" id="intb_tour_align_<?php echo esc_attr( $index ); ?>" class="widefat">
                        <option value="start" <?php selected( $align, 'start' ); ?>><?php esc_html_e( 'Start', 'interactive-tour-builder' ); ?></option>
                        <option value="center" <?php selected( $align, 'center' ); ?>><?php esc_html_e( 'Center', 'interactive-tour-builder' ); ?></option>
                        <option value="end" <?php selected( $align, 'end' ); ?>><?php esc_html_e( 'End', 'interactive-tour-builder' ); ?></option>
                    </select>
                </p>
            </div>

            <p>
                <label for="intb_tour_description_<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Description', 'interactive-tour-builder' ); ?></label>
                <textarea name="intb_tour_meta_fields[<?php echo esc_attr( $index ); ?>][description]" id="intb_tour_description_<?php echo esc_attr( $index ); ?>" rows="4" class="widefat"><?php echo esc_textarea( $description ); ?></textarea>
                <small><?php echo esc_html( __( 'Enter a description. You can use dynamic variables like {{post_name}}, {{username}}, {{user_email}}, {{display_name}}, {{admin_email}}.', 'interactive-tour-builder' ) ); ?></small>
            </p>


        </li>
    <?php endforeach; ?>
</ul>
<p><a href="#" id="intb_add_meta_field" class="intb_add_input"><?php esc_html_e( 'Add more', 'interactive-tour-builder' ); ?></a></p>
