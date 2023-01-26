<?php

function cleanPhoneNumber($number)
{
  return preg_replace('/\D/', '', "$number");
}

function formatName($lastName)
{
  return sanitize_text_field($lastName);
}

function formatPhoneNumber($number)
{
  return sanitize_text_field($number);
}

function sptmEnqueueStyles()
{
  $plugin = plugin_basename(SPTM_PLUGIN_FILE);
  wp_enqueue_style('sptm-styles', plugins_url('styles.css', $plugin), array(), '1.0.1');
}

if (!function_exists('get_attachment_by_name')) {
  function get_attachment_by_name($name)
  {
    $query = new WP_Query(array(
      'posts_per_page' => 1,
      'post_type' => 'attachment',
      'name' => $name,
    ));
    return $query->post;
  }
}
