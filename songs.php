<?php
/*
Plugin Name: Plop Songbook
Plugin URI: https://diekirch.lgs.lu
Description: None
Author: Pol Wagner
Version: 2022.06.20.04
Author URI: https://diekirch.lgs.lu
*/
$dir = plugin_dir_url(__FILE__);
$dir2 = plugin_dir_path(__FILE__);

add_action('init', 'custom_songs_css');
/*add_action('admin_print_styles-post.php', 'custom_songs_css');
add_action('admin_print_styles-post-new.php', 'custom_songs_css');*/

function custom_songs_css() {
    //if (isset($_REQUEST["post_type"]) && $_REQUEST["post_type"]=="coworkers")
    {
        $dir = plugin_dir_url(__FILE__);
        wp_enqueue_style("songs_style", $dir . "style.css");
    }
}


include("{$dir2}post.php");
include("{$dir2}shortcode.php");
include("{$dir2}view.php");