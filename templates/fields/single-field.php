<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
?>
<div class="intb-select-post-types">
    <label for="<?php echo esc_attr( $key ); ?>"><b><?php echo esc_attr( $title ); ?></b></label>
    <select id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>[]" multiple="multiple" style="width:100%;">
        <?php foreach ( $options as $option ) : ?>
            <option value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo ( is_array( $saved_value ) && in_array( $option['value'], $saved_value ) ) ? 'selected="selected"' : ''; ?>>
                <?php echo esc_html( $option['label'] ); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small><?php echo isset( $desc ) ? wp_kses_post( $desc ) : ''; ?></small>
</div>
