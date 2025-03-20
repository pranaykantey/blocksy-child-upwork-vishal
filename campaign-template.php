<?php
/*
Template Name: Campaign Template
*/

function add_open_graph_tags()
{
    global $post;
    $intro_headline = get_post_meta(get_the_ID(), 'intro_headline', true) ?: 'I tried out the top 5 men\'s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…';
    $author_name = get_post_meta(get_the_ID(), 'author_name', true) ?: 'Peter Attia';
    $site_name = get_post_meta(get_the_ID(), 'site_name', true) ?: 'versus.reviews';
    $site_url = get_post_meta(get_the_ID(), 'site_url', true) ?: 'https://versus.reviews/';
    $meta_keywords = get_post_meta(get_the_ID(), 'meta_keywords', true);
    $meta_description = get_post_meta(get_the_ID(), 'meta_description', true);
?>
    <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($intro_headline); ?>" />
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>" />
    <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" />
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

// wp_enqueue_style('product-review-style', get_stylesheet_directory_uri() . '/product-review.css', array(), '1.1');

// $num_products = get_post_meta(get_the_ID(), 'num_products', true) ?: 5;
// $intro_headline = get_post_meta(get_the_ID(), 'intro_headline', true) ?: 'I tried out the top 5 men\'s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…';
// $intro_paragraph = get_post_meta(get_the_ID(), 'intro_paragraph', true) ?: '';
// $conclusion_headline1 = get_post_meta(get_the_ID(), 'conclusion_headline1', true) ?: 'Why I chose .....';
// $conclusion_para1 = get_post_meta(get_the_ID(), 'conclusion_para1', true) ?: 'eb5 is my clear winner for effectiveness, affordability, and versatility.';
// $conclusion_image1 = get_post_meta(get_the_ID(), 'conclusion_image1', true);
// $conclusion_para2 = get_post_meta(get_the_ID(), 'conclusion_para2', true) ?: 'Affordability is another critical factor.';
// $conclusion_headline2 = get_post_meta(get_the_ID(), 'conclusion_headline2', true) ?: 'How Does XYZ work';
// $conclusion_para3 = get_post_meta(get_the_ID(), 'conclusion_para3', true) ?: 'The effectiveness of XYZ comes down to';
// $conclusion_image2 = get_post_meta(get_the_ID(), 'conclusion_image2', true);
// $conclusion_para4 = get_post_meta(get_the_ID(), 'conclusion_para4', true) ?: '';
// $cta_text = get_post_meta(get_the_ID(), 'cta_text', true) ?: 'Learn More';
// $cta_link = get_post_meta(get_the_ID(), 'cta_link', true) ?: 'https://eb5.com/products/face-cream-for-men';
// $sidebar_ad_image = get_post_meta(get_the_ID(), 'sidebar_ad_image', true);
// $logo_url = get_post_meta(get_the_ID(), 'logo_url', true) ?: 'https://vitality.guide/wp-content/uploads/sites/5/2023/04/Vitality-Guide-logo-Photoroom-768x271.jpg';
// $author_image = get_post_meta(get_the_ID(), 'author_image', true) ?: 'https://vitality.guide/wp-content/uploads/sites/5/2024/07/WhatsApp-Image-2024-07-25-at-19.05.33.jpeg';
// $author_name = get_post_meta(get_the_ID(), 'author_name', true) ?: 'Peter Attia';
// $site_name = get_post_meta(get_the_ID(), 'site_name', true) ?: 'versus.reviews';
// $site_url = get_post_meta(get_the_ID(), 'site_url', true) ?: 'https://versus.reviews/';
// $custom_fields = get_post_meta(get_the_ID(), 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
// $best_product_category = get_post_meta(get_the_ID(), 'best_product_category', true) ?: 'facial product for men';
// $best_product_name = get_post_meta(get_the_ID(), "product_1_name", true);

// $discount_offer = get_post_meta(get_the_ID(), 'discount_offer', true);
// $discount_code = get_post_meta(get_the_ID(), 'discount_code', true);

// var_dump($num_products);
?>
<?php
while (have_posts()) : the_post(); ?>
    <main data-content="main">

        <div class="title-area">
            <div class="container" id="title-container">
                <div class="title-content">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>



        <!-- product start 1 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 1;
        $it = 2;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <!-- style="width: 100%; height: 100%; aspect-ratio: 1; overflow: hidden;" -->
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                                <!-- style="object-fit: cover; width: 100%; height: 100%;" -->
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 1 -->
        <!-- review start 1 -->
        <?php
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 1;
        $ct = 1;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                                
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 1 -->


        <!-- product start 3 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 3;
        $it = 3;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '.';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 3 -->
        <!-- review start 2 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 2;
        $ct = 2;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 2 -->

        <!-- product start 4 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 4;
        $it = 5;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 5 -->
        <!-- review start 3 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 3;
        $ct = 3;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end -->
        <!-- product start 6 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 6;
        $it = 7;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 7 -->
        <!-- review start 4 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 4;
        $ct = 4;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 4 -->
        <!-- product start 8 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 8;
        $it = 8;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 8 -->
        <!-- review start 5 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 5;
        $ct = 5;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 4 -->
        <!-- product start 9 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 9;
        $it = 10;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 10 -->
        <!-- review start 6 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 6;
        $ct = 6;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 6 -->
        <!-- product start 11 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 11;
        $it = 12;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 12 -->
        <!-- review start 7 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 7;
        $ct = 7;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 7 -->
        <!-- start repeater . -->
        <!-- product start 13 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 13;
        $it = 13;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 13 -->
        <!-- review start 8 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 8;
        $ct = 8;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 8 -->
        <!-- end repeater. -->
        <!-- start repeater . -->
        <!-- product start 14 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 14;
        $it = 15;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 15 -->
        <!-- review start 9 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 9;
        $ct = 9;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 9 -->
        <!-- end repeater. -->
        <!-- start repeater . -->
        <!-- product start 15 -->
        <?php
        // var_dump(get_the_ID());
        $num_products = get_post_meta(get_the_ID(), 'num_products', true) ? get_post_meta(get_the_ID(), 'num_products', true) : 5;
        $i = 15;
        $it = 16;
        if ($i <= $num_products) :
            while ($i <= $it) :
        ?>
                <div class="repeater-items">
                    <div class="container row">
                        <div class="repeater-left left">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_image", true))) : ?>
                                <div class="img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="image">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="repeater-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_name", true))) : ?>
                                <h3 class="repeater-title"><?php echo $i;
                                                            echo '. ';
                                                            echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "product_{$i}_pros", true))) : ?>
                                <div class="repeater-content">
                                    <p><?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $i++;
            endwhile;
        endif; ?>
        <!-- product end 15 -->
        <!-- review start 10 -->
        <?php
        // var_dump(get_the_ID());
        $num_reviews = get_post_meta(get_the_ID(), 'num_reviews', true) ? get_post_meta(get_the_ID(), 'num_reviews', true) : 5;
        $c = 10;
        $ct = 10;
        if ($c <= $num_reviews) :
            while ($c <= $ct) :
        ?>
                <div class="review-item">
                    <div class="container row">
                        <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_image", true))) : ?>
                            <div class="review-left left">
                                <div class="review-img-container">
                                    <img src="<?php echo get_post_meta(get_the_ID(), "review_{$c}_image", true); ?>" alt="image">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="review-right right">
                            <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_comment", true))) : ?>
                                <p class="review-comment">
                                    "<?php echo get_post_meta(get_the_ID(), "review_{$c}_comment", true); ?>"
                                </p>
                            <?php endif; ?>
                            <p>
                                <?php if (!empty(get_post_meta(get_the_ID(), "review_{$c}_author", true))) : ?>
                                    <span class="author"><?php echo get_post_meta(get_the_ID(), "review_{$c}_author", true); ?></span><br>
                                <?php endif; ?>
                                
                                <?php if( !empty(get_post_meta(get_the_ID(), "review_{$c}_author_designation", true))) : ?>
                                    <span><i><?php echo get_post_meta(get_the_ID(), "review_{$c}_author_designation", true); ?></i></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
                $c++;
            endwhile;
        endif;
        ?>
        <!-- review end 10 -->
        <!-- end repeater. -->


        <div class="template-footer">
            <div class="footer-content">
                <div class="footer-container row">
                    <?php if (!empty(get_post_meta(get_the_ID(), "footer_image", true))) : ?>
                        <div class="footer-top image">
                            <img src="<?php echo get_post_meta(get_the_ID(), "footer_image", true); ?>" alt="image">
                        </div>
                    <?php endif; ?>
                    <div class="footer-left left">
                        <?php if (!empty(get_post_meta(get_the_ID(), "footer_text", true))) : ?>
                            <p class="footer-text">
                                <?php echo get_post_meta(get_the_ID(), "footer_text", true); ?>
                            </p>
                        <?php endif; ?>
                        <div class="row buttons">
                            <?php if (!empty(get_post_meta(get_the_ID(), "footer_button_one_text", true))) : ?>
                                <a href="<?php echo get_post_meta(get_the_ID(), "footer_button_one_link", true); ?>" class="button-one"><?php echo get_post_meta(get_the_ID(), "footer_button_one_text", true); ?></a><br>
                            <?php endif; ?>
                            <?php if (!empty(get_post_meta(get_the_ID(), "footer_button_two_text", true))) : ?>
                                <a href="<?php echo get_post_meta(get_the_ID(), "footer_button_two_link", true); ?>" class="button-two"><?php echo get_post_meta(get_the_ID(), "footer_button_two_text", true); ?> <svg viewBox="0 0 24 24" fill="none" class="_icon_8sy5x_1" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.09998 12H20.1M20.1 12L14.1 6M20.1 12L14.1 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg></a><br>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty(get_post_meta(get_the_ID(), "footer_image", true))) : ?>
                        <div class="footer-right right">
                            <img src="<?php echo get_post_meta(get_the_ID(), "footer_image", true); ?>" alt="image">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </main>
<?php endwhile; ?>
<?php
get_footer();
?>