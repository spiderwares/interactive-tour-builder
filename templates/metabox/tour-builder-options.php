<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
?>

<div class="intb_option_wrap">
<table class="form-table">
    <tbody>
        <?php foreach ( $fields as $field_Key => $field ) : 
            $field_Val      = isset( $options[ $field_Key ] ) ? $options[ $field_Key ] : $field['default']; 
            $class          = isset( $field['class'] ) ? $field['class'] : ''; 
            $extra_class    = isset( $field['extra_class'] ) ? $field['extra_class'] : '';
            $tr_style_attr  = ( ! empty( $class ) && isset( $options[ $class ] ) && $options[ $class ] === 'no' ) ? ' style="display: none;"' : ''; 

            // Determine conditional display based on style key and value
            $style_display_attr = '';
            if ( isset( $field['style'] ) && ! empty( $field['style'] ) ) :
                $style_parts     = explode( '.', $field['style'], 2 );
                $style_key       = $style_parts[0];
                $style_val       = $style_parts[1];
                $value_to_check  = isset( $options[ $style_key ] ) ? $options[ $style_key ] : ( isset( $fields[ $style_key ]['default'] ) ? $fields[ $style_key ]['default'] : '' );

                // Handle checkbox style where value_to_check might be an array
                $style_display_attr = in_array( $style_val, (array) $value_to_check, true ) ? '' : ' style="display: none;"';
            endif; ?>
            <tr 
                class="<?php echo esc_attr( trim( $class . ' ' . $extra_class ) ); ?>" 
                <?php echo $tr_style_attr; ?> 
                <?php echo $style_display_attr; ?>>

                    <th scope="row">
                        <?php echo esc_html( $field['name'] ); ?>
                    </th>
                    <?php
                    switch ( $field['field_type'] ) {

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

                        case "intbcheckbox":
                            intb_get_template(
                                'fields/checkbox-field.php',
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
