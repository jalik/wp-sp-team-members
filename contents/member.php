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

  $unknown = "<span class='detail-not-applicable' title='" . __('Non renseigné', 'sptm') . "'>" . __('n.r.', 'sptm') . "</span>";

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
        <span>" . __('Fixe', 'sptm') . " :</span>" .
    ($post->phone
      ? "<a href='tel:" . cleanPhoneNumber($post->phone) . "'>" . formatPhoneNumber($post->phone) . "</a>"
      : $unknown
    ) . "
      </div>
      <div class='member-mobile'>
        <span>" . __('Portable', 'sptm') . " :</span>" .
    ($post->mobile
      ? "<a href='tel:" . cleanPhoneNumber($post->mobile) . "'>" . formatPhoneNumber($post->mobile) . "</a>"
      : $unknown
    ) . "
      </div>
      <div class='member-email'>
        <span>" . __('Email', 'sptm') . " :</span>" .
    ($post->email
      ? "<a href='mailto:" . sanitize_email($post->email) . "'>" . formatPhoneNumber($post->email) . "</a>"
      : $unknown
    ) . "
      </div>
		</div>
	</div>
</div>
";
}
