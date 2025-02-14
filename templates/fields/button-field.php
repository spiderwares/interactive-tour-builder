<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; 
endif;
/* 
    Button Field Template
*/
?>

<td class="forminp">
    <div>
        <a href="<?php echo esc_url( $field['pro_link'] ); ?>" target="_blank" class="intb-pro-btn">
            <span class="shine-content"><?php echo esc_html( $field['button_text'] ); ?></span>
        </a>
    </div>
    <small class="description"><?php echo esc_html( $field['desc'] ); ?></small>
</td>
