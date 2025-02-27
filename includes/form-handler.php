<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    add_action( 'wp_ajax_bmi_calculate', 'bmi_pro_calculate_handler' );
    add_action( 'wp_ajax_nopriv_bmi_calculate', 'bmi_pro_calculate_handler' );

    function bmi_pro_calculate_handler() {
        check_ajax_referer( 'bmi_ajax_nonce', 'nonce' );

      // Sanitize and validate all input fields
      $input_data = array(
        'name'              => sanitize_text_field( $_POST['name'] ),
        'email'             => sanitize_email( $_POST['email'] ),
        'phone'             => sanitize_text_field( $_POST['phone'] ),
        'age'               => intval( $_POST['age'] ),
        'gender'            => sanitize_text_field( $_POST['gender'] ),
        'height'            => intval( $_POST['height'] ),
        'weight'            => intval( $_POST['weight'] ),
        'fitness_goal'      => sanitize_text_field( $_POST['fitness_goal'] ),
        'calories_per_day' => intval( $_POST['calories_per_day'] ),
        'diet_preference'   => sanitize_text_field( $_POST['diet_preference'] ),
        'activity_level'    => sanitize_text_field( $_POST['activity_level'] ),
        'gym_sessions_per_week' => intval( $_POST['gym_sessions_per_week'] ),
        'time_in_gym'       => intval( $_POST['time_in_gym'] ),
        'hours_of_sleep'    => intval( $_POST['hours_of_sleep'] ),
        'emotional_state'   => sanitize_text_field( $_POST['emotional_state'] ),
      );

      // Perform basic validation
      $errors = array();

      if ( empty( $input_data['name'] ) ) {
        $errors[] = 'Name is required.';
      }

      if ( empty( $input_data['email'] ) || ! is_email( $input_data['email'] ) ) {
        $errors[] = 'Valid email is required.';
      }
      if ( empty( $input_data['age'] ) || $input_data['age'] <= 0 ) {
        $errors[] = 'Valid age is required.';
      }
        if ( empty( $input_data['height'] ) || $input_data['height'] <= 0 ) {
        $errors[] = 'Valid height is required.';
      }

      if ( empty( $input_data['weight'] ) || $input_data['weight'] <= 0 ) {
        $errors[] = 'Valid weight is required.';
      }

      // If validation fails, return errors
      if ( ! empty( $errors ) ) {
        wp_send_json_error( array( 'errors' => $errors ) );
        wp_die();
      }

        // Calculate BMI, BFP, BMR, Ideal Weight, and Recommendations
        $bmi = calculate_bmi( $input_data['weight'], $input_data['height'] );
        $bfp = calculate_bfp( $bmi, $input_data['age'], $input_data['gender'] );
        $bmr = calculate_bmr( $input_data['weight'], $input_data['height'], $input_data['age'], $input_data['gender'] );
        $ideal_weight = calculate_ideal_weight( $input_data['height'] );
        $recommendations = get_recommendations($bmi,  $input_data['fitness_goal'] );

        // Store data in the database
        global $wpdb;
        $table_name = $wpdb->prefix . 'bmi_pro_data';

        $data = array(
            'time'              => current_time( 'mysql' ),
            'name'              => $input_data['name'],
            'email'             => $input_data['email'],
            'phone'             => $input_data['phone'],
            'age'               => $input_data['age'],
            'gender'            => $input_data['gender'],
            'height'            => $input_data['height'],
            'weight'            => $input_data['weight'],
            'fitness_goal'      => $input_data['fitness_goal'],
            'calories_per_day' => $input_data['calories_per_day'],
            'diet_preference'   => $input_data['diet_preference'],
            'activity_level'    => $input_data['activity_level'],
            'gym_sessions_per_week' => $input_data['gym_sessions_per_week'],
            'time_in_gym'       => $input_data['time_in_gym'],
            'hours_of_sleep'    => $input_data['hours_of_sleep'],
            'emotional_state'   => $input_data['emotional_state'],
            'bmi'               => $bmi,
            'bfp'               => $bfp,
            'bmr'               => $bmr,
            'ideal_weight'      => $ideal_weight,
            'recommendations'   => $recommendations,
        );

        $format = array(
            '%s', // time
            '%s', // name
            '%s', // email
            '%s', // phone
            '%d', // age
            '%s', // gender
            '%d', // height
            '%d', // weight
            '%s', // fitness_goal
            '%d', // calories_per_day
            '%s', // diet_preference
            '%s', // activity_level
            '%d', // gym_sessions_per_week
            '%d', // time_in_gym
            '%d', // hours_of_sleep
            '%s', // emotional_state
            '%f', // bmi
            '%f', // bfp
            '%f', // bmr
            '%s', // ideal_weight
            '%s', // recommendations
        );

        $wpdb->insert( $table_name, $data, $format );

        // Prepare response data
        $response_data = array(
            'bmi'           => number_format( (float) $bmi, 2, '.', '' ),
            'bfp'           => number_format( (float) $bfp, 2, '.', '' ),
            'bmr'           => number_format( (float) $bmr, 2, '.', '' ),
            'ideal_weight'  => $ideal_weight,
            'recommendations' => $recommendations,
        );

        // Send JSON response
        wp_send_json_success( $response_data );
        wp_die();
    }
    ?>
