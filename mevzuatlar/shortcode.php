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
            <a href="' . get_permalink() . '"> <span>İncele</span> <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M6.83705 16.9129C6.47098 16.5468 6.47098 15.9532 6.83705 15.5871L12.4242 10L6.83705 4.41294C6.47098 4.04681 6.47098 3.45319 6.83705 3.08706C7.20317 2.721 7.7968 2.721 8.16292 3.08706L14.4129 9.33706C14.779 9.70319 14.779 10.2968 14.4129 10.6629L8.16292 16.9129C7.7968 17.279 7.20317 17.279 6.83705 16.9129Z" fill="#0A47CA"/>
</svg></span></a></li>';
        }
        $output .= '</ul>';
        $output .= '<style>
         .mevzuat-listesi {
            display: flex;
            list-style-type: none;
            gap:24px;
            }
         .mevzuat-listesi li {
            border-radius: 16px;
            background: #F3F6FC;
            padding: 16px;
            max-width: 410px;
            min-height: 160px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
            }
             .mevzuat-listesi li .mevzuat-title {
             font-size: 20px;
             font-weight: 700;
             line-height: 120%;
             }
             
             .mevzuat-listesi li a {
             color:#0A47CA;
             text-decoration: none;
             margin-top: auto;
             display: flex;         
             align-items: center;
             }
             
             
    
</style>';
        return $output;



        wp_reset_postdata();
    } else {
        echo 'Henüz mevzuat eklenmemiş.';
    }

    return ob_get_clean();
}
