<?php
$term = get_queried_object();

wp_reset_query();
$args  = array(
    'post_type'      => 'news',
    'posts_per_page' => 3,
    'offset'         => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => array(
        array(
            'taxonomy' => 'news_category',
            'field'    => 'slug',
            'terms'    => $term->slug,
        ),
    ),
);
$query = new WP_Query($args);

$news_posts_array = [];
while ($query->have_posts()) {
    $query->the_post();

    $title          = get_the_title();
    $content        = get_the_content();
    $featured_image = get_the_post_thumbnail_url();
    $categories     = get_the_terms(get_the_ID(), 'news_category');
    $published_date = get_the_date();
    $permalink      = get_the_permalink();

    $image_id = get_post_thumbnail_id();
    list($url, $width, $height) = wp_get_attachment_image_src($image_id, 'post-thumbnail');

    $post_category = [];
    foreach ($categories as $category) {
        if (sizeof($categories) > 1) {
            array_push($post_category, $category->name);
        } else {
            array_push($post_category, $category->name);
        }
    }


    $news_post_single = array(
        'title'          => $title,
        'content'        => $content,
        'featured_image' => $featured_image,
        'category'       => $post_category,
        'width'          => $width,
        'height'         => $height,
        'published_date' => $published_date,
        'permalink'      => $permalink
    );
    array_push($news_posts_array, $news_post_single);
}
$newsJSON = json_encode($news_posts_array);
?>
