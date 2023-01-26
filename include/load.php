<?php

function sptmGetTermBySlug($slug, $taxonomy)
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

function loadPosts($posts)
{
  foreach ($posts as $post) {
    $lang = strtolower(substr(sanitize_text_field($post['tax_input']['language']), 0, 2));
    $title = sanitize_text_field($post['post_title']);
    $post['post_name'] = !empty($post['post_name'])
      ? sanitize_title($post['post_name'])
      : sanitize_title($title) . "-$lang";

    $record = get_page_by_path($post['post_name'], ARRAY_A, $post['post_type']);

    $taxonomies = array();

    foreach ($post['tax_input'] as $taxonomy => $term) {
      clean_taxonomy_cache($taxonomy);

      if ($taxonomy != 'language') {
        // Do not append language if term is in the default language.
        if (function_exists('pll_default_language') && pll_default_language() == $lang) {
          $slug = sanitize_title($term);
        } else {
          $slug = sanitize_title("$term-$lang");
        }

        // Check if term exists.
        $wpTerm = sptmGetTermBySlug($slug, $taxonomy);

        if ($wpTerm) {
          // Replace term name by its id.
          $taxonomies[$taxonomy] = array($wpTerm->term_id);
        } else {
          // Create term.
          $result = wp_insert_term($term, $taxonomy, array('slug' => $slug));
          $taxonomies[$taxonomy] = array($result['term_id']);

          foreach ($taxonomies[$taxonomy] as $termId) {
            // Set term language using polylang.
            if (function_exists('pll_set_term_language')) {
              pll_set_term_language($termId, $lang);
            }
          }
        }
      }

      unset($post['tax_input'][$taxonomy]);
    }

    $recordId = null;

    // Create or update member.
    if ($record) {
      $recordId = $record['ID'];
      wp_update_post(array_merge(array('ID' => $recordId), $post));
    } else {
      $recordId = wp_insert_post($post);

      // Set post language using polylang.
      if ($recordId && function_exists('pll_set_post_language')) {
        pll_set_post_language($recordId, $lang);
      }
    }

    // Set post terms.
    foreach ($taxonomies as $taxonomy => $terms) {
      wp_set_object_terms($recordId, $terms, $taxonomy);
    }

    // Set post featured image.
    if (isset($post['image']) && is_string($post['image'])) {
      $filename = basename($post['image']);
      $mediaSlug = preg_replace('/.[a-zA-Z0-9]{1,4}$/', '', sanitize_title($filename));
      $media = get_attachment_by_name($mediaSlug);

      if (empty($media)) {
        $imageId = media_sideload_image($post['image'], $recordId, null, 'id');
      } else {
        $imageId = $media->ID;
      }
      if (is_int($imageId)) {
        set_post_thumbnail($recordId, $imageId);
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
    loadPosts($json['members']);
  }
}

add_action('admin_init', 'sptmLoadJSONFile');
