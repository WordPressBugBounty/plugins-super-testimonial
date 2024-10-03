jQuery(document).ready(function($) {
    'use strict';
    // Initialize Owl Carousel for all sliders with the 'testimonial-slider' class
    $('.testimonial-slider').each(function() {
        var $this = $(this); // The current slider instance

        // Initialize Owl Carousel with values from data-* attributes
        $this.owlCarousel({
            lazyLoad: true,
            items: $this.data('items'),  // Get data-items
            loop: $this.data('loop'),    // Get data-loop
            margin: $this.data('margin'),  // Get data-margin
            autoplay: $this.data('autoplay'),  // Get data-autoplay
            autoplaySpeed: $this.data('autoplay-speed'),  // Get data-autoplay-speed
            autoplayTimeout: $this.data('autoplay-timeout'),  // Get data-autoplay-timeout
            autoplayHoverPause: $this.data('stop-hover'),  // Get data-stop-hover
            nav: true,
            dots: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            smartSpeed: 450,
            responsive: {
                0: { items: $this.data('itemsmobile') },  // Get data-itemsmobile
                678: { items: $this.data('itemsdesktopsmall') },  // Get data-itemsdesktopsmall
                980: { items: $this.data('itemsdesktop') },  // Get data-itemsdesktop
                1199: { items: $this.data('items') }  // Get data-items (default for large screens)
            }
        });
    });
});
