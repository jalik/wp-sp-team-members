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
