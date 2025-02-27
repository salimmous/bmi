let bmiGauge = null;

function createBMIGauge() {
    bmiGauge = new JustGage({
        id: "bmi-gauge-container",
        value: 0, // Initial value
        min: 0,
        max: 40, // Arbitrary max value for BMI
        title: "BMI",
        label: "",
        decimals: 2,
        customSectors: [{
            color: "#00ff00", // Green
            lo: 0,
            hi: 18.5
        }, {
            color: "#00cc00", // Darker Green
            lo: 18.5,
            hi: 25
        }, {
            color: "#ffcc00", // Yellow
            lo: 25,
            hi: 30
        }, {
            color: "#ff6600", // Orange
            lo: 30,
            hi: 35
        }, {
            color: "#ff0000", // Red
            lo: 35,
            hi: 40
        }],
        counter: true
    });
}

function updateBMIGauge(bmiValue) {
    if (bmiGauge) {
        bmiGauge.refresh(bmiValue);
    }
}

// Ensure the gauge is created when the DOM is ready
jQuery(document).ready(function($) {
    createBMIGauge();
});
