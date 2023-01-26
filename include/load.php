<?php

function sptm_get_term_by_slug($slug, $taxonomy)
{
  $query = new WP_Term_Query(array(
    'slug' => $slug,
//    'taxonomy' => $taxonomy,
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
  ));
  $terms = $query->get_terms();
  return sizeof($terms) > 0 ? $terms[0] : null;
}

function sptm_load_posts($posts = array())
{
  foreach ($posts as $post) {
    $lang = strtolower(substr(sanitize_text_field($post['tax_input']['language']), 0, 2));
    $title = sanitize_text_field($post['post_title']);
    $post['post_name'] = sanitize_title($title) . "-$lang";

    $taxonomies = array();

    foreach ($post['tax_input'] as $taxonomy => $term) {
      if ($taxonomy != 'language') {
        // Check if term exists.
        $term_slug = sanitize_title("$term-$lang");
        $db_term = sptm_get_term_by_slug($term_slug, $taxonomy);

        if ($db_term) {
          $taxonomies[$taxonomy] = array($db_term->term_id);
        }
        unset($post['tax_input'][$taxonomy]);
      }
    }

    $record = get_page_by_path($post['post_name'], ARRAY_A, $post['post_type']);
    $record_id = null;

    // Create or update member.
    if ($record) {
      $record_id = $record['ID'];
      wp_update_post(array_merge(array('ID' => $record_id), $post));
    } else {
      $record_id = wp_insert_post($post);
    }

    // Set post language using polylang.
    if ($record_id && function_exists('pll_set_post_language')) {
      pll_set_post_language($record_id, $lang);
    }

    // Set post translations using polylang.
    if (function_exists('pll_default_language') && pll_default_language() != $lang
      && function_exists('pll_get_post_translations')
      && function_exists('pll_save_post_translations')) {
      // Get post in default language.
      $original_member = get_member_by_name(sanitize_title($title) . "-" . pll_default_language());

      // Prepare post translations.
      $translations = array();

      if ($original_member) {
        $translations = pll_get_post_translations($original_member->ID);
      }
      $translations = array_merge($translations, array($lang => $record_id));

      // Save post translations.
      pll_save_post_translations($translations);
    }

    // Set post terms.
    foreach ($taxonomies as $taxonomy => $terms) {
      wp_set_object_terms($record_id, $terms, $taxonomy);
    }

    // Set post featured image.
    if (isset($post['image']) && is_string($post['image'])) {
      $filename = basename($post['image']);
      $mediaSlug = preg_replace('/.[a-zA-Z0-9]{1,4}$/', '', sanitize_title($filename));
      $media = get_attachment_by_name($mediaSlug);

      if (empty($media)) {
        $imageId = media_sideload_image($post['image'], $record_id, null, 'id');
      } else {
        $imageId = $media->ID;
      }
      if (is_int($imageId)) {
        set_post_thumbnail($record_id, $imageId);
      }
    }
  }
}

function sptm_load_terms($terms = array())
{
  foreach ($terms as $taxonomy => $translations) {
    foreach ($translations as $trans) {
      $list = array();

      foreach ($trans as $lang => $term) {
        $slug = sanitize_title("$term-$lang");
        $db_term = sptm_get_term_by_slug($slug, $taxonomy);

        // Create or load term.
        if (!$db_term) {
          $result = wp_insert_term($term, $taxonomy, array('slug' => $slug));
          $term_id = $result['term_id'];
        } else {
          $term_id = $db_term->term_id;
        }

        $list[$lang] = $term_id;

        // Set term language using polylang.
        if (function_exists('pll_set_term_language')) {
          pll_set_term_language($term_id, $lang);
        }
      }

      // Save term translations.
      if (sizeof($list) > 0) {
        if (function_exists('pll_save_term_translations')) {
          pll_save_term_translations($list);
        }
      }
    }
  }
}

function sptmLoadJSONFile()
{
  $file = path_join(SPTM_PLUGIN_DIR, "data.json");

  if (file_exists($file)) {
    $content = file_get_contents($file);
    $json = json_decode($content, true);

    if (isset($json['terms']) && is_array($json['terms'])) {
      sptm_load_terms($json['terms']);
    }
    if (isset($json['members']) && is_array($json['members'])) {
      sptm_load_posts($json['members']);
    }
  }
}

add_action('admin_init', 'sptmLoadJSONFile');
