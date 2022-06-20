<?php
function songs_create_post_type()
{
    $labels2 = array(
        'name' => __('Languages'),
        'singular_name' => __('Language'),
        'search_items' => __('Search Languages'),
        'all_items' => __('All Languages'),
        'parent_item' => __('Languages'),
        'parent_item_colon' => __('Language:'),
        'edit_item' => __('Edit Language'),
        'update_item' => __('Update Language'),
        'add_new_item' => __('New Language'),
        'new_item_name' => __('New Language'),
        'menu_name' => __('Languages'),
    );
    register_taxonomy(
        'song-language',
        'songs',
        array(
            'labels' => $labels2,
            'rewrite' => array(
                'slug' => 'song-language'
            ),
            'hierarchical' => true,
            'sort' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
            'show_tagcloud' => true,
            'public' => true,
            //'query_var'=>'branche_name',
            'show_in_quick_edit' => true,
            'capabilities' => array(
                'manage_terms' => 'manage_languages',
                'edit_terms' => 'manage_languages',
                'delete_terms' => 'manage_languages',
                'assign_terms' => 'manage_languages'
            ),
        )
    );

    $labels = array(
        'name' => 'Songs',
        'singular_name' => 'Song',
        'menu_name' => 'Songs',
        'name_admin_bar' => 'Song',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Song',
        'new_item' => 'New Song',
        'edit_item' => 'Edit Song',
        'view_item' => 'View Song',
        'all_items' => 'All Songs',
        'search_items' => 'Search Songs',
        'parent_item_colon' => 'Parent Songs:',
        'not_found' => 'No Song found.',
        'not_found_in_trash' => 'No Song found in Trash.'
    );
    register_post_type('songs',
        array(
            'labels' => $labels,
            'supports' => array( 'title', 'editor','page-attributes' ),
            'menu_icon' => 'dashicons-media-audio',
            'taxonomies' => array( 'song-language' ),
            'hierarchical' => false,
            'public' => true,
            //'rewrite' => false,
            'rewrite' => [
                'slug' => '/songbook',
                'with_front' => false
            ],
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capabilities' => array(
                'edit_post' => 'edit_songs',
                'read_post' => 'read_songs',
                'delete_post' => 'delete_songs',
                'edit_posts' => 'edit_songs',
                'edit_others_posts' => 'edit_others_songs',
                'publish_posts' => 'publish_songs',
                'read_private_posts' => 'read_private_songs',
                'create_posts' => 'edit_songs',
                'edit_published_posts' => 'edit_published_songs',
                'edit_private_posts' => 'edit_private_songs',
            ),
        )
    );
}

function songs_meta_box_add()
{
    add_meta_box("songs_meta", "Song data", "songs_meta", "songs", "normal", "high");
}

function songs_meta()
{
    global $post;
    $custom = get_post_custom($post->ID);

    $artist = $custom["artist"][0];
    $refrain = $custom["refrain"][0];
    $melodie = $custom["melodie"][0];
    $arrangedby = $custom["arrangedby"][0];
    $text = $custom["text"][0];

    echo "<table>";
    echo "<tr><td><label class=\"cw_label\" for=\"txtArtist\">Artist</label></td>
				<td><input name=\"artist\" id=\"txtArtist\" type=\"text\" value=\"$artist\" class=\"cw_value\" />
				</td></tr>";
    echo "<tr><td><label class=\"cw_label\" for=\"txtMelodie\">Melodie</label></td>
				<td><input name=\"melodie\" id=\"txtMelodie\" type=\"text\" value=\"$melodie\" class=\"cw_value\" />
				</td></tr>";
    echo "<tr><td><label class=\"cw_label\" for=\"txtArrangedBy\">Arranged By</label></td>
				<td><input name=\"arrangedby\" id=\"txtArrangedBy\" type=\"text\" value=\"$arrangedby\" class=\"cw_value\" />
				</td></tr>";
    echo "<tr><td><label class=\"cw_label\" for=\"txtText\">Text</label></td>
				<td><input name=\"text\" id=\"txtText\" type=\"text\" value=\"$text\" class=\"cw_value\" />
				</td></tr>";
    echo "<tr><td><label class=\"cw_label\" for=\"txtRefrain\">Refrain</label></td>
			  <td><textarea name=\"refrain\" id=\"txtRefrain\" cols='150' rows='10' class=\"cw_value\" />$refrain</textarea></td>
				</tr>";
    echo "</table>";

}

function songs_save_song()
{
    global $post;
    date_default_timezone_set('Europe/Brussels');
    if ( isset($_POST['post_type']) && $_POST['post_type'] == 'songs' )
    {
        update_post_meta($post->ID, "artist", $_POST["artist"]);
        update_post_meta($post->ID, "refrain", $_POST["refrain"]);
        update_post_meta($post->ID, "melodie", $_POST["melodie"]);
        update_post_meta($post->ID, "arrangedby", $_POST["arrangedby"]);
        update_post_meta($post->ID, "text", $_POST["text"]);
        /*remove_action('save_post', 'songs_save_song');
        $title = $_POST["surname"] . " " . $_POST["firstname"];
        $post_id = wp_update_post(array( "ID" => $post->ID, "post_title" => $title, "post_name" => sanitize_title($title) ), true);
        add_action('save_post', 'songs_save_song');*/
    }
}


function tn_disable_visual_editor( $can ) {
    global $post;
    if ( "songs" == $post->post_type )
        return false;
    return $can;
}
add_filter( 'user_can_richedit', 'tn_disable_visual_editor' );
add_action('init', 'songs_create_post_type');
add_action('save_post', 'songs_save_song');
add_action('add_meta_boxes', 'songs_meta_box_add');

function songs_filter_content($content)
{
    global $post;
    if ( "songs" !== $post->post_type )
        return $content;

    $custom = get_post_custom($post->ID);
    $artist = $custom["artist"][0];
    $refrain = $custom["refrain"][0];
    $melodie = $custom["melodie"][0];
    $arrangedby = $custom["arrangedby"][0];
    $text = $custom["text"][0];

    $songpart = $post->post_content;

    $songpart = "<div class='songs_line'>".str_replace("\n","&nbsp;</div>\n<div class='songs_line'>",$songpart)."</div>";

    $songpart = preg_replace("/%refrain%/","</div><div class='songs_refrain'>".str_replace("\n","</div><div class='songs_refrain'>",$refrain)."</div><div class='songs_line'>",$songpart);

    $songpart = preg_replace_callback("/\/\/(.*)$/m",function ($found) {
        return "<div class='songs_refrain'>".substr(rtrim($found[0]),2,strlen($found[0])-2)."</div>";
    },$songpart);

    $song_meta = "<div class='songs_meta_envelope'>";
    if ( trim($artist) != "" )
        $song_meta .= "    <div class='songs_meta_line'><span class='songs_meta_line_label'>Artist: </span>$artist</div>";
    if ( trim($melodie) != "" )
        $song_meta .= "    <div class='songs_meta_line'><span class='songs_meta_line_label'>Melody: </span>$melodie</div>";
    if ( trim($arrangedby) != "" )
        $song_meta .= "    <div class='songs_meta_line'><span class='songs_meta_line_label'>Arranged by: </span>$arrangedby</div>";
    if ( trim($text) != "" )
        $song_meta .= "    <div class='songs_meta_line'><span class='songs_meta_line_label'>Text: </span>$text</div>";

    $song_meta .= "   </div>";

    return "$song_meta<div class='songs_content'>".$songpart."</div>";

}
add_filter('the_content','songs_filter_content');