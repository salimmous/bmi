<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // Add user profile settings page
    function bmi_pro_add_user_settings_page() {
        add_users_page(
            __( 'BMI Calculator Pro User Settings', 'bmi-pro' ),
            __( 'BMI Settings', 'bmi-pro' ),
            'read', // Only accessible to logged-in users
            'bmi-pro-user-settings',
            'bmi_pro_user_settings_page_callback'
        );
    }
    add_action( 'admin_menu', 'bmi_pro_add_user_settings_page' );

    // Callback function for the user settings page
    function bmi_pro_user_settings_page_callback() {
        $user_id = get_current_user_id();
        $user_data = get_user_meta( $user_id, 'bmi_pro_user_data', true );

        if ( ! $user_data ) {
            $user_data = array(
                'height'   => '',
                'weight'   => '',
                'goal'     => '',
            );
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'BMI Calculator Pro User Settings', 'bmi-pro' ); ?></h1>
            <form method="post" action="">
                <input type="hidden" name="bmi_pro_user_settings_nonce" value="<?php echo wp_create_nonce( 'bmi_pro_user_settings_nonce' ); ?>">

                <label for="height"><?php esc_html_e( 'Height (cm)', 'bmi-pro' ); ?></label>
                <input type="number" id="height" name="height" value="<?php echo esc_attr( $user_data['height'] ); ?>" required><br><br>

                <label for="weight"><?php esc_html_e( 'Weight (kg)', 'bmi-pro' ); ?></label>
                <input type="number" id="weight" name="weight" value="<?php echo esc_attr( $user_data['weight'] ); ?>" required><br><br>

                <label for="goal"><?php esc_html_e( 'Fitness Goal', 'bmi-pro' ); ?></label>
                <select id="goal" name="goal">
                    <option value="weight_loss" <?php selected( $user_data['goal'], 'weight_loss' ); ?>><?php esc_html_e( 'Weight Loss', 'bmi-pro' ); ?></option>
                    <option value="muscle_gain" <?php selected( $user_data['goal'], 'muscle_gain' ); ?>><?php esc_html_e( 'Muscle Gain', 'bmi-pro' ); ?></option>
                    <option value="maintain" <?php selected( $user_data['goal'], 'maintain' ); ?>><?php esc_html_e( 'Maintain', 'bmi-pro' ); ?></option>
                </select><br><br>

                <input type="submit" value="<?php esc_attr_e( 'Save Settings', 'bmi-pro' ); ?>">
            </form>
        </div>
        <?php
    }

    // Save user settings
    function bmi_pro_save_user_settings() {
      if ( isset( $_POST['bmi_pro_user_settings_nonce'] ) && wp_verify_nonce( $_POST['bmi_pro_user_settings_nonce'], 'bmi_pro_user_settings_nonce' ) )
      {
        $user_id = get_current_user_id();

        $user_data = array(
            'height'   => isset( $_POST['height'] ) ? intval( $_POST['height'] ) : '',
            'weight'   => isset( $_POST['weight'] ) ? intval( $_POST['weight'] ) : '',
            'goal'     => isset( $_POST['goal'] ) ? sanitize_text_field( $_POST['goal'] ) : '',
        );

        update_user_meta( $user_id, 'bmi_pro_user_data', $user_data );
          echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'bmi-pro' ) . '</p></div>';
      }
    }
  add_action( 'admin_init', 'bmi_pro_save_user_settings');
    ?>
