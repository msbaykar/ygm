<?php
/**
 * Plugin Name: Mevzuatlar CPT
 * Description: Mevzuatlar için özel yazı tipi (Custom Post Type).
 * Version: 1.0
 * Author: Sen
 */

add_action('init', 'register_mevzuatlar_cpt');

function register_mevzuatlar_cpt() {
    $labels = array(
        'name' => 'Mevzuatlar',
        'singular_name' => 'Mevzuat',
        'menu_name' => 'Mevzuatlar',
        'name_admin_bar' => 'Mevzuat',
        'add_new' => 'Yeni Ekle',
        'add_new_item' => 'Yeni Mevzuat Ekle',
        'new_item' => 'Yeni Mevzuat',
        'edit_item' => 'Mevzuatı Düzenle',
        'view_item' => 'Mevzuatı Görüntüle',
        'all_items' => 'Tüm Mevzuatlar',
        'search_items' => 'Mevzuat Ara',
        'not_found' => 'Hiç mevzuat bulunamadı.',
        'not_found_in_trash' => 'Çöp kutusunda mevzuat bulunamadı.'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-media-document', // İkon seçimi
        'rewrite' => array('slug' => 'mevzuatlar'),
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest' => true, // Gutenberg ve REST API için
    );

    register_post_type('mevzuatlar', $args);
}

add_shortcode('mevzuat_listele', 'mevzuat_listele_shortcode');

function mevzuat_listele_shortcode() {
    ob_start();
    $args = array(
        'post_type' => 'mevzuatlar',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $mevzuat_query = new WP_Query($args);

    if ($mevzuat_query->have_posts()) {
        echo '<ul class="mevzuat-listesi">';
        while ($mevzuat_query->have_posts()) {
            $mevzuat_query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo 'Henüz mevzuat eklenmemiş.';
    }

    return ob_get_clean();
}
