<?php

global $_wp_additional_image_sizes;

function sptmDefaultMemberImg()
{
  $plugin = plugin_basename(SPTM_PLUGIN_FILE);
  $src = plugins_url('images/default-member.svg', $plugin);
  return "<img alt='" . __('default member photo', 'sptm') . "' class='member-photo' src='$src' />";
}

function sptmMember($post, $atts = array())
{
  $opts = array_change_key_case(array_merge(
    array(
      'showcontacts' => 1,
      'showjob' => 1,
    ), $atts
  ));

  $name = formatName($post->post_title);
  $link = get_post_permalink($post);
  $image = get_the_post_thumbnail($post, 'medium', array(
    'class' => 'member-photo'
  ));

  if (!$image) {
    $image = sptmDefaultMemberImg();
  }

  $taxonomies = get_the_terms($post, 'job');
  $job = $taxonomies ? $taxonomies[0]->name : null;

  ob_start();

  print "
<div class='member'>
	<a class='member-header' href='$link'>
		<figure>
			$image
		</figure>
	</a>
	<div class='member-body'>
		<a class='member-name' href='$link'>$name</a>
		<div class='member-details'>";


  if ($opts['showjob'] > 0) {
    print "
      <p class='member-job'>
        $job
      </p>";
  }

  if ($opts['showcontacts'] > 0) {
    print sptmMemberContactInfo($post);
  }
  print "
		</div>
	</div>
</div>
";
  return ob_get_clean();
}
