<?php
/*
Template Name: Product simple_sidebar
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

// wp_enqueue_style('google-fonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', false);
// wp_enqueue_style('google-fonts-open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap', false);
// wp_enqueue_style('product-simple_sidebar-style', get_stylesheet_directory_uri() . '/css/simple-with-sidebar.css', array(), '1.1');
// wp_enqueue_script('product-simple_sidebar-script', get_stylesheet_directory_uri() . '/product-simple_sidebar.js', array('jquery'), '1.1', true);

$post_id = get_the_ID();
?>


<div id="content" class="site">
    <div class="site-inner">
        <?php while (have_posts()) : the_post(); ?>
            <div id="primary" class="content-area">
                <main id="main" class="site-main">

                    <article id="post-2558" class="post-2558 post type-post status-publish format-standard hentry category-wellness tag-sahmpoo-top-5-steps">

                        <div class="top-string" style="margin-bottom: 20px;">
                        </div>

                        <div class="post-meta">
                            <span class="entry-date"><?php the_time('F j, Y'); ?></span>
                        </div>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header><!-- .entry-header -->



                        <!--    -->
                        <!--    === Autor Props ===-->
                        <!-- author_name -->
                        <?php if (get_post_meta(get_the_ID(), "author_name", true) || get_post_meta(get_the_ID(), "author_image", true)) : ?>
                            <div class="author-name-wrapper">
                                <div class="author">
                                    <?php if (get_post_meta(get_the_ID(), "author_image", true)) : ?>
                                        <img class="author-image" src="<?php echo get_post_meta(get_the_ID(), "author_image", true); ?>" alt="<?php if (get_post_meta(get_the_ID(), "author_name", true)) {
                                                                                                                                                    echo get_post_meta(get_the_ID(), "author_name", true);
                                                                                                                                                } ?>" title="<?php if (get_post_meta(get_the_ID(), "author_name", true)) {
                                                                                                                                                                    echo get_post_meta(get_the_ID(), "author_name", true);
                                                                                                                                                                } ?>">
                                    <?php endif; ?>
                                    <?php if (get_post_meta(get_the_ID(), "author_name", true)) : ?>
                                        <span class="author-name"><?php echo get_post_meta(get_the_ID(), "author_name", true); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--    END-->

                        <div class="entry-content">
                            <div class="wp-block-image">
                                <figure class="aligncenter size-large">
                                    <?php the_post_thumbnail(); ?>
                                </figure>
                            </div>

                            <?php if (get_post_meta(get_the_ID(), "subtitle", true)) : ?>
                                <div class="subtitle">
                                    <?php echo get_post_meta(get_the_ID(), "subtitle", true); ?>
                                </div>
                            <?php endif; ?>



                            <div class="post-main-content">
                                <?php the_content(); ?>
                            </div>

                            <?php
                            $num_products = get_post_meta(get_the_ID(), 'num_products', true) ?: 5;
                            $i = 1;
                            while ($i <= $num_products) :
                            ?>
                                <div class="product-repeater-item">
                                    <?php if (get_post_meta(get_the_ID(), "product_{$i}_name", true)) : ?>
                                        <h2 class="wp-block-heading heading-2"><?php echo $i; ?>. <strong><?php echo get_post_meta(get_the_ID(), "product_{$i}_name", true); ?></strong></h2>
                                    <?php endif; ?>

                                    <?php if (get_post_meta(get_the_ID(), "product_{$i}_image", true)) : ?>
                                        <div class="wp-block-image">
                                            <figure class="aligncenter size-large is-resized">
                                                <img decoding="async" width="1024" height="1024" src="<?php echo get_post_meta(get_the_ID(), "product_{$i}_image", true); ?>" alt="" class="wp-image-2561" style="aspect-ratio:16/9;object-fit:cover;width:848px;height:auto">
                                            </figure>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (get_post_meta(get_the_ID(), "product_{$i}_cons", true)) : ?>
                                        <div class="repeater-item-cons">
                                            <?php echo get_post_meta(get_the_ID(), "product_{$i}_cons", true); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (get_post_meta(get_the_ID(), "product_{$i}_pros", true)) : ?>
                                        <div class="repeater-item-content">
                                            <?php echo get_post_meta(get_the_ID(), "product_{$i}_pros", true); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php $i++;
                            endwhile; ?>


                            <!-- // 'considerations_title',
    // 'considerations_image',
    // 'considerations_content', -->

                            <?php if (get_post_meta(get_the_ID(), "considerations_title", true)) :
                                if (hasHeadingTag(get_post_meta(get_the_ID(), "considerations_title", true))) :
                            ?>
                                    <?php echo get_post_meta(get_the_ID(), "considerations_title", true); ?>
                                <?php else: ?>
                                    <h2 class="wp-block-heading"><strong><?php echo get_post_meta(get_the_ID(), "considerations_title", true); ?></strong></h2>
                            <?php endif;
                            endif; ?>

                            <?php if (get_post_meta(get_the_ID(), "considerations_image", true)) : ?>
                                <div class="wp-block-image">
                                    <figure class="aligncenter size-large"><img loading="lazy" decoding="async" width="1024" height="1024" src="<?php echo get_post_meta(get_the_ID(), "considerations_image", true); ?>" alt="" class="wp-image-2569" sizes="(max-width: 1024px) 100vw, 1024px"></figure>
                                </div>
                            <?php endif; ?>

                            <?php if (get_post_meta(get_the_ID(), "considerations_content", true)) : ?>
                                <?php echo get_post_meta(get_the_ID(), "considerations_content", true); ?>
                            <?php endif; ?>



                            <div class="wp-block-media-text alignwide is-vertically-aligned-center has-background" style="background-color:#e6e6e640;grid-template-columns:15% auto">

                                <?php if (get_post_meta(get_the_ID(), "footer_image", true)) : ?>
                                    <figure class="wp-block-media-text__media">
                                        <!-- footer_image_link -->
                                        <?php if (get_post_meta(get_the_ID(), "footer_image_link", true)) : ?>
                                            <a href="<?php echo get_post_meta(get_the_ID(), "footer_image_link", true); ?>">
                                            <?php endif; ?>
                                            <img loading="lazy" decoding="async" width="150" height="150" src="<?php echo get_post_meta(get_the_ID(), "footer_image", true); ?>" alt="" class="wp-image-241 size-full">
                                            <?php if (get_post_meta(get_the_ID(), "footer_image_link", true)) : ?>
                                            </a>
                                        <?php endif; ?>
                                    </figure>
                                <?php endif; ?>

                                <?php if (get_post_meta(get_the_ID(), "footer_text", true)) : ?>
                                    <div class="wp-block-media-text__content">
                                        <style>
                                            .gb-671f60b7c49f9 {
                                                font-size: 20px;
                                            }

                                            @media only screen and (max-width: 600px) {
                                                .gb-671f60b7c49f9 {
                                                    font-size: 14px !important;
                                                }
                                            }
                                        </style>
                                        <div class="gb-671f60b7c49f9 has-text-align-left has-medium-font-size"><mark style="background-color:rgba(0, 0, 0, 0);color:#0041e5" class="has-inline-color">
                                                <?php if (get_post_meta(get_the_ID(), "footer_text_link", true)) : ?>
                                                    <a href="<?php echo get_post_meta(get_the_ID(), "footer_text_link", true); ?>">
                                                    <?php endif; ?>
                                                    <strong><?php echo get_post_meta(get_the_ID(), "footer_text", true); ?></strong>
                                                    <?php if (get_post_meta(get_the_ID(), "footer_text_link", true)) : ?>
                                                    </a>
                                                <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>



                            <?php if (get_post_meta(get_the_ID(), "footer_button_one_text", true)) : ?>
                                <div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
                                    <div class="wp-block-button has-custom-width wp-block-button__width-75 has-custom-font-size aligncenter is-style-fill has-medium-font-size">
                                        <a class="wp-block-button__link has-bright-blue-background-color has-background wp-element-button" href="<?php if (get_post_meta(get_the_ID(), "footer_button_one_text", true)) {
                                                                                                                                                        echo get_post_meta(get_the_ID(), "footer_button_one_link", true);
                                                                                                                                                    } else {
                                                                                                                                                        echo '#';
                                                                                                                                                    } ?>" style="border-radius:20px" target="_blank" rel="noreferrer noopener"><?php echo get_post_meta(get_the_ID(), "footer_button_one_text", true); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (get_post_meta(get_the_ID(), "footer_button_two_text", true)) : ?>
                                <div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
                                    <div class="wp-block-button has-custom-width wp-block-button__width-75 has-custom-font-size aligncenter is-style-fill has-medium-font-size">
                                        <a class="wp-block-button__link has-bright-blue-background-color has-background wp-element-button" href="<?php if (get_post_meta(get_the_ID(), "footer_button_two_text", true)) {
                                                                                                                                                        echo get_post_meta(get_the_ID(), "footer_button_two_link", true);
                                                                                                                                                    } else {
                                                                                                                                                        echo '#';
                                                                                                                                                    } ?>" style="border-radius:20px" target="_blank" rel="noreferrer noopener"><?php echo get_post_meta(get_the_ID(), "footer_button_two_text", true); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>



                            <div style="color:#ddd" class="wp-block-genesis-blocks-gb-spacer gb-block-spacer gb-divider-solid gb-divider-size-1">
                                <hr style="height:30px">
                            </div>



                            <?php if (get_post_meta(get_the_ID(), "footer_ad_image", true)) : ?>
                                <p class="has-text-align-center has-medium-gray-color has-text-color has-small-font-size" style="line-height:0">Sponsored by</p>
                                <div class="wp-block-image">
                                    <figure class="aligncenter size-full">
                                        <!-- footer_ad_image_link -->
                                        <?php if (get_post_meta(get_the_ID(), "footer_ad_image_link", true)) : ?>
                                            <a href="<?php echo get_post_meta(get_the_ID(), "footer_ad_image_link", true); ?>">
                                            <?php endif; ?>
                                            <img loading="lazy" decoding="async" width="300" height="250" src="<?php echo get_post_meta(get_the_ID(), "footer_ad_image", true); ?>" alt="" class="wp-image-407">

                                            <?php if (get_post_meta(get_the_ID(), "footer_ad_image_link", true)) : ?>
                                            </a>
                                        <?php endif; ?>
                                    </figure>
                                </div>
                            <?php endif; ?>
                        </div><!-- .entry-content -->

                    </article><!-- #post-2558 -->

                </main>

                <aside id="secondary" class="sidebar widget-area">
                    <!-- sidebar_ad_image -->
                    <?php if (get_post_meta(get_the_ID(), "sidebar_ad_image", true)) : ?>
                        <?php if (get_post_meta(get_the_ID(), "sidebar_ad_image_link", true)) : ?>
                            <a href="<?php echo get_post_meta(get_the_ID(), "sidebar_ad_image_link", true); ?>">
                            <?php endif; ?>
                            <img src="<?php echo get_post_meta(get_the_ID(), "sidebar_ad_image", true); ?>" class="banner-sidebar">

                            <?php if (get_post_meta(get_the_ID(), "sidebar_ad_image_link", true)) : ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <section id="block-7" class="widget widget_block"></section>
                </aside><!-- .sidebar .widget-area -->
            </div>
        <?php endwhile; ?>
    </div><!-- .site-wrapper -->
</div>

<?php
get_footer();
?>