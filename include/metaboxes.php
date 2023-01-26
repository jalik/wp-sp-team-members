<?php

function sptmMetaBoxesSetup()
{
  add_meta_box(
    'member_contact_info',
    __('Informations de contact', 'sptm'),
    'sptmMemberContactInfoMetaBox',
    'member',
    'side'
  );
}

add_action('add_meta_boxes', 'sptmMetaBoxesSetup');

function sptmMemberContactInfoMetaBox($post)
{
  $civility = get_post_meta($post->ID, 'civility', true);
  $email = get_post_meta($post->ID, 'email', true);
  $mobile = get_post_meta($post->ID, 'mobile', true);
  $phone = get_post_meta($post->ID, 'phone', true);
  echo '
<p>
  <label for="member_civility">' . __('Civilité', 'sptm') . ' :</label>
  <input id="member_civility" type="text" name="civility" value="' . sanitize_text_field($civility) . '" />
</p>
<p>
  <label for="member_email">' . __('Email', 'sptm') . ' :</label>
  <input id="member_email" type="text" name="email" value="' . sanitize_text_field($email) . '" />
</p>
<p>
  <label for="member_mobile">' . __('Mobile', 'sptm') . ' :</label>
  <input id="member_mobile" type="text" name="mobile" value="' . sanitize_text_field($mobile) . '" />
</p>
<p>
    <label for="member_phone">' . __('Téléphone', 'sptm') . ' :</label>
    <input id="member_phone" type="text" name="phone" value="' . sanitize_text_field($phone) . '" />
</p>';
}

function sptmSaveMemberMetas($postId)
{
  if (isset($_POST['civility'])) {
    update_post_meta($postId, 'civility', sanitize_text_field($_POST['civility']));
  }
  if (isset($_POST['email'])) {
    update_post_meta($postId, 'email', sanitize_email($_POST['email']));
  }
  if (isset($_POST['mobile'])) {
    update_post_meta($postId, 'mobile', sanitize_text_field($_POST['mobile']));
  }
  if (isset($_POST['phone'])) {
    update_post_meta($postId, 'phone', sanitize_text_field($_POST['phone']));
  }
}

add_action('save_post', 'sptmSaveMemberMetas');
