<?php
/*
Template Name: Product Review
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
add_action('wp_head', 'add_open_graph_tags');


get_header();

wp_enqueue_style('product-review-style', get_stylesheet_directory_uri() . '/product-review.css', array(), '1.1');

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
$site_name = get_post_meta(get_the_ID(), 'site_name', true) ?: 'versus.reviews';
$site_url = get_post_meta(get_the_ID(), 'site_url', true) ?: 'https://versus.reviews/';
$custom_fields = get_post_meta(get_the_ID(), 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
$best_product_category = get_post_meta(get_the_ID(), 'best_product_category', true) ?: 'facial product for men';
$best_product_name = get_post_meta(get_the_ID(), "product_1_name", true);

$discount_offer = get_post_meta(get_the_ID(), 'discount_offer', true);
$discount_code = get_post_meta(get_the_ID(), 'discount_code', true);

// var_dump($num_products);
?>

<div class="site">
    <div class="site-inner">
        <header class="site-header">
            <div class="site-header-main">
                <div class="site-branding">
                    <a href="<?php echo esc_url($site_url); ?>" class="custom-logo-link" rel="home">
                        <img src="<?php echo esc_url($logo_url); ?>" class="custom-logo" alt="<?php echo esc_attr($site_name); ?>" decoding="async">
                    </a>
                </div>
            </div>
        </header>

        <div class="content-area">
            <main class="site-main">
                <article id="post-<?php the_ID(); ?>" <?php post_class('product-review-article'); ?> itemscope itemtype="https://schema.org/Review">
                    <div class="post-meta">
                        <span>
                            <?php echo get_the_date('F j, Y'); ?>
                        </span>
                    </div>

                    <header class="entry-header">
                        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                    </header>

                    <div class="author-name-wrapper">
                        <div class="author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <img class="author-image" src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>" title="<?php echo esc_attr($author_name); ?>" loading="lazy">
                            <span class="author-name" itemprop="name"><?php echo esc_html($author_name); ?></span>
                        </div>
                    </div>

                    <div class="entry-content" itemprop="reviewBody">
                        <h2 class="intro-headline product-review-subtitle"><?php echo wp_kses_post($intro_headline); ?></h2>

                        <?php if (has_post_thumbnail()): ?>
                            <div class="wp-block-image">
                                <figure class="aligncenter size-large">
                                    <?php the_post_thumbnail('large', array('class' => 'featured-image', 'loading' => 'lazy')); ?>
                                </figure>
                            </div>
                        <?php endif; ?>

                        <p class="intro-paragraph has-medium-font-size" style="line-height:1.4"><?php echo wp_kses_post($intro_paragraph); ?></p>

                        <?php
                        // Store the winner section in a variable to reuse later
                        ob_start();
                        ?>
                        <div class="winner-section">
                            <div class="wp-block-media-text alignwide is-vertically-aligned-center has-background" style="background-color:#e6e6e640;grid-template-columns:15% auto">
                                <figure class="wp-block-media-text__media">
                                    <img decoding="async" width="150" height="150" src="https://vitality.guide/wp-content/uploads/sites/5/2024/07/Winner.webp" alt="" class="wp-image-241 size-full" loading="lazy">
                                </figure>
                                <div class="wp-block-media-text__content">
                                    <p class="gb-66a13a12b2fea has-text-align-left has-medium-font-size">
                                        <mark style="background-color:rgba(0, 0, 0, 0);color:#0041e5" class="has-inline-color">
                                            <strong><a href="<?php echo esc_url($cta_link); ?>"><?php echo esc_html($best_product_name); ?></a></strong>
                                        </mark> is my winning choice for the overall best <?php echo esc_html($best_product_category); ?>.
                                    </p>
                                </div>
                            </div>

                            <div class="wp-block-buttons is-content-justification-center is-layout-flex wp-container-core-buttons-layout-1 wp-block-buttons-is-layout-flex">
                                <div class="wp-block-button has-custom-width wp-block-button__width-75 has-custom-font-size aligncenter is-style-fill has-medium-font-size">
                                    <a class="wp-block-button__link has-bright-blue-background-color has-background wp-element-button" href="<?php echo esc_url($cta_link); ?>" style="border-radius:20px" target="_blank" rel="noreferrer noopener"><?php echo esc_html($cta_text); ?></a>
                                </div>
                            </div>

                            <p class="has-text-align-center">
                                <strong>Get <?php echo esc_html($discount_offer); ?> Your Purchase!</strong>
                                <br>
                                <strong>With Special Promo Code
                                    <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-vivid-red-color"><?php echo esc_html($discount_code); ?></mark>
                                </strong>
                                <br>
                                <strong>Exclusive for Vitality Guide Readers!</strong>
                            </p>
                        </div>
                        <?php
                        $winner_section = ob_get_clean();
                        ?>

                        <?php
                        for ($i = 1; $i <= $num_products; $i++) :
                            $name = get_post_meta(get_the_ID(), "product_{$i}_name", true);
                            $rating = get_post_meta(get_the_ID(), "product_{$i}_rating", true);
                            $image = get_post_meta(get_the_ID(), "product_{$i}_image", true);
                            $description = get_post_meta(get_the_ID(), "product_{$i}_description", true);
                        ?>

                            <div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product">
                                <h2 style="font-size: 28px;">
                                    <strong>
                                        <?php echo $i . ". "; ?>
                                        <?php if ($i === 1): ?>
                                            <a href="<?php echo esc_url($cta_link); ?>" target="_blank" rel="noopener noreferrer">
                                                <span itemprop="name"><?php echo esc_html($name); ?></span>
                                            </a>
                                        <?php else: ?>
                                            <span itemprop="name"><?php echo esc_html($name); ?></span>
                                        <?php endif; ?>
                                    </strong>
                                </h2>

                                <div class="wp-block-image product-image-container">
                                    <figure class="aligncenter size-large">
                                        <?php if ($i === 1): ?>
                                            <a href="<?php echo esc_url($cta_link); ?>" target="_blank" rel="noopener noreferrer">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy" itemprop="image">
                                            </a>
                                        <?php else: ?>
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy" itemprop="image">
                                        <?php endif; ?>
                                    </figure>
                                </div>

                                <p class="has-background" style="background-color: #e6e6e640">
                                    <?php foreach ($custom_fields as $field):
                                        $field_key = sanitize_key($field);
                                        $field_value = get_post_meta(get_the_ID(), "product_{$i}_{$field_key}", true);
                                    ?>
                                        <strong><?php echo esc_html($field); ?></strong>:
                                        <mark class="has-inline-color has-bright-blue-color"><?php echo esc_html($field_value); ?></mark>
                                        <br>
                                    <?php endforeach; ?>
                                    <strong><strong><strong>Overall Rating</strong></strong></strong>
                                    <span itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                                        <meta itemprop="worstRating" content="1">
                                        <meta itemprop="bestRating" content="5">
                                        <meta itemprop="ratingValue" content="<?php echo esc_attr($rating); ?>">
                                        <mark class="has-inline-color has-bright-blue-color"><?php echo esc_html($rating); ?></mark>
                                    </span>
                                </p>

                                <div itemprop="description">
                                    <?php echo wpautop(wp_kses_post($description)); ?>
                                </div>

                                <?php
                                // Display the winner section after the first product
                                if ($i === 1) {
                                    echo $winner_section;
                                }
                                ?>
                            </div>
                        <?php endfor; ?>

                        <div class="conclusion">
                            <h3><?php echo wp_kses_post($conclusion_headline1); ?></h3>
                            <p><?php echo wp_kses_post($conclusion_para1); ?></p>

                            <?php if ($conclusion_image1): ?>
                                <div class="wp-block-image">
                                    <figure class="aligncenter size-large">
                                        <img src="<?php echo esc_url($conclusion_image1); ?>" alt="Conclusion Image 1" loading="lazy">
                                    </figure>
                                </div>
                            <?php endif; ?>

                            <p><?php echo wp_kses_post($conclusion_para2); ?></p>

                            <h3><?php echo wp_kses_post($conclusion_headline2); ?></h3>
                            <p><?php echo wp_kses_post($conclusion_para3); ?></p>

                            <?php if ($conclusion_image2): ?>
                                <div class="wp-block-image">
                                    <figure class="aligncenter size-large">
                                        <img src="<?php echo esc_url($conclusion_image2); ?>" alt="Conclusion Image 2" loading="lazy">
                                    </figure>
                                </div>
                            <?php endif; ?>

                            <p><?php echo wp_kses_post($conclusion_para4); ?></p>
                        </div>

                        <!-- Repeat the winner section at the end of the blog -->
                        <?php echo $winner_section; ?>

                        <div class="cta-section">
                            <a href="<?php echo esc_url($cta_link); ?>" class="cta-button"><?php echo esc_html($cta_text); ?></a>
                        </div>
                    </div>
                </article>
            </main>

            <?php if ($sidebar_ad_image): ?>
                <aside class="sidebar widget-area">
                    <a>
                        <img src="<?php echo esc_url($sidebar_ad_image); ?>" alt="Sidebar Ad" class="sidebar-ad-image" loading="lazy">
                    </a>
                </aside>
            <?php endif; ?>
        </div>

        <footer class="site-footer">
            <div class="site-info">
                <span class="site-title"><a href="<?php echo esc_url($site_url); ?>" rel="home"><?php echo esc_html($site_name); ?></a></span>
                All Rights Reserved
            </div>
        </footer>
    </div>
</div>

<?php
get_footer();
?>