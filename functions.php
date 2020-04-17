<?php

/*======================================= код для админки ====================================*/

function sbg_favorites_admin_scripts() {
	wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css', '', '5.13.0', 'all');
	wp_enqueue_style('sbg-styles', plugins_url('/css/style-admin.css', __FILE__), null, null);

	global $post;
	wp_enqueue_script('sbg-dashboard-scripts', plugins_url('/js/admin-panel.js', __FILE__), array('jquery'), null, true);
	wp_localize_script('sbg-dashboard-scripts', 'sbgFavorites', ['url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('sbg-admin-favorites') ]);
}

// Функция для регистрации виджета в админке где будут показываться
// добавленные пользователем записи 
function sbg_favorites_dashboard_widget() {
	wp_add_dashboard_widget('sbg_favorites_dashboard', 'Ваш список избранного', 'sbg_show_dashboard_widget');
}

// Функция рендер
function sbg_show_dashboard_widget() {
	$user = wp_get_current_user();
	$favorites = get_user_meta($user->ID, 'sbg-favorites');
	$loader_src = plugins_url('img/loading.gif', __FILE__);

	if(!$favorites) {
		echo 'Список пуст';
		return;
	}
	$str = implode(',', $favorites);
	$sbg_posts = get_posts( ['include' => $str] );

	echo '<ul>';
	foreach($favorites as $item) {
		$post_image =  get_the_post_thumbnail($item, array(35, 35));
		if(!$post_image) {
			$post_image = '<img src="'. plugins_url('/img/no-image.png', __FILE__) .'" alt="">';
		}
		echo '<li class="sbg-dashboard-favorites sbg-dashboard-favorites-item-'. $item .'"><a href="#"><img src="' . $loader_src . '" class="sbg-favorites-loading-'. $item .' sbg-favorites-hidden" alt=""></a><a class="hide" href="'. get_permalink($item) .'">'. $post_image .'</a><a class="hide" href="'. get_permalink($item) .'">'. get_the_title($item) .'</a><span class="hide delete-item-btn" data-id="'. $item .'"><i data-action="delete" class="fas fa-trash-alt"></i></span></li>';
	}
	echo '<li class="sbg-dashboard-favorites-loader"><img src="' . $loader_src . '" class="sbg-favorites-hidden" alt=""></li></ul>';
	echo '<div class="sbg-delete-all-favorites-block">
	<button data-action="delete-all" class="sbg-delete-all-favorites" type="button">Удалить все записи</button></div>';
}

// Функция удаление записей по одной из админки
function wp_ajax_sbg_delete_in_dashboard() {
	if ( !wp_verify_nonce( $_POST['admin_security'], 'sbg-admin-favorites' ) ) {
		wp_die('Security Error');
	}

	$user = wp_get_current_user();

	if($_POST['method'] == 'delete') {
		$postId = $_POST['postId'];
		if(!sbg_is_favorites($postId)) wp_die();

		if(delete_user_meta($user->ID, 'sbg-favorites', $postId)) {
			wp_die("Удалено");
		}
		wp_die("Ощибка удалении");
	}

	if($_POST['method'] == 'delete-all') {
		if(delete_user_meta($user->ID, 'sbg-favorites')) {
			wp_die("Все записи удалены");
		}
		wp_die("all");
	}
	
}


/*======================================= код для админки ====================================*/
/*============================================================================================*/


/*============================================================================================*/
/*======================================= код для записей ====================================*/

function sbg_favorites_scripts() {
	if (is_single() && is_user_logged_in()) {
		wp_enqueue_script('sbg-main-scripts', plugins_url('/js/main.js', __FILE__), array('jquery'), null, true);
		wp_enqueue_style('sbg-styles', plugins_url('/css/style.css', __FILE__), null, null);
		
		global $post;
		// ajax
		wp_localize_script('sbg-main-scripts', 'sbgFavorites', ['url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('sbg-favorites'), 'postId' => $post->ID ]);
	}
}

// вывод кнопки, инфо возле заголовка для добавление или удаление записи 
function sbg_favorites_content($content) {
	
	if (is_single() && is_user_logged_in()) {
		$loader_src = plugins_url('img/loading.gif', __FILE__);
		
		global $post;
		if(sbg_is_favorites($post->ID)) {
			return '<p class="sbg-favorites-link"><img src="' . $loader_src . '" class="sbg-favorites-loading sbg-favorites-hidden" alt=""><a href="#" data-action="del" style="color: orange">Удалить из избранного</a></p>' . $content;	
		}

		return '<p class="sbg-favorites-link"><img src="' . $loader_src . '" class="sbg-favorites-loading sbg-favorites-hidden" alt=""><a href="#" data-action="add">Добавить в Избранное</a></p>' . $content;
	}
	return $content;
}

function wp_ajax_sbg_change() {
	if ( !wp_verify_nonce( $_POST['security'], 'sbg-favorites' ) ) {
		wp_die('Security Error');
	}
	
	$post_id = (int)$_POST['postId'];
	$user = wp_get_current_user();
	
	if($_POST['method'] == 'add') {
		if(sbg_is_favorites($post_id)) wp_die();
		
		if(add_user_meta($user->id, 'sbg-favorites', $post_id)) {
			wp_die('Добавлено');
		}
		wp_die( "Ощибка завершен");
	}
	
	if($_POST['method'] == 'del') {
		if(!sbg_is_favorites($post_id)) wp_die();
		
		if(delete_user_meta($user->id, 'sbg-favorites', $post_id)) {
			wp_die('Удалено');
		}
		wp_die( "Ощибка Удаление");
	}
	
}

function sbg_is_favorites($post_id) {
	$user = wp_get_current_user();
	$favorites = get_user_meta($user->ID, 'sbg-favorites');
	
	foreach($favorites as $item) {
		if($item == $post_id) return true;
	}
	
	return false;
}
/*======================================= код для записей ====================================*/
/*============================================================================================*/