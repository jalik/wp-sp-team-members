<?php

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
  return "
    <div class='member-contact-info'>
      <p class='member-email'>
        " . ($post->email ? sptmEmailLink($post->email) : "") . "
      </p>
    </div>";
}

function sptmPhoneLink($phone)
{
  return "<a href='tel:" . cleanPhoneNumber($phone) . "'>" . formatPhoneNumber($phone) . "</a>";
}
