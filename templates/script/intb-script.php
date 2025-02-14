<?php

// Get options data and meta data
$options_data = isset($options_data) ? $options_data : [];
$meta_data = isset($meta_data) ? $meta_data : [];

// Extract the options
$animate            = !empty($options_data['intb_animate']) && $options_data['intb_animate'] === 'yes';
$show_progress      = !empty($options_data['intb_show_progress']) && $options_data['intb_show_progress'] === 'yes';
$show_buttons       = !empty($options_data['intb_show_buttons']) && $options_data['intb_show_buttons'] === 'yes';
$button_config      = $show_buttons ? '["next", "previous", "close"]' : '[]';
$overlay_color      = !empty($options_data['intb_overlay_color']) ? $options_data['intb_overlay_color'] : '#000';
$smoothScroll       = !empty($options_data['intb_smooth_scroll']) && $options_data['intb_smooth_scroll'] === 'yes';
$overlay_opacity    = !empty($options_data['intb_overlay_opacity']) ? $options_data['intb_overlay_opacity'] : 0.5;
$popoverClass       = !empty($options_data['intb_pop_over_class']) ? $options_data['intb_pop_over_class'] : '';
$set_style          = !empty($options_data['intb_style']) ? $options_data['intb_style'] : 'style1';
$popoverClass       = $popoverClass . ' intb-' . $set_style; 
$next_btn_text      = !empty($options_data['intb_next_button_text']) ? addslashes($options_data['intb_next_button_text']) : '';
$previous_btn_text  = !empty($options_data['intb_previous_button_text']) ? addslashes($options_data['intb_previous_button_text']) : '';
$done_btn_text      = !empty($options_data['intb_done_button_text']) ? addslashes($options_data['intb_done_button_text']) : '';
$stage_padding      = !empty($options_data['intb_stage_padding']) ? $options_data['intb_stage_padding'] : '10';
$allow_close        = !empty($options_data['intb_show_close_button']) && $options_data['intb_show_close_button'] === 'yes';
$stage_radius       = isset($options_data['intb_stage_radius']) ? (int)$options_data['intb_stage_radius'] : 0;
$keyboard_control   = !empty($options_data['intb_allow_keyboard_control']) && $options_data['intb_allow_keyboard_control'] === 'yes';
$popover_offset     = isset($options_data['intb_popover_offset']) ? (int)$options_data['intb_popover_offset'] : 0;
$enable_cookie      = isset($options_data['intb_enable_cookie']) && $options_data['intb_enable_cookie'] === 'yes';
$max_views          = isset($options_data['intb_display_limit']) ? (int)$options_data['intb_display_limit'] : 999999999999;
$showButtons        = [];

if (!empty($options_data['intb_enable_next_button']) && $options_data['intb_enable_next_button'] === 'yes') :
    $showButtons[] = "next";
endif;
if (!empty($options_data['intb_enable_previous_button']) && $options_data['intb_enable_previous_button'] === 'yes') :
    $showButtons[] = "previous";
endif;
$showButtons[] = "close";

$showButtons = '[' . implode(',', array_map(function($item) {
    return '"' . $item . '"';
}, $showButtons)) . ']';

// Prepare cookie script
$cookie_script = '';
if ($enable_cookie) :
    $cookie_name = 'intb_tour_views_' . $post_id;
    $cookie_script = "
    function getCookie(name) {
        let cookieArr = document.cookie.split(';');
        for (let i = 0; i < cookieArr.length; i++) {
            let cookie = cookieArr[i].trim();
            if (cookie.startsWith(name + '=')) {
                return cookie.substring(name.length + 1);
            }
        }
        return null;
    }

    var views = getCookie('$cookie_name');
    views = views ? parseInt(views) : 0;

    if (views >= $max_views) {
        return;
    }

    views++;
    document.cookie = '$cookie_name=' + views + '; max-age=" . (30 * 24 * 60 * 60) . "; path=/';
    ";
endif;
?>
<?php if(!empty($meta_data)): ?>
jQuery(document).ready(function($) {
    var driver = window.driver?.js?.driver || window.driver;
    if (!driver) {
        console.error('Driver.js is not defined. Ensure the script is loaded properly.');
        return;
    }

    // Cookie check before showing the tour
    <?php echo $cookie_script; ?>

    <?php
        // Define the variable to hold driverObj JavaScript code
        $intb_driverObj = '';

        // Your existing code for initializing the driver and its options
        $driverOptions = "
            animate: " . ($animate ? 'true' : 'false') . ",
            showProgress: " . ($show_progress ? 'true' : 'false') . ",
            overlayColor: '" . esc_js($overlay_color) . "',
            smoothScroll: " . ($smoothScroll ? 'true' : 'false') . ",
            overlayOpacity: " . esc_js($overlay_opacity) . ",
            stageRadius: " . esc_js($stage_radius) . ",
            popoverClass: '" . esc_js($popoverClass) . "',
            nextBtnText: '" . esc_js($next_btn_text) . "',
            prevBtnText: '" . esc_js($previous_btn_text) . "',
            doneBtnText: '" . esc_js($done_btn_text) . "',
            showButtons: " . $showButtons . ",
            stagePadding: '" . esc_js($stage_padding) . "',
            allowClose: " . ($allow_close ? 'true' : 'false') . ",
            allowKeyboardControl: " . ($keyboard_control ? 'true' : 'false') . ",
            popoverOffset: " . esc_js($popover_offset) . ",
            steps: [";

        // Prepare the steps for the driver tour
        foreach ($meta_data as $step) :
            $current_user   = wp_get_current_user();
            $user_logged_in = is_user_logged_in();
            $element = isset($step['target_element']) ? $step['target_element'] : 'null';
            $title = isset($step['title']) ? addslashes($step['title']) : '';
            $description = isset($step['description']) ? addslashes($step['description']) : '';

            $description = str_replace(
                array(
                    '{{post_name}}',
                    '{{post_description}}',
                    '{{username}}',
                    '{{user_email}}',
                    '{{admin_email}}',
                    '{{display_name}}'
                ),
                array(
                    get_the_title($post_id),
                    get_post_field('post_content', $post_id),
                    $user_logged_in ? $current_user->user_login : '',
                    $user_logged_in ? $current_user->user_email : '',
                    get_option('admin_email'),
                    $user_logged_in ? $current_user->display_name : '',
                ),
                $description
            );

            $driverOptions .= "{";
            if (!empty($element)) {
                $driverOptions .= "element: '" . esc_js($element) . "',";
            }
            $driverOptions .= "popover: {
                title: '" . esc_js($title) . "',
                description: '" . esc_js($description) . "',
                side: '" . esc_js(isset($step['side']) ? $step['side'] : 'right') . "',
                align: '" . esc_js(isset($step['align']) ? $step['align'] : 'start') . "'
            }},";
        endforeach;

        $driverOptions .= "]"; // Close the steps array

        // Now set the driverObj as a JavaScript object in the $intb_driverObj PHP variable
        $intb_driverObj = "var driverObj = new driver({{$driverOptions}});";
        ?>
        <?php echo wp_kses_post( $intb_driverObj ); ?>

    <?php $trigger_script = '$.intbTourHelper.startTour(driverObj);'; ?>

    <?php echo wp_kses_post( apply_filters( 'intb_tour_trigger_script', $trigger_script, $options_data, $post_id, $intb_driverObj ) ); ?>

});
<?php endif; ?>
