<?php

// COUNTERS SHORTCODE [counters][counter qty="" txt="" before="" after=""][/counters]
function dgts_counters_shortcode( $atts, $content = null ) {

    return '<div class="dgts_counters">' . do_shortcode($content) . '</div>';

}

function dgts_counter_shortcode( $atts ) {

    $counter = shortcode_atts( array(
        'qty'     =>  '',
        'txt'     =>  '',
        'before'  =>  '',
        'after'   =>  ''
    ), $atts );

    $qty = ($counter['qty']) ? $counter['qty'] : '';
    $txt = ($counter['txt']) ? $counter['txt'] : '';
    $before = ($counter['before']) ? $counter['before'] : '';
    $after = ($counter['after']) ? $counter['after'] : '';

    $out = '<div class="dgts_counter"><span class="dgts_before">'.$before.'</span><span class="dgts_number">'.$qty.'</span><span class="dgts_after">'.$after.'</span><div class="dgts_title">'.$txt.'</div></div>';
 
    return $out;

}

// ADDING SHORTCODES
add_shortcode( 'counters', 'dgts_counters_shortcode' );
add_shortcode( 'counter', 'dgts_counter_shortcode' );

?>