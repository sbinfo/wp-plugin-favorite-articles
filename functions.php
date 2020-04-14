<?php

function sbg_favorites_content($content) {

    if(is_single() && is_user_logged_in()) {
        return '<p class="sbg-favorites-link"><a href="#">Добавить в Избранное</a></p>' . $content;
    }
    return $content;
}

function sbg_favorites_scripts() {
    if(is_single() && is_user_logged_in()) {
        wp_enqueue_script('sbg-main-scripts', plugins_url('/js/main.js', __FILE__), array('jquery'), null, true);
        wp_enqueue_style('sbg-styles', plugins_url('/css/style.css', __FILE__), null, null);
        // ajax
        wp_localize_script( 'sbg-main-scripts', 'sbgFavorites', ['url' => admin_url('admin-ajax.php')] );  
    }
}

function wp_ajax_sbg_test() {
    if( isset($_POST['test'])) {
        print_r($_POST);
    }

    wp_die("запрос завершен");
}
