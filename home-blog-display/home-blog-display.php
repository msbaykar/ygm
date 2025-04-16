<?php
/*
Plugin Name: Özel Blog Listesi
Description: Özel tasarımla son 5 blog yazısını 2+3 düzeninde gösterir.
Version: 1.0
Author: Biarkadaş
*/

add_shortcode('ozel_blog_listesi', 'ozel_blog_listesi_shortcode');

function ozel_blog_listesi_shortcode() {
    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 5
    ]);

    if (!$query->have_posts()) return '';

    ob_start();
    ?>
    <style>
        .ozel-blog-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .ozel-blog-grid .item {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .ozel-blog-grid .item:hover {
            background: #f9f9f9;
        }

        .ozel-blog-grid .item img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .ozel-blog-grid .item h3 {
            font-size: 18px;
            margin: 0 0 10px;
        }

        .ozel-blog-grid .item .excerpt {
            font-size: 14px;
            color: #555;
        }

        .row1 .item:first-child {
            flex: 0 0 60%;
        }

        .row1 .item:last-child {
            flex: 0 0 38%;
        }

        .row2 .item {
            flex: 0 0 31.5%;
        }

        @media (max-width: 768px) {
            .row1 .item,
            .row2 .item {
                flex: 0 0 100%;
            }
        }
    </style>

    <div class="ozel-blog-grid row1">
        <?php
        $count = 0;
        while ($query->have_posts() && $count < 2) {
            $query->the_post();
            ?>
            <a class="item" href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                } ?>
                <h3><?php the_title(); ?></h3>
                <div class="excerpt"><?php the_excerpt(); ?></div>
            </a>
            <?php
            $count++;
        }
        ?>
    </div>

    <div class="ozel-blog-grid row2">
        <?php
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <a class="item" href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                } ?>
                <h3><?php the_title(); ?></h3>
                <div class="excerpt"><?php the_excerpt(); ?></div>
            </a>
            <?php
        }
        wp_reset_postdata();
        ?>
    </div>
    <?php
    return ob_get_clean();
}