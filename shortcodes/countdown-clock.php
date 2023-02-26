<?php

// COUNTDOWN CLOCK SHORTCODE [countdown day="" month="" year="" hour="" minutes="" seconds=""]
function dgts_countdown_clock_shortcode( $atts ) {

    $countdown = shortcode_atts( array(
        'day'      =>  '',
        'month'    =>  '',
        'year'     =>  '',
        'hour'     =>  '',
        'minutes'  =>  '',
        'seconds'  =>  '',
        'txt'  =>  ''
    ), $atts );

    $day = ($countdown['day']) ? $countdown['day'] : '';
    $month = ($countdown['month']) ? $countdown['month'] : '';
    $year = ($countdown['year']) ? $countdown['year'] : '';
    $hour = ($countdown['hour']) ? $countdown['hour'] : '';
    $minutes = ($countdown['minutes']) ? $countdown['minutes'] : '';
    $seconds = ($countdown['seconds']) ? $countdown['seconds'] : '';
    $txt = ($countdown['txt']) ? $countdown['txt'] : '';

    $out = '<div class="dgts_countdown_clock" data-countdown="'.$month.'/'.$day.'/'.$year.' '.$hour.':'.$minutes.':'.$seconds.'" data-txt="'.$txt.'"></div>';
 
    return $out;

}

// ADDING SHORTCODES
add_shortcode( 'countdown_clock', 'dgts_countdown_clock_shortcode' );

?>