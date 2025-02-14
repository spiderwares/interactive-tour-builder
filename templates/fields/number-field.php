<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* 
    Number Field Template
*/
?>
<td>
    <div class="intb-number-field">
        <input type="number" 
               id="<?php echo esc_attr( $field_Key ); ?>" 
               name="intb_options[<?php echo esc_attr( $field_Key ); ?>]" 
               value="<?php echo esc_attr( $field_Val ); ?>" 
               placeholder="<?php echo isset( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : ''; ?>" 
               min="<?php echo isset( $field['min'] ) ? esc_attr( $field['min'] ) : ''; ?>" 
               max="<?php echo isset( $field['max'] ) ? esc_attr( $field['max'] ) : ''; ?>" 
               step="<?php echo isset( $field['step'] ) ? esc_attr( $field['step'] ) : '1'; ?>" />
    </div>
    <small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</td>
