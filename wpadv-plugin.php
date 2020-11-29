<?php
/**
 *  Plugin Name: WordPress Advanced Plugin
 */

if( function_exists('acf_register_block_type') ) {

    function wpadv_register_block () {
        acf_register_block_type(array(
            'name'              => 'meal',
            'title'             => __('Meal'),
            'description'       => __('Search meal by name'),
            'render_template'   => plugin_dir_path(__DIR__).'wpadv-plugin/meal.php',
            'category'          => 'formatting',
            'icon'              => 'carrot',
        ));
        acf_register_block_type(array(
            'name'              => 'area',
            'title'             => __('Area'),
            'description'       => __('Search the area of your favourite meal'),
            'render_template'   => plugin_dir_path(__DIR__).'wpadv-plugin/area.php',
            'category'          => 'formatting',
            'icon'              => 'admin-site-alt',
        ));
    }

    

    add_action( 'acf/init', 'wpadv_register_block' );
}


