<?php
/*
Plugin Name: DGTheme ShortCodes
Plugin URI: http://dgtheme.com/shortcodes
Description: DGTheme ShortCodes is a plugin that adds several useful shortcodes that you can use in your blog posts and pages.
Version: 1.1
Author: DGTheme
Author URI: https://themeforest.net/user/dgtheme
*/

// DEFINE PATHS
define( 'DGTS_PATH', plugin_dir_path(__FILE__) );
define( 'DGTS_URL', plugin_dir_url(__FILE__) );
define( 'DGTS_BASE', plugin_basename( __FILE__ ) );
define( 'DGTS_UPDATE', 'http://dgtheme.com/update/shortcodes/update.php' );

// LOAD AUTO UPDATE
function dgts_auto_update() {

    require_once ( 'includes/autoupdate.php' );
    $plugin_current_version = '1.0';
    $plugin_remote_path = DGTS_UPDATE;
    $plugin_slug = DGTS_BASE;
    $license_user = '';
    $license_key = '';

    new WP_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug, $license_user, $license_key );

}
add_action( 'init', 'dgts_auto_update' );

function dgts_register_admin_scripts() {

    wp_register_script('shortcodes-generator', DGTS_URL . 'js/shortcodes-generator.js', '', '', true);
    wp_register_style( 'admin', DGTS_URL . 'css/admin.css', array(), '1', 'all' );

    wp_enqueue_style( 'admin' );

}
add_action( 'admin_enqueue_scripts', 'dgts_register_admin_scripts' );

// REGISTER SCRIPTS
function dgts_register_scripts() {

    wp_register_script('countdown', DGTS_URL . 'js/countdown.js', '', '', true);
    wp_register_script('counters', DGTS_URL . 'js/counters.js', '', '', true);
    wp_register_script('waypoints', DGTS_URL . 'js/waypoints.js', '', '', true);
    wp_register_script('carousel', DGTS_URL . 'js/carousel.js', '', '', true);
    wp_register_script('shortcodes', DGTS_URL . 'js/shortcodes.js', '', '', true);

    wp_enqueue_script('jquery');
    wp_enqueue_script('countdown');
    wp_enqueue_script('counters');
    wp_enqueue_script('waypoints');
    wp_enqueue_script('carousel');
    wp_enqueue_script('shortcodes');

}
add_action('wp_enqueue_scripts', 'dgts_register_scripts');

// REGISTER STYLES
function dgts_register_styles() {

    wp_register_style( 'shortcodes', DGTS_URL . 'css/shortcodes.css', array(), '1', 'all' );
    wp_register_style( 'carousel', DGTS_URL . 'css/carousel.css', array(), '1', 'all' );
    wp_register_style( 'color', DGTS_URL . 'css/color.php', array(), '1', 'all' );
    wp_register_style( 'font-awesome', DGTS_URL . 'css/font-awesome.css', array(), '1', 'all' );

    wp_enqueue_style( 'shortcodes');
    wp_enqueue_style( 'carousel');
    wp_enqueue_style( 'color');
    wp_enqueue_style( 'font-awesome');

}
add_action('wp_enqueue_scripts', 'dgts_register_styles');

// DEFAULT CAROUSEL PARAMS
function dgts_default_carousel_params() {

    $carousel_params = array(
        'slide' => 1
    );

    wp_localize_script( 'shortcodes', 'DGTSCarousel', $carousel_params );

}
add_action( 'wp_enqueue_scripts', 'dgts_default_carousel_params' );

// LOAD LANGUAGES
function dgts_load_textdomain() {
    load_plugin_textdomain( 'dgts', false, dirname( DGTS_BASE ) . '/languages/' );
}
add_action('plugins_loaded', 'dgts_load_textdomain');

function dgts_shortcodes_translation_generator( $hook ) {

    wp_enqueue_script( 'shortcodes-generator', DGTS_URL . 'scripts' );
    wp_localize_script( 'shortcodes-generator', 'dgts', array(
        'yes'                              =>  __( 'Yes', 'dgts' ),
        'no'                               =>  __( 'No', 'dgts' ),
        'step_one'                         =>  __( '( Step 1 of 2 )', 'dgts' ),
        'step_two'                         =>  __( '( Step 2 of 2 )', 'dgts' ),
        'descending'                       =>  __( 'Descending', 'dgts' ),
        'ascending'                        =>  __( 'Ascending', 'dgts' ),
        'orderby'                          =>  __( 'Order by', 'dgts' ),
        'by_date'                          =>  __( 'Date', 'dgts' ),
        'by_ID'                            =>  __( 'ID', 'dgts' ),
        'by_comment'                       =>  __( 'Number of comments', 'dgts' ),
        'by_title'                         =>  __( 'Title', 'dgts' ),
        'by_modified'                      =>  __( 'Modified date', 'dgts' ),
        'by_rand'                          =>  __( 'Random', 'dgts' ),
        'grid_shortcode'                   =>  __( 'Grid', 'dgts' ),
        'section_shortcode'                =>  __( 'Section', 'dgts' ),
        'section_options'                  =>  __( 'Section Options', 'dgts' ),
        'section_full'                     =>  __( 'Set full width section', 'dgts' ),
        'section_color'                    =>  __( 'Section background color', 'dgts' ),
        'section_image'                    =>  __( 'Section background image', 'dgts' ),
        'section_repeat'                   =>  __( 'Image repeat', 'dgts' ),
        'section_repeat_no'                =>  __( 'No repeat', 'dgts' ),
        'section_repeat_yes'               =>  __( 'Repeat both', 'dgts' ),
        'section_repeat_x'                 =>  __( 'Repeat horizontally', 'dgts' ),
        'section_repeat_y'                 =>  __( 'Repeat vertically', 'dgts' ),
        'section_attachment'               =>  __( 'Image attachment', 'dgts' ),
        'section_attachment_scroll'        =>  __( 'Static', 'dgts' ),
        'section_attachment_fixed'         =>  __( 'Dynamic', 'dgts' ),
        'section_size'                     =>  __( 'Image size', 'dgts' ),
        'section_size_auto'                =>  __( 'Original', 'dgts' ),
        'section_size_cover'               =>  __( 'Fit to screen', 'dgts' ),
        'row_shortcode'                    =>  __( 'Row', 'dgts' ),
        'row_options'                      =>  __( 'Row Options', 'dgts' ),
        'row_width'                        =>  __( 'Row width in pixels', 'dgts' ),
        'row_width_tooltip'                =>  __( 'empty field = 100% width', 'dgts' ),
        'row_height'                       =>  __( 'Row height in pixels', 'dgts' ),
        'row_height_tooltip'               =>  __( 'empty field = auto height', 'dgts' ),
        'columns_shortcode'                =>  __( 'Columns', 'dgts' ),
        'columns_options'                  =>  __( 'Columns Options', 'dgts' ),
        'columns_width'                    =>  __( 'Column width in % (plus separated)', 'dgts' ),
        'price_shortcode'                  =>  __( 'Pricing Tables', 'dgts' ),
        'price_options'                    =>  __( 'Pricing Tables Options', 'dgts' ),
        'price_table'                      =>  __( 'Pricing Table', 'dgts' ),
        'price_per_row'                    =>  __( 'Tables per row', 'dgts' ),
        'price_title'                      =>  __( 'Table Title', 'dgts' ),
        'price_title_silver'               =>  __( 'Silver', 'dgts' ),
        'pricing_featured'                 =>  __( 'Featured', 'dgts' ),
        'price_price'                      =>  __( 'Price', 'dgts' ),
        'price_currency'                   =>  __( '1299$', 'dgts' ),
        'price_fee'                        =>  __( 'Fee', 'dgts' ),
        'price_fee_monthly'                =>  __( 'Monthly', 'dgts' ),
        'price_button'                     =>  __( 'Button text', 'dgts' ),
        'price_button_text'                =>  __( 'Purchase NOW', 'dgts' ),
        'price_button_url'                 =>  __( 'Button link', 'dgts' ),
        'price_sample_text'                =>  __( 'Sample text', 'dgts' ),
        'counters_shortcode'               =>  __( 'Counters', 'dgts' ),
        'counters_options'                 =>  __( 'Counters Options', 'dgts' ),
        'counters_per_row'                 =>  __( 'Counters per row', 'dgts' ),
        'counter_item'                     =>  __( 'Counter', 'dgts' ),
        'counters_number'                  =>  __( 'Number', 'dgts' ),
        'counters_before'                  =>  __( 'Before Number', 'dgts' ),
        'counters_after'                   =>  __( 'After Number', 'dgts' ),
        'counters_currency'                =>  __( '$', 'dgts' ),
        'counters_title'                   =>  __( 'Counter Title', 'dgts' ),
        'counters_title_text'              =>  __( 'Sample text', 'dgts' ),
        'coundown_shortcode'               =>  __( 'Countdown Clock', 'dgts' ),
        'countdown_options'                =>  __( 'Countdown Clock Options', 'dgts' ),
        'countdown_day'                    =>  __( 'Enter day', 'dgts' ),
        'countdown_month'                  =>  __( 'Enter month', 'dgts' ),
        'countdown_year'                   =>  __( 'Enter year', 'dgts' ),
        'countdown_hour'                   =>  __( 'Enter hour', 'dgts' ),
        'countdown_minutes'                =>  __( 'Enter minutes', 'dgts' ),
        'countdown_seconds'                =>  __( 'Enter seconds', 'dgts' ),
        'countdown_txt'                    =>  __( 'Message after the countdown', 'dgts' ),
        'countdown_txt_output'             =>  __( 'Happy New Year!', 'dgts' ),
        'posts_carousel_shortcode'         =>  __( 'Posts Carousel', 'dgts' ),
        'posts_carousel_options'           =>  __( 'Posts Carousel Options', 'dgts' ),
        'posts_carousel_show'              =>  __( 'Number of posts to display', 'dgts' ),
        'posts_carousel_show_tooltip'      =>  __( 'empty = all posts', 'dgts' ),
        'posts_carousel_slide'             =>  __( 'Number of visible posts', 'dgts' ),
        'posts_carousel_category'          =>  __( 'Show posts from category (comma separated)', 'dgts' ),
        'posts_carousel_meta'              =>  __( 'Show post meta', 'dgts' ),
        'posts_carousel_date'              =>  __( 'Show post date', 'dgts' ),
        'posts_carousel_more'              =>  __( 'Button text', 'dgts' ),
        'posts_carousel_more_text'         =>  __( 'Read more', 'dgts' ),
        'posts_carousel_order'             =>  __( 'Posts order', 'dgts' ),
        'logos_carousel_shortcode'         =>  __( 'Logos Carousel', 'dgts' ),
        'logos_carousel_options'           =>  __( 'Logos Carousel Options', 'dgts' ),
        'logos_carousel_show'              =>  __( 'Number of logos to display', 'dgts' ),
        'logos_carousel_slide'             =>  __( 'Number of visible logos', 'dgts' ),
        'logos_carousel_ids'               =>  __( 'Logo ID (comma separated)', 'dgts' ),
        'logos_carousel_order'             =>  __( 'Logos order', 'dgts' ),
        'testimonials_carousel_shortcode'  =>  __( 'Testimonials Carousel', 'dgts' ),
        'testimonials_carousel_options'    =>  __( 'Testimonials Carousel Options', 'dgts' ),
        'testimonials_carousel_show'       =>  __( 'Number of testimonials to display', 'dgts' ),
        'testimonials_carousel_slide'      =>  __( 'Number of visible testimonials', 'dgts' ),
        'testimonials_carousel_ids'        =>  __( 'Testimonial ID (comma separated)', 'dgts' ),
        'testimonials_carousel_order'      =>  __( 'Testimonials order', 'dgts' ),
        'team_members_shortcode'           =>  __( 'Team Members', 'dgts' ),
        'team_members_options'             =>  __( 'Team Members Options', 'dgts' ),
        'team_members_carousel'            =>  __( 'Enable team carousel', 'dgts' ),
        'team_members_show'                =>  __( 'Number of team members to display', 'dgts' ),
        'team_members_slide'               =>  __( 'Number of team members per row / visible team members', 'dgts' ),
        'team_members_ids'                 =>  __( 'Team Member ID (comma separated)', 'dgts' ),
        'team_members_order'               =>  __( 'Team members order', 'dgts' ),

    ));

}
add_action( 'admin_enqueue_scripts', 'dgts_shortcodes_translation_generator' );

function dgts_countdown_clock_translation() {

    wp_localize_script( 'shortcodes', 'dgts', array(
        'countdown_days_text'     =>  __( 'Days', 'dgts' ),
        'countdown_months_text'   =>  __( 'Months', 'dgts' ),
        'countdown_hours_text'    =>  __( 'Hours', 'dgts' ),
        'countdown_minutes_text'  =>  __( 'Minutes', 'dgts' ),
        'countdown_seconds_text'  =>  __( 'Seconds', 'dgts' )
    ));

}
add_action('wp_enqueue_scripts', 'dgts_countdown_clock_translation');

// THEME SUPPORT
add_theme_support( 'post-thumbnails' ); 
add_image_size( '1200x500', 1200, 500, array( 'center', 'center' ) );

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 12);

// INCLUDES
include_once DGTS_PATH . 'includes/plugin-options.php';

require_once DGTS_PATH . 'shortcodes/grid.php';
require_once DGTS_PATH . 'shortcodes/pricing-tables.php';
require_once DGTS_PATH . 'shortcodes/countdown-clock.php';
require_once DGTS_PATH . 'shortcodes/counters.php';
require_once DGTS_PATH . 'shortcodes/posts-carousel.php';
require_once DGTS_PATH . 'shortcodes/logos-carousel.php';
require_once DGTS_PATH . 'shortcodes/testimonials-carousel.php';
require_once DGTS_PATH . 'shortcodes/team-members.php';

require_once DGTS_PATH . 'widgets/logos-carousel.php';
require_once DGTS_PATH . 'widgets/testimonials-carousel.php';

// COLOR PICKER
function dgts_enqueue_color_picker( $hook_suffix ) {

    global $wp_version;
    
    if ( 3.5 <= $wp_version ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    } else {
        wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );
    }
    
    wp_enqueue_script( 'color-picker-settings', DGTS_URL . 'js/colors-picker.js' );

}
add_action( 'admin_enqueue_scripts', 'dgts_enqueue_color_picker' );

// INIT SHORTCODES GENERATOR
function dgts_add_mce_button() {

    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }

    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'dgts_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'dgts_register_mce_button' );
    }

}
add_action('admin_head', 'dgts_add_mce_button');

function dgts_add_tinymce_plugin( $plugin_array ) {

    $plugin_array['dgts_mce_button'] = DGTS_URL . "js/shortcodes-generator.js";
    return $plugin_array;

}
add_filter("mce_external_plugins", "dgts_add_tinymce_plugin");

function dgts_register_mce_button( $buttons ) {

    array_push( $buttons, 'dgts_mce_button' );
    return $buttons;

}

?>