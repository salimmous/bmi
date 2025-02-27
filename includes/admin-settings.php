<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // Add admin menu page
    function bmi_pro_add_admin_menu() {
        add_menu_page(
            __( 'BMI Calculator Pro Settings', 'bmi-pro' ),
            __( 'BMI Calculator Pro', 'bmi-pro' ),
            'manage_options',
            'bmi-calculator-pro',
            'bmi_pro_admin_page_callback',
            'dashicons-calculator',
            6
        );
    }
    add_action( 'admin_menu', 'bmi_pro_add_admin_menu' );

    // Callback function for the admin page
    function bmi_pro_admin_page_callback() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'BMI Calculator Pro Settings', 'bmi-pro' ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'bmi_pro_settings_group' );
                do_settings_sections( 'bmi-calculator-pro' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Register settings
    function bmi_pro_register_settings() {
        register_setting(
            'bmi_pro_settings_group',
            'bmi_pro_settings',
            'bmi_pro_sanitize_settings'
        );

        add_settings_section(
            'bmi_pro_general_section',
            __( 'General Settings', 'bmi-pro' ),
            'bmi_pro_general_section_callback',
            'bmi-calculator-pro'
        );

        add_settings_field(
            'api_key',
            __( 'API Key', 'bmi-pro' ),
            'bmi_pro_api_key_callback',
            'bmi-calculator-pro',
            'bmi_pro_general_section'
        );

      add_settings_field(
        'enable_ai',
        __( 'Enable AI Features', 'bmi-pro' ),
        'bmi_pro_enable_ai_callback',
        'bmi-calculator-pro',
        'bmi_pro_general_section'
      );
    }
    add_action( 'admin_init', 'bmi_pro_register_settings' );

    // Callback for the general section
    function bmi_pro_general_section_callback() {
        echo '<p>' . esc_html__( 'Configure general settings for BMI Calculator Pro.', 'bmi-pro' ) . '</p>';
    }

    // Callback for the API key field
    function bmi_pro_api_key_callback() {
        $options = get_option( 'bmi_pro_settings' );
        $api_key = isset( $options['api_key'] ) ? $options['api_key'] : '';
        echo "<input type='text' name='bmi_pro_settings[api_key]' value='" . esc_attr( $api_key ) . "' class='regular-text' />";
    }
    // Callback for the enable AI checkbox
    function bmi_pro_enable_ai_callback() {
      $options = get_option( 'bmi_pro_settings' );
      $enable_ai = isset( $options['enable_ai'] ) ? $options['enable_ai'] : 0;
      echo "<input type='checkbox' name='bmi_pro_settings[enable_ai]' value='1' " . checked( 1, $enable_ai, false ) . " />";
    }

    // Sanitize settings
    function bmi_pro_sanitize_settings( $input ) {
        $sanitized_input = array();

        if ( isset( $input['api_key'] ) ) {
            $sanitized_input['api_key'] = sanitize_text_field( $input['api_key'] );
        }
      if ( isset( $input['enable_ai'] ) ) {
        $sanitized_input['enable_ai'] = intval( $input['enable_ai'] ); // Ensure it's 0 or 1
      }

        return $sanitized_input;
    }
    ?>
