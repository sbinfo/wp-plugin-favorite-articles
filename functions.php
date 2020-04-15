<?php

function sbg_favorites_content($content) {

	if (is_single() && is_user_logged_in()) {
		$loader_src = plugins_url('img/loading.gif', __FILE__);
		return '<p class="sbg-favorites-link"><img src="' . $loader_src . '" class="sbg-favorites-loading sbg-favorites-hidden" alt=""><a href="#">Добавить в Избранное</a></p>' . $content;
	}
	return $content;
}

function sbg_favorites_scripts() {
	if (is_single() && is_user_logged_in()) {
		wp_enqueue_script('sbg-main-scripts', plugins_url('/js/main.js', __FILE__), array('jquery'), null, true);
		wp_enqueue_style('sbg-styles', plugins_url('/css/style.css', __FILE__), null, null);

		global $post;

		// ajax
		wp_localize_script('sbg-main-scripts', 'sbgFavorites', ['url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('sbg-favorites'), 'postId' => $post->ID ]);
	}
}

function wp_ajax_sbg_test() {
	if ( !wp_verify_nonce( $_POST['security'], 'sbg-favorites' ) ) {
		wp_die('Security Error');
	}

	wp_die( $_POST['postId'] . "запрос завершен");
}
