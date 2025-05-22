<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* 
    Select Field Template
*/
?>
<td>
    <div class="intb-select-field">
        <select id="<?php echo esc_attr( $field_Key ); ?>" 
                name="intb_options[<?php echo esc_attr( $field_Key ); ?>]"
                data-hide="<?php echo isset( $field['data_hide'] ) ? esc_attr( $field['data_hide'] ) : '';  ?>">
            <?php if ( isset( $field['options'] ) && is_array( $field['options'] ) ) : ?>
                <?php foreach ( $field['options'] as $key => $label ) : ?>
                    <?php $disabled = ( isset( $field['disabled_options'] ) && in_array( $key, $field['disabled_options'] ) ) ? 'disabled' : '';  ?>
                    <option value="<?php echo esc_attr( $key ); ?>" 
                        <?php selected( $field_Val, $key ); ?>
                        data-show=".<?php echo esc_attr( $key ); ?>"
                        <?php echo esc_attr( $disabled ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</td>
