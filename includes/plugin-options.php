<?php

// CREATE MENU
function dgts_plugin_menu() {

    add_menu_page(
        __( 'DGTS Options', 'dgts' ),
        __( 'DGTS Options', 'dgts' ),
        'administrator',
        'dgts_plugin_options',
        'dgts_setting_page_display'
    );

}
add_action( 'admin_menu', 'dgts_plugin_menu' );

// DISPLAY SETTINGS PAGE
function dgts_setting_page_display( $active_tab = '' ) {
?>
    <div class="wrap">
    
        <div id="icon-themes" class="icon32"></div>
        <h2><?php _e( 'DGTheme Shortcodes Options', 'dgts' ); ?></h2>
        <?php settings_errors(); ?>
        
        <?php if( isset( $_GET[ 'tab' ] ) ) {
            $active_tab = $_GET[ 'tab' ];
        } else {
            $active_tab = 'basic_options';
        } ?>
        
        <h2 class="nav-tab-wrapper">
            <a href="?page=dgts_plugin_options&tab=basic_options" class="nav-tab <?php echo $active_tab == 'basic_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Basic Options', 'dgts' ); ?></a>
        </h2>
        
        <form method="post" action="options.php">
            <?php
            
                if( $active_tab == 'basic_options' ) {
                
                    settings_fields( 'dgts_basic_options' );
                    do_settings_sections( 'dgts_basic_options' );
                    
                }
                
                submit_button();
            ?>
        </form>
        
    </div>
<?php
}

// DEFAULT OPTIONS

/* BASIC */
function dgts_default_basic_options() {
    
    $defaults = array(
        'dgts_color'  =>  '#26AD60'
    );
    
    return apply_filters( 'dgts_default_basic_options', $defaults );
    
}

// INITIALIZE OPTIONS

/* BASIC */
function dgts_initialize_basic_options() {

    if( false == get_option( 'dgts_basic_options' ) ) {
        add_option( 'dgts_basic_options', apply_filters( 'dgts_default_basic_options', dgts_default_basic_options() ) );
    }
    
    add_settings_section(
        'dgts_basic_settings_section',
        __( 'Basic Options', 'dgts' ),
        'dgts_basic_page_options_callback',
        'dgts_basic_options'
    );

    add_settings_field(
        'dgts_color',
        __( 'Set the color', 'dgts' ),
        'dgts_basic_options_callback',
        'dgts_basic_options',
        'dgts_basic_settings_section',
        array(
            'type'      => 'select_color',
            'id'        => 'dgts_color',
            'name'      => 'dgts_color',
            'desc'      => '',
            'std'       => '',
            'label_for' => 'dgts_color',
            'class'     => 'color-picker'
        )
    );
    
    register_setting(
        'dgts_basic_options',
        'dgts_basic_options',
        'dgts_validate_colors'
    );
    
}
add_action( 'admin_init', 'dgts_initialize_basic_options' );

// OPTION PAGES DESCRIPTION
function dgts_basic_page_options_callback() {
    echo '<p>' . __( 'Basic plugin options', 'dgts' ) . '</p>';
}

// CALLBACKS

/* BASIC */
function dgts_basic_options_callback($args)
{
    extract( $args );

    $option_name = 'dgts_basic_options';
    $options = get_option( $option_name );
    $color = ( $options[$id] != "" ) ? sanitize_text_field( $options[$id] ) : '#26AD60';

    switch ( $type ) {
        case 'select_color' :
            $html = '<input class="'.$class.'" type="text" id="'.$id.'" name="'.$option_name.'['.$name.']" value="'.$color.'" />';
            $html .= '<div id="colorpicker"></div>';

            echo $html;
        break;
    }
}

// SANITIZE OPTIONS
function dgts_validate_colors( $input ) {

    $valid = array();
    $valid['dgts_color'] = sanitize_text_field( $input['dgts_color'] );
    
    return $valid;

}