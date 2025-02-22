<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
?>

<div class="intb_option_wrap">
    <table class="form-table">
        <tbody>
            <?php foreach ( $fields as $field_Key => $field ) : 
                $field_Val = isset( $options[ $field_Key ] ) ? $options[ $field_Key ] : $field['default']; ?>

                <tr>
                    <th scope="row">
                        <?php echo esc_html( $field['name'] ); ?>
                    </th>
                    <?php
                    switch ( $field['field_type'] ) {
                        case "radioImg":
                            intb_get_template(
                                'fields/radioImg-field.php',
                                array(
                                    'field'     => $field,
                                    'field_Val' => $field_Val,
                                    'field_Key' => $field_Key,
                                )
                            );
                            break;

                        case "intbswitch":
                            intb_get_template(
                                'fields/switch-field.php',
                                array(
                                    'field'     => $field,
                                    'field_Val' => $field_Val,
                                    'field_Key' => $field_Key,
                                )
                            );
                            break;
                        
                        case "intbtext" : 
                            intb_get_template(
                                'fields/text-field.php',
                                array(
                                    'field'         => $field,
                                    'field_Val'     => $field_Val,
                                    'field_Key'     => $field_Key
                                )
                            );
                            break;
                        
                        case "intbcolor" : 
                            intb_get_template(
                                'fields/color-field.php',
                                array(
                                    'field'         => $field,
                                    'field_Val'     => $field_Val,
                                    'field_Key'     => $field_Key
                                )
                            );
                            break;

                        case "intbnumber" : 
                            intb_get_template(
                                'fields/number-field.php',
                                array(
                                    'field'         => $field,
                                    'field_Val'     => $field_Val,
                                    'field_Key'     => $field_Key
                                )
                            );
                            break;

                        case "intbuserroles": 
                            intb_get_template(
                                'fields/user-role.php',
                                array(
                                    'field'     => $field,
                                    'field_Val' => $field_Val,
                                    'field_Key' => $field_Key,
                                )
                            );
                            break;

                        case "intbbutton":
                            intb_get_template(
                                'fields/button-field.php',
                                array(
                                    'field'     => $field,
                                    'field_Val' => $field_Val,
                                    'field_Key' => $field_Key,
                                )
                            );
                            break;

                        case "intbselect":
                            intb_get_template(
                                'fields/select-field.php',
                                array(
                                    'field'     => $field,
                                    'field_Val' => $field_Val,
                                    'field_Key' => $field_Key,
                                )
                            );
                            break;

                        case "intbuserrole":
                            intb_get_template(
                                'fields/userrole-field.php',
                                array(
                                    'field'     => $field,
                                    'field_Val' => $field_Val,
                                    'field_Key' => $field_Key,
                                )
                            );
                            break;

                    }
                    ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>
