<?php

function sptmRegisterPostTypes()
{
  $labels = array(
    'name' => __('Membre', 'sptm'),
    'all_items' => __('Tous les membres', 'sptm'),
    'singular_name' => __('Membre', 'sptm'),
    'add_new_item' => __('Ajouter un membre', 'sptm'),
    'edit_item' => __('Modifier le membre', 'sptm'),
    'menu_name' => __('Membres', 'sptm')
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => true,
    'delete_with_user' => false,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-groups',
    'supports' => array(
      'title',
      'thumbnail',
      'excerpt',
      'revisions',
      'custom-fields',
      'page-attributes',
      'editor'
    ),
    'taxonomies' => array('team', 'job')
  );

  register_post_type('member', $args);
}

add_action('init', 'sptmRegisterPostTypes');
