<?php

// POSTS CAROUSEL SHORTCODE [posts_carousel show="" slide="" category="" meta="" date="" more="" order="" orderby=""]
function dgts_posts_carousel_shortcode( $atts ) {

    $posts = shortcode_atts( array(
        'show'      =>  '',
        'slide'     =>  '',
        'category'  =>  '',
        'meta'      =>  '',
        'date'      =>  '',
        'more'      =>  '',
        'order'     =>  '',
        'orderby'   =>  ''
    ), $atts );

    $show = ($posts['show']) ? $posts['show'] : '99';
    $slide = ($posts['slide']) ? $posts['slide'] : '';
    $category = ($posts['category']) ? $posts['category'] : '';
    $meta = ($posts['meta']) ? $posts['meta'] : '';
    $date = ($posts['date']) ? $posts['date'] : '';
    $more = ($posts['more']) ? $posts['more'] : '';
    $order = ($posts['order']) ? $posts['order'] : '';
    $orderby = ($posts['orderby']) ? $posts['orderby'] : '';
    $instance = uniqid();

    $params = array(
        'slide' => $slide
    );
    wp_localize_script( 'shortcodes', 'DGTSCarousel'.$instance, $params );

    $out = '';
    $out .= '<div id="dgts_carousel_' . $instance . '" class="dgts_posts_carousel" data-instance="' . $instance . '">';

    query_posts( array(
        'showposts'      =>  esc_attr( $show ),
        'category_name'  =>  esc_attr( $category ),
        'orderby'        =>  esc_attr( $orderby ),
        'order'          =>  esc_attr( $order )
    ));

    if (have_posts()) :
        while (have_posts()) : the_post();
            global $post;

            $out .= '<div class="dgts_post_container">';
            $out .= '<div class="dgts_post_thumbnail"><a href="'.get_the_permalink().'" alt="'.get_the_title().'">';
            $out .= get_the_post_thumbnail( $post -> ID, array( 1200, 500 ) );
            $out .= '<div class="dgts_mask"><div class="dgts_mask_icon"></div></div></a>';
            if ($date == 'yes') {
                $out .= '<div class="dgts_date">';
                $out .= '<div class="dgts_day">'.get_the_time('d').'</div>';
                $out .= '<div class="dgts_month">'.get_the_time('M').'</div>';
                $out .= '<div class="dgts_year">'.get_the_time('Y').'</div>';
                $out .= '</div>';
            }
            $out .= '</div>';
            $out .= '<div class="dgts_post_content">';
            $out .= '<a href="'.get_the_permalink().'"><h4 class="dgts_post_title">'.get_the_title().'</h4></a>';
            $out .= '<p>'.get_the_excerpt().'</p>';
            $out .= '</div>';
            $out .= '<div class="dgts_post_footer">';
            $out .= '<div class="dgts_post_meta">';
            $out .= '<div class="dgts_meta">';
            if ($meta == 'yes') {
                $out .= '<div class="dgts_meta_categories"><i class="fa fa-folder-open"></i>';
                $terms = get_the_term_list( $post->ID, 'category', '', ', ' );
                $out .= $terms.'</div>';
                $out .= '<span class="dgts_meta_author"><a href="' . site_url() . '/author/' . get_the_author() . '"><i class="fa fa-user"></i> ' . get_the_author() . '</a></span>';
                $out .= '<span class="dgts_meta_comments"><a href="'.get_permalink().'/#comments"><i class="fa fa-comments"></i> '.get_comments_number( 'No comments', '1 comment', '% comments' ).'</a></span>';
            }
            if ( current_user_can('edit_others_pages') ) {
                $out .= '<span class="dgts_meta_edit">';
                $out .= '<a href="'.get_edit_post_link().'"><i class="fa fa-pencil"></i> '.__('Edit', 'dgts').'</a>';
                $out .= '</span>';
            }
            $out .= '</div>';
            $out .= '</div>';
            if (!empty($more)) {
                $out .= '<a class="dgts_show_more" href="'.get_the_permalink().'">';
                $out .= $more;
                $out .= '</a>';
            }
            $out .= '</div>';
            $out .= '</div>';

        endwhile;
    endif;

    $out .= '</div>';

    wp_reset_query();

    return $out;

}

// ADDING SHORTCODES
add_shortcode('posts_carousel', 'dgts_posts_carousel_shortcode');

?>