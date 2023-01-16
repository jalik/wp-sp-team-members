<?php

function sptmTeamMembers($posts)
{
  ob_start();

  echo "<div class='team'>";
  foreach ($posts as $post) {
    echo sptmMember($post);
  }
  echo "</div>";

  return ob_get_clean();
}
