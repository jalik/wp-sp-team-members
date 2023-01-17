<?php

function sptmTeamMembers($posts, $opts)
{
  ob_start();

  if ($opts['showtitle'] > 0) {
    $term = get_term_by('slug', $opts['slug'], 'team');
    echo "<div class='team-name'>$term->name</div>";
  }

  echo "<div class='team'>";
  foreach ($posts as $post) {
    echo sptmMember($post);
  }
  echo "</div>";

  return ob_get_clean();
}
