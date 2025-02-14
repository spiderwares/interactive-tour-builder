<?php 
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/**
* Radio image field html
*/
?>
<td>
    <?php if ( isset( $field['options'] ) ) : ?>
        <select name="slideroption[<?php echo esc_attr( $field_Key ); ?>]" id="<?php echo esc_attr( $field_Key ); ?>" class="widefat">
            <?php foreach ( $field['options'] as $optionKey => $optionLabel ) : ?>
                <option 
                    value="<?php echo esc_attr( $optionKey ); ?>" 
                    <?php selected( $optionKey, $field_Val ); ?>>
                    <?php echo esc_html( $optionLabel ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
</td>
