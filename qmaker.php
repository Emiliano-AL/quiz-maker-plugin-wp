<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://habitatweb.mx/
 * @since             1.0.0
 * @package           Qmaker
 *
 * @wordpress-plugin
 * Plugin Name:       Quizzes Maker HW
 * Plugin URI:        https://habitatweb.mx/
 * Description:       Este plugin, sirve para crear Quizes de manera sencilla y concreta
 * Version:           1.0.0
 * Author:            Habitat Web
 * Author URI:        https://habitatweb.mx/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qmaker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $wpdb;
define( 'QM_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'QM_PLUGIN_DIR_PATH', 	plugin_dir_path( __FILE__ ) );
define( 'QM_PLUGIN_DIR_URL', 	plugin_dir_url( __FILE__ ) );
define( 'QM_QUIZ', 			"{$wpdb->prefix}qm_quizes" );
define( 'QM_QUESTION', 		"{$wpdb->prefix}qm_questions" );
define( 'QM_ANSWERS', 		"{$wpdb->prefix}qm_answers" );

define( 'QMAKER_VERSION', '1.0.6' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-qmaker-activator.php
 */
function activate_qmaker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qmaker-activator.php';
	Qmaker_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-qmaker-deactivator.php
 */
function deactivate_qmaker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qmaker-deactivator.php';
	Qmaker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_qmaker' );
register_deactivation_hook( __FILE__, 'deactivate_qmaker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-qmaker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_qmaker() {
	$plugin = new Qmaker();
	$plugin->run();
}
run_qmaker();
