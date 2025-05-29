jQuery(function($) {
    class INTBAdmin {
        constructor() {
            this.index              = $('#intb_tour_meta_fields_wrapper .intb_tour_meta_field_group').length;
            this.metaFieldsWrapper  = $('#intb_tour_meta_fields_wrapper');
            this.init();
        }

        init() {
            this.addInitialFieldIfEmpty();
            this.initializeColorPicker();
            this.initializeSelect2();
            this.initializeSortable();
            this.bindEvents();
        }

        bindEvents() {
            $(document.body).on('click', '#intb_add_meta_field', this.handleAddField.bind(this));
            $(document.body).on('click', '.intb_remove_meta', this.handleRemoveField.bind(this));
            $(document.body).on( 'change', '.intb-switch-field input[type="checkbox"], .intb-checkbox-group input[type="checkbox"], select', this.toggleVisibility.bind(this) );
        }

        handleAddField(e) {
            e.preventDefault();
            this.addNewField(this.index);
            this.index++;
        }

        handleRemoveField(e) {
            e.preventDefault();
            $(e.currentTarget).closest('.intb_tour_meta_field_group').remove();

            if (this.metaFieldsWrapper.find('.intb_tour_meta_field_group').length === 0) {
                this.addNewField(0);
                this.index = 1;
            }
        }

        initializeSortable() {
            this.metaFieldsWrapper.sortable({
                items: '> li.intb_tour_meta_field_group',
                update: () => {
                    this.metaFieldsWrapper.find('.intb_tour_meta_field_group').each((i, el) => {
                        $(el).attr('data-index', i);
                        $(el).find('input, textarea, select').each(function () {
                            const name = $(this).attr('name').replace(/\[\d+\]/, `[${i}]`),
                                  id = $(this).attr('id').replace(/_\d+/, `_${i}`);
                            $(this).attr('name', name).attr('id', id);
                        });
                        $(el).find('label').each(function () {
                            const forAttr = $(this).attr('for').replace(/_\d+/, `_${i}`);
                            $(this).attr('for', forAttr);
                        });
                    });
                }
            });
        }

        addNewField(index) {
            this.metaFieldsWrapper.append(`
                <li class="intb_tour_meta_field_group" data-index="${index}">
                    <a href="#" class="intb_remove_meta" data-index="${index}"><span class="intb-close-sign">&#10005;</span></a>
                    <a href="#" class="intb_move_meta" data-index="${index}"><i class="dashicons dashicons-move"></i></a>
                    <div class="intb_flex">
                        <p>
                            <label for="intb_tour_title_${index}">Title</label>
                            <input type="text" name="intb_tour_meta_fields[${index}][title]" id="intb_tour_title_${index}" class="widefat" />
                        </p>
                        <p>
                            <label for="intb_tour_target_element_${index}">Target Element</label>
                            <input type="text" name="intb_tour_meta_fields[${index}][target_element]" id="intb_tour_target_element_${index}" class="widefat" />
                            <small>Enter target element like #your_id .your_class</small>
                        </p>
                        <p>
                            <label for="intb_tour_side_${index}">Side</label>
                            <select name="intb_tour_meta_fields[${index}][side]" id="intb_tour_side_${index}" class="widefat">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                                <option value="top">Top</option>
                                <option value="bottom">Bottom</option>
                            </select>
                        </p>
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

        addInitialFieldIfEmpty() {
            if (this.metaFieldsWrapper.find('.intb_tour_meta_field_group').length === 0) {
                this.addNewField(0);
                this.index = 1;
            }
        }

        initializeColorPicker() {
            $('.intb-color-picker').wpColorPicker();
        }

        initializeSelect2() {
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
        }

        toggleVisibility(e) {
            var _this = $(e.currentTarget);

            if (_this.is('select')) {
                var target      = _this.find(':selected').data('show'),
                    hideElemnt  = _this.data( 'hide' );
                    $(document.body).find(hideElemnt).hide();
                    $(document.body).find(target).show();
            } else if (_this.is(':checkbox') && _this.closest('.intb-checkbox-group').length ) {
                var target = _this.val();
                if (_this.is(':checked')) {
                    $('.'+target).show();
                } else {
                    $('.'+target).hide();
                }
            } else {
                var target = _this.data('show');
                $(document.body).find(target).toggle();
            }
        }
    }

    new INTBAdmin();
});
