<?php

function sptmRegisterTaxonomies()
{
  $job = array(
    'labels' => array(
      'name' => __('Poste', 'sptm'),
      'new_item_name' => __('Nom du poste', 'sptm'),
      'add_new_item' => __('Ajouter un poste', 'sptm'),
    ),
    'public' => true,
    'show_in_rest' => true,
    'hierarchical' => true,
  );

  register_taxonomy('job', 'member', $job);

  $team = array(
    'labels' => array(
      'name' => __('Équipe', 'sptm'),
      'new_item_name' => __('Nom de l\'équipe', 'sptm'),
      'add_new_item' => __('Ajouter une équipe', 'sptm'),
      'parent_item' => __('Équipe parente', 'sptm'),
    ),
    'public' => true,
    'show_in_rest' => true,
    'hierarchical' => true,
  );

  register_taxonomy('team', 'member', $team);
}

add_action('init', 'sptmRegisterTaxonomies');
