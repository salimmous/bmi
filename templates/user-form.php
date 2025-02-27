<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    ?>

    <div class="bmi-calculator-pro">
        <h2><?php esc_html_e( 'Personal Details', 'bmi-pro' ); ?></h2>
        <form id="bmi-form">
            <div class="form-group">
                <label for="name"><?php esc_html_e( 'Name', 'bmi-pro' ); ?></label>
                <input type="text" id="name" name="name" required>

                <label for="email"><?php esc_html_e( 'Email', 'bmi-pro' ); ?></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone"><?php esc_html_e( 'Phone', 'bmi-pro' ); ?></label>
                <input type="tel" id="phone" name="phone">

                <label for="age"><?php esc_html_e( 'Age', 'bmi-pro' ); ?></label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="gender"><?php esc_html_e( 'Gender', 'bmi-pro' ); ?></label>
                <select id="gender" name="gender" required>
                    <option value="Male"><?php esc_html_e( 'Male', 'bmi-pro' ); ?></option>
                    <option value="Female"><?php esc_html_e( 'Female', 'bmi-pro' ); ?></option>
                </select>

                <label for="height"><?php esc_html_e( 'Height (in cm)', 'bmi-pro' ); ?></label>
                <input type="number" id="height" name="height" required>
            </div>

            <div class="form-group">
                <label for="weight"><?php esc_html_e( 'Weight (in kg)', 'bmi-pro' ); ?></label>
                <input type="number" id="weight" name="weight" required>

                <label for="fitness_goal"><?php esc_html_e( 'Fitness Goal', 'bmi-pro' ); ?></label>
                <select id="fitness_goal" name="fitness_goal">
                    <option value="Weight Loss"><?php esc_html_e( 'Weight Loss', 'bmi-pro' ); ?></option>
                    <option value="Muscle Gain"><?php esc_html_e( 'Muscle Gain', 'bmi-pro' ); ?></option>
                    <option value="Overall Health"><?php esc_html_e( 'Overall Health', 'bmi-pro' ); ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="calories_per_day"><?php esc_html_e( 'Calories per day', 'bmi-pro' ); ?></label>
                <input type="number" id="calories_per_day" name="calories_per_day">

                <label for="diet_preference"><?php esc_html_e( 'Diet Preference', 'bmi-pro' ); ?></label>
                <select id="diet_preference" name="diet_preference">
                    <option value="Vegetarian"><?php esc_html_e( 'Vegetarian', 'bmi-pro' ); ?></option>
                    <option value="Vegan"><?php esc_html_e( 'Vegan', 'bmi-pro' ); ?></option>
                    <option value="Paleo"><?php esc_html_e( 'Paleo', 'bmi-pro' ); ?></option>
                    <option value="Keto"><?php esc_html_e( 'Keto', 'bmi-pro' ); ?></option>
                    <option value="Low Carb"><?php esc_html_e( 'Low Carb', 'bmi-pro' ); ?></option>
                    <option value="Other"><?php esc_html_e( 'Other', 'bmi-pro' ); ?></option>
                </select>
            </div>

            <div class="form-group">
                <label for="activity_level"><?php esc_html_e( 'Activity Level', 'bmi-pro' ); ?></label>
                <select id="activity_level" name="activity_level">
                    <option value="Sedentary"><?php esc_html_e( 'Sedentary', 'bmi-pro' ); ?></option>
                    <option value="Lightly Active"><?php esc_html_e( 'Lightly Active', 'bmi-pro' ); ?></option>
                    <option value="Moderately Active"><?php esc_html_e( 'Moderately Active', 'bmi-pro' ); ?></option>
                    <option value="Very Active"><?php esc_html_e( 'Very Active', 'bmi-pro' ); ?></option>
                    <option value="Extra Active"><?php esc_html_e( 'Extra Active', 'bmi-pro' ); ?></option>
                </select>

                <label for="gym_sessions_per_week"><?php esc_html_e( 'Gym Sessions per Week', 'bmi-pro' ); ?></label>
                <input type="number" id="gym_sessions_per_week" name="gym_sessions_per_week">
            </div>
            <div class="form-group">
                <label for="time_in_gym"><?php esc_html_e( 'Time in Gym (hours per session)', 'bmi-pro' ); ?></label>
                <input type="number" id="time_in_gym" name="time_in_gym">

                <label for="hours_of_sleep"><?php esc_html_e( 'Hours of Sleep', 'bmi-pro' ); ?></label>
                <input type="number" id="hours_of_sleep" name="hours_of_sleep">
            </div>

            <div class="form-group">
                <label for="emotional_state"><?php esc_html_e( 'Emotional State', 'bmi-pro' ); ?></label>
                <textarea id="emotional_state" name="emotional_state"></textarea>
            </div>

            <button type="submit"><?php esc_html_e( 'Calculate Now', 'bmi-pro' ); ?></button>
        </form>
    </div>
