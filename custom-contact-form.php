<?php
/*
Plugin Name: My Contact Form
Description: A customizable contact form plugin.
Version: 1.0
Author: Your Name
*/

// Define plugin directory
define('MY_CONTACT_FORM_DIR', plugin_dir_path(__FILE__));

// Include necessary files
include_once MY_CONTACT_FORM_DIR . 'includes/admin-settings.php';
include_once MY_CONTACT_FORM_DIR . 'includes/form-handler.php';
include_once MY_CONTACT_FORM_DIR . 'includes/options.php';

// Register shortcode
function my_contact_form_shortcode() {
    ob_start();
    include MY_CONTACT_FORM_DIR . 'templates/form-template.php';
    return ob_get_clean();
}
add_shortcode('my_contact_form', 'my_contact_form_shortcode');

// Enqueue styles and scripts
function my_contact_form_enqueue_assets() {
    wp_enqueue_style('my-contact-form-style', plugins_url('assets/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'my_contact_form_enqueue_assets');
// Activation hook
function my_contact_form_activate() {
    // Set default options
    if (false === get_option('my_contact_form_email')) {
        add_option('my_contact_form_email', get_option('admin_email'));
    }
    if (false === get_option('my_contact_form_subject')) {
        add_option('my_contact_form_subject', 'New Contact Form Message');
    }
    if (false === get_option('my_contact_form_success_message')) {
        add_option('my_contact_form_success_message', 'Thank you for your message!');
    }
    if (false === get_option('my_contact_form_fields')) {
        add_option('my_contact_form_fields', array(
            array('label' => 'Name', 'type' => 'text', 'name' => 'cf-name'),
            array('label' => 'E-mail', 'type' => 'email', 'name' => 'cf-email'),
            array('label' => 'Company Name', 'type' => 'text', 'name' => 'cf-company'),
            array('label' => 'Contact Number', 'type' => 'tel', 'name' => 'cf-contact'),
            array('label' => 'Message', 'type' => 'textarea', 'name' => 'cf-message'),
        ));
    }
}
register_activation_hook(__FILE__, 'my_contact_form_activate');

// Deactivation hook
function my_contact_form_deactivate() {
    // No action required on deactivation
}
register_deactivation_hook(__FILE__, 'my_contact_form_deactivate');
