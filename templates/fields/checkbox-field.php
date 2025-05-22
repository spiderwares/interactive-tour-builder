<?php
if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;
/*
 * Checkbox Field Template
 */
?>
<td>
	<div class="intb-checkbox-group">
		<?php if ( isset( $field['options'] ) && is_array( $field['options'] ) ) : ?>
			<?php foreach ( $field['options'] as $key => $label ) : 
				$is_checked = is_array( $field_Val ) && in_array( $key, $field_Val, true );
				$is_disabled = isset( $field['disabled_options'] ) && in_array( $key, $field['disabled_options'], true );
			?>
				<label>
					<input 
						type="checkbox"
						name="intb_options[<?php echo esc_attr( $field_Key ); ?>][]"
						value="<?php echo esc_attr( $key ); ?>"
						<?php checked( $is_checked ); ?>
						data-hide="<?php echo isset( $field['data_hide'] ) ? esc_attr( $field['data_hide'] ) : ''; ?>"
						<?php disabled( $is_disabled ); ?>
					/>
					<?php echo esc_html( $label ); ?>
				</label><br/>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</td>
