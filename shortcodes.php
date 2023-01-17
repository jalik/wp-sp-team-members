<?php

function sptmTeamShortcode($atts = array(), $content = null, $tag = '')
{
  wp_enqueue_style('sptm-styles', plugins_url('styles.css', __FILE__));

  $opts = array_change_key_case(shortcode_atts(
    array(
      'showtitle' => 1,
      'showcontacts' => 1,
      'showjob' => 1,
      'slug' => null,
      'offset' => 0,
      'limit' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    ), $atts, $tag
  ));

  // Get members in the team.
  $posts = get_posts(array(
    'post_type' => 'member',
    'posts_per_page' => esc_sql($opts['limit']),
    'offset' => esc_sql($opts['offset']),
    'orderby' => esc_sql($opts['orderby']),
    'order' => esc_sql($opts['order']),
    'tax_query' => array(
      array(
        'taxonomy' => 'team',
        'field' => 'slug',
        'terms' => esc_sql($opts['slug'])
      )
    )
  ));

  return sptmTeamMembers($posts, $opts);
}

add_shortcode('sptm_team', 'sptmTeamShortcode');


// todo shortcode pour récupérer un membre
