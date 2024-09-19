<?php
/*
Template Name: Product Comparison
*/

get_header();

wp_enqueue_style('product-comparison-style', get_template_directory_uri() . '/product-comparison.css', array(), '1.1');
wp_enqueue_script('product-comparison-script', get_template_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

$post_id = get_the_ID();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Rasa:ital,wght@0,300..700;1,300..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="conparison-main-container">
    
    <div class="container comparision-template-container">
        <div class="sticky-header">
            <nav>
                <a href="#benefits" class="active"><?php echo get_post_meta($post_id, 'benefits_nav_text', true); ?></a>
                <a href="#key-ingredients"><?php echo get_post_meta($post_id, 'ingredients_nav_text', true); ?></a>
                <a href="#top-5"><?php echo get_post_meta($post_id, 'top_5_nav_text', true); ?></a>
            </nav>
           <div class="progress-indicator">
                <div class="progress-circle">
                    <span class="progress-percentage">0%</span>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="content-area">
                <p class="disclosure-top"><?php echo get_post_meta($post_id, 'disclosure_top', true); ?></p>
                <h1><?php the_title(); ?></h1>
                <h2><?php echo get_post_meta($post_id, 'subtitle', true); ?></h2>
                <div class="tab-area-container">
                    <ul class="tab-ul">
                        <li class="li tab-li">
                            <a href="#benefits"><?php echo get_post_meta($post_id, 'benefits_nav_text', true); ?></a>
                        </li>
                        <li class="li tab-li li-active">
                            <a href="#key-ingredients"><?php echo get_post_meta($post_id, 'ingredients_nav_text', true); ?></a>
                        </li>
                        <li class="li tab-li">
                            <a href="#top-5"><?php echo get_post_meta($post_id, 'top_5_nav_text', true); ?></a>-
                        </li>
                    </ul>
                </div>
                <p class="disclosure"><a href="#"><?php echo get_post_meta($post_id, 'disclosure', true); ?></a></p>
                <div class="main-iamge">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <div class="health-benefits">
                    <!-- Add your health benefits icons here -->
                    <div class="benefit-item">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cognitive-health-icon.png" alt="Cognitive Health">
                        <span>Cognitive Health</span>
                    </div>
                    <!-- Add more benefit items as needed -->
                </div>



                <section id="benefits" class="benefits">
                    <div class="benifits-title heading-container">
                        <h2><?php echo get_post_meta($post_id, 'benefits_title', true); ?></h2>
                    </div>
                    <div class="benifits-content field-content">
                        <?php
                            $benifit_get =  wpautop(get_post_meta($post_id, 'benefits_content', true));
                            $field_value = $benifit_get;
                            $regex = '/<h4(.*?)>/';
                            $regexicon = '/<i(.*)>/';

                            $replace = '<h4$1><i class="fa-solid fa-check"></i>';

                            if( 0 === preg_match_all($regexicon, $field_value) ) {
                                $meta_value = preg_replace($regex, $replace, $field_value);
                            }else {
                                $meta_value = $field_value;
                            }
                            echo $meta_value;

                            // echo preg_match_all('/<h4(.*?)>(.*?)<\/h4>/', $field_value);
                        ?>
                    </div>
                </section>
                
                <section id="usage" class="usage">
                    <div class="usage-title ">
                        <h2><?php echo get_post_meta($post_id, 'usage_title', true); ?></h2>
                    </div>
                    <div class="usage-content ">
                        <?php
                            $usage_content = wpautop(get_post_meta($post_id, 'usage_content', true));
                            
                            $field_value = $usage_content;
                            $regex = '/<h4(.*?)>/';
                            $regexicon = '/<i(.*)>/';

                            $replace = '<h4$1><i class="fa-solid fa-xmark"></i>';

                            if( 0 === preg_match_all($regexicon, $field_value) ) {
                                $meta_value = preg_replace($regex, $replace, $field_value);
                            }else {
                                $meta_value = $field_value;
                            }
                            echo $meta_value;
                        ?>
                    </div>
                </section>

                <section id="key-ingredients" class="key-ingredients">
                    <div class="what-to-look-for">
                        <div class="key-indgredients-title heading-container">
                            <h2><?php echo get_post_meta($post_id, 'ingredients_to_look_for_title', true); ?></h2>
                        </div>
                        <div class="key-ingredients-content field-content">
                            <?php
                                $ingredients_to_look_for_content = wpautop(get_post_meta($post_id, 'ingredients_to_look_for_content', true));
                                
                                $field_value = $ingredients_to_look_for_content;
                                $regex = '/<h4(.*?)>/';
                                $regexicon = '/<i(.*)>/';

                                $replace = '<h4$1><i class="fa-solid fa-check"></i>';

                                if( 0 === preg_match_all($regexicon, $field_value) ) {
                                    $meta_value = preg_replace($regex, $replace, $field_value);
                                }else {
                                    $meta_value = $field_value;
                                }
                                echo $meta_value;
                            ?>
                        </div>
                    </div>
                    <div class="what-to-avoid">
                        <div class="what-to-avoid-title heading-container">
                            <h2><?php echo get_post_meta($post_id, 'ingredients_to_avoid_title', true); ?></h2>
                        </div>
                        <div class="what-to-avoid-content field-content">
                            <?php
                                $ingredients_to_avoid_content = wpautop(get_post_meta($post_id, 'ingredients_to_avoid_content', true));
                                
                                
                                $field_value = $ingredients_to_avoid_content;
                                $regex = '/<h4(.*?)>/';
                                $regexicon = '/<i(.*)>/';

                                $replace = '<h4$1><i class="fa-solid fa-xmark"></i>';

                                if( 0 === preg_match_all($regexicon, $field_value) ) {
                                    $meta_value = preg_replace($regex, $replace, $field_value);
                                }else {
                                    $meta_value = $field_value;
                                }
                                echo $meta_value;
                            ?>
                        </div>
                    </div>
                </section>
                
                <section id="consider" class="consider">
                    <div class="consider-title heading-container">
                        <h2><?php echo get_post_meta($post_id, 'considerations_title', true); ?></h2>
                    </div>
                    <div class="consider-content field-content">
                        <?php
                            $considerations_content = wpautop(get_post_meta($post_id, 'considerations_content', true));
                            
                                
                            $field_value = $considerations_content;
                            $regex = '/<h4(.*?)>/';
                            $regexicon = '/<i(.*)>/';

                            $replace = '<h4$1><i class="fa-solid fa-check"></i>';

                            if( 0 === preg_match_all($regexicon, $field_value) ) {
                                $meta_value = preg_replace($regex, $replace, $field_value);
                            }else {
                                $meta_value = $field_value;
                            }
                            echo $meta_value;
                        ?>
                    </div>
                </section>
                <div class="products-number-title">
                    <h2><?php echo get_post_meta($post_id, 'top_products_title', true); ?></h2>
                </div>
                <section id="top-5" class="product-comparison">
                    <?php
                    $num_products = intval(get_post_meta($post_id, 'num_products', true));
                    for ($i = 1; $i <= $num_products; $i++) {
                        $product_name = get_post_meta($post_id, "product_{$i}_name", true);
                        $product_brand = get_post_meta($post_id, "product_{$i}_brand", true);
                        $product_link = get_post_meta($post_id, "product_{$i}_link", true);
                        $product_image = get_post_meta($post_id, "product_{$i}_image", true);
                        $product_rating = get_post_meta($post_id, "product_{$i}_rating", true);
                        $product_grade = get_post_meta($post_id, "product_{$i}_grade", true);
                        $product_pros = get_post_meta($post_id, "product_{$i}_pros", true);
                        $product_cons = get_post_meta($post_id, "product_{$i}_cons", true);
                        $product_bottom_line = get_post_meta($post_id, "product_{$i}_bottom_line", true);
                        ?>
                        <div class="product-card">
                            <div class="product-header">
                                <div class="product-header-top d-flex">
                                    <div class="header-top-left w-50">
                                        <h3><?php echo esc_html($i . '. ' . $product_name); ?></h3>
                                        <p class="product-brand">by <?php echo esc_html($product_brand); ?></p>
                                    </div>
                                    <div class="header-top-right w-50">

                                    </div>
                                </div>
                                <div class="product-header-bottom d-flex">
                                    <div class="product-image loop w-50">
                                        <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_name); ?>" />
                                    </div>
                                    <div class="product-grade w-50">
                                        <span><?php echo esc_html($product_grade); ?></span>
                                        <p>OVERALL GRADE</p>
                                    </div>
                                </div>
                            </div>

                            <div class="product-description d-flex">
                                <div class="product-pros-cons w-50">
                                    <div class="pros">
                                        <h4>PROS</h4>
                                        <?php echo wpautop($product_pros); ?>
                                    </div>
                                    
                                    <div class="cons">
                                        <h4>CONS</h4>
                                        <?php echo wpautop($product_cons); ?>
                                    </div>
                                </div>
                                <div class="product-description-content w-50">
                                    <div class="product-bottom-line">
                                        <h4>The Bottom Line</h4>
                                        <?php echo wpautop($product_bottom_line); ?>
                                    </div>

                                    <div class="product-rating">
                                        <span>Total Ranking</span>
                                        <p><?php echo esc_html($product_rating); ?>/10</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="product-footer">
                                <a class="learn-more" href="<?php echo esc_url($product_link); ?>">Learn More</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </section>

                <section class="citations">
                    <h2><?php echo get_post_meta($post_id, 'citations_title', true); ?></h2>
                    <div class="citations-content">
                        <?php echo wpautop(get_post_meta($post_id, 'citations', true)); ?>
                    </div>
                </section>
                
                <div class="back-to-top">
                    <a href="#top-5"><?php echo get_post_meta($post_id, 'back_to_top_text', true); ?></a>
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-one">
                    <div class="sidebar-content sidebar-content-1">
                        <?php if( !empty( get_post_meta($post_id, 'sidebar_1_title', true) ) ) {
                            echo '<h3>' . get_post_meta($post_id, 'sidebar_1_title', true) . '</h3>';
                        } ?>
                        
                        <?php if( !empty( get_post_meta($post_id, 'sidebar_1_image_1', true) ) ) : ?>
                        <div class="sidebar-item">
                            <img src="<?php echo get_post_meta($post_id, 'sidebar_1_image_1', true); ?>">
                        </div>
                        <?php endif; ?>

                        <?php if( !empty( get_post_meta($post_id, 'sidebar_1_image_2', true) ) ) : ?>
                        <div class="sidebar-item">
                            <img src="<?php echo get_post_meta($post_id, 'sidebar_1_image_2', true); ?>">
                        </div>
                        <?php endif; ?>

                        <?php if( !empty( get_post_meta($post_id, 'sidebar_1_subtitle', true) ) ) : ?>
                        <div class="sidebar-item">
                            <p><?php echo get_post_meta($post_id, 'sidebar_1_subtitle', true); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sidebar-two element-b">
                    <div class="sidebar-content">
                        <?php if( !empty( get_post_meta($post_id, 'sidebar_2_title', true) ) ) {
                            echo '<h3>' . get_post_meta($post_id, 'sidebar_2_title', true) . '</h3>';
                        } ?>
                        <div class="estimated-read-time">
                            <div class="progress-left">
                                <div class="progress-ring">
                                    <svg>
                                        <circle cx="30" cy="30" r="28"></circle>
                                        <circle cx="30" cy="30" r="28"></circle>
                                    </svg>
                                    <!-- <svg>
                                        <circle cx="40" cy="40" r="40"></circle>
                                        <circle cx="40" cy="40" r="40"></circle>
                                    </svg> -->
                                    <!-- <div class="reading-progress" data-uw-styling-context="true">
                                        <div class="percent" data-uw-styling-context="true">100%</div>
                                        <svg class="progress-circle" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="xMinYMin meet" data-uw-styling-context="true"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 300ms linear; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 0px;" data-uw-styling-context="true"></path> </svg>
                                        <svg class="progress-circle-background" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="xMinYMin meet" data-uw-styling-context="true"> <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 300ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 0;" data-uw-styling-context="true"></path></svg>
                                    </div> -->
                                    <div class="progress-text">
                                        <span class="percentage">0%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-right">
                            <?php if( !empty( get_post_meta($post_id, 'sidebar_2_subtitle', true) ) ) {
                            echo '<p>' . get_post_meta($post_id, 'sidebar_2_subtitle', true) . '</p>';
                        } ?>
                            </div>
                            
                        </div>
                        <ul class="sidebar-nav sidebar-item">

                            <?php
                            $x = 0;
                            while( $x < 6 ) : $x++;
                                if( !empty( get_post_meta($post_id, "sidebar_2_link_title_{$x}", true ))) : ?>
                            <li>
                                <?php
                                    if( 'active' === get_post_meta($post_id, "sidebar_2_icon_{$x}", true) ) {
                                        echo '<span class="active"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg></span>';
                                    }else {
                                        echo '<span class="inactive"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></span>';
                                    }
                                ?>
                                <a href="<?php echo get_post_meta($post_id, "sidebar_2_link_{$x}", true ); ?>"><?php echo get_post_meta($post_id, "sidebar_2_link_title_{$x}", true ); ?></a>
                            </li>
                            <?php
                        
                                endif;
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script>
   class StickySections {
    constructor(containerElement) {
        this.container = {
        el: containerElement,
        }
        this.sections = Array.from(this.container.el.querySelectorAll('section'));
        this.initContainer = this.initContainer.bind(this);
        this.init();
    }

    initContainer() {
        this.container.el.style.setProperty('--stick-items', `${this.sections.length + 1}00vh`);
    }
    
    init() {
        this.initContainer();
    }  
    }

    // Init StickySections
    const sectionsContainer = document.querySelectorAll('[data-sticky-sections]');
    sectionsContainer.forEach((section) => {
    new StickySections(section);
    });
</script> -->
<?php get_footer(); ?>
