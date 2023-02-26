<?php

$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

header("Content-type: text/css; charset: UTF-8");

$basic_options = get_option( 'dgts_basic_options' );
$color = $basic_options['dgts_color'];

function hex2rgb($hex_color) {

   $hex_color = str_replace("#", "", $hex_color);

   if(strlen($hex_color) == 3) {
      $r = hexdec(substr($hex_color,0,1).substr($hex_color,0,1));
      $g = hexdec(substr($hex_color,1,1).substr($hex_color,1,1));
      $b = hexdec(substr($hex_color,2,1).substr($hex_color,2,1));
   } else {
      $r = hexdec(substr($hex_color,0,2));
      $g = hexdec(substr($hex_color,2,2));
      $b = hexdec(substr($hex_color,4,2));
   }
   $rgb = array($r, $g, $b);

   return implode(", ", $rgb);

}

function colourBrightness($hex, $percent) {

    $hash = '';
    if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
    }

    $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));

    for ($i=0; $i<3; $i++) {

        if ($percent > 0) {
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
        } else {
            $positivePercent = $percent - ($percent*2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
        }

        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }

    }

    $hex = '';
    for($i=0; $i < 3; $i++) {

        $hexDigit = dechex($rgb[$i]);

        if(strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }

        $hex .= $hexDigit;

    }

    return $hash.$hex;

}

$darker = -0.8;
$dark = colourBrightness($color,$darker);

$transparent = 0.8;
$rgba = hex2rgb($color).', '.$transparent;

?>

/* == CAROUSEL == */
.owl-theme .owl-controls .owl-page span {
    background: <?php echo $color; ?> !important;
    border-color: <?php echo $color; ?> !important;
}

/* == PRICING TABLE == */
.dgts_pricing_table .dgts_pt_title,
.dgts_pricing_table .dgts_pt_box .dgts_pt_link {
    background: <?php echo $color; ?>;
}
.dgts_pricing_table .dgts_pt_details {
    background: <?php echo $dark; ?>;
}
.dgts_pricing_table .dgts_pt_box .dgts_pt_button {
    border-bottom-color: <?php echo $color; ?>;
}
.dgts_pricing_table .dgts_pt_box .dgts_pt_link:hover {
    background: <?php echo $dark; ?>;
}
.dgts_pricing_table .dgts_pt_box .dgts_pt_link:hover ~ .dgts_pt_button {
    border-bottom-color: <?php echo $dark; ?>;
}

/* == COUNTDOWN CLOCK == */
.dgts_countdown_clock .dgts_clock_month,
.dgts_countdown_clock .dgts_clock_day,
.dgts_countdown_clock .dgts_clock_hour,
.dgts_countdown_clock .dgts_clock_minute,
.dgts_countdown_clock .dgts_clock_second {
    background: <?php echo $color; ?>;
}
.dgts_countdown_clock div > span {
    background: <?php echo $dark; ?>;
}
.dgts_countdown_clock .dgts_clock_after {
    border-bottom: 4px solid <?php echo $color; ?>;
}

/* == POSTS CAROUSEL == */
.dgts_posts_carousel .dgts_post_container {
    border-bottom-color: <?php echo $color; ?>;
}
.dgts_posts_carousel .dgts_post_container .dgts_post_thumbnail .dgts_date {
    background: rgba(<?php echo $rgba; ?>);
}
.dgts_posts_carousel .dgts_post_container .dgts_post_thumbnail .dgts_mask {
    background: rgba(<?php echo $rgba; ?>);
}
.dgts_posts_carousel .dgts_post_container .dgts_post_content a:hover .dgts_post_title {
    color: <?php echo $color; ?>;
}
.dgts_posts_carousel .dgts_post_container .dgts_post_footer .dgts_post_meta .dgts_meta a:hover,
.dgts_posts_carousel .dgts_post_container .dgts_post_footer .dgts_show_more {
    color: <?php echo $color; ?>;
}
.dgts_posts_carousel .dgts_post_container .dgts_post_footer .dgts_show_more:hover {
    background: <?php echo $color; ?>;
}

/* == LOGOS CAROUSEL == */
.dgts_logos_carousel .dgts_logo .dgts_logo_link:hover h5,
#dgts_logos_carousel_widget .dgts_logo .dgts_logo_link:hover h5 {
    color: <?php echo $color; ?>;
}

/* == TESTIMONIALS CAROUSEL == */
.dgts_testimonials_carousel .dgts_testimonial .dgts_testimonial_content .dgts_testimonial_title,
#dgts_testimonials_carousel_widget .dgts_testimonial .dgts_testimonial_content .dgts_testimonial_title {
    color: <?php echo $color; ?>;
}
.dgts_testimonials_carousel .dgts_testimonial .dgts_testimonial_client h6 a:hover,
#dgts_testimonials_carousel_widget .dgts_testimonial .dgts_testimonial_client h6 a:hover {
    color: <?php echo $color; ?>;
}

/* == TEAM MEMBERS == */
.dgts_team_members .dgts_member_box .dgts_member .dgts_member_position,
.dgts_team_members_carousel .dgts_member_box .dgts_member .dgts_member_position {
    color: <?php echo $color; ?>;
}
.dgts_team_members .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_box,
.dgts_team_members_carousel .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_box {
    border-bottom-color: <?php echo $color; ?>;
}
.dgts_team_members .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_link,
.dgts_team_members_carousel .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_link {
    background: <?php echo $color; ?>;
}
.dgts_team_members .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_link:hover,
.dgts_team_members_carousel .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_link:hover {
    background: <?php echo $dark; ?>;
}
.dgts_team_members .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_link:hover ~ .dgts_member_social_box,
.dgts_team_members_carousel .dgts_member_box .dgts_member .dgts_member_social .dgts_member_social_link:hover ~ .dgts_member_social_box {
    border-bottom-color: <?php echo $dark; ?>;
}