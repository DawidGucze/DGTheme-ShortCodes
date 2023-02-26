jQuery(document).ready(function($) {

    var winWidth = $(window).width();

    // GRID SECTION
    var section = $( '.dgts_full_width_section' );
    
    if ( section[0] )
        var offset = section.offset().left;

    section.css({'width':winWidth, 'margin-left': -offset});

    // COLUMNS
    $('.dgts_row').each(function(n) {

        $(this).attr('id', 'dgts_row_' + n);

        var col = $('#dgts_row_' + n + ' .dgts_columns');
        var length = col.length;

        col.addClass('dgts_column_' + length);

    });

    // COUNTDOWN CLOCK
    $('[data-countdown]').each(function() {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate).on('update.countdown', function(event) {
            $this.html(event.strftime('<div class="dgts_clock_month"><span>%m</span><div class="dgts_clock_text">' + dgts.countdown_months_text + '</div></div>' + '<div class="dgts_clock_day"><span>%n</span><div class="dgts_clock_text">' + dgts.countdown_days_text + '</div></div>' + '<div class="dgts_clock_hour"><span>%H</span><div class="dgts_clock_text">' + dgts.countdown_hours_text + '</div></div>' + '<div class="dgts_clock_minute"><span>%M</span><div class="dgts_clock_text">' + dgts.countdown_minutes_text + '</div></div>' + '<div class="dgts_clock_second"><span>%S</span><div class="dgts_clock_text">' + dgts.countdown_seconds_text + '</div></div>'));
        }).on('finish.countdown', function(event) {
            var txt = $this.data('txt');
            $this.html('<div class="dgts_clock_after">' + txt + '</div>');
        });
    });

    // CAROUSELS

    // shortcodes
    $(".dgts_posts_carousel").each(function(index) {
        var instance = $( this ).data('instance');
        CarouselSettings(instance);
    });

    $(".dgts_logos_carousel").each(function(index) {
        var instance = $( this ).data('instance');
        CarouselSettings(instance);
    });

    $(".dgts_testimonials_carousel").each(function(index) {
        var instance = $( this ).data('instance');
        CarouselSettings(instance);
    });

    $(".dgts_team_members_carousel").each(function(index) {
        var instance = $( this ).data('instance');
        CarouselSettings(instance);
    });

    // widgets
    $("#dgts_logos_carousel_widget").owlCarousel({
        singleItem : true,
        autoPlay : 3000
    });

    $("#dgts_testimonials_carousel_widget").owlCarousel({
        singleItem : true,
        autoPlay : 3000,
        stopOnHover : true,
        autoHeight : true
    });

    function CarouselSettings(instance) {
        var settingObj = window["DGTSCarousel"+instance];
        var owlcontainer = $("#dgts_carousel_" + instance);
        var count = settingObj.slide;

        if (count == 1) {
            jQuery(owlcontainer).owlCarousel({
                singleItem : true,
                autoPlay : 4000
            });
        }
        if (count == 2) {
            jQuery(owlcontainer).owlCarousel({
                itemsCustom : [
                    [0, 1],
                    [640, 2]
                ],
                autoPlay : 4000
            });
        }
        if (count == 3) {
            jQuery(owlcontainer).owlCarousel({
                itemsCustom : [
                    [0, 1],
                    [640, 2],
                    [930, 3]
                ],
                autoPlay : 4000
            });
        }
        if (count > 3) {
            jQuery(owlcontainer).owlCarousel({
                itemsCustom : [
                    [0, 1],
                    [640, 2],
                    [930, 3],
                    [1200, count]
                ],
                autoPlay : 4000
            });
        }

    }

    // COUNTERS
    $(".dgts_counters").each(function(n) {
        $(this).attr("id", "dgts_counters_" + n);
        var col = $('#dgts_counters_' + n + ' .dgts_counter');
        var length = col.length;

        col.css('width', (100/length)+'%');

    });

    $('.dgts_number').counterUp({
        delay: 10,
        time: 3000
    });

});

jQuery(window).resize(function() {

    var winWidth = jQuery(window).width();

    // GRID SECTION
    var section = jQuery( '.dgts_full_width_section' );

    if ( section[0] )
        var offset = section.offset().left;

    section.css({'width':winWidth, 'margin-left': -offset});

});