<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    /**
     * Calculate BMI.
     *
     * @param int $weight Weight in kilograms.
     * @param int $height Height in centimeters.
     * @return float Calculated BMI.
     */
    function calculate_bmi( $weight, $height ) {
        $height_in_meters = $height / 100;
        return $weight / ( $height_in_meters * $height_in_meters );
    }

    /**
     * Calculate BFP (Body Fat Percentage).
     *
     * @param float $bmi Calculated BMI.
     * @param int $age Age in years.
     * @param string $gender Gender ('Male' or 'Female').
     * @return float Calculated BFP.
     */
    function calculate_bfp( $bmi, $age, $gender ) {
        if ( $gender === 'Male' ) {
            return ( 1.20 * $bmi ) + ( 0.23 * $age ) - 16.2;
        } else {
            return ( 1.20 * $bmi ) + ( 0.23 * $age ) - 5.4;
        }
    }

    /**
     * Calculate BMR (Basal Metabolic Rate).
     *
     * @param int $weight Weight in kilograms.
     * @param int $height Height in centimeters.
     * @param int $age Age in years.
     * @param string $gender Gender ('Male' or 'Female').
     * @return float Calculated BMR.
     */
    function calculate_bmr( $weight, $height, $age, $gender ) {
        if ( $gender === 'Male' ) {
            return 88.362 + ( 13.397 * $weight ) + ( 4.799 * $height ) - ( 5.677 * $age );
        } else {
            return 447.593 + ( 9.247 * $weight ) + ( 3.098 * $height ) - ( 4.330 * $age );
        }
    }

    /**
     * Calculate Ideal Weight.
     *
     * @param int $height Height in centimeters.
     * @return string Ideal weight range.
     */
    function calculate_ideal_weight( $height ) {
        $height_in_meters = $height / 100;
        $lower_bmi = 18.5;
        $upper_bmi = 24.9;
        $lower_weight = $lower_bmi * ( $height_in_meters * $height_in_meters );
        $upper_weight = $upper_bmi * ( $height_in_meters * $height_in_meters );
        return number_format( $lower_weight, 1 ) . ' - ' . number_format( $upper_weight, 1 ) . ' kg';
    }

    /**
     * Get recommendations based on BMI.
     * @param float $bmi
     * @param string $fitness_goal
     * @return string Recommendations.
     */
    function get_recommendations($bmi, $fitness_goal) {
      $recommendations = '';

      if ($bmi < 18.5) {
        $recommendations .= "You are underweight. Consider consulting a nutritionist to develop a healthy weight gain plan. ";
      } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
        $recommendations .= "You are at a healthy weight. Keep up the good work with a balanced diet and regular exercise. ";
      } elseif ($bmi >= 25 && $bmi <= 29.9) {
        $recommendations .= "You are overweight. Consider creating a calorie deficit, increasing cardio workouts, and reducing processed food intake. ";
      } else {
        $recommendations .= "You are obese. It's important to start a weight loss plan under the guidance of a healthcare professional. ";
      }

      if ($fitness_goal === 'Weight Loss') {
          $recommendations .= "Focus on a combination of diet and exercise to achieve sustainable weight loss.";
      } elseif ($fitness_goal === 'Muscle Gain') {
          $recommendations .= "Incorporate strength training and a protein-rich diet to build muscle mass.";
      } elseif ($fitness_goal === 'Overall Health') {
          $recommendations .= "Maintain a balanced lifestyle with regular physical activity and a nutritious diet.";
      }
      $recommendations .= " You may want to consider increasing your physical activity for overall health benefits.";

      return $recommendations;
    }

    ?>
