<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // Add Fitbit settings to admin page
    function bmi_pro_add_fitbit_settings() {
        add_settings_section(
            'bmi_pro_fitbit_section',
            __( 'Fitbit Integration', 'bmi-pro' ),
            'bmi_pro_fitbit_section_callback',
            'bmi-calculator-pro'
        );

        add_settings_field(
            'fitbit_client_id',
            __( 'Client ID', 'bmi-pro' ),
            'bmi_pro_fitbit_client_id_callback',
            'bmi-calculator-pro',
            'bmi_pro_fitbit_section'
        );

        add_settings_field(
            'fitbit_client_secret',
            __( 'Client Secret', 'bmi-pro' ),
            'bmi_pro_fitbit_client_secret_callback',
            'bmi-calculator-pro',
            'bmi_pro_fitbit_section'
        );
    }
    add_action( 'admin_init', 'bmi_pro_add_fitbit_settings' );

    // Callback for the Fitbit section
    function bmi_pro_fitbit_section_callback() {
        echo '<p>' . esc_html__( 'Configure Fitbit integration settings for BMI Calculator Pro.', 'bmi-pro' ) . '</p>';
    }

    // Callback for the Fitbit Client ID field
    function bmi_pro_fitbit_client_id_callback() {
        $options = get_option( 'bmi_pro_settings' );
        $client_id = isset( $options['fitbit_client_id'] ) ? $options['fitbit_client_id'] : '';
        echo "<input type='text' name='bmi_pro_settings[fitbit_client_id]' value='" . esc_attr( $client_id ) . "' class='regular-text' />";
    }

    // Callback for the Fitbit Client Secret field
    function bmi_pro_fitbit_client_secret_callback() {
        $options = get_option( 'bmi_pro_settings' );
        $client_secret = isset( $options['fitbit_client_secret'] ) ? $options['fitbit_client_secret'] : '';
        echo "<input type='text' name='bmi_pro_settings[fitbit_client_secret]' value='" . esc_attr( $client_secret ) . "' class='regular-text' />";
    }

    // Sanitize Fitbit settings
    function bmi_pro_sanitize_fitbit_settings( $input ) {
        if ( isset( $input['fitbit_client_id'] ) ) {
            $input['fitbit_client_id'] = sanitize_text_field( $input['fitbit_client_id'] );
        }

        if ( isset( $input['fitbit_client_secret'] ) ) {
            $input['fitbit_client_secret'] = sanitize_text_field( $input['fitbit_client_secret'] );
        }

        return $input;
    }
    add_filter( 'pre_update_option_bmi_pro_settings', 'bmi_pro_sanitize_fitbit_settings' );
    ?>
