<?php

// REGISTER TEAM MEMBERS POST TYPE
function dgts_team_members_post_type() {

    $labels = array(
        'name'                =>  __( 'Team Members', 'dgts' ),
        'singular_name'       =>  __( 'Team Member', 'dgts' ),
        'menu_name'           =>  __( 'DGTS Team', 'dgts' ),
        'add_new'             =>  __( 'Add New Team Member', 'dgts' ),
        'new_item'            =>  __( 'New Team Member', 'dgts' ),
        'edit_item'           =>  __( 'Edit Team Member', 'dgts' ),
        'view_item'           =>  __( 'View Team Member', 'dgts' ),
        'all_items'           =>  __( 'All Team Members', 'dgts' ),
        'search_items'        =>  __( 'Search Team Members', 'dgts' ),
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
        'rewrite'               =>  array( 'slug' => 'team_members' ),
        'capability_type'       =>  'post',
        'has_archive'           =>  true,
        'hierarchical'          =>  false,
        'menu_position'         =>  11,
        'menu_icon'             =>  'dashicons-groups',
        'supports'              =>  array( 'editor', 'thumbnail' ),
        'register_meta_box_cb'  =>  'dgts_team_members_meta_boxes'
    );

    register_post_type( 'team_members', $args );

}
add_action( 'init', 'dgts_team_members_post_type' );

// META BOXES
function dgts_team_members_meta_boxes() {

    add_meta_box( 'dgts_team_members_meta', __( 'Team Member Details', 'dgts' ), 'dgts_team_members_meta_form', 'team_members', 'normal', 'high' );

}
 
function dgts_team_members_meta_form() {

    $post_id = get_the_ID();
    $team_member_data = get_post_meta( $post_id, '_team_member', true );
    $name = ( empty( $team_member_data['name'] ) ) ? '' : $team_member_data['name'];
    $position = ( empty( $team_member_data['position'] ) ) ? '' : $team_member_data['position'];
    $mail = ( empty( $team_member_data['mail'] ) ) ? '' : $team_member_data['mail'];
    $facebook = ( empty( $team_member_data['facebook'] ) ) ? '' : $team_member_data['facebook'];
    $twitter = ( empty( $team_member_data['twitter'] ) ) ? '' : $team_member_data['twitter'];
    $linkedin = ( empty( $team_member_data['linkedin'] ) ) ? '' : $team_member_data['linkedin'];
    $instagram = ( empty( $team_member_data['instagram'] ) ) ? '' : $team_member_data['instagram'];
    $google_plus = ( empty( $team_member_data['google_plus'] ) ) ? '' : $team_member_data['google_plus'];

    wp_nonce_field( 'team_members', 'team_members' );

?>
    <p>
        <label><?php _e( 'Member name (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $name; ?>" name="team_member[name]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Position in team (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $position; ?>" name="team_member[position]" size="40" />
    </p>
    <p>
        <label><?php _e( 'E-mail (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $mail; ?>" name="team_member[mail]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Facebook (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $facebook; ?>" name="team_member[facebook]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Twitter (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $twitter; ?>" name="team_member[twitter]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Linkedin (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $linkedin; ?>" name="team_member[linkedin]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Instagram (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $instagram; ?>" name="team_member[instagram]" size="40" />
    </p>
    <p>
        <label><?php _e( 'Google+ (optional)', 'dgts' ); ?></label><br />
        <input type="text" value="<?php echo $google_plus; ?>" name="team_member[google_plus]" size="40" />
    </p>
    <input type="hidden" name="dgts_hidden_flag" value="true" />
<?php
}

function dgts_team_members_save_post( $post_id ) {

    if (isset($_POST['dgts_hidden_flag'])) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( !empty( $_POST['team_members'] ) && ! wp_verify_nonce( $_POST['team_members'], 'team_members' ) )
            return;

        if ( !empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) )
                return;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
        }

        if ( !wp_is_post_revision( $post_id ) && 'team_members' == get_post_type( $post_id ) ) {

            remove_action( 'save_post', 'dgts_team_members_save_post' );
     
            wp_update_post( array(
                'ID'          =>  $post_id,
                'post_title'  =>  __( 'Team Member ID:', 'dgts' ) . ' ' . $post_id
            ) );
     
            add_action( 'save_post', 'dgts_team_members_save_post' );

        }

        if ( !empty( $_POST['team_member'] ) ) {

            $team_member_data['name'] = ( empty( $_POST['team_member']['name'] ) ) ? '' : sanitize_text_field( $_POST['team_member']['name'] );
            $team_member_data['position'] = ( empty( $_POST['team_member']['position'] ) ) ? '' : sanitize_text_field( $_POST['team_member']['position'] );
            $team_member_data['mail'] = ( empty( $_POST['team_member']['mail'] ) ) ? '' : sanitize_text_field( $_POST['team_member']['mail'] );
            $team_member_data['facebook'] = ( empty( $_POST['team_member']['facebook'] ) ) ? '' : sanitize_text_field( $_POST['team_member']['facebook'] );
            $team_member_data['twitter'] = ( empty( $_POST['team_member']['twitter'] ) ) ? '' : esc_url( $_POST['team_member']['twitter'] );
            $team_member_data['linkedin'] = ( empty( $_POST['team_member']['linkedin'] ) ) ? '' : esc_url( $_POST['team_member']['linkedin'] );
            $team_member_data['instagram'] = ( empty( $_POST['team_member']['instagram'] ) ) ? '' : esc_url( $_POST['team_member']['instagram'] );
            $team_member_data['google_plus'] = ( empty( $_POST['team_member']['google_plus'] ) ) ? '' : esc_url( $_POST['team_member']['google_plus'] );

            update_post_meta( $post_id, '_team_member', $team_member_data );

        } else {
            delete_post_meta( $post_id, '_team_member' );
        }

    }

}
add_action( 'save_post', 'dgts_team_members_save_post' );

// TEAM MEMBERS SHORTCODE [team_members carousel="" show="" slide="" id="" order="" orderby=""]
function dgts_team_members_shortcode( $atts ) {

    $team_member = shortcode_atts( array(
        'carousel'  =>  '',
        'show'      =>  '',
        'slide'     =>  '',
        'id'        =>  '',
        'order'     =>  '',
        'orderby'   =>  ''
    ), $atts );

    $carousel = ( $team_member['carousel'] ) ? $team_member['carousel'] : '';
    $show = ( $team_member['show'] ) ? $team_member['show'] : '99';
    $slide = ( $team_member['slide'] ) ? $team_member['slide'] : '';
    $id = ( $team_member['id'] ) ? $team_member['id'] : '';
    $order = ( $team_member['order'] ) ? $team_member['order'] : '';
    $orderby = ( $team_member['orderby'] ) ? $team_member['orderby'] : '';
    $ids = '';
    
    if ( $carousel == 'yes' ) {

        $instance = uniqid();
        $carousel = ' id="dgts_carousel_' . $instance . '"';
        $container = '_carousel';
        $data = ' data-instance="' . $instance . '"';
        $columns = '';

        $params = array(
            'slide' => $slide
        );
        wp_localize_script( 'shortcodes', 'DGTSCarousel'.$instance, $params );

    } else {

        $carousel = '';
        $container = '';
        $data = '';
        $columns = ' dgts_member_col_'.$slide;

    }

    if ( !empty($id) ) {
        $ids = explode(',', $id);
    }

    query_posts( array(
        'showposts'  =>  esc_attr( $show ),
        'post_type'  =>  'team_members',
        'post__in'   =>  $ids,
        'order'      =>  esc_attr( $order ),
        'orderby'    =>  esc_attr( $orderby )
    ));

    $out = '';
    $out .= '<div'.$carousel.' class="dgts_team_members'.$container.'"'.$data.'>';

    if (have_posts()) :
        while (have_posts()) : the_post();

            $post_id = get_the_ID();
            $team_member_data = get_post_meta( $post_id, '_team_member', true );
            $name = ( empty( $team_member_data['name'] ) ) ? '' : $team_member_data['name'];
            $position = ( empty( $team_member_data['position'] ) ) ? '' : $team_member_data['position'];
            $mail = ( empty( $team_member_data['mail'] ) ) ? '' : $team_member_data['mail'];
            $facebook = ( empty( $team_member_data['facebook'] ) ) ? '' : $team_member_data['facebook'];
            $twitter = ( empty( $team_member_data['twitter'] ) ) ? '' : $team_member_data['twitter'];
            $linkedin = ( empty( $team_member_data['linkedin'] ) ) ? '' : $team_member_data['linkedin'];
            $instagram = ( empty( $team_member_data['instagram'] ) ) ? '' : $team_member_data['instagram'];
            $google_plus = ( empty( $team_member_data['google_plus'] ) ) ? '' : $team_member_data['google_plus'];
 
            $out .= '<div class="dgts_member_box'.esc_attr($columns).'">';
            $out .= '<div class="dgts_member">';
            $out .= '<div class="dgts_member_image">' . get_the_post_thumbnail() . '</div>';
            $out .= '<h4 class="dgts_member_name">' . $name . '</h4>';
            if ( !empty( $team_member_data['position'] )) $out .= '<h5 class="dgts_member_position">' . $position . '</h5>';
            $out .= '<p class="dgts_member_text">' . get_the_content() . '</p>';
            $out .= '<div class="dgts_member_social">';
            if ( !empty( $team_member_data['facebook'] )) $out .= '<a class="dgts_member_social_link fa fa-facebook" href="' . esc_url( $facebook ) . '" target="_blank"></a>';
            if ( !empty( $team_member_data['twitter'] )) $out .= '<a class="dgts_member_social_link fa fa-twitter" href="' . esc_url( $twitter ) . '" target="_blank"></a>';
            if ( !empty( $team_member_data['linkedin'] )) $out .= '<a class="dgts_member_social_link fa fa-linkedin" href="' . esc_url( $linkedin ) . '" target="_blank"></a>';
            if ( !empty( $team_member_data['instagram'] )) $out .= '<a class="dgts_member_social_link fa fa-instagram" href="' . esc_url( $instagram ) . '" target="_blank"></a>';
            if ( !empty( $team_member_data['google_plus'] )) $out .= '<a class="dgts_member_social_link fa fa-google-plus" href="' . esc_url( $google_plus ) . '" target="_blank"></a>';
            if ( !empty( $team_member_data['mail'] )) $out .= '<a class="dgts_member_social_link fa fa-envelope" href="mailto:' . $mail . '" target="_blank"></a>';
            $out .= '<div class="dgts_member_social_box"></div>';
            $out .= '</div>';
            $out .= '</div>';
            $out .= '</div>';

        endwhile;
    endif;

    $out .= '</div>';

    wp_reset_query();

    return $out;

}
add_shortcode('team_members', 'dgts_team_members_shortcode');

?>