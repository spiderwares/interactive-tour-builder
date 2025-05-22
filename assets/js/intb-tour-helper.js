jQuery(function ($) {
    class IntbTourManager {
        constructor() {
            if (typeof intbTourData === 'undefined' || !intbTourData.tours.length) {
                console.warn('No tours found in intbTourData.');
                return;
            }
            this.init();
        }

        init() {
            this.setupTourHelper();
            this.initializeTours();
        }

        setupTourHelper() {
            $.intbTourHelper = {
                startTour: (tourInstance, tourId, displayLimit) => {
                    setTimeout(() => {
                        tourInstance.drive();
                        let tourCount = parseInt(this.getCookie('intb_tour_seen_' + tourId)) || 0;
                        tourCount++;
                        this.setCookie('intb_tour_seen_' + tourId, tourCount, 30);
                        if (displayLimit > 0 && tourCount >= displayLimit) {
                            this.setCookie('intb_tour_blocked_' + tourId, 'yes', 30);
                        }
                    }, 50);
                }
            };
        }

        initializeTours() {
            intbTourData.tours.forEach((tour) => {
                let driver = window.driver?.js?.driver || window.driver;

                if (!driver) {
                    console.error('Driver.js is not loaded.');
                    return;
                }
                
                let tourId          = tour.id,
                    displayLimit    = parseInt(tour.options.intb_display_limit) || 0;

                if (tour.options.intb_enable_cookie === 'yes' && this.getCookie('intb_tour_blocked_' + tourId)) {
                    return;
                }
                
                const initializeTour = () => {
                    let buttons = [
                        tour.options.intb_enable_next_button === 'yes' ? 'next' : null,
                        tour.options.intb_enable_previous_button === 'yes' ? 'previous' : null,
                        tour.options.intb_show_close_button === 'yes' ? 'close' : null
                    ].filter(Boolean);
        
                    // Fallback if no buttons are enabled
                    if (buttons.length === 0) {
                        buttons = [''];
                    }

                    let driverObj = new driver({
                        animate: tour.options.intb_animate === 'yes',
                        smoothScroll: tour.options.intb_smooth_scroll === 'yes',
                        allowKeyboardControl: tour.options.intb_allow_keyboard_control === 'yes',
                        showProgress: tour.options.intb_show_progress === 'yes',
                        showButtons: buttons,
                        allowClose: tour.options.intb_allow_close === 'yes',
                        nextBtnText: tour.options.intb_next_button_text || 'Next',
                        prevBtnText: tour.options.intb_previous_button_text || 'Previous',
                        doneBtnText: tour.options.intb_done_button_text || 'Done',
                        popoverClass: tour.options.intb_pop_over_class + ' intb-' + tour.options.intb_style,
                        popoverOffset: parseInt(tour.options.intb_popover_offset) || 10,
                        overlayColor: tour.options.intb_overlay_color || '#000',
                        overlayOpacity: parseFloat(tour.options.intb_overlay_opacity) || 0.5,
                        stagePadding: parseInt(tour.options.intb_stage_padding) || 10,
                        stageRadius: parseInt(tour.options.intb_stage_radius) || 5,
                        steps: tour.meta_fields.map(field => ({
                            element: field.target_element || undefined,
                            popover: {
                                title: field.title,
                                description: field.description
                                    .replace('{{post_name}}', tour.title)
                                    .replace('{{username}}', intbTourData.user.username)
                                    .replace('{{user_email}}', intbTourData.user.user_email)
                                    .replace('{{display_name}}', intbTourData.user.display_name)
                                    .replace('{{admin_email}}', intbTourData.user.admin_email),
                                side: field.side,
                                align: field.align
                            }
                        }))
                    });
                    $.intbTourHelper.startTour(driverObj, tourId, displayLimit);
                };
                
                console.log(tour.options.intb_display_type);
                var displayTypes = tour.options.intb_display_type;

                // If the display type is set to 'click' and wp.hooks is available, trigger the tour when the target element is clicked.
                if ( Array.isArray(displayTypes) && displayTypes.includes('click') && typeof wp !== 'undefined' && wp.hooks ) {
                    wp.hooks.doAction('intbTourTrigger', tour.options.intb_element_to_click, initializeTour);
                }

                // If the display type is set to 'scroll' and a scroll value is provided, trigger the tour when the page is scrolled past the defined point.
                if ( Array.isArray(displayTypes) && displayTypes.includes('scroll') && tour.options.intb_display_scroll ) {
                    let scrollTrigger = parseInt(tour.options.intb_display_scroll);
                    if (!isNaN(scrollTrigger) && scrollTrigger >= 0) {
                        wp.hooks.doAction('intbTourTriggerScroll', scrollTrigger, initializeTour);
                    }
                }
                
                // If the display type is set to 'after_second', trigger the tour after the specified delay in seconds.
                if ( Array.isArray(displayTypes) && displayTypes.includes('after_second') && tour.options.intb_display_after_second ) {
                    let delayTime = parseInt(tour.options.intb_display_after_second) * 1000;
                    setTimeout(initializeTour, delayTime);
                }
            });
        }

        setCookie(name, value, days) {
            let expires = '';
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + value + '; path=/; SameSite=Lax' + expires;
        }

        getCookie(name) {
            let nameEQ  = name + '=',
                cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                let c = cookies[i].trim();
                if (c.indexOf(nameEQ) === 0) {
                    return c.substring(nameEQ.length, c.length);
                }
            }
            return null;
        }
    }
    // new IntbTourManager();
    window.IntbTourManager          = IntbTourManager; // **Make it globally accessible**
    window.intbTourManagerInstance  = new IntbTourManager();
});
