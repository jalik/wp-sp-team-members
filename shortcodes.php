<?php

function sptmTeamMembersShortcode($atts = array(), $content = null, $tag = '')
{
  wp_enqueue_style('sptm-styles', plugins_url('styles.css', __FILE__));

  // Get members in the team.
  $posts = get_posts(array(
    'posts_per_page' => 10,
    'post_type' => 'member',
    'order' => 'ASC',
    'orderby' => 'title',
    'tax_query' => array(
      array(
        'taxonomy' => 'team',
        'field' => 'slug',
        'terms' => $atts['team']
      )
    )
  ));

  return sptmTeamMembers($posts);
}

add_shortcode('sptm_members', 'sptmTeamMembersShortcode');

// todo shortcode pour récupérer un membre
