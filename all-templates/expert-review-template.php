<?php
/*
Template Name: Expert Review
*/

function add_open_graph_tags()
{
    global $post;
    $intro_headline = get_post_meta($post->ID, 'intro_headline', true) ?: 'I tried out the top 5 men\'s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…';
    $author_name = get_post_meta($post->ID, 'author_name', true) ?: 'Peter Attia';
    $site_name = get_post_meta($post->ID, 'site_name', true) ?: 'versus.reviews';
    $site_url = get_post_meta($post->ID, 'site_url', true) ?: 'https://versus.reviews/';
    $meta_keywords = get_post_meta($post->ID, 'meta_keywords', true);
    $meta_description = get_post_meta($post->ID, 'meta_description', true);
?>
    <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($intro_headline); ?>" />
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>" />
    <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'large')); ?>" />
    <meta property="article:author" content="<?php echo esc_attr($author_name); ?>" />
    <meta property="article:published_time" content="<?php echo esc_attr(get_the_date('c')); ?>" />
    <meta property="og:article:author:name" content="<?php echo esc_attr($author_name); ?>" />
    <meta property="og:article:reading_time" content="6 minutes" />
    <meta property="og:site:url" content="<?php echo esc_url($site_url); ?>" />
    <meta name="keywords" content="<?php echo esc_html($meta_keywords); ?>">
    <meta name="description" content="<?php echo esc_html($meta_description); ?>">
<?php
}
// add_action('wp_head', 'add_open_graph_tags');


get_header();

wp_enqueue_style('expert-review-style', get_stylesheet_directory_uri() . '/assets/template/css/expert-review.css', array(), '1.1');

$num_products = get_post_meta(get_the_ID(), 'num_products', true) ?: 5;
$intro_headline = get_post_meta(get_the_ID(), 'intro_headline', true) ?: 'I tried out the top 5 men\'s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…';
$intro_paragraph = get_post_meta(get_the_ID(), 'intro_paragraph', true) ?: '';
$conclusion_headline1 = get_post_meta(get_the_ID(), 'conclusion_headline1', true) ?: 'Why I chose .....';
$conclusion_para1 = get_post_meta(get_the_ID(), 'conclusion_para1', true) ?: 'eb5 is my clear winner for effectiveness, affordability, and versatility.';
$conclusion_image1 = get_post_meta(get_the_ID(), 'conclusion_image1', true);
$conclusion_para2 = get_post_meta(get_the_ID(), 'conclusion_para2', true) ?: 'Affordability is another critical factor.';
$conclusion_headline2 = get_post_meta(get_the_ID(), 'conclusion_headline2', true) ?: 'How Does XYZ work';
$conclusion_para3 = get_post_meta(get_the_ID(), 'conclusion_para3', true) ?: 'The effectiveness of XYZ comes down to';
$conclusion_image2 = get_post_meta(get_the_ID(), 'conclusion_image2', true);
$conclusion_para4 = get_post_meta(get_the_ID(), 'conclusion_para4', true) ?: '';
$cta_text = get_post_meta(get_the_ID(), 'cta_text', true) ?: 'Learn More';
$cta_link = get_post_meta(get_the_ID(), 'cta_link', true) ?: 'https://eb5.com/products/face-cream-for-men';
$sidebar_ad_image = get_post_meta(get_the_ID(), 'sidebar_ad_image', true);
$logo_url = get_post_meta(get_the_ID(), 'logo_url', true) ?: 'https://vitality.guide/wp-content/uploads/sites/5/2023/04/Vitality-Guide-logo-Photoroom-768x271.jpg';
$author_image = get_post_meta(get_the_ID(), 'author_image', true) ?: 'https://vitality.guide/wp-content/uploads/sites/5/2024/07/WhatsApp-Image-2024-07-25-at-19.05.33.jpeg';
$author_name = get_post_meta(get_the_ID(), 'author_name', true) ?: 'Peter Attia';
$author_tagline = get_post_meta(get_the_ID(), 'author_tagline', true);
$site_name = get_post_meta(get_the_ID(), 'site_name', true) ?: 'versus.reviews';
$site_url = get_post_meta(get_the_ID(), 'site_url', true) ?: 'https://versus.reviews/';
$custom_fields = get_post_meta(get_the_ID(), 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
$best_product_category = get_post_meta(get_the_ID(), 'best_product_category', true) ?: 'facial product for men';
$best_product_name = get_post_meta(get_the_ID(), "product_1_name", true);

$discount_offer = get_post_meta(get_the_ID(), 'discount_offer', true);
$discount_code = get_post_meta(get_the_ID(), 'discount_code', true);

$analyzed_count = get_post_meta(get_the_ID(), 'analyzed_count', true);
$research_hours = get_post_meta(get_the_ID(), 'research_hours', true);
$brands_count = get_post_meta(get_the_ID(), 'brands_count', true);



// var_dump($num_products);
/*
    Used Meta keys:
        // $author_image
        // $author_name
        product_{$i}_ingredients
        "product_{$i}_rating"
        "product_{$i}_name"
        "product_{$i}_image"
        "product_{$i}_flavors",
        "product_{$i}_flavor_type",
        "product_{$i}_flavor_reviewed",
        "product_{$i}_brand",
        "product_{$i}_source",
        "product_{$i}_ingredients",
        'product_{$i}_tested',
        'product_{$i}_weight',
        // 'analyzed_count',
        // 'research_hours',
        // 'brands_count',
*/


?>

<div class="site">
    <div class="site-inner">
        <?php while (have_posts()) : the_post(); ?>
            <div class="main-content-area">
                <!-- author box area  -->
                <div class="container-fluid">
                    <div class="author-box">
                        <div class="row align-center">
                            <div class="author-details">
                                <?php
                                if (!empty($author_name)) {
                                    echo sprintf("<h2>Hi, I am %s 👋</h2> ", $author_name);
                                }
                                if (!empty($author_tagline)) {
                                    echo sprintf('<p>%s</p>', $author_tagline);
                                }
                                ?>

                            </div>
                            <div class="author-image">
                                <?php
                                if (!empty($author_image)) {
                                    echo sprintf('<img src="%s">', $author_image);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end author box area -->
                <section class="title-area">
                    <div class="mini-container">
                        <h1><?php the_title(); ?></h1>
                        <div class="updated-date text-uppercase">
                            <!-- Updated JANuary 17 2025 -->
                            <?php
                            if (NULL != get_the_date("F j Y")) {
                                echo 'Updated ' . get_the_date("F j Y");
                            }
                            ?>
                        </div>
                        <div class="analyzed-area row">
                            <div class="analyzed-item">
                                <div class="number-box">
                                    <img loading="lazy" src="https://cdn.prod.website-files.com/6682b2a9e4616dbec888f61b/66fd8937ceff2f3bf1997f0f_book-open-01.png" alt="" class="icon-image _40">
                                    <span class="number"><?php echo $analyzed_count; ?></span>
                                </div>
                                <div class="analyzed-title">Ratings analyzed</div>
                            </div>
                            <div class="analyzed-item">
                                <div class="number-box">
                                    <img loading="lazy" src="https://cdn.prod.website-files.com/6682b2a9e4616dbec888f61b/66fd8937ceff2f3bf1997f0f_book-open-01.png" alt="" class="icon-image _40">
                                    <span class="number"><?php echo $research_hours; ?></span>
                                </div>
                                <div class="analyzed-title">Ratings analyzed</div>
                            </div>
                            <div class="analyzed-item">
                                <div class="number-box">
                                    <img loading="lazy" src="https://cdn.prod.website-files.com/6682b2a9e4616dbec888f61b/66fd8937ceff2f3bf1997f0f_book-open-01.png" alt="" class="icon-image _40">
                                    <span class="number"><?php echo $brands_count; ?></span>
                                </div>
                                <div class="analyzed-title">Ratings analyzed</div>
                            </div>
                            <div class="analyzed-item">
                                <div class="number-box">
                                    <img src="<?php echo get_theme_file_uri() . '/assets/images/bottle.png' ?>" alt="">
                                    <span class="number"><?php echo $num_products; ?></span>
                                </div>
                                <div class="analyzed-title">Powders tested</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php endwhile; ?>
        <div class="product-top-area">
            <div class="product-top-container">
                <div class="product-area-top row">
                    <?php
                    for ($i = 1; $i <= $num_products; $i++) :
                        $name = get_post_meta(get_the_ID(), "product_{$i}_name", true);
                        $rating = get_post_meta(get_the_ID(), "product_{$i}_rating", true);
                        $image = get_post_meta(get_the_ID(), "product_{$i}_image", true);
                        // $description = get_post_meta(get_the_ID(), "product_{$i}_description", true);
                    ?>
                        <div class="product-box-div">
                            <a href="#" class="product-box">
                                <div class="product-badge-container">
                                    <div class="product-badge">
                                        <?php if ($i <= 2) : ?>
                                            <img src="<?php echo get_theme_file_uri() . '/assets/images/verified.png' ?>" alt="">
                                            <!-- <svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>check-circle</title>
                                                    <desc>Created with sketchtool.</desc>
                                                    <g id="web-app" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g id="check-circle" fill="#ffffff" fill-rule="nonzero">
                                                            <path d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M8,10 L6,12 L11,17 L18,10 L16,8 L11,13 L8,10 Z" id="Shape"> </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg> -->
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m344-60-76-128-144-32 14-148-98-112 98-112-14-148 144-32 76-128 136 58 136-58 76 128 144 32-14 148 98 112-98 112 14 148-144 32-76 128-136-58-136 58Zm34-102 102-44 104 44 56-96 110-26-10-112 74-84-74-86 10-112-110-24-58-96-102 44-104-44-56 96-110 24 10 112-74 86 74 84-10 114 110 24 58 96Zm102-318Zm-42 142 226-226-56-58-170 170-86-84-56 56 142 142Z"/></svg> -->
                                        <?php endif; ?>
                                        <div class="caption-text">
                                            <?php if ($i == 1) : ?>
                                                <strong>WINNER</strong>
                                            <?php elseif ($i == 2) : ?>
                                                <strong>Runner up</strong>
                                            <?php else: ?>
                                                <strong>Rank #<?php echo $i; ?></strong>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-main">
                                    <img width="380" loading="lazy" alt=""
                                        src="https://cdn.prod.website-files.com/672b9dd9259efc37f105e857/672b9dd9259efc37f105eb6b_equip%20pd%20image%20larger.png"
                                        class="product-image small prime-pd-specific">
                                    <div class="product-title"><?php echo wp_trim_words($name, 2); ?></div>
                                    <div class="star-rating"></div>
                                    <style>
                                        <?php

                                        $productRating = get_post_meta(get_the_ID(), "product_{$i}_rating", true);

                                        $stars = '';
                                        for ($ii = 1; $ii <= 5; $ii++) {
                                            if ($ii <= floor($productRating)) {
                                                $stars .= 'S';
                                            } else {
                                                $stars .= 's';
                                            }
                                        }
                                        ?>.product-box-div:nth-child(<?php echo $i; ?>) .star-rating::before {
                                            content: "<?php echo $stars; ?>" !important;
                                        }
                                    </style>
                                    <div class="star-text"><?php echo $productRating; ?>/5</div>
                                </div>
                                <div class="product-description">
                                    <div class="details-container">
                                        <div class="details-content">
                                            <div class="details-text">
                                                <strong>Source:&nbsp;</strong>Lean Beef<strong>
                                                    <br>
                                                    Ingredients:&nbsp;</strong>3
                                            </div>
                                        </div>
                                    </div>
                                    <div class="see-more">See more</div>
                                </div>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="reason-area">
                <!-- // 'research_reason_title',
    // 'research_reason_content',
    // 'research_reason_gallery',
    // 'research_reason_caption', -->
                <?php
                $research_reason_title = get_post_meta(get_the_ID(), 'research_reason_title', true);
                $research_reason_content = get_post_meta(get_the_ID(), 'research_reason_content', true);
                $research_reason_gallery = get_post_meta(get_the_ID(), 'research_reason_gallery', true);
                $research_reason_caption = get_post_meta(get_the_ID(), 'research_reason_caption', true);
                ?>
                <div class="mini-container">
                    <?php if (!empty($research_reason_title)) : ?>
                        <h2><?php echo $research_reason_title; ?></h2>
                        <?php endif; ?><?php if (!empty($research_reason_content)) : ?>
                        <div class="reason-content">
                            <?php echo $research_reason_content; ?>
                        </div>
                    <?php endif; ?>
                    <div class="reason-gallery-container">
                        <div class="reason-gallery row half-image">
                            <?php if (!empty($research_reason_gallery)) :
                                $gallery = explode(',', $research_reason_gallery);
                                foreach ($gallery as $gallery_item) :
                            ?>
                                    <img src="<?php echo $gallery_item; ?>">
                            <?php endforeach;
                            endif; ?>
                        </div>
                        <?php if (!empty($research_reason_caption)) : ?>
                            <p><?php echo $research_reason_caption; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mini-container">
                <?php the_content(); ?>
            </div>
        </div>

        <div class="factors-area">
            <div class="mini-container">
                <div class="factors-content">
                    <?php
                    $conclusion_headline1 = get_post_meta(get_the_ID(), 'conclusion_headline1', true);
                    if (!empty($conclusion_headline1)) :
                    ?>
                        <h2><?php echo $conclusion_headline1; ?></h2>
                    <?php endif; ?>
                    <?php
                    $conclusion_para1 = get_post_meta(get_the_ID(), 'conclusion_para1', true);
                    if (!empty($conclusion_para1)) :
                    ?>
                        <?php echo $conclusion_para1; ?>
                    <?php endif; ?>
                    <?php
                    $conclusion_para2 = get_post_meta(get_the_ID(), 'conclusion_para2', true);
                    if (!empty($conclusion_para2)) :
                    ?>
                        <?php echo $conclusion_para2; ?>
                    <?php endif; ?>
                    <?php
                    $conclusion_para3 = get_post_meta(get_the_ID(), 'conclusion_para3', true);
                    if (!empty($conclusion_para3)) :
                    ?>
                        <?php echo $conclusion_para3; ?>
                    <?php endif; ?>
                    <?php
                    $conclusion_headline2 = get_post_meta(get_the_ID(), 'conclusion_headline2', true);
                    if (!empty($conclusion_headline2)) :
                    ?>
                        <h2><?php echo $conclusion_headline2; ?></h2>
                    <?php endif; ?>
                    <div class="conclusion-para-4">
                        <?php
                        $conclusion_para4 = get_post_meta(get_the_ID(), 'conclusion_para4', true);
                        if (!empty($conclusion_para4)) :
                        ?>
                            <?php echo $conclusion_para4; ?>
                        <?php endif; ?>
                    </div>
                    <div class="conclusions-image row half-image">
                        <!-- conclusion_image1 -->

                        <?php
                        $conclusion_image1 = get_post_meta(get_the_ID(), 'conclusion_image1', true);
                        if (!empty($conclusion_image1)) :
                        ?>
                            <img src="<?php echo $conclusion_image1; ?>">
                        <?php endif; ?>
                        <?php
                        $conclusion_image2 = get_post_meta(get_the_ID(), 'conclusion_image2', true);
                        if (!empty($conclusion_image2)) :
                        ?>
                            <img src="<?php echo $conclusion_image2; ?>">
                        <?php endif; ?>
                        <!-- conclusion_image_overlay -->
                        <?php
                        $conclusion_image_overlay = get_post_meta(get_the_ID(), 'conclusion_image_overlay', true);
                        if (!empty($conclusion_image_overlay)) :
                        ?>
                            <p><?php echo $conclusion_image_overlay; ?></p>
                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
        <!-- main-product-area -->
        <div class="main-product-area">
            <div class="mini-container">
                <div class="mini-product-title">
                    <?php
                    $conclusion_headline3 = get_post_meta(get_the_ID(), 'conclusion_headline3', true);
                    if (!empty($conclusion_headline3)) :
                    ?>
                        <h2><?php echo $conclusion_headline3; ?></h2>
                    <?php endif; ?>
                </div>
                <div class="main-product">
                    <?php
                    for ($i = 1; $i <= $num_products; $i++) :
                        $name = get_post_meta(get_the_ID(), "product_{$i}_name", true);
                        $rating = get_post_meta(get_the_ID(), "product_{$i}_rating", true);
                        $price = get_post_meta(get_the_ID(), "product_{$i}_price", true);
                        $image = get_post_meta(get_the_ID(), "product_{$i}_image", true);
                        $ingredients = get_post_meta(get_the_ID(), "product_{$i}_ingredients", true);
                        $ingredientsImplode = explode(',', $ingredients);
                        $flavor = get_post_meta(get_the_ID(), "product_{$i}_flavor", true);
                        $flavor_type = get_post_meta(get_the_ID(), "product_{$i}_flavor_type", true);
                        $flavors = get_post_meta(get_the_ID(), "product_{$i}_flavors", true);
                        $source = get_post_meta(get_the_ID(), "product_{$i}_source", true);
                        $tested = get_post_meta(get_the_ID(), "product_{$i}_tested", true);
                        $weight = get_post_meta(get_the_ID(), "product_{$i}_weight", true);
                        $description = get_post_meta(get_the_ID(), "product_{$i}_description", true);
                        $pros = get_post_meta(get_the_ID(), "product_{$i}_pros", true);
                        $cons = get_post_meta(get_the_ID(), "product_{$i}_cons", true);
                        $product_what_i_love = get_post_meta(get_the_ID(), "product_{$i}_what_i_love", true);
                        $product__could_be_better = get_post_meta(get_the_ID(), "product_{$i}_could_be_better", true);
                        $top_gallery = get_post_meta(get_the_ID(), "product_{$i}_top_gallery", true);
                        $top_gallery_caption = get_post_meta(get_the_ID(), "product_{$i}_top_gallery_caption", true);
                        $bottom_gallery = get_post_meta(get_the_ID(), "product_{$i}_bottom_gallery", true);
                        $bottom_gallery_caption = get_post_meta(get_the_ID(), "product_{$i}_bottom_gallery_caption", true);
                        $link = get_post_meta(get_the_ID(), "product_{$i}_link", true);
                        $reference = get_post_meta(get_the_ID(), "product_{$i}_reference", true);
                        $bottom_line = get_post_meta(get_the_ID(), "product_{$i}_bottom_line", true);
                        $offer_date = get_post_meta(get_the_ID(), "product_{$i}_offer_date", true);
                        // bottom_line
                    ?>
                        <div class="product-box <?php if ($i > 1) {
                                                    echo " secondary-box";
                                                } ?>">
                            <div class="main-product-container">
                                <div class="product-top">
                                    <?php if ($i < 2) : ?>
                                        <div class="badge-one">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20">
                                                <path d="M15 9c1.657 0 3-1.343 3-3v0h2c0 0 0 0.001 0 0.001 0 2.761-2.239 5-5 5-0.035 0-0.070-0-0.105-0.001l0.005 0c-0.411 1.966-1.934 3.489-3.867 3.894l-0.033 0.006v2.1l5 2v1h-12v-1l5-2v-2.1c-1.966-0.411-3.489-1.934-3.894-3.867l-0.006-0.033h-0.1c-2.761 0-5-2.239-5-5v0h2c0 1.657 1.343 3 3 3v0-5h-3v2h-2v-4h5v-2h10v2h5v4h-2v-2h-3v5z" />
                                            </svg>
                                            <span class="badge-text"><b>winner #<?php echo $i; ?></b> out of <?php echo $num_products; ?></span>
                                        </div>
                                        <div class="badge-two">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20">
                                                <path d="M10 12c-3.314 0-6-2.686-6-6s2.686-6 6-6v0c3.314 0 6 2.686 6 6s-2.686 6-6 6v0zM10 9c1.657 0 3-1.343 3-3s-1.343-3-3-3v0c-1.657 0-3 1.343-3 3s1.343 3 3 3v0zM14 11.75v8.25l-4-4-4 4v-8.25c1.115 0.79 2.502 1.262 4 1.262s2.885-0.473 4.022-1.277l-0.022 0.015z"></path>
                                            </svg>
                                            <span class="badge-text">Healthiest & Cleanest</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="badge-three">
                                            #<span class="badge-text"><?php echo $i; ?> of <?php echo $num_products; ?> products</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-image-area row">
                                    <div class="left half image">
                                        <img src="https://cdn.prod.website-files.com/6703fce8f05594ed8cef9ca7/67193e8a004aae634078f7b5_equip%20pd%20image%20larger.png" alt="image">
                                    </div>
                                    <div class="right half product-specifications">
                                        <h2><?php echo $name; ?></h2>
                                        <div class="rating">
                                            4.5/5 <div class="star-rating"></div>
                                        </div>
                                        <?php if (!empty($flavor)) : ?>
                                            <div class="flavour">
                                                Flavor Reviewed: <?php echo $flavor; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($flavor_type)) : ?>
                                            <div class="product-type">
                                                <strong>Beef type: </strong><?php echo $flavor_type; ?>
                                                <!-- 🐄 -->
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($source)) : ?>
                                            <div class="product-source">
                                                <strong>Source: </strong><?php echo $source; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($flavors)) : ?>
                                            <div class="product-flafours">
                                                <strong>Flavors: </strong><?php echo $flavors; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="ingredients">
                                            <?php
                                            if (!empty($ingredientsImplode)) :
                                                if (is_array($ingredientsImplode)) : ?>
                                                    <strong>Ingredients:</strong> <?php echo count($ingredientsImplode); ?> total
                                                    <ol>
                                                        <?php foreach ($ingredientsImplode as $item) : ?>
                                                            <li><?php echo $item; ?></li>
                                                        <?php endforeach; ?>
                                                    </ol>
                                                <?php elseif (is_string($ingredientsImplode)) : ?>
                                                    <ol>
                                                        <li><?php echo $ingredientsImplode; ?></li>
                                                    </ol>
                                            <?php endif;
                                            endif; ?>
                                        </div>
                                        <div class="with-icon-specifications">
                                            <?php if (!empty($weight)) : ?>
                                                <div class="unit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="32" height="32" viewBox="0 0 32 32">
                                                        <path d="M30.826 1.172c-1.562-1.562-4.094-1.562-5.656 0l-11.4 11.398c2.641 0.941 4.719 3.020 5.656 5.66l11.4-11.402c1.563-1.562 1.563-4.094 0-5.656zM15.996 21.332c0-2.945-2.391-5.332-5.336-5.332s-5.332 2.387-5.332 5.332l0.004 0.004c-0.004 3.945-2.148 7.387-5.332 9.23l0.016 0.020c1.566 0.898 3.379 1.414 5.316 1.414 5.891 0 10.668-4.777 10.668-10.668h-0.004z" />
                                                    </svg>
                                                    <strong>Protein per serving:</strong> <?php echo $weight; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($tested)) : ?>
                                                <div class="tested">
                                                    <svg fill="#000" height="800" width="800" viewBox="0 0 481.882 481.882" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M474.353 422.852h-56.245v-80.489c0-33.958-27.633-61.591-61.591-61.591s-61.591 27.633-61.591 61.591v80.489H7.529c-4.216 0-7.529 3.388-7.529 7.529v43.972c0 4.141 3.313 7.529 7.529 7.529h466.823c4.141 0 7.529-3.388 7.529-7.529v-43.972c0-4.141-3.388-7.529-7.529-7.529zM356.53 367.879c-14.088 0-25.508-11.421-25.508-25.508s11.42-25.508 25.508-25.508 25.508 11.421 25.508 25.508-11.42 25.508-25.508 25.508zM106.767 307.878c-4.216 0-7.529 3.388-7.529 7.529v43.972c0 4.141 3.313 7.529 7.529 7.529h173.1v-24.547c0-12.411 3.031-24.104 8.289-34.484h-181.389zM288.228 59.851c2.561 0 5.06.241 7.527.587V33.732c0-4.141-3.388-7.529-7.529-7.529h-14.08V7.529c0-4.141-3.313-7.529-7.529-7.529h-51.426c-4.141 0-7.529 3.388-7.529 7.529v18.673h-14.08c-4.141 0-7.529 3.388-7.529 7.529v200.583c0 4.141 3.388 7.529 7.529 7.529h8.583v21.459c0 4.216 3.388 7.529 7.529 7.529h62.419c4.141 0 7.529-3.313 7.529-7.529v-21.459h8.583c4.141 0 7.529-3.388 7.529-7.529v-67.089c-2.467.346-4.966.587-7.527.587-29.765 0-53.978-24.217-53.978-53.981s24.213-53.981 53.978-53.981zM341.489 105.458c.428 2.736.717 5.519.717 8.373 0 19.485-10.409 36.539-25.927 46.032 29.833 21.753 47.693 56.088 47.693 93.727 0 4.153-.305 8.313-.759 12.463 22.148 1.93 41.574 13.324 54.314 30.098 3.512-13.917 5.475-28.142 5.475-42.562 0-52.256-31.332-108.034-81.513-139.999zM288.228 74.909c-21.463 0-38.92 17.459-38.92 38.923 0 21.463 17.456 38.923 38.92 38.923s38.919-17.459 38.919-38.923c0-21.464-17.456-38.923-38.919-38.923zM295.757 121.361h-15.059v-15.059h15.059v15.059z" />
                                                    </svg>
                                                    <strong>Third party tested:</strong> <?php echo $tested; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="price-per-serving">
                                                <svg height="800px" width="800px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                                    <g>
                                                        <path class="st0" d="M239.732,12.188L0,0l12.176,239.742l42.29,42.29l-9.192-2.301c-9.079,37.239-12.986,70.45-12.986,99.069   c0,33.794,5.399,60.91,14.827,80.798c4.713,9.877,10.572,17.924,17.699,23.906c7.015,5.97,15.746,9.652,24.938,9.652   c8.732,0,17.239-3.333,24.826-8.855c7.475-5.511,14.366-13.322,20.572-23.322c10.338-16.667,16.78-38.384,20.922-63.333   c0.684-4.018,1.256-8.037,1.828-12.178l-20.909-20.92c-0.808,10.236-1.952,20.112-3.568,29.427   c-3.794,23.098-10.001,42.402-17.7,54.816c-5.162,8.158-10.224,13.794-14.703,17.014c-4.602,3.334-8.159,4.254-11.268,4.366   c-3.22-0.113-6.319-1.145-10.224-4.254c-5.746-4.714-12.188-14.59-16.78-29.417c-4.602-14.826-7.475-34.253-7.475-57.7   c0-24.366,2.986-53.21,10.461-85.499l71.257,71.246c1.493-15.399,2.065-31.718,2.065-48.384c0-55.274-7.015-114.12-16.318-153.996   c-10.573,0.224-21.257-3.794-29.304-11.841c-15.635-15.746-15.635-41.144,0-56.891c15.746-15.746,41.144-15.746,56.892,0   c15.735,15.747,15.735,41.145,0,56.891c-1.841,1.728-3.682,3.334-5.746,4.714c3.333,13.558,6.206,28.956,8.731,45.623   c5.286,35.286,8.732,76.083,8.732,115.5c0,24.142-1.269,47.7-4.142,69.305L284.446,512L512,284.446L239.732,12.188z" />
                                                        <path class="st0" d="M143.996,152.515c-3.558-14.142-7.352-26.094-11.718-35.523l-20.808,9.776   c3.333,7.126,6.903,18.036,10.236,31.258c0.348,1.38,0.685,2.76,1.033,4.141c7.586-0.123,15.285-2.537,21.841-7.127   C144.456,154.232,144.232,153.311,143.996,152.515z" />
                                                    </g>
                                                </svg>
                                                <strong>
                                                    Price per serving:</strong>
                                                <?php if (strpos($price, '$')) {
                                                    echo $price;
                                                } else {
                                                    echo '$' . $price;
                                                } ?> per serving
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-image-button-area">
                                    <div class="button-parent">
                                        <a class="large-button" href="<?php echo $link; ?>">Check Now</a>
                                    </div>
                                    <?php if (!empty($reference)) : ?>
                                        <div class="refarence-website">
                                            Visit: <?php echo $reference; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($bottom_line)) : ?>
                                        <div class="coupon-code">
                                            <strong>🔥 <?php echo $bottom_line; ?> 🔥<br></strong>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($offer_date)) : ?>
                                        <div class="expiry">
                                            <?php echo $offer_date; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="pros-and-cons row">
                                    <?php if (!empty($pros)) : ?>
                                        <div class="pros w-50">
                                            <div class="pros-title">
                                                <h5>Pros:</h5>
                                            </div>
                                            <?php echo $pros; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($cons)) : ?>
                                        <div class="cons w-50">
                                            <div class="cons-title">
                                                <h5>Cons:</h5>
                                            </div>
                                            <?php echo $cons; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($description)) : ?>
                                    <div class="product-description">
                                        <h5 class="product-description-title">Overall</h5>
                                        <?php echo $description; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-top-gallery-container">
                                <div class="product-top-gallery row half-image justify-content-center">
                                    <?php
                                    $gallery_items = explode(',', $top_gallery);
                                    foreach ($gallery_items as $gallery_item) :
                                    ?>
                                        <img src="<?php echo $gallery_item; ?>">
                                    <?php endforeach; ?>
                                </div>
                                <div class="caption">
                                    <?php
                                    if (!empty($top_gallery_caption)) {
                                        echo sprintf('<p>%s</p>', $top_gallery_caption);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="product-authors-review">
                                <?php if (!empty($product_what_i_love)) : ?>
                                    <div class="product-what-i-love">
                                        <h4>👍 What I love</h4>
                                        <p>
                                            <?php echo $product_what_i_love; ?>
                                        </p>

                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($product__could_be_better)) : ?>
                                    <div class="product-what-i-love">
                                        <h4>👎 What could be better</h4>

                                        <p>
                                            <?php echo $product__could_be_better; ?>
                                        </p>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-bottom-gallery-container">
                                <div class="product-bottm-gallery row full-image justify-content-center">
                                    <?php
                                    $gallery_items = explode(',', $bottom_gallery);
                                    foreach ($gallery_items as $gallery_item) :
                                    ?>
                                        <img src="<?php echo $gallery_item; ?>">
                                    <?php endforeach; ?>
                                </div>
                                <div class="caption">
                                    <?php
                                    if (!empty($bottom_gallery_caption)) {
                                        echo sprintf('<p>%s</p>', $bottom_gallery_caption);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <style>
                        .pros-and-cons .pros ul li::before {
                            content: "";
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                            background: url("<?php echo get_theme_file_uri() . '/assets/images/verified-blue.png' ?>") no-repeat center;
                            background-size: contain;
                            margin-right: 8px;
                            transform: translateY(1.5px);
                        }

                        .pros-and-cons .cons ul li::before {
                            content: "";
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                            background: url("<?php echo get_theme_file_uri() . '/assets/images/cross-red.png' ?>") no-repeat center;
                            background-size: contain;
                            margin-right: 8px;
                            transform: translateY(1.5px);
                        }
                    </style>
                </div>
            </div>
        </div>


        <div class="statistics-area">
            <div class="mini-container">
                <h3>My clean protein powder score chart (scored 1-5)</h3>
                <div class="statistics-table">
                    <table class="table">
                        <tr class="tr header">
                            <th class="td">Brand</th>
                            <th class="td">Ingredients</th>
                            <th class="td">Bioavailability</th>
                            <th class="td">Taste</th>
                            <th class="td">Mixability</th>
                            <th class="td">Digestibility</th>
                            <th class="td">Price per serving</th>
                            <th class="td">Overall</th>
                        </tr>
                        <?php
                        for ($i = 1; $i <= $num_products; $i++) :
                            $name = get_post_meta(get_the_ID(), "product_{$i}_name", true);
                            $rating = get_post_meta(get_the_ID(), "product_{$i}_rating", true);
                            $rating_ingredients = get_post_meta(get_the_ID(), "product_{$i}_rating_ingredients", true);
                            $rating_bioavailability = get_post_meta(get_the_ID(), "product_{$i}_rating_bioavailability", true);
                            $rating_taste = get_post_meta(get_the_ID(), "product_{$i}_rating_taste", true);
                            $rating_mixability = get_post_meta(get_the_ID(), "product_{$i}_rating_mixability", true);
                            $rating_digestibility = get_post_meta(get_the_ID(), "product_{$i}_rating_digestibility", true);
                            $price = get_post_meta(get_the_ID(), "product_{$i}_price", true);
                        ?>
                            <tr class="tr">
                                <td class="td nobreak"><?php echo $name; ?></td>
                                <td class="td"><?php echo $rating_ingredients; ?></td>
                                <td class="td"><?php echo $rating_bioavailability; ?></td>
                                <td class="td"><?php echo $rating_taste; ?></td>
                                <td class="td"><?php echo $rating_mixability; ?></td>
                                <td class="td"><?php echo $rating_digestibility; ?></td>
                                <td class="td"><?php if (strpos($price, '$')) {
                                                    echo $price;
                                                } else {
                                                    echo '$' . $price;
                                                } ?></td>
                                <td class="td"><?php echo $rating; ?></td>
                            </tr>
                        <?php endfor; ?>

                    </table>
                </div>
            </div>
        </div>


    </div>
</div>

<?php
get_footer();
?>