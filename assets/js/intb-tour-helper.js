jQuery(document).ready(function($) {
    $.intbTourHelper = {
        startTour: function(tourInstance) {
            setTimeout(function() {
                tourInstance.drive();  // Start the tour
            }, 50);
        },

        destroyTour: function(tourInstance) {
            // Ensure the destroy method is available
            if (tourInstance && typeof tourInstance.destroy === 'function') {
                tourInstance.destroy(); 
            }
        }
    };
});
