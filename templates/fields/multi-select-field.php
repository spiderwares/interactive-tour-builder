<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
    /* Selected Page Field  */
?>
<div class="intb-select-pages">
    <label for="<?php echo esc_attr( $key ); ?>"><b><?php echo esc_attr( $title ); ?></b></label>
    <select id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>[]" multiple="multiple" style="width:100%;">
        <?php foreach ( $posts as $post_item ) : ?>
            <option value="<?php echo esc_attr( $post_item->ID ); ?>" <?php echo in_array( $post_item->ID, $saved_pages ) ? 'selected="selected"' : ''; ?>>
                <?php echo esc_html( $post_item->post_title ); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small><?php echo isset( $desc ) ? wp_kses_post( $desc ) : ''; ?></small>
</div>