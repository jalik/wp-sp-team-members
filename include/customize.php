<?php

function sptmCustomizeTheContent($content)
{
  if (is_single() && get_post_type() == 'member') {
    // Load styles.
    sptmEnqueueStyles();

    $post = get_post();
    $terms = get_the_terms($post, 'job');
    $job = null;

    foreach ($terms as $term) {
      $job = $term->name;
    }

    ob_start();

    // Append member details.
    print $content;
    print "<p class='member-job'>$job</p>";

    print "<div class='member-contact-info'>";

    if ($post->mobile) {
      print "<p class='member-mobile' title=''>
      " . sptmLabel(__('Portable', 'sptm'))
        . sptmPhoneLink($post->mobile) . "
      </p>";
    }
    if ($post->phone) {
      print "<p class='member-phone'>
      " . sptmLabel(__('Fixe', 'sptm'))
        . sptmPhoneLink($post->phone) . "
      </p>";
    }
    if ($post->email) {
      print "<p class='member-email'>
      " . sptmLabel(__('Email', 'sptm'))
        . sptmEmailLink($post->email) . "
      </p>";
    }
    print "</div>";
    return ob_get_clean();
  }
  return $content;
}

add_filter('the_content', 'sptmCustomizeTheContent');
