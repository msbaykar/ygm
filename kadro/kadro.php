<?php
/*
Plugin Name: Kadro Eklentisi
Description: Kadro custom post type ve grid listeleme shortocode'u.
Version: 1.0
Author: Biarkadaş
*/

if (!defined('ABSPATH')) exit;

// CPT: Kadro
function kadro_register_post_type() {
    register_post_type('kadro', array(
        'labels' => array(
            'name' => 'Kadro',
            'singular_name' => 'Kadro',
            'add_new' => 'Yeni Ekle',
            'add_new_item' => 'Yeni Kadro Üyesi Ekle',
            'edit_item' => 'Kadroyu Düzenle',
            'new_item' => 'Yeni Kadro',
            'view_item' => 'Kadroyu Gör',
            'search_items' => 'Kadro Ara',
            'not_found' => 'Kadro bulunamadı',
            'all_items' => 'Tüm Kadro',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-id-alt',
        'has_archive' => true,
        'rewrite' => array('slug' => 'kadro'),
        'supports' => array('title', 'thumbnail', 'editor'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'kadro_register_post_type');

// Custom Fields (Unvan ve Sıralama)
function kadro_custom_meta_boxes() {
    add_meta_box('kadro_detaylari', 'Detaylar', 'kadro_meta_box_callback', 'kadro', 'normal', 'high');
}
add_action('add_meta_boxes', 'kadro_custom_meta_boxes');

function kadro_meta_box_callback($post) {
    $unvan = get_post_meta($post->ID, 'unvan', true);
    $sira = get_post_meta($post->ID, 'siralama', true);
    ?>
    <label>Ünvan:</label><br>
    <input type="text" name="unvan" value="<?php echo esc_attr($unvan); ?>" style="width:100%;"><br><br>
    <label>Sıralama:</label><br>
    <input type="number" name="siralama" value="<?php echo esc_attr($sira); ?>" style="width:100%;">
    <?php
}

function kadro_save_meta_fields($post_id) {
    if (isset($_POST['unvan'])) {
        update_post_meta($post_id, 'unvan', sanitize_text_field($_POST['unvan']));
    }
    if (isset($_POST['siralama'])) {
        update_post_meta($post_id, 'siralama', intval($_POST['siralama']));
    }
}
add_action('save_post', 'kadro_save_meta_fields');

// Shortcode
function kadro_listesi_shortcode($atts) {
    ob_start();
    $query = new WP_Query([
        'post_type' => 'kadro',
        'posts_per_page' => -1,
        'orderby' => 'meta_value_num',
        'meta_key' => 'siralama',
        'order' => 'ASC'
    ]);

    if ($query->have_posts()) {
        echo '<div class="kadro-grid">';
        while ($query->have_posts()) {
            $query->the_post();
            $unvan = get_post_meta(get_the_ID(), 'unvan', true);
            echo '<div class="kadro-card">';
            if (has_post_thumbnail()) {
                echo get_the_post_thumbnail(get_the_ID(), 'medium');
            }
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<p>' . esc_html($unvan) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    }

    return ob_get_clean();
}
add_shortcode('kadro_listesi', 'kadro_listesi_shortcode');

// Stil
function kadro_style() {
    echo '
    <style>
    .kadro-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    .kadro-card {
        width: calc(33.333% - 20px);
        box-shadow: 0 0 10px #eee;
        padding: 20px;
        box-sizing: border-box;
        text-align: center;
        background: #fff;
    }
    .kadro-card img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }
    .kadro-card h3 {
        margin: 10px 0 5px;
        font-size: 18px;
        font-weight: bold;
    }
    .kadro-card p {
        margin: 0;
        font-size: 14px;
        color: #555;
    }
    @media screen and (max-width: 768px) {
        .kadro-card {
            width: 100%;
        }
    }
    </style>
    ';
}
add_action('wp_head', 'kadro_style');