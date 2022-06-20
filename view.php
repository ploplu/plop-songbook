<?php

//add_image_size( 'admin-list-thumb', 80, 80, false );
add_action("manage_posts_custom_column",  "songs_custom_columns");
add_filter("manage_edit-songs_columns", "songs_edit_columns");
add_filter( 'manage_edit-songs_sortable_columns', 'songs_sortable' );

function songs_sortable( $cols ) {
    $cols['title']='Title';
    $cols['artist']='Artist';
    $cols['languages']='Languages';
    $cols['melodie']='Melody';
    $cols['text']='Text';
    $cols['arrangedby']='Arrangedby';
    return $cols;
}
function songs_edit_columns($columns){
    $columns = array(
        "cb" => "cb2",
        "title" => "Title",
        "artist"=>"Artist",
        "languages"=>"Languages",
        "melodie"=>"Melody",
        "text"=>"Text",
        "arrangedby"=>"Arrangedby"
    );
    return $columns;
}
function songs_custom_columns($column){
    global $post;

    $custom = get_post_custom();
    switch ($column) {
        case "cb":
            echo "<input type=\"checkbox\" />";
            break;
        case "artist":
            echo $custom["artist"][0];
            break;
        case "languages":
            $l= get_the_term_list($post->ID, 'song-language', '', ', ','');
            echo (($l=="")?"keng":$l);
            break;
        case "melodie":
            echo $custom["melodie"][0];
            break;
        case "text":
            echo $custom["text"][0];
            break;
        case "arrangedby":
            echo $custom["arrangedby"][0];
            break;

    }
}

