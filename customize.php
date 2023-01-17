<?php

function sptmCustomizeTheContent($content)
{
  if (is_single() && get_post_type() == 'member') {
    // Load styles.
    sptmEnqueueStyles();

    $post = get_post();
    $terms = get_the_terms($post, 'job');
    foreach ($terms as $term) {
      $job = $term->name;
    }

    // Append member details.
    return "
      $content
      <p class='member-job'>$job</p>
      " . sptmMemberContactInfo($post);
  }
  return $content;
}

add_filter('the_content', 'sptmCustomizeTheContent');
