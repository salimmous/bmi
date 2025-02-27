<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    ?>

    <div class="bmi-results-pro">
        <h2><?php esc_html_e( 'Results', 'bmi-pro' ); ?></h2>

        <!-- BMI Gauge Container -->
      <div id="bmi-gauge-container"></div>

        <div class="results-table">
            <div class="table-header">
                <div><?php esc_html_e( 'Category', 'bmi-pro' ); ?></div>
                <div><?php esc_html_e( 'Details', 'bmi-pro' ); ?></div>
            </div>
            <div class="table-row">
                <div><?php esc_html_e( 'BMI', 'bmi-pro' ); ?>:</div>
                <div id="result-bmi"></div>
            </div>
            <div class="table-row">
                <div><?php esc_html_e( 'BFP', 'bmi-pro' ); ?>:</div>
                <div id="result-bfp"></div>
            </div>
            <div class="table-row">
                <div><?php esc_html_e( 'BMR', 'bmi-pro' ); ?>:</div>
                <div id="result-bmr"></div>
            </div>
            <div class="table-row">
                <div><?php esc_html_e( 'Ideal Weight', 'bmi-pro' ); ?>:</div>
                <div id="result-ideal-weight"></div>
            </div>
            <div class="table-row recommendations" >
                <div><?php esc_html_e( 'Recommendations', 'bmi-pro' ); ?>:</div>
                <div id="result-recommendations"></div>
            </div>
        </div>
    </div>
