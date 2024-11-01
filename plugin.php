<?php
/*
Plugin Name: WP Mass Mail
Plugin URI: http://mr.hokya.com/wp-mass-mail
Description: It allows you to send bulk mail messages to multiple commentators addresses at once via DashBoard Menu.
Version: 2.45
Author: Julian Widya Perdana
Author URI: http://mr.hokya.com/
*/

function wp_mass_mail_menu () {
	add_dashboard_page('Mass Mail', 'Mass Mail', 'manage_options','wp-mass-mail/options.php');
}

add_action('admin_menu', 'wp_mass_mail_menu');

?>