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
  $email = get_post_meta($post->ID, 'email', true);
  $mobile = get_post_meta($post->ID, 'mobile', true);
  $phone = get_post_meta($post->ID, 'phone', true);
  echo '
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
  if (isset($_POST['email'])) {
    update_post_meta($postId, 'email', esc_html($_POST['email']));
  }
  if (isset($_POST['mobile'])) {
    update_post_meta($postId, 'mobile', esc_html($_POST['mobile']));
  }
  if (isset($_POST['phone'])) {
    update_post_meta($postId, 'phone', esc_html($_POST['phone']));
  }
}

add_action('save_post', 'sptmSaveMemberMetas');
