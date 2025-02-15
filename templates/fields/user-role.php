<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* 
    User role field Template
*/
?>

<div class="intb-select-user-roles">
    <label for="intb_user_roles"><b><?php echo esc_html( $field['name'] ); ?>1212</b></label>
    
    <select id="intb_user_roles" name="intb_user_roles[]" multiple="multiple" style="width:100%;">
        <?php
            global $wp_roles;
            $roles = $wp_roles->roles;

            // Add custom Visitor role for non-logged-in users
            $roles['visitor'] = array(
                'name' => esc_html__( 'Visitor', 'interactive-tour-builder' ),
            );

            // Loop through roles and generate options
            foreach ( $roles as $role_key => $role ) :
                $selected = isset( $field_Val ) && in_array( $role_key, (array) $field_Val ) ? 'selected="selected"' : '';
                ?>
                <option value="<?php echo esc_attr( $role_key ); ?>" <?php echo esc_html( $selected ); ?>>
                    <?php echo esc_html( $role['name'] ); ?>
                </option>
                <?php
            endforeach;
        ?>
    </select>
    
    <small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</div>