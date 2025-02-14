<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* Selected Taxonomy Terms Field */
?>
<div class="intb-select-taxonomies">
    <label for="<?php echo esc_attr( $key ); ?>"><b><?php echo esc_attr( $title ); ?></b></label>
    <select id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>[]" multiple="multiple" style="width:100%;">
        <?php foreach ( $posts as $taxonomy_slug => $taxonomy_terms ) : ?>
            <optgroup label="<?php echo esc_html( get_taxonomy( $taxonomy_slug )->labels->name ); ?>">
                <?php foreach ( $taxonomy_terms as $term ) : ?>
                    <option value="<?php echo esc_attr( $term['ID'] ); ?>" <?php echo in_array( $term['ID'], $saved_pages ) ? 'selected="selected"' : ''; ?>>
                        <?php echo esc_html( $term['name'] ); ?>
                    </option>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
    </select>
    <small><?php echo isset( $desc ) ? wp_kses_post( $desc ) : ''; ?></small>
</div>
