<?php
/**
 * Plugin Name: BMI Calculate Pro
 * Description: A comprehensive BMI calculator plugin with advanced features.
 * Version: 1.0.0
 * Author: Salim Moustanir
 * Text Domain: bmi-pro
 * Domain Path: /languages
 */

// Security: Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants
define( 'BMI_PRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BMI_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin textdomain.
 */
function bmi_pro_load_textdomain() {
    load_plugin_textdomain( 'bmi-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'bmi_pro_load_textdomain' );

/**
 * Enqueue scripts and styles.
 */
function bmi_pro_enqueue_scripts() {
    // Enqueue CSS
    wp_enqueue_style( 'bmi-pro-style', BMI_PRO_PLUGIN_URL . 'assets/css/style.css', array(), '1.0.0' );

    // Enqueue JavaScript
    wp_enqueue_script( 'bmi-pro-scripts', BMI_PRO_PLUGIN_URL . 'assets/js/scripts.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'bmi-ajax', BMI_PRO_PLUGIN_URL . 'assets/js/bmi-ajax.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'bmi-gauge-js', BMI_PRO_PLUGIN_URL . 'assets/js/bmi-gauge.js', array('jquery'), '1.0.0', true );

  $localized_data = array(
    'ajax_url' => admin_url( 'admin-ajax.php' ),
    'nonce'    => wp_create_nonce( 'bmi_ajax_nonce' ), // Corrected nonce name
);
  wp_localize_script( 'bmi-ajax', 'bmi_ajax_obj', $localized_data );
}
add_action( 'wp_enqueue_scripts', 'bmi_pro_enqueue_scripts' );

/**
 * Create database table on plugin activation.
 */
function bmi_pro_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bmi_pro_data';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(255) NOT NULL,
        age smallint NOT NULL,
        gender varchar(50) NOT NULL,
        height smallint NOT NULL,
        weight smallint NOT NULL,
        fitness_goal varchar(255) NOT NULL,
        calories_per_day smallint NOT NULL,
        diet_preference varchar(255) NOT NULL,
        activity_level varchar(255) NOT NULL,
        gym_sessions_per_week smallint NOT NULL,
        time_in_gym smallint NOT NULL,
        hours_of_sleep smallint NOT NULL,
        emotional_state text NOT NULL,
        bmi float NOT NULL,
        bfp float NULL,
        bmr float NULL,
        ideal_weight varchar(50) NULL,
        recommendations text NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'bmi_pro_create_table' );

/**
 * Shortcode for displaying the BMI calculator form.
 */
function bmi_pro_calculator_shortcode() {
    ob_start();
    include( BMI_PRO_PLUGIN_DIR . 'templates/user-form.php' );
    return ob_get_clean();
}
add_shortcode( 'bmi_calculator', 'bmi_pro_calculator_shortcode' );

/**
 * Shortcode for displaying the results page.
 */
function bmi_pro_results_shortcode() {
    ob_start();
    include( BMI_PRO_PLUGIN_DIR . 'templates/results-page.php' );
    return ob_get_clean();
}
add_shortcode( 'bmi_results', 'bmi_pro_results_shortcode' );

// Include necessary files
require_once BMI_PRO_PLUGIN_DIR . 'includes/calculator-functions.php';
require_once BMI_PRO_PLUGIN_DIR . 'includes/form-handler.php';
require_once BMI_PRO_PLUGIN_DIR . 'includes/admin-settings.php';
require_once BMI_PRO_PLUGIN_DIR . 'includes/dashboard-analytics.php';
require_once BMI_PRO_PLUGIN_DIR . 'includes/user-settings.php';
require_once BMI_PRO_PLUGIN_DIR . 'includes/fitbit-integration.php';
require_once BMI_PRO_PLUGIN_DIR . 'includes/ai-handler.php';

// Add admin menu and dashboard widget
add_action( 'admin_menu', 'bmi_pro_add_admin_menu' );
add_action( 'wp_dashboard_setup', 'bmi_pro_add_dashboard_widget' );
?>
