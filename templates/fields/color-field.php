<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* 
    Color Field Template
*/
?>
<td>
    <div class="intb-color-field">
        <input type="text" 
               id="<?php echo esc_attr( $field_Key ); ?>" 
               name="intb_options[<?php echo esc_attr( $field_Key ); ?>]" 
               value="<?php echo esc_attr( $field_Val ); ?>" 
               class="intb-color-picker" />
    </div>
    <small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</td>