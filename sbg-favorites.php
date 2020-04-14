<?php 
/**
 * Plugin Name: Adding Articles to Favorites
 * Description: Плагин добавляет для авторизованных пользователей ссылку к статьям, 
 * позволяющую добавить статью в список избранных статей
 * Author:      Said Babaiev <babaiev.info@gmail.com>
 * Version:     1.0
 */

add_filter('the_content', 'sbg_favorites_content');

function sbg_favorites_content($content) {

    if(is_single() && is_user_logged_in()) {
        return '<p class="sbg-favorites-link"><a href="#">Добавить в Избранное</a></p>' . $content;
    }
    return $content;
}