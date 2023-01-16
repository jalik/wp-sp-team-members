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

function sptmPhoneLink($phone)
{
  return "<a href='tel:" . cleanPhoneNumber($phone) . "'>" . formatPhoneNumber($phone) . "</a>";
}
