<?php
/**
 * Theme Name: История Олёкмы
 * Description: Тема для архива истории Олёкминского района
 * Version: 1.0.0
 * Author: Agent Jon
 * Text Domain: istoria-olekmy
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Theme setup
add_action('after_setup_theme', function() {
    // Add theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    
    // Register menus
    register_nav_menus([
        'primary' => __('Главное меню', 'istoria-olekmy'),
        'footer' => __('Меню в подвале', 'istoria-olekmy'),
    ]);
});

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', function() {
    // Theme stylesheet
    wp_enqueue_style('istoria-olekmy-style', get_stylesheet_uri(), [], '1.0.0');
    
    // Leaflet for maps
    if (is_page_template('template-map.php')) {
        wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
        wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);
    }
    
    // Theme scripts
    wp_enqueue_script('istoria-olekmy-scripts', get_template_directory_uri() . '/js/scripts.js', ['jquery'], '1.0.0', true);
    
    // Pass AJAX URL to scripts
    wp_localize_script('istoria-olekmy-scripts', 'olekmy_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'rest_url' => rest_url('olekmy/v1/'),
    ]);
});

// Custom template functions
require_once get_template_directory() . '/inc/template-functions.php';

// Custom template tags
require_once get_template_directory() . '/inc/template-tags.php';
