"use strict";

jQuery(document).ready(function ($) {
    let index = $('#intb_tour_meta_fields_wrapper .intb_tour_meta_field_group').length;

    // Add new field on button click
    $('#intb_add_meta_field').click(function (e) {
        e.preventDefault();
        addNewField(index);
        index++;
    });

    // Remove a field group
    $('body').on('click', '.intb_remove_meta', function (e) {
        e.preventDefault();
        $(this).closest('.intb_tour_meta_field_group').remove();

        // Check if no fields remain, add one blank field
        if ($('#intb_tour_meta_fields_wrapper .intb_tour_meta_field_group').length === 0) {
            addNewField(0);
            index = 1; // Reset index
        }
    });

    // Make fields sortable
    $('#intb_tour_meta_fields_wrapper').sortable({
        items: '> li.intb_tour_meta_field_group',
        update: function () {
            $('#intb_tour_meta_fields_wrapper .intb_tour_meta_field_group').each(function (i) {
                $(this).attr('data-index', i);
                $(this).find('input, textarea, select').each(function () {
                    let name = $(this).attr('name').replace(/\[\d+\]/, `[${i}]`);
                    let id = $(this).attr('id').replace(/_\d+/, `_${i}`);
                    $(this).attr('name', name);
                    $(this).attr('id', id);
                });
                $(this).find('label').each(function () {
                    let forAttr = $(this).attr('for').replace(/_\d+/, `_${i}`);
                    $(this).attr('for', forAttr);
                });
            });
        }
    });


    function addNewField(index) {
        $('#intb_tour_meta_fields_wrapper').append(`
            <li class="intb_tour_meta_field_group" data-index="${index}">
                <a href="#" class="intb_remove_meta" data-index="${index}"><span class="intb-close-sign">&#10005;</span></a>
                <a href="#" class="intb_move_meta" data-index="${index}"><i class="dashicons dashicons-move"></i></a>
                
                <div class="intb_flex">
                    <p>
                        <label for="intb_tour_title_${index}">Title</label>
                        <input type="text" name="intb_tour_meta_fields[${index}][title]" id="intb_tour_title_${index}" value="" class="widefat" />
                    </p>
                    <p>
                        <label for="intb_tour_target_element_${index}">Target Element</label>
                        <input type="text" name="intb_tour_meta_fields[${index}][target_element]" id="intb_tour_target_element_${index}" value="" class="widefat" />
                        <small>Enter targer element like #your_id .your_class</small>
                    </p>
                    <!-- Side Field -->
                    <p>
                        <label for="intb_tour_side_${index}">Side</label>
                        <select name="intb_tour_meta_fields[${index}][side]" id="intb_tour_side_${index}" class="widefat">
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                            <option value="top">Top</option>
                            <option value="bottom">Bottom</option>
                        </select>
                    </p>

                    <!-- Align Field -->
                    <p>
                        <label for="intb_tour_align_${index}">Align</label>
                        <select name="intb_tour_meta_fields[${index}][align]" id="intb_tour_align_${index}" class="widefat">
                            <option value="start">Start</option>
                            <option value="center">Center</option>
                            <option value="end">End</option>
                        </select>
                    </p>
                </div>

                <p>
                    <label for="intb_tour_description_${index}">Description</label>
                    <textarea name="intb_tour_meta_fields[${index}][description]" id="intb_tour_description_${index}" rows="4" class="widefat"></textarea>
                    <small>Enter a description. You can use dynamic variables like {{post_name}}, {{username}}, {{user_email}}, {{display_name}}, {{admin_email}}.</small>
                </p> 
            </li>
        `);
    }

    // On page load, check if no fields exist and add one blank field
    if ($('#intb_tour_meta_fields_wrapper .intb_tour_meta_field_group').length === 0) {
        addNewField(0);
        index = 1; // Reset index
    }

    
    $('.intb-color-picker').wpColorPicker();

    if ($('#intb_selected_pages').length > 0) {
        $('#intb_selected_pages').select2({
            placeholder: "Search and Select Pages", 
            minimumResultsForSearch: 1
        });
    }

    if ($('#intb_selected_single_page').length > 0) {
        $('#intb_selected_single_page').select2({
            placeholder: "Search and Select Single Pages",
            minimumResultsForSearch: 1
        });
    }

    if ($('#intb_selected_archives').length > 0) {
        $('#intb_selected_archives').select2({
            placeholder: "Search and Select Single Pages",
            minimumResultsForSearch: 1
        });
    }

    if ($('#intb_selected_taxonomies').length > 0) {
        $('#intb_selected_taxonomies').select2({
            placeholder: "Search and Select Taxonomy Terms",
            minimumResultsForSearch: 1 
        });
    }

});
