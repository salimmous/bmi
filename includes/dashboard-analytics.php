<?php
    // Security: Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // Add dashboard widget
    function bmi_pro_add_dashboard_widget() {
        wp_add_dashboard_widget(
            'bmi_pro_dashboard_widget',
            __( 'BMI Calculator Pro Analytics', 'bmi-pro' ),
            'bmi_pro_dashboard_widget_callback'
        );
    }
    add_action( 'wp_dashboard_setup', 'bmi_pro_add_dashboard_widget' );

    // Callback function for the dashboard widget
    function bmi_pro_dashboard_widget_callback() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bmi_pro_data';

        // Get total number of entries
        $total_entries = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

        // Get average BMI
        $average_bmi = $wpdb->get_var( "SELECT AVG(bmi) FROM $table_name" );

        // Get distribution of BMI categories
        $bmi_categories = $wpdb->get_results( "SELECT
            SUM(CASE WHEN bmi < 18.5 THEN 1 ELSE 0 END) as underweight,
            SUM(CASE WHEN bmi >= 18.5 AND bmi < 25 THEN 1 ELSE 0 END) as normal,
            SUM(CASE WHEN bmi >= 25 AND bmi < 30 THEN 1 ELSE 0 END) as overweight,
            SUM(CASE WHEN bmi >= 30 THEN 1 ELSE 0 END) as obese
        FROM $table_name" );
      $bmi_categories = $bmi_categories[0];

        // Prepare data for chart (using JavaScript)
        $chart_data = array(
            'labels' => array(
                __( 'Underweight', 'bmi-pro' ),                __( 'Normal', 'bmi-pro' ),
                __( 'Overweight', 'bmi-pro' ),
                __( 'Obese', 'bmi-pro' ),
            ),
            'data'   => array(
                (int) $bmi_categories->underweight,
                (int) $bmi_categories->normal,
                (int) $bmi_categories->overweight,
                (int) $bmi_categories->obese,
            ),
        );

        ?>
        <div class="bmi-pro-dashboard-widget">
            <p><?php printf( esc_html__( 'Total Entries: %d', 'bmi-pro' ), esc_html( $total_entries ) ); ?></p>
            <p><?php printf( esc_html__( 'Average BMI: %.2f', 'bmi-pro' ), esc_html( $average_bmi ) ); ?></p>

            <canvas id="bmi-pro-chart" width="400" height="200"></canvas>

            <!-- Include Chart.js from CDN -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('DOMContentLoaded event fired.'); // Debugging

                    var ctx = document.getElementById('bmi-pro-chart');

                    if (ctx) {
                        console.log('Canvas element found.'); // Debugging
                        ctx = ctx.getContext('2d');

                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo json_encode( $chart_data['labels'] ); ?>,
                                datasets: [{
                                    label: '<?php echo esc_js( __( 'BMI Distribution', 'bmi-pro' ) ); ?>',
                                    data: <?php echo json_encode( $chart_data['data'] ); ?>,
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.5)',
                                        'rgba(75, 192, 192, 0.5)',
                                        'rgba(255, 206, 86, 0.5)',
                                        'rgba(255, 99, 132, 0.5)',
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(255, 99, 132, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    } else {
                        console.error('Canvas element not found.'); // Debugging
                    }
                });
            </script>
        </div>
        <?php
    }
?>
