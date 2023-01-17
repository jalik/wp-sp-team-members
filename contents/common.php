<?php

function sptmDetailUnknown()
{
  return "<span class='detail-not-applicable' title='"
    . __('Non renseigné', 'sptm') . "'>"
    . __('n.r.', 'sptm') . "</span>";
}

function sptmEmailLink($email)
{
  $sanitizedEmail = sanitize_email($email);
  return "<a href='mailto:$sanitizedEmail'>$sanitizedEmail</a>";
}

function sptmLabel($label)
{
  return "<span>" . esc_html($label) . " :</span>";
}

function sptmMemberContactInfo($post)
{
  $unknown = sptmDetailUnknown();
  return "
    <div class='member-contact-info'>
      <p class='member-mobile'>
        " . sptmLabel(__('Portable', 'sptm')) .
    ($post->mobile ? sptmPhoneLink($post->mobile) : $unknown) . "
      </p>
      <p class='member-phone'>
        " . sptmLabel(__('Fixe', 'sptm')) .
    ($post->phone ? sptmPhoneLink($post->phone) : $unknown) . "
      </p>
      <p class='member-email'>
        " . sptmLabel(__('Email', 'sptm')) .
    ($post->email ? sptmEmailLink($post->email) : $unknown) . "
      </p>
    </div>";
}

function sptmPhoneLink($phone)
{
  return "<a href='tel:" . cleanPhoneNumber($phone) . "'>" . formatPhoneNumber($phone) . "</a>";
}
