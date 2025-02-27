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
		'bmi_pro_settings_page_callback',
		'dashicons-chart-line',
		6
	);
}

// Callback function for the settings page
function bmi_pro_settings_page_callback() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Save settings if form is submitted
    if ( isset( $_POST['bmi_pro_settings_nonce'] ) && wp_verify_nonce( $_POST['bmi_pro_settings_nonce'], 'bmi_pro_save_settings' ) ) {
        // Sanitize and save general settings
        $api_key = isset( $_POST['bmi_pro_api_key'] ) ? sanitize_text_field( $_POST['bmi_pro_api_key'] ) : '';
        $enable_ai = isset( $_POST['bmi_pro_enable_ai'] ) ? 1 : 0;

        update_option( 'bmi_pro_api_key', $api_key );
        update_option( 'bmi_pro_enable_ai', $enable_ai );

        // Sanitize and save Fitbit settings
        $fitbit_client_id = isset( $_POST['bmi_pro_fitbit_client_id'] ) ? sanitize_text_field( $_POST['bmi_pro_fitbit_client_id'] ) : '';
        $fitbit_client_secret = isset( $_POST['bmi_pro_fitbit_client_secret'] ) ? sanitize_text_field( $_POST['bmi_pro_fitbit_client_secret'] ) : '';

        update_option( 'bmi_pro_fitbit_client_id', $fitbit_client_id );
        update_option( 'bmi_pro_fitbit_client_secret', $fitbit_client_secret );

        // Sanitize and save AI settings (Placeholder)
        $ai_api_key = isset( $_POST['bmi_pro_ai_api_key'] ) ? sanitize_text_field( $_POST['bmi_pro_ai_api_key'] ) : '';
        update_option( 'bmi_pro_ai_api_key', $ai_api_key ); // Placeholder

        // Display a success message
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'bmi-pro' ) . '</p></div>';
    }

    // Retrieve current settings
    $api_key             = get_option( 'bmi_pro_api_key', '' );
    $enable_ai           = get_option( 'bmi_pro_enable_ai', 0 );
    $fitbit_client_id    = get_option( 'bmi_pro_fitbit_client_id', '' );
    $fitbit_client_secret = get_option( 'bmi_pro_fitbit_client_secret', '' );
    $ai_api_key          = get_option( 'bmi_pro_ai_api_key', '' ); // Placeholder
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__( 'BMI Calculator Pro Settings', 'bmi-pro' ); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field( 'bmi_pro_save_settings', 'bmi_pro_settings_nonce' ); ?>

            <h2><?php echo esc_html__( 'General Settings', 'bmi-pro' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="bmi_pro_api_key"><?php echo esc_html__( 'API Key', 'bmi-pro' ); ?></label></th>
                    <td>
                        <input type="text" id="bmi_pro_api_key" name="bmi_pro_api_key" value="<?php echo esc_attr( $api_key ); ?>" class="regular-text">
                        <p class="description"><?php echo esc_html__( 'Enter your API key for external services.', 'bmi-pro' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bmi_pro_enable_ai"><?php echo esc_html__( 'Enable AI Features', 'bmi-pro' ); ?></label></th>
                    <td>
                        <input type="checkbox" id="bmi_pro_enable_ai" name="bmi_pro_enable_ai" value="1" <?php checked( $enable_ai, 1 ); ?>>
                        <p class="description"><?php echo esc_html__( 'Enable AI-powered features (if available).', 'bmi-pro' ); ?></p>
                    </td>
                </tr>
            </table>

            <h2><?php echo esc_html__( 'Fitbit Integration', 'bmi-pro' ); ?></h2>
            <p><?php echo esc_html__( 'Configure Fitbit integration settings for BMI Calculator Pro.', 'bmi-pro' ); ?></p>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="bmi_pro_fitbit_client_id"><?php echo esc_html__( 'Client ID', 'bmi-pro' ); ?></label></th>
                    <td>
                        <input type="text" id="bmi_pro_fitbit_client_id" name="bmi_pro_fitbit_client_id" value="<?php echo esc_attr( $fitbit_client_id ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bmi_pro_fitbit_client_secret"><?php echo esc_html__( 'Client Secret', 'bmi-pro' ); ?></label></th>
                    <td>
                        <input type="text" id="bmi_pro_fitbit_client_secret" name="bmi_pro_fitbit_client_secret" value="<?php echo esc_attr( $fitbit_client_secret ); ?>" class="regular-text">
                    </td>
                </tr>
            </table>

            <h2><?php echo esc_html__( 'AI Integration (Placeholder)', 'bmi-pro' ); ?></h2>
            <p><?php echo esc_html__( 'Configure AI integration settings for BMI Calculator Pro (Placeholder).', 'bmi-pro' ); ?></p>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="bmi_pro_ai_api_key"><?php echo esc_html__( 'AI API Key (Placeholder)', 'bmi-pro' ); ?></label></th>
                    <td>
                        <input type="text" id="bmi_pro_ai_api_key" name="bmi_pro_ai_api_key" value="<?php echo esc_attr( $ai_api_key ); ?>" class="regular-text">
                    </td>
                </tr>
            </table>

            <?php submit_button( __( 'Save Changes', 'bmi-pro' ) ); ?>
        </form>
    </div>
    <?php
}
?>
