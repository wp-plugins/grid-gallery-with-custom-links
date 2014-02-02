<?php
/**
 * Load scripts, styles and icons
*/
if ( ! defined( 'ABSPATH' ) ) exit;

function abcfggcl_enq_scripts() {
    wp_register_script( 'ggcl-equal-heights-js', ABCFGGCL_PLUGIN_URL . 'js/abcf-ehs-min-02.js', array( 'jquery' ), ABCFGGCL_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'abcfggcl_enq_scripts' );

function abcfggcl_enq_styles() {
    wp_register_style('ggcl-style', ABCFGGCL_PLUGIN_URL . 'css/grid-gallery-with-custom-links.css', array(), ABCFGGCL_VERSION, 'all');
    wp_enqueue_style('ggcl-style');
}

add_action( 'wp_enqueue_scripts', 'abcfggcl_enq_styles', 10000 );

function abcfggcl_enq_admin_style() {
    wp_register_style('ggcl-admin', ABCFGGCL_PLUGIN_URL . 'css/admin.css', ABCFGGCL_VERSION, 'all');
    wp_enqueue_style('ggcl-admin');
}
add_action( 'admin_enqueue_scripts', 'abcfggcl_enq_admin_style', 100 );

function abcfggcl_add_plugin_icons() {
    $icon_url = ABCFGGCL_PLUGIN_URL . 'images/icon_32x32.png';?>
<style type="text/css" media="screen">
    #icon-abcfggcl_menu.icon32-posts-abcfggcl_post_type { background:transparent url( "<?php echo $icon_url; ?>" ) no-repeat 0px 0px !important;}
    #icon-edit.icon32-posts-abcfggcl_post_type { background:transparent url( "<?php echo $icon_url; ?>" ) no-repeat 0px 0px !important;}
</style><?php
}
add_action( 'admin_head', 'abcfggcl_add_plugin_icons' );