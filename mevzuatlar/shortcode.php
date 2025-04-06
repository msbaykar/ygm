<?php
add_shortcode('mevzuat_listele', 'mevzuat_son_uc_listele_shortcode');

function mevzuat_son_uc_listele_shortcode() {
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
