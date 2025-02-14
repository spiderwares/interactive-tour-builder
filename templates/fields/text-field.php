<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* 
    Text Field Template
*/
?>
<td>
    <div class="intb-text-field">
        <input type="text" 
               id="<?php echo esc_attr( $field_Key ); ?>" 
               name="intb_options[<?php echo esc_attr( $field_Key ); ?>]" 
               value="<?php echo esc_attr( $field_Val ); ?>" 
               placeholder="<?php echo isset( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : ''; ?>" />
    </div>
    <small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</td>
