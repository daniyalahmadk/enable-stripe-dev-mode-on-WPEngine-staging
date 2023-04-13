<?php
/*
Plugin Name: Stripe Disable On WPEngine Staging
Plugin URI: https://www.fusefloat.com
Description: This plugin will automatically enable the Stripe test mode on WPEngine when it is deployed on the staging site.
Version: 1.0
Author: Daniyal Ahmed
Author URI: https://www.fusefloat.com/
License: GNU General Public License v3.0
License URI: http://www.opensource.org/licenses/gpl-license.php
NOTE: This plugin is released under the GPLv2 license. The icons used in this plugin are the property
of their respective owners, and do not, necessarily, inherit the GPLv2 license.
*/
/**
 * 
 * Main Detector
 * 
 * */
require_once('inc/main.php');
/**
 * 
 * Options Page
 * 
 * **/
require_once('inc/options.php');