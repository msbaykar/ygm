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
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $mevzuat_query = new WP_Query($args);

    if ($mevzuat_query->have_posts()) {
        $output = '<ul class="mevzuat-listesi">';
        while ($mevzuat_query->have_posts()) {
            $mevzuat_query->the_post();

            $output .= '<li>
             <div class="icon-class">
             <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="48" height="48" rx="24" fill="#01377D"/>
            <path d="M31.1795 19.1323L26.9744 14.8258C26.4615 14.3132 25.7436 14.0056 24.9231 14.0056H18.8718C17.3333 13.903 16 15.236 16 16.774V31.129C16 32.667 17.2308 34 18.8718 34H29.1282C30.6667 34 32 32.7696 32 31.129V21.0805C32 20.3628 31.6923 19.645 31.1795 19.1323ZM20.9231 22.1059H24C24.4103 22.1059 24.8205 22.4135 24.8205 22.9262C24.8205 23.4388 24.5128 23.7464 24 23.7464H20.9231C20.5128 23.7464 20.1026 23.4388 20.1026 22.9262C20.1026 22.4135 20.5128 22.1059 20.9231 22.1059ZM27.0769 27.8479H20.9231C20.5128 27.8479 20.1026 27.5403 20.1026 27.0276C20.1026 26.5149 20.4103 26.2073 20.9231 26.2073H27.0769C27.4872 26.2073 27.8974 26.5149 27.8974 27.0276C27.8974 27.5403 27.4872 27.8479 27.0769 27.8479Z" fill="white"/>
            </svg></div>
             <div class="mevzuat-title">' . get_the_title() . '</div>
            <a href="' . get_permalink() . '"> İncele</a></li>';
        }
        $output .= '</ul>';
        $output .= '<style>
         .mevzuat-listesi {
            display: flex;
            list-style-type: none;
            }
         .mevzuat-listesi li {
            border-radius: 16px;
            background: #F3F6FC;
            padding: 16px;
            
            }
    
</style>';
        return $output;



        wp_reset_postdata();
    } else {
        echo 'Henüz mevzuat eklenmemiş.';
    }

    return ob_get_clean();
}
