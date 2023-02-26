<?php

// PRICING TABLES SHORTCODE [pricing_tables][/pricing_tables]
function dgts_pricing_tables_shortcode( $atts, $content = null ) {

    return '<div class="dgts_pricing_tables">' . do_shortcode($content) . '</div>';

}

// PRICING TABLE SHORTCODE [pricing_table featured="" title="" price="" per="" button_txt="" button_url=""][/pricing_table]
function dgts_pricing_table_shortcode( $atts, $content = null ) {

    $pt = shortcode_atts( array(
        'per_row'     =>  '',
        'featured'    =>  '',
        'title'       =>  '',
        'price'       =>  '',
        'per'         =>  '',
        'button_txt'  =>  '',
        'button_url'  =>  ''
    ), $atts );

    $per_row = ($pt['per_row']) ? ' dgts_pt_col_'.$pt['per_row'] : '';
    $featured = ($pt['featured'] == 'yes') ? ' featured' : '';
    $title = ($pt['title']) ? $pt['title'] : '';
    $price = ($pt['price']) ? $pt['price'] : '';
    $per = ($pt['per']) ? $pt['per'] : '';
    $button_txt = ($pt['button_txt']) ? $pt['button_txt'] : '';
    $button_url = ($pt['button_url']) ? $pt['button_url'] : '';

    $out = '';
    $out .= '<div class="dgts_pricing_table'.esc_attr($per_row).esc_attr($featured).'">';
    $out .= '<div class="dgts_pt_title">'.$title.'</div>';
    $out .= '<div class="dgts_pt_details">';
    $out .= '<div class="dgts_pt_price">'.$price.'</div>';
    $out .= '<div class="dgts_pt_term">'.$per.'</div>';
    $out .= '</div>';
    $out .= do_shortcode($content);
    $out .= '<div class="dgts_pt_box">';
    if ( !empty($button_txt) ) {
        $out .= '<a href="'.esc_url($button_url).'" class="dgts_pt_link">'.$button_txt.'</a>';
    }
    $out .= '<div class="dgts_pt_button">';
    $out .= '</div>';
    $out .= '</div>';
    $out .= '</div>';

    return $out;

}

// PRICING TABLE FEATURE SHORTCODE [pricing_feature][/pricing_feature]
function dgts_pricing_feature_shortcode( $atts, $content = null ) {

    return '<div class="dgts_pt_feature"><p>' . do_shortcode($content) . '</p></div>';

}

// ADDING SHORTCODES
add_shortcode('pricing_tables', 'dgts_pricing_tables_shortcode');
add_shortcode('pricing_table', 'dgts_pricing_table_shortcode');
add_shortcode('pricing_feature', 'dgts_pricing_feature_shortcode');

?>