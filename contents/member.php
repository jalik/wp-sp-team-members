<?php

global $_wp_additional_image_sizes;

function sptmMember($post)
{
  $name = formatName($post->post_title);
  $link = get_post_permalink($post);
  $image = get_the_post_thumbnail($post, 'medium', array(
    'class' => 'member-photo'
  ));

  $taxonomies = get_the_terms($post, 'job');
  $job = $taxonomies ? $taxonomies[0]->name : null;

  return "
<div class='member'>
	<a class='member-header' href='$link'>
		<figure>
			$image
		</figure>
	</a>
	<div class='member-body'>
		<a class='member-name' href='$link'>$name</a>
		<div class='member-details'>
            <div class='member-job'>
                $job
            </div>
            <div class='member-phone'>
                <span>Fixe :</span>
                <a href='tel:" . cleanPhoneNumber($post->phone) . "'>"
    . formatPhoneNumber($post->phone) .
    "</a>
            </div>
            <div class='member-mobile'>
                <span>Portable :</span>
                <a href='tel:" . cleanPhoneNumber($post->mobile) . "'>"
    . formatPhoneNumber($post->mobile) .
    "</a>
            </div>
            <div class='member-email'>
                <span>Email :</span>
                <a href='mailto:" . sanitize_email($post->email) . "'>"
    . formatPhoneNumber($post->email) .
    "</a>
            </div>
		</div>
	</div>
</div>
";
}
