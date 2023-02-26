<?php

// REGISTER LOGOS POST TYPE
function dgts_logos_post_type() {

    $labels = array(
        'name'                =>  __( 'Logos', 'dgts' ),
        'singular_name'       =>  __( 'Logo', 'dgts' ),
        'menu_name'           =>  __( 'DGTS Logos', 'dgts' ),
        'add_new'             =>  __( 'Add New Logo', 'dgts' ),
        'new_item'            =>  __( 'New Logo', 'dgts' ),
        'edit_item'           =>  __( 'Edit Logo', 'dgts' ),
        'view_item'           =>  __( 'View Logo', 'dgts' ),
        'all_items'           =>  __( 'All Logos', 'dgts' ),
        'search_items'        =>  __( 'Search Logos', 'dgts' ),
        'not_found'           =>  __( 'Nothing found.', 'dgts' ),
        'not_found_in_trash'  =>  __( 'Nothing found in Trash.', 'dgts' )
    );

    $args = array(
        'labels'                =>  $labels,
        'public'                =>  true,
        'publicly_queryable'    =>  true,
        'show_ui'               =>  true,
        'show_in_menu'          =>  true,
        'query_var'             =>  true,
        'rewrite'               =>  array( 'slug' => 'logos' ),
        'capability_type'       =>  'post',
        'has_archive'           =>  true,
        'hierarchical'          =>  false,
        'menu_position'         =>  10,
        'menu_icon'             =>  'dashicons-images-alt2',
        'supports'              =>  array( 'thumbnail' ),
        'register_meta_box_cb'  =>  'dgts_logos_meta_boxes'
    );

    register_post_type( 'logos', $args );

}
add_action( 'init', 'dgts_logos_post_type' );

// META BOXES
function dgts_logos_meta_boxes() {

    add_meta_box( 'dgts_logos_meta', __( 'Logo Details', 'dgts' ), 'dgts_logos_meta_form', 'logos', 'normal', 'high' );

}
 
function dgts_logos_meta_form() {

    $post_id = get_the_ID();
    $logo_data = get_post_meta( $post_id, '_logo', true );
    $company = ( empty( $logo_data['company'] ) ) ? '' : $logo_data['company'];
    $link = ( empty( $logo_data['link'] ) ) ? '' : $logo_data['link'];

    wp_nonce_field( 'logos', 'logos' );

?>
    <p>
        <label><?php _e( 'Company name (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $company; ?>" name="logo[company]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Website link (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $link; ?>" name="logo[link]" size="40" />
    </p>
    <input type="hidden" name="dgts_hidden_flag" value="true" />
<?php
}

function dgts_logos_save_post( $post_id ) {

    if (isset($_POST['dgts_hidden_flag'])) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( !empty( $_POST['logos'] ) && ! wp_verify_nonce( $_POST['logos'], 'logos' ) )
            return;

        if ( !empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) )
                return;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
        }

        if ( !wp_is_post_revision( $post_id ) && 'logos' == get_post_type( $post_id ) ) {

            remove_action( 'save_post', 'dgts_logos_save_post' );
     
            wp_update_post( array(
                'ID'          =>  $post_id,
                'post_title'  =>  __( 'Logo ID:', 'dgts' ) . ' ' . $post_id
            ) );
     
            add_action( 'save_post', 'dgts_logos_save_post' );

        }

        if ( !empty( $_POST['logo'] ) ) {

            $logo_data['company'] = ( empty( $_POST['logo']['company'] ) ) ? '' : sanitize_text_field( $_POST['logo']['company'] );
            $logo_data['link'] = ( empty( $_POST['logo']['link'] ) ) ? '' : esc_url( $_POST['logo']['link'] );

            update_post_meta( $post_id, '_logo', $logo_data );

        } else {
            delete_post_meta( $post_id, '_logo' );
        }

    }

}
add_action( 'save_post', 'dgts_logos_save_post' );

// LOGOS CAROUSEL SHORTCODE [logos_carousel show="" slide="" id="" order="" orderby=""]
function dgts_logos_carousel_shortcode( $atts ) {

    $logo = shortcode_atts( array(
        'show'     =>  '',
        'slide'    =>  '',
        'id'       =>  '',
        'order'    =>  '',
        'orderby'  =>  ''
    ), $atts );

    $show = ( $logo['show'] ) ? $logo['show'] : '99';
    $slide = ( $logo['slide'] ) ? $logo['slide'] : '';
    $id = ( $logo['id'] ) ? $logo['id'] : '';
    $order = ( $logo['order'] ) ? $logo['order'] : '';
    $orderby = ( $logo['orderby'] ) ? $logo['orderby'] : '';
    $instance = uniqid();
    $ids = '';

    $params = array(
        'slide' => $slide
    );
    wp_localize_script( 'shortcodes', 'DGTSCarousel'.$instance, $params );

    if ( !empty($id) ) {
        $ids = explode(',', $id);
    }

    query_posts( array(
        'showposts'  =>  esc_attr( $show ),
        'post_type'  =>  'logos',
        'post__in'   =>  $ids,
        'order'      =>  esc_attr( $order ),
        'orderby'    =>  esc_attr( $orderby )
    ));

    $out = '';
    $out .= '<div id="dgts_carousel_' . $instance . '" class="dgts_logos_carousel" data-instance="' . $instance . '">';

    if (have_posts()) :
        while (have_posts()) : the_post();

            $post_id = get_the_ID();
            $logo_data = get_post_meta( $post_id, '_logo', true );
            $company = ( empty( $logo_data['company'] ) ) ? '' : $logo_data['company'];
            $link = ( empty( $logo_data['link'] ) ) ? '' : $logo_data['link'];

            $out .= '<div class="dgts_logo">';
            if ( !empty( $link ) ) : $out .= '<a class="dgts_logo_link" href="'.$link.'" target="_blank">'; endif;
            $out .= get_the_post_thumbnail();
            $out .= '<h5>'.$company.'</h5>';
            if ( !empty( $link ) ) : $out .= '</a>'; endif;
            $out .= '</div>';

        endwhile;
    endif;

    $out .= '</div>';

    wp_reset_query();

    return $out;

}
add_shortcode('logos_carousel', 'dgts_logos_carousel_shortcode');

?>