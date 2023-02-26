<?php

// REGISTER TESTIMONIALS POST TYPE
function dgts_testimonials_post_type() {

    $labels = array(
        'name'                =>  __( 'Testimonials', 'dgts' ),
        'singular_name'       =>  __( 'Testimonial', 'dgts' ),
        'menu_name'           =>  __( 'DGTS Testimonials', 'dgts' ),
        'add_new'             =>  __( 'Add New Testimonial', 'dgts' ),
        'new_item'            =>  __( 'New Testimonial', 'dgts' ),
        'edit_item'           =>  __( 'Edit Testimonial', 'dgts' ),
        'view_item'           =>  __( 'View Testimonial', 'dgts' ),
        'all_items'           =>  __( 'All Testimonials', 'dgts' ),
        'search_items'        =>  __( 'Search Testimonials', 'dgts' ),
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
        'rewrite'               =>  array( 'slug' => 'testimonials' ),
        'capability_type'       =>  'post',
        'has_archive'           =>  true,
        'hierarchical'          =>  false,
        'menu_position'         =>  11,
        'menu_icon'             =>  'dashicons-editor-quote',
        'supports'              =>  array( 'editor', 'thumbnail' ),
        'register_meta_box_cb'  =>  'dgts_testimonials_meta_boxes'
    );

    register_post_type( 'testimonials', $args );

}
add_action( 'init', 'dgts_testimonials_post_type' );

// META BOXES
function dgts_testimonials_meta_boxes() {

    add_meta_box( 'dgts_testimonials_meta', __( 'Testimonial Details', 'dgts' ), 'dgts_testimonials_meta_form', 'testimonials', 'normal', 'high' );

}
 
function dgts_testimonials_meta_form() {

    $post_id = get_the_ID();
    $testimonial_data = get_post_meta( $post_id, '_testimonial', true );
    $introduction = ( empty( $testimonial_data['introduction'] ) ) ? '' : $testimonial_data['introduction'];
    $client = ( empty( $testimonial_data['client'] ) ) ? '' : $testimonial_data['client'];
    $company = ( empty( $testimonial_data['company'] ) ) ? '' : $testimonial_data['company'];
    $link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];

    wp_nonce_field( 'testimonials', 'testimonials' );

?>
    <p>
        <label><?php _e( 'Short introduction (optional)', 'dgts' ); ?></label><br />
        <textarea name="testimonial[introduction]" cols="37" rows="3"><?php echo $introduction; ?></textarea>
    </p>
    <p>
        <label><?php _e( 'Client name (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $client; ?>" name="testimonial[client]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Company name (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $company; ?>" name="testimonial[company]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Website link (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $link; ?>" name="testimonial[link]" size="40" />
    </p>
    <input type="hidden" name="dgts_hidden_flag" value="true" />
<?php
}

function dgts_testimonials_save_post( $post_id ) {

    if (isset($_POST['dgts_hidden_flag'])) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( !empty( $_POST['testimonials'] ) && ! wp_verify_nonce( $_POST['testimonials'], 'testimonials' ) )
            return;

        if ( !empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) )
                return;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
        }

        if ( !wp_is_post_revision( $post_id ) && 'testimonials' == get_post_type( $post_id ) ) {

            remove_action( 'save_post', 'dgts_testimonials_save_post' );
     
            wp_update_post( array(
                'ID'          =>  $post_id,
                'post_title'  =>  __( 'Testimonial ID:', 'dgts' ) . ' ' . $post_id
            ) );
     
            add_action( 'save_post', 'dgts_testimonials_save_post' );

        }

        if ( !empty( $_POST['testimonial'] ) ) {

            $testimonial_data['introduction'] = ( empty( $_POST['testimonial']['introduction'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['introduction'] );
            $testimonial_data['client'] = ( empty( $_POST['testimonial']['client'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['client'] );
            $testimonial_data['company'] = ( empty( $_POST['testimonial']['company'] ) ) ? '' : sanitize_text_field( $_POST['testimonial']['company'] );
            $testimonial_data['link'] = ( empty( $_POST['testimonial']['link'] ) ) ? '' : esc_url( $_POST['testimonial']['link'] );

            update_post_meta( $post_id, '_testimonial', $testimonial_data );

        } else {
            delete_post_meta( $post_id, '_testimonial' );
        }

    }

}
add_action( 'save_post', 'dgts_testimonials_save_post' );

// TESTIMONIALS CAROUSEL SHORTCODE [testimonials_carousel show="" slide="" id="" order="" orderby=""]
function dgts_testimonials_carousel_shortcode( $atts ) {

    $testimonial = shortcode_atts( array(
        'show'     =>  '',
        'slide'    =>  '',
        'id'       =>  '',
        'order'    =>  '',
        'orderby'  =>  ''
    ), $atts );

    $show = ( $testimonial['show'] ) ? $testimonial['show'] : '99';
    $slide = ( $testimonial['slide'] ) ? $testimonial['slide'] : '';
    $id = ( $testimonial['id'] ) ? $testimonial['id'] : '';
    $order = ( $testimonial['order'] ) ? $testimonial['order'] : '';
    $orderby = ( $testimonial['orderby'] ) ? $testimonial['orderby'] : '';
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
        'post_type'  =>  'testimonials',
        'post__in'   =>  $ids,
        'order'      =>  esc_attr( $order ),
        'orderby'    =>  esc_attr( $orderby )
    ));

    $out = '';
    $out .= '<div id="dgts_carousel_' . $instance . '" class="dgts_testimonials_carousel" data-instance="' . $instance . '">';

    if (have_posts()) :
        while (have_posts()) : the_post();

            $post_id = get_the_ID();
            $testimonial_data = get_post_meta( $post_id, '_testimonial', true );
            $introduction = ( empty( $testimonial_data['introduction'] ) ) ? '' : $testimonial_data['introduction'];
            $client = ( empty( $testimonial_data['client'] ) ) ? '' : $testimonial_data['client'];
            $company = ( empty( $testimonial_data['company'] ) ) ? '' : $testimonial_data['company'];
            $link = ( empty( $testimonial_data['link'] ) ) ? '' : $testimonial_data['link'];

            $out .= '<div class="dgts_testimonial">';
            $out .= '<div class="dgts_testimonial_image">' . get_the_post_thumbnail();
            if (has_post_thumbnail()) {
                $out .= '<div class="dgts_testimonial_client">';
                if ( empty($company) ) : $out .= '<h5 style="margin: 15px 0;">'.$client.'</h5>'; else : $out .= '<h5>'.$client.'</h5>'; endif;
                if ( !empty($link) && !empty($company) ) : $out .= '<h6 style="margin: 5px 0 15px 0;"><a href="' . esc_url( $link ) . '" target="_blank">'.$company.'</a></h6>'; endif;
                if ( empty($link) && !empty($company) ) : $out .= '<h6 style="margin: 5px 0 15px 0;">'.$company.'</h6>'; endif;
                $out .= '</div>';
            }
            $out .= '</div>';
            $out .= '<div class="dgts_testimonial_content">';
            $out .= '<div class="dgts_testimonial_title">' . $introduction . '</div>';
            $out .= '<div class="dgts_testimonial_text">' . get_the_content() . '</div>';
            if (!has_post_thumbnail()) {
                $out .= '<div class="dgts_testimonial_client">';
                $out .= '<h5>'.$client.'</h5>';
                if ( !empty($link) && !empty($company) ) : $out .= '<h6><a href="' . esc_url( $link ) . '" target="_blank">'.$company.'</a></h6>'; endif;
                if ( empty($link) && !empty($company) ) : $out .= '<h6>'.$company.'</h6>'; endif;
                $out .= '</div>';
            }
            $out .= '<span class="dgts_quote">&ldquo;</span>';
            $out .= '</div>';
            $out .= '</div>';

        endwhile;
    endif;

    $out .= '</div>';

    wp_reset_query();

    return $out;

}
add_shortcode('testimonials_carousel', 'dgts_testimonials_carousel_shortcode');

?>