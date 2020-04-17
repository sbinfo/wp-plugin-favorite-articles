<?php 
/**
 * Plugin Name: Adding Articles to Favorites
 * Description: Плагин добавляет для авторизованных пользователей ссылку к статьям, 
 * позволяющую добавить статью в список избранных статей
 * Author:      Said Babaiev <babaiev.info@gmail.com>
 * Version:     1.0
 */

require __DIR__ . '/functions.php';

add_filter('the_content', 'sbg_favorites_content');
add_action('wp_enqueue_scripts', 'sbg_favorites_scripts');
add_action('admin_head', 'sbg_favorites_admin_scripts');
add_action('wp_ajax_sbg_change', 'wp_ajax_sbg_change');
add_action('wp_ajax_sbg_delete_in_dashboard', 'wp_ajax_sbg_delete_in_dashboard');
add_action('wp_dashboard_setup', 'sbg_favorites_dashboard_widget');

