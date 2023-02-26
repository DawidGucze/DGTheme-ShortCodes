<?php

// LOGOS CAROUSEL WIDGET
function dgts_logos_carousel_widget( $show = 1, $order = 'DESC', $orderby = 'date', $id = null ) {

    $ids = '';
    if ( !empty($id) ) {
        $ids = explode(',', $id);
    }

    query_posts( array(
        'showposts'  =>  $show,
        'post_type'  =>  'logos',
        'post__in'   =>  $ids,
        'orderby'    =>  $orderby,
        'order'      =>  $order
    ));

    $out = '';
    $out .= '<div id="dgts_logos_carousel_widget">';

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

class Logos_Carousel_Widget extends WP_Widget {

    public function __construct() {

        $widget_info = array( 'classname' => 'dgts_logos_carousel_widget', 'description' => __( 'Display logos carousel.', 'dgts' ) );
        parent::__construct( 'dgts_logos_carousel', __( 'DGTS Logos Carousel', 'dgts' ), $widget_info );

    }

    public function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $show = (int) $instance['show'];
        $order = strip_tags( $instance['order'] );
        $orderby = strip_tags( $instance['orderby'] );
        $id = ( null == $instance['id'] ) ? '' : strip_tags( $instance['id'] );
 
        echo $before_widget;
 
        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title;
 
        echo dgts_logos_carousel_widget( $show, $order, $orderby, $id );
 
        echo $after_widget;

    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['show'] = (int) $new_instance['show'];
        $instance['order'] = strip_tags( $new_instance['order'] );
        $instance['orderby'] = strip_tags( $new_instance['orderby'] );
        $instance['id'] = ( null == $new_instance['id'] ) ? '' : strip_tags( $new_instance['id'] );
 
        return $instance;

    }

    public function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'show' => '6', 'order' => 'DESC', 'orderby' => 'date', 'id' => null ) );
        $title = strip_tags( $instance['title'] );
        $show = (int) $instance['show'];
        $order = strip_tags( $instance['order'] );
        $orderby = strip_tags( $instance['orderby'] );
        $id = ( null == $instance['id'] ) ? '' : strip_tags( $instance['id'] );
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'dgts' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
 
        <p><label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e( 'Number of logos to display', 'dgts' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" type="text" value="<?php echo esc_attr( $show ); ?>" />
        </p>
 
        <p><label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order', 'dgts' ); ?> </label>
        <select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
            <option value="DESC" <?php selected( $order, 'DESC' ); ?>><?php _e( 'Descending', 'dgts' ); ?></option>
            <option value="ASC" <?php selected( $order, 'ASC' ); ?>><?php _e( 'Ascending', 'dgts' ); ?></option>
        </select></p>
 
        <p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order by', 'dgts' ); ?></label>
        <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
            <option value="date" <?php selected( $orderby, 'date' ); ?>><?php _e( 'Date', 'dgts' ); ?></option>
            <option value="ID" <?php selected( $orderby, 'ID' ); ?>><?php _e( 'ID', 'dgts' ); ?></option>
            <option value="modified" <?php selected( $orderby, 'modified' ); ?>><?php _e( 'Modified date', 'dgts' ); ?></option>
            <option value="rand" <?php selected( $orderby, 'rand' ); ?>><?php _e( 'Random', 'dgts' ); ?></option>
        </select></p>
 
        <p><label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Logo ID (comma separated)', 'dgts' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" type="text" value="<?php echo $id; ?>" /></p>
<?php
    }

}
add_action( 'widgets_init', 'dgts_register_logos_carousel_widget' );

function dgts_register_logos_carousel_widget() {
    register_widget( 'Logos_Carousel_Widget' );
}

?>