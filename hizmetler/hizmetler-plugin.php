<?php
/*
Plugin Name: Hizmetlerimiz
Description: Hizmetler için özel içerik ve listeleme.
Version: 1.0
Author: Biarkadaş
*/

if (!defined('ABSPATH')) exit;

// Custom Post Type
function hizmetlerimiz_register_post_type() {
    register_post_type('hizmet', array(
        'labels' => array(
            'name' => 'Hizmetler',
            'singular_name' => 'Hizmet',
            'add_new' => 'Yeni Hizmet Ekle',
            'add_new_item' => 'Yeni Hizmet Ekle',
            'edit_item' => 'Hizmeti Düzenle',
            'new_item' => 'Yeni Hizmet',
            'view_item' => 'Hizmeti Gör',
            'search_items' => 'Hizmet Ara',
            'not_found' => 'Hizmet bulunamadı',
            'all_items' => 'Tüm Hizmetler',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-hammer',
        'has_archive' => true,
        'rewrite' => array('slug' => 'hizmetler'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'hizmetlerimiz_register_post_type');

// Shortcode
function hizmet_listesi_shortcode($atts) {
    ob_start();

    $query = new WP_Query([
        'post_type' => 'hizmet',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC'
    ]);

    if ($query->have_posts()) {
        echo '<div class="hizmet-grid">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="hizmet-item">';
            echo '<a href="' . get_permalink() . '">';
            if (has_post_thumbnail()) {
                echo get_the_post_thumbnail(get_the_ID(), 'medium');
            }
            echo '<h3>' . get_the_title() . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    }

    return ob_get_clean();
}
add_shortcode('hizmet_listesi', 'hizmet_listesi_shortcode');

// Stil
function hizmet_listesi_style() {
    echo '
    <style>
    .hizmet-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    .hizmet-item {
        width: calc(33.333% - 20px);
        text-align: center;
        box-shadow: 0 0 10px #eee;
        padding: 15px;
        background: #fff;
        box-sizing: border-box;
    }
    .hizmet-item img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }
    .hizmet-item h3 {
        font-size: 16px;
        margin-top: 10px;
    }
    @media screen and (max-width: 768px) {
        .hizmet-item {
            width: 100%;
        }
    }
    </style>
    ';
}
add_action('wp_head', 'hizmet_listesi_style');