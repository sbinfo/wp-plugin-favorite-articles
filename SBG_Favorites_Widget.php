<?php
class SBG_Favorites_Widget extends WP_Widget {
    public function __construct() {
        $args = [
            'name' => 'Избранные записи',
            'description' => 'Выводит блок избранных  записей пользователя'
        ];
        parent::__construct('sbg-favorites-widget','', $args);
    }

    // Форма виджета в админке
    public function form($instance) {
        extract($instance);
        $title = !empty($title) ? esc_attr($title) : 'Избранные записи';
        ?>

        <p>
            <label for="<?= $this->get_field_id('title') ?>">Заголовок</label>
            <input type="text" name="<?= $this->get_field_name('title') ?>" value="<?= $title ?>" id="<?= $this->get_field_id('title') ?>" class="widefat">
        </p>
        
        <?php
    }
    
    // Виджет в пользователской части
    public function widget($args, $instance) {
        if(!is_user_logged_in()) return;
        
        $title = !empty($instance['title']) ? esc_attr($instance['title']) : 'Избранные записи';
        echo $args['before_widget'];
            echo $args['before_title'];
                echo $title;
                sbg_show_dashboard_widget();
            echo $args['after_title'];
        echo $args['after_widget'];
    }
}