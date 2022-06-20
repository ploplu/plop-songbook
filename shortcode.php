<?php

function songs_list_songs()
{
    $retu = "";
    $terms = get_terms( array(
        'taxonomy' => 'song-language',
        'hide_empty' => false,
        'orderby'        => 'slug',
    ) );
    foreach ( $terms as $term )
    {
        $retu .= "<div class='songs_list_language_title'><img
  src=\"".plugin_dir_url(__FILE__)."/pix/".substr($term->slug,2).".png\"
  width=\"30\"> $term->name</div>";
        $query = new WP_Query(array(
            'post_type' => 'songs',
            'posts_per_page' => 1000,
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => array( array(
                                      'taxonomy' => 'song-language',
                                      'field' => 'slug',
                                      'terms' => $term->slug
                                  ))
        ));

        $retu .= "<div class='songs_list_title_envelope'>";
        while ( $query->have_posts() )
        {
            $query->the_post();
            $name = get_the_title();
            $link = get_the_permalink();
            $retu .= "<div class='songs_list_title'><a href='{$link}'>{$name}</a></div>";
        }
        $retu .= "</div>";

    }
    return $retu;
}

add_shortcode( "songs_list_songs", "songs_list_songs" );


