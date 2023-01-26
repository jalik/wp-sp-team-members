<?php

/*
Plugin Name: Team Members
Plugin URI:
Description: Show your teams and members.
Version: 1.1.0
Author: SIGMA POLYNESIA (Karl STEIN)
Author URI: https://www.sigmapolynesia.com
License: MIT
*/

defined('ABSPATH') || die();

define('SPTM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SPTM_PLUGIN_FILE', __FILE__);

include_once 'include/functions.php';
include_once 'include/customize.php';
include_once 'include/load.php';
include_once 'include/metaboxes.php';
include_once 'include/post-types.php';
include_once 'include/shortcodes.php';
include_once 'include/taxonomies.php';
include_once 'contents/common.php';
include_once 'contents/member.php';
include_once 'contents/team.php';
