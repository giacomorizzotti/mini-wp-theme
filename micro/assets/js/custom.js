/**
 * Custom JavaScript for Mini Child Theme
 * 
 * This file is automatically enqueued if it exists.
 * jQuery is available as a dependency.
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Your custom JavaScript here
        
        // Example: Log when document is ready
        console.log('Mini Child Theme: Custom JS loaded');
        
        // Example: Add smooth scrolling to anchor links
        /*
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                    return false;
                }
            }
        });
        */
        
        // Example: Mobile menu toggle
        /*
        $('.mobile-menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').slideToggle();
        });
        */
        
    });
    
})(jQuery);
