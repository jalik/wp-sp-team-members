<?php

function sptmTeamMembersShortcode($atts = array(), $content = null, $tag = '')
{
  wp_enqueue_style('sptm-styles', plugins_url('styles.css', __FILE__));

  $opts = shortcode_atts(
    array(
      'team' => null,
      'offset' => 0,
      'limit' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
    ), $atts, 'sptm_members'
  );

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
        'terms' => esc_sql($opts['team'])
      )
    )
  ));

  return sptmTeamMembers($posts);
}

add_shortcode('sptm_members', 'sptmTeamMembersShortcode');

// todo shortcode pour récupérer un membre
