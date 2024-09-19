<?php
// Metabox fields.
      // How to use: $meta_value = get_post_meta( $post_id, $field_id, true );
      // Example: get_post_meta( get_the_ID(), "my_metabox_field", true );

      class SidebarFieldsMetabox {

        private $screens = array('post');
        private $fields = array(
            array(
              'label' => 'Sidebar 1 Title',
              'id' => 'sidebar_1_title',
              'type' => 'text',
              'default' => 'Our Main Sources',
            ),
            array(
              'label' => 'Sidebar 1 Subtitle',
              'id' => 'sidebar_1_subtitle',
              'type' => 'text',
            ),
            array(
              'label' => 'Sidebar 1 Image 1',
              'id' => 'sidebar_1_image_1',
              'type' => 'text',
            ),
            array(
              'label' => 'Sidebar 1 Image 2',
              'id' => 'sidebar_1_image_2',
              'type' => 'text',
            ),
            array(
              'label' => 'Sidebar 2 Title',
              'id' => 'sidebar_2_title',
              'type' => 'text',
              'default' => 'What You Will Learn',
            ),
            array(
              'label' => 'Sidebar 2 Subtitle',
              'id' => 'sidebar_2_subtitle',
              'type' => 'text',
              'default' => 'Estimated Read Time: 5 Minutes'
            ),
            array(
                'label' => 'S2 Link Icon 1',
                'id' => 'sidebar_2_icon_1',
                'type' => 'selecticon',
            ),
            array(
              'label' => 'S2 Link Title 1',
              'id' => 'sidebar_2_link_title_1',
              'type' => 'text',
            ),
            array(
              'label' => 'S2 Link 1',
              'id' => 'sidebar_2_link_1',
              'type' => 'text',
            ),
            array(
                'label' => 'S2 Link Icon 2',
                'id' => 'sidebar_2_icon_2',
                'type' => 'selecticon',
            ),
            array(
              'label' => 'S2 Link Title 2',
              'id' => 'sidebar_2_link_title_2',
              'type' => 'text',
            ),
            array(
              'label' => 'S2 Link 2',
              'id' => 'sidebar_2_link_2',
              'type' => 'text',
            ),
            array(
                'label' => 'S2 Link Icon 3',
                'id' => 'sidebar_2_icon_3',
                'type' => 'selecticon',
            ),
            array(
              'label' => 'S2 Link Title 3',
              'id' => 'sidebar_2_link_title_3',
              'type' => 'text',
            ),
            array(
              'label' => 'S2 Link 3',
              'id' => 'sidebar_2_link_3',
              'type' => 'text',
            ),
            array(
                'label' => 'S2 Link Icon 4',
                'id' => 'sidebar_2_icon_4',
                'type' => 'selecticon',
            ),
            array(
              'label' => 'S2 Link Title 4',
              'id' => 'sidebar_2_link_title_4',
              'type' => 'text',
            ),
            array(
              'label' => 'S2 Link 4',
              'id' => 'sidebar_2_link_4',
              'type' => 'text',
            ),
            array(
                'label' => 'S2 Link Icon 5',
                'id' => 'sidebar_2_icon_5',
                'type' => 'selecticon',
            ),
            array(
              'label' => 'S2 Link Title 5',
              'id' => 'sidebar_2_link_title_5',
              'type' => 'text',
            ),
            array(
              'label' => 'S2 Link 5',
              'id' => 'sidebar_2_link_5',
              'type' => 'text',
            ),
            array(
                'label' => 'S2 Link Icon 6',
                'id' => 'sidebar_2_icon_6',
                'type' => 'selecticon',
            ),
            array(
              'label' => 'S2 Link Title 6',
              'id' => 'sidebar_2_link_title_6',
              'type' => 'text',
            ),
            array(
              'label' => 'S2 Link 6',
              'id' => 'sidebar_2_link_6',
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
              'SidebarFields',
              __( 'Sidebar Metabox', 'blocksy-child' ),
              array( $this, 'meta_box_callback' ),
              $s,
              'normal',
              'high'
            );
          }
        }

        public function meta_box_callback( $post ) {
          wp_nonce_field( 'SidebarFields_data', 'SidebarFields_nonce' ); 
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
              case 'selecticon' : ob_start(); ?>
                    <select name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>">
                        <option value="active" <?php if( 'active' == $meta_value ) { echo 'selected'; } ?>>active</option>
                        <option value="inactive" <?php if( 'inactive' == $meta_value ) { echo 'selected'; } ?>>inactive</option>
                    </select>
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
          if ( !isset( $_POST['SidebarFields_nonce'] ) ) {
            return $post_id;
          }
          $nonce = $_POST['SidebarFields_nonce'];
          if ( !wp_verify_nonce( $nonce, 'SidebarFields_data' ) ) {
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

      if (class_exists('SidebarFieldsMetabox')) {
        new SidebarFieldsMetabox;
      };
      