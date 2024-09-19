<?php
// Metabox fields.
      // How to use: $meta_value = get_post_meta( $post_id, $field_id, true );
      // Example: get_post_meta( get_the_ID(), "my_metabox_field", true );

      class CustomFieldsMetabox {

        private $screens = array('post');
        /* array(
        'disclosure_top',

        'Featured_Image',

        'subtitle', 
        'benefits_nav_text',
        'ingredients_nav_text', 
        'top_5_nav_text', 
        'disclosure', 
        'benefits_title',
        'benefits_subtitle', 
        'benefits_content', 
        'usage_title', 
        'usage_content',
        'ingredients_to_look_for_title', 
        'ingredients_to_look_for_content',
        'ingredients_to_avoid_title', 
        'ingredients_to_avoid_content',
        'considerations_title', 
        'considerations_content', 
        'top_products_title',
	      'num_products', 
        'results_disclaimer', 
        'citations_title', 
        'citations',
	      'back_to_top_text', 
        'primary_color', 
        'secondary_color', 
        'tertiary_color'
    );
    */
        private $fields = array(
          array(
            'label' => 'Disclosure Top',
            'id' => 'disclosure_top',
            'type' => 'text',
          ),
          array(
            'label' => 'Subtitle',
            'id' => 'subtitle',
            'type' => 'text',
          ),
          array(
            'label' => 'Benefits Nav Text',
            'id' => 'benefits_nav_text',
            'type' => 'text',
          ),
          array(
            'label' => 'Ingredients Nav Text',
            'id' => 'ingredients_nav_text',
            'type' => 'text',
          ),
          array(
            'label' => 'Top 5 Nav Text',
            'id' => 'top_5_nav_text',
            'type' => 'text',
          ),
          array(
            'label' => 'Disclosure',
            'id' => 'disclosure',
            'type' => 'text',
          ),
          array(
            'label' => 'Benefits Title',
            'id' => 'benefits_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Benefits Subtitle',
            'id' => 'benefits_subtitle',
            'type' => 'text',
          ),
          array(
            'label' => 'Benefits Content',
            'id' => 'benefits_content',
            'type' => 'textarea',
          ),
          array(
            'label' => 'Usage Title',
            'id' => 'usage_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Usage Content',
            'id' => 'usage_content',
            'type' => 'textarea',
          ),
          array(
            'label' => 'Ingredients To Look For Title',
            'id' => 'ingredients_to_look_for_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Ingredients To Look For Content',
            'id' => 'ingredients_to_look_for_content',
            'type' => 'textarea',
          ),
          array(
            'label' => 'Ingredients To Avoid Title',
            'id' => 'ingredients_to_avoid_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Ingredients To Avoid Content',
            'id' => 'ingredients_to_avoid_content',
            'type' => 'textarea',
          ),
          array(
            'label' => 'Considerations Title',
            'id' => 'considerations_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Considerations Content',
            'id' => 'considerations_content',
            'type' => 'textarea',
          ),
          array(
            'label' => 'Top Products Title',
            'id' => 'top_products_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Number Of Products',
            'id' => 'num_products',
            'type' => 'number',
          ),
          array(
            'label' => 'Results Disclaimer',
            'id' => 'results_disclaimer',
            'type' => 'text',
          ),
          array(
            'label' => 'Citations Title',
            'id' => 'citations_title',
            'type' => 'text',
          ),
          array(
            'label' => 'Citations',
            'id' => 'citations',
            'type' => 'textarea',
          ),
          array(
            'label' => 'Back To Top Text',
            'id' => 'back_to_top_text',
            'type' => 'text',
          ),
          array(
            'label' => 'Primary Color',
            'id' => 'primary_color',
            'type' => 'color',
          ),
          array(
            'label' => 'Secondary Color',
            'id' => 'secondary_color',
            'type' => 'color',
          ),
          array(
            'label' => 'Tertiary Color',
            'id' => 'tertiary_color',
            'type' => 'color',
          ),
        );

        public function __construct() {
          add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
          add_action( 'save_post', array( $this, 'save_fields' ) );
        }

        public function add_meta_boxes() {
          foreach ( $this->screens as $s ) {
            add_meta_box(
              'CustomFields',
              __( 'Main Metabox', 'blocksy-child' ),
              array( $this, 'meta_box_callback' ),
              $s,
              'normal',
              'high'
            );
          }
        }

        public function meta_box_callback( $post ) {
          wp_nonce_field( 'CustomFields_data', 'CustomFields_nonce' ); 
          $this->field_generator( $post );
        }

        public function field_generator( $post ) {
          $output = '';
          foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $meta_value = get_post_meta( $post->ID, $field['id'], true );
            if ( empty( $meta_value ) ) {
              if ( isset( $field['default'] ) ) {
                $meta_value = $field['default'];
              }
            }
            switch ( $field['type'] ) {
              case 'textarea': ob_start(); ?>
                <?php wp_editor(  $meta_value, $field['id'], $settings = array('textarea_name'=>$field['id']) ); ?>
                <?php
                $input = ob_get_clean();
                break;
              default:
                $input = sprintf(
                '<input %s id="%s" name="%s" type="%s" value="%s">',
                $field['type'] !== 'color' ? 'style="width: 100%"' : '',
                $field['id'],
                $field['id'],
                $field['type'],
                $meta_value
              );
            }
            $output .= $this->format_rows( $label, $input );
          }
          echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
        }

        public function format_rows( $label, $input ) {
          return '<div style="margin-top: 10px;"><strong>'.$label.'</strong></div><div>'.$input.'</div>';
        }

        

        public function save_fields( $post_id ) {
          if ( !isset( $_POST['CustomFields_nonce'] ) ) {
            return $post_id;
          }
          $nonce = $_POST['CustomFields_nonce'];
          if ( !wp_verify_nonce( $nonce, 'CustomFields_data' ) ) {
            return $post_id;
          }
          if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
          }
          foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
              switch ( $field['type'] ) {
                case 'email':
                  $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
                  break;
                case 'text':
                  $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
                break;
              }
              
              update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
            } else if ( $field['type'] === 'checkbox' ) {
              update_post_meta( $post_id, $field['id'], '0' );
            }
          }
        }
      }

      if (class_exists('CustomFieldsMetabox')) {
        new CustomFieldsMetabox;
      };
      