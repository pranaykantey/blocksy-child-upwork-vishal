<?php
// Metabox fields.
      // How to use: $meta_value = get_post_meta( $post_id, $field_id, true );
      // Example: get_post_meta( get_the_ID(), "my_metabox_field", true );

      class ProductsMetaboxFiedls {

        private $screens = array('post');
        
        private $fields = array(
          array(
            'label' => 'Disclosure Top',
            'id' => 'disclosure_top',
            'type' => 'text',
          ),
        );

        public function __construct() {
          add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
          add_action( 'save_post', array( $this, 'save_fields' ) );
        }

        public function add_meta_boxes() {
          foreach ( $this->screens as $s ) {
            add_meta_box(
              'CustomFieldsTwo',
              __( 'Products Metabox', 'blocksy-child' ),
              array( $this, 'meta_box_callback' ),
              $s,
              'normal',
              'high'
            );
          }
        }

        public function meta_box_callback( $post ) {
          wp_nonce_field( 'CustomFieldsTwo_data', 'CustomFieldsTwo_nonce' ); 
          $this->field_generator( $post );
        }

        public function field_generator( $post ) {
          $outputHtml = "<h2> This fields area generated form Number Of Products ( Change number and save to see result )</h2>";
          $post_id = $post->ID;
          $iLimit = get_post_meta($post_id, 'num_products',true);
          $iLimit = isset( $iLimit ) ? $iLimit : 0;
          $i = 0;
          $label = '';
          $input = '';
            while( $i < $iLimit ) : $i++;
                    // $product_name = get_post_meta($post_id, "product_{$i}_name", true);
                    // $product_brand = get_post_meta($post_id, "product_{$i}_brand", true);
                    // $product_link = get_post_meta($post_id, "product_{$i}_link", true);
                    // $product_image = get_post_meta($post_id, "product_{$i}_image", true);
                    // $product_rating = get_post_meta($post_id, "product_{$i}_rating", true);
                    // $product_grade = get_post_meta($post_id, "product_{$i}_grade", true);
                    // $product_pros = get_post_meta($post_id, "product_{$i}_pros", true);
                    // $product_cons = get_post_meta($post_id, "product_{$i}_cons", true);
                    // $product_bottom_line = get_post_meta($post_id, "product_{$i}_bottom_line", true);
                    
                    $product_name = "product_{$i}_name";
                    $product_brand = "product_{$i}_brand";
                    $product_link = "product_{$i}_link";
                    $product_image = "product_{$i}_image";
                    $product_rating = "product_{$i}_rating";
                    $product_grade = "product_{$i}_grade";
                    $product_pros = "product_{$i}_pros";
                    $product_cons = "product_{$i}_cons";
                    $product_bottom_line = "product_{$i}_bottom_line";
                    $outputHtml .= '<div class="container-for-metabox"><h3> Product '. $i . '</h3>';
                    // product name 
                    $label = '<label for="' . $product_name . '">' . 'Product '. $i . ' Name' . '</label>';

                    $meta_value = get_post_meta( $post->ID, $product_name, true );
                    // var_dump($product_name);
                    
                    $input = sprintf(
                      '<input %s id="%s" name="%s" type="%s" value="%s">',
                      'style="width: 100%"',
                      $product_name,
                      $product_name,
                      'text',
                      $meta_value
                    );
                    // end product name
                    $outputHtml .= $this->format_rows( $label, $input );

                    // product brand 
                    $label = '<label for="' . $product_brand . '">' . 'Product '. $i . ' Brand' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_brand, true );
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        'style="width: 100%"',
                        $product_brand,
                        $product_brand,
                        'text',
                        $meta_value
                    );
                    // end product brand
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product link 
                    $label = '<label for="' . $product_link . '">' . 'Product '. $i . 'link' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_link, true );
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        'style="width: 100%"',
                        $product_link,
                        $product_link,
                        'text',
                        $meta_value
                    );
                    // end product link
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product image 
                    $label = '<label for="' . $product_image . '">' . 'Product '. $i . ' Image' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_image, true );
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        'style="width: 100%"',
                        $product_image,
                        $product_image,
                        'text',
                        $meta_value
                    );
                    // end product image
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product rating 
                    $label = '<label for="' . $product_rating . '">' . 'Product '. $i . ' Rating' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_rating, true );
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        'style="width: 100%"',
                        $product_rating,
                        $product_rating,
                        'text',
                        $meta_value
                    );
                    // end product rating
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product product_grade 
                    $label = '<label for="' . $product_grade . '">' . 'Product '. $i . ' Grade' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_grade, true );
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        'style="width: 100%"',
                        $product_grade,
                        $product_grade,
                        'text',
                        $meta_value
                    );
                    // end product product_grade
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product product_pros 
                    $label = '<label for="' . $product_pros . '">' . 'Product '. $i . ' Pros' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_pros, true );

                    // $regex = '/<li(.*?)>/';
                    // $regexicon = '/<i class="fa-solid fa-check"><\/i>/';
                    // $replace = '<li$1><i class="fa-solid fa-check"></i>';
                    
                    // // echo preg_replace($regex, $replace, $str);

                    // if( preg_match_all($regex, $field_value) != preg_match_all($regexicon, $field_value) ) {
                    //   $meta_value = preg_replace($regex, $replace, $field_value);
                    // }else {
                    //   $meta_value = $field_value;
                    // }

                    ob_start();
                    wp_editor(  $meta_value, $product_pros, $settings = array('textarea_name'=>$product_pros) );
                    $input = ob_get_clean();
                    // $input = sprintf(
                    //     '<input %s id="%s" name="%s" type="%s" value="%s">',
                    //     'style="width: 100%"',
                    //     $product_pros,
                    //     $product_pros,
                    //     'text',
                    //     $meta_value
                    // );
                    // end product product_pros
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product product_cons 
                    $label = '<label for="' . $product_cons . '">' . 'Product '. $i . ' Cons' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_cons, true );
                    
                    // $regex = '/<li(.*?)>/';
                    // $regexicon = '/<i class="fa-solid fa-xmark"><\/i>/';
                    // $replace = '<li$1><i class="fa-solid fa-xmark"></i>';
                    
                    // // echo preg_replace($regex, $replace, $str);

                    // if( preg_match_all($regex, $field_value) != preg_match_all($regexicon, $field_value) ) {
                    //   $meta_value = preg_replace($regex, $replace, $field_value);
                    // }else {
                    //   $meta_value = $field_value;
                    // }

                    ob_start();
                    wp_editor(  $meta_value, $product_cons, $settings = array('textarea_name'=>$product_cons) );
                    $input = ob_get_clean();

                    // $input = sprintf(
                    //     '<input %s id="%s" name="%s" type="%s" value="%s">',
                    //     'style="width: 100%"',
                    //     $product_cons,
                    //     $product_cons,
                    //     'text',
                    //     $meta_value
                    // );
                    // end product product_cons
                    $outputHtml .= $this->format_rows( $label, $input );
                    
                    // product product_bottom_line 
                    $label = '<label for="' . $product_bottom_line . '">' . 'Product '. $i . ' Button Line' . '</label>';
                    $meta_value = get_post_meta( $post->ID, $product_bottom_line, true );
                    
                    ob_start();
                    wp_editor(  $meta_value, $product_bottom_line, $settings = array('textarea_name'=>$product_bottom_line) );
                    $input = ob_get_clean();
                    
                    // $input = sprintf(
                    //     '<input %s id="%s" name="%s" type="%s" value="%s">',
                    //     'style="width: 100%"',
                    //     $product_bottom_line,
                    //     $product_bottom_line,
                    //     'text',
                    //     $meta_value
                    // );
                    // end product product_bottom_line
                    $outputHtml .= $this->format_rows( $label, $input );

                    $outputHtml .= '</div><br><br>';
                    $output = $outputHtml;
            endwhile;
          echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
        }

        public function format_rows( $label, $input ) {
          return '<div style="margin-top: 10px;"><strong>'.$label.'</strong></div><div>'.$input.'</div>';
        }

        

        public function save_fields( $post_id ) {
          if ( !isset( $_POST['CustomFieldsTwo_nonce'] ) ) {
            return $post_id;
          }
          $nonce = $_POST['CustomFieldsTwo_nonce'];
          if ( !wp_verify_nonce( $nonce, 'CustomFieldsTwo_data' ) ) {
            return $post_id;
          }
          if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
          }
        //   foreach ( $this->fields as $field ) {
        
        $iLimit = get_post_meta($post_id, 'num_products',true);
        $iLimit = isset( $iLimit ) ? $iLimit : 0;
        $i = 0;
        while( $i < $iLimit ) { $i++;

            
            $product_name = "product_{$i}_name";
            $product_brand = "product_{$i}_brand";
            $product_link = "product_{$i}_link";
            $product_image = "product_{$i}_image";
            $product_rating = "product_{$i}_rating";
            $product_grade = "product_{$i}_grade";
            $product_pros = "product_{$i}_pros";
            $product_cons = "product_{$i}_cons";
            $product_bottom_line = "product_{$i}_bottom_line";

            // product_name start.
            if ( isset( $_POST[ $product_name ] ) ) {
                $_POST[ $product_name ] = sanitize_text_field( $_POST[ $product_name ] );
                update_post_meta( $post_id, $product_name, $_POST[ $product_name ] );
            }
            // product_name end.
            // product_brand start.
            if ( isset( $_POST[ $product_brand ] ) ) {
                $_POST[ $product_brand ] = sanitize_text_field( $_POST[ $product_brand ] );
                update_post_meta( $post_id, $product_brand, $_POST[ $product_brand ] );
            }
            // product_brand end.
            // product_link start.
            if ( isset( $_POST[ $product_link ] ) ) {
                $_POST[ $product_link ] = sanitize_text_field( $_POST[ $product_link ] );
                update_post_meta( $post_id, $product_link, $_POST[ $product_link ] );
            }
            // product_link end.
            // product_image start.
            if ( isset( $_POST[ $product_image ] ) ) {
                $_POST[ $product_image ] = sanitize_text_field( $_POST[ $product_image ] );
                update_post_meta( $post_id, $product_image, $_POST[ $product_image ] );
            }
            // product_image end.
            // product_rating start.
            if ( isset( $_POST[ $product_rating ] ) ) {
                $_POST[ $product_rating ] = sanitize_text_field( $_POST[ $product_rating ] );
                update_post_meta( $post_id, $product_rating, $_POST[ $product_rating ] );
            }
            // product_rating end.
            // product_grade start.
            if ( isset( $_POST[ $product_grade ] ) ) {
                $_POST[ $product_grade ] = sanitize_text_field( $_POST[ $product_grade ] );
                update_post_meta( $post_id, $product_grade, $_POST[ $product_grade ] );
            }
            // product_grade end.
            // product_pros start.
            if ( isset( $_POST[ $product_pros ] ) ) {

              $field_value = $_POST[ $product_pros ];
              $regex = '/<li(.*?)>/';
              // $regexicon = '/<i(.^*)>/';
              $regexicon = '/<i(.*)>/';
              $replace = '<li$1><i class="fa-solid fa-check"></i>';
              if( 0 === preg_match_all($regexicon, $field_value) ) {
                $meta_value = preg_replace($regex, $replace, $field_value);
              }else {
                $meta_value = $field_value;
              }

              update_post_meta( $post_id, $product_pros, $meta_value );

            }
            // product_pros end.
            // product_cons start.
            if ( isset( $_POST[ $product_cons ] ) ) {

                $field_value = $_POST[ $product_cons ];
                
                $regex = '/<li(.*?)>/';
                $regexicon = '/<i(.*)>/';
                $replace = '<li$1><i class="fa-solid fa-xmark"></i>';
                if( 0 === preg_match_all($regexicon, $field_value) ) {
                  $meta_value = preg_replace($regex, $replace, $field_value);
                }else {
                  $meta_value = $field_value;
                }
              
                update_post_meta( $post_id, $product_cons, $meta_value );
            }
            // product_cons end.
            // product_bottom_line start.
            if ( isset( $_POST[ $product_bottom_line ] ) ) {
                $_POST[ $product_bottom_line ] = $_POST[ $product_bottom_line ];
                update_post_meta( $post_id, $product_bottom_line, $_POST[ $product_bottom_line ] );
            }
            // product_bottom_line end.


          }
        }

      }

      if (class_exists('ProductsMetaboxFiedls')) {
        new ProductsMetaboxFiedls;
      };
      