<?php

// SECTION SHORTCODE [section color="" image="" repeat="" attach="" size=""][/section]
function dgts_section_shortcode( $atts, $content = null ) {
    
    $section = shortcode_atts( array(
        'full'    =>  '',
        'color'   =>  '',
        'image'   =>  '',
        'repeat'  =>  '',
        'attach'  =>  '',
        'size'    =>  ''
    ), $atts );

    $full = ( !empty( $section['full'] )) ? $section['full'] : '';
    $color = ( !empty( $section['color'] )) ? 'background-color:'.$section['color'].'; ' : '';
    $image = ( !empty( $section['image'] )) ? 'background-image:url('.$section['image'].'); ' : '';
    $repeat = ( !empty( $section['repeat'] )) ? 'background-repeat:'.$section['repeat'].'; ' : '';
    $attach = ( !empty( $section['attach'] )) ? 'background-attachment:'.$section['attach'].'; ' : '';
    $size = ( !empty( $section['size'] )) ? 'background-size:'.$section['size'].';' : '';

    $full_width = '';
    if ( $full == 'yes' ) $full_width = '_full_width';

    $out = '';
    $out .= '<section class="dgts'.$full_width.'_section" style="'.esc_attr($color).esc_attr($image).esc_attr($repeat).esc_attr($attach).esc_attr($size).'">';
    $out .= do_shortcode($content);
    $out .= '</section><div class="dgts_clear"></div>';

    return $out;

}

// ROW SHORTCODE [row width="" height=""][/row]
function dgts_row_shortcode( $atts, $content = null ) {

    $row = shortcode_atts( array(
        'width'   =>  '',
        'height'  =>  ''
    ), $atts );

    $width = ( $row['width'] ) ? 'max-width:'.$row['width'].'px;' : '';
    $height = ( $row['height'] ) ? 'height:'.$row['height'].'px;' : '';
    $style = '';

    if ( !empty( $width ) || !empty( $height )) {
        $style = ' style='.esc_attr($width).esc_attr($height).'';
    }

    $out = '<div class="dgts_row"'.$style.'>' . do_shortcode($content) . '</div><div class="dgts_clear"></div>';

    return $out;

}

// COLUMNS SHORTCODE [columns qty=""][/columns]
function dgts_columns_shortcode( $atts, $content = null ) {

    $columns = shortcode_atts( array(
        'qty'  =>  '',
    ), $atts );

    $qty = ( $columns['qty'] ) ? $columns['qty'] : '';
    $style = ' style="width: '.esc_attr($qty).';"';

    $out = '<div class="dgts_columns"'.$style.'>' . do_shortcode($content) . '</div>';

    return $out;

}

// ADDING SHORTCODES
add_shortcode('section', 'dgts_section_shortcode');
add_shortcode('row', 'dgts_row_shortcode');
add_shortcode('columns', 'dgts_columns_shortcode');

?>