<?php

function sptmTeamMembers($posts, $atts = array())
{
  $opts = array_change_key_case(array_merge(
    array(
      'showtitle' => 1,
      'slug' => null,
    ), $atts
  ));

  ob_start();

  if ($opts['showtitle'] > 0) {
    $term = get_term_by('slug', $opts['slug'], 'team');
    echo "<div class='team-name'>$term->name</div>";
  }

  echo "<div class='team'>";
  foreach ($posts as $post) {
    echo sptmMember($post, $opts);
  }
  echo "</div>";

  return ob_get_clean();
}
