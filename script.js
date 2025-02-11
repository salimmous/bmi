document.addEventListener("DOMContentLoaded", function() {
    // --- Mock Data and Functions ---

    // Get health data from localStorage (or use defaults)
    function getHealthData() {
        const today = new Date().toLocaleDateString();
        let data = JSON.parse(localStorage.getItem(today));

        if (!data) {
            data = {
                name: '',
                email: '',
                phone: '',
                age: 0,
                gender: 'male',
                heightCm: 0,
                weightKg: 0,
                fitness_goal: 'weight_loss',
                calories: 0,
                diet_preference: 'standard',
                activity_level: 'sedentary',
                gym_sessions: 0,
                time_in_gym: 0,
                sleep_hours: 0
            };
        }
        return data;
    }

    // Calculate BMI and other metrics
    function calculateMetrics(data) {
        let { age, gender, heightCm, weightKg } = data;

        // BMI Calculation
        const bmi = weightKg / Math.pow(heightCm / 100, 2) || 0;

        // Mock BFP Calculation (simplified approximation)
        const bfp = (1.20 * bmi) + (0.23 * age) - (gender === 'male' ? 10.8 : 0) - 5.4;

        // Mock Ideal Weight Calculation (simplified approximation)
        const idealWeight = 22 * Math.pow(heightCm / 100, 2);

        // Mock BMR Calculation (simplified approximation)
        let bmr;
        if (gender === 'male') {
            bmr = 88.362 + (13.397 * weightKg) + (4.799 * heightCm) - (5.677 * age);
        } else {
            bmr = 447.593 + (9.247 * weightKg) + (3.098 * heightCm) - (4.330 * age);
        }

        return { bmi, bfp, idealWeight, bmr };
    }

    // --- UI Logic ---
    const nextDayBtn = document.getElementById("next-day-btn");
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const ageInput = document.getElementById('age');
    const genderSelect = document.getElementById('gender');
    const heightCmInput = document.getElementById('height_cm');
    const weightKgInput = document.getElementById('weight_kg');
    const fitnessGoalSelect = document.getElementById('fitness_goal');
    const caloriesInput = document.getElementById('calories');
    const dietPreferenceSelect = document.getElementById('diet_preference');
    const activityLevelSelect = document.getElementById('activity_level');
    const gymSessionsInput = document.getElementById('gym_sessions');
    const timeInGymInput = document.getElementById('time_in_gym');
    const sleepHoursInput = document.getElementById('sleep_hours');

    const bmiResult = document.getElementById('bmi-value');
    const bfpResult = document.getElementById('bfp-value');
    const idealWeightResult = document.getElementById('ideal-weight');
    const bmrResult = document.getElementById('bmr-value');
    const recommendationsResult = document.getElementById('recommendations');
    const needle = document.getElementById('needle');

    function updateDisplay() {
        const healthData = getHealthData();
        const metrics = calculateMetrics(healthData);

        // Update results with units, with error handling
        if (bmiResult) {
            bmiResult.textContent = metrics.bmi.toFixed(2) + " kg/m2";
        }
        if (bfpResult) {
            bfpResult.textContent = metrics.bfp.toFixed(2) + " %";
        }
        if (idealWeightResult) {
            idealWeightResult.textContent = metrics.idealWeight.toFixed(2) + " kgs";
        }
        if (bmrResult) {
            bmrResult.textContent = metrics.bmr.toFixed(2);
        }
        if (recommendationsResult) {
            recommendationsResult.textContent = generateRecommendation(healthData, metrics);
        }

        // Populate input fields from localStorage
        nameInput.value = healthData.name;
        emailInput.value = healthData.email;
        phoneInput.value = healthData.phone;
        ageInput.value = healthData.age;
        genderSelect.value = healthData.gender;
        heightCmInput.value = healthData.heightCm;
        weightKgInput.value = healthData.weightKg;
        fitnessGoalSelect.value = healthData.fitness_goal;
        caloriesInput.value = healthData.calories;
        dietPreferenceSelect.value = healthData.diet_preference;
        activityLevelSelect.value = healthData.activity_level;
        gymSessionsInput.value = healthData.gym_sessions;
        timeInGymInput.value = healthData.time_in_gym;
        sleepHoursInput.value = healthData.sleep_hours;

        // Calculate needle rotation based on BMI (mock)
        const bmi = metrics.bmi;
        let rotation = -90; // Start pointing left
        if (bmi >= 18.5 && bmi <= 50) {
            rotation = -90 + ((bmi - 18.5) / (50 - 18.5)) * 180;
        } else if (bmi > 50) {
            rotation = 90;
        }
        if(needle) {
            needle.style.transform = `translateX(-50%) rotate(${rotation}deg)`;
        }


        // Display BMI immediately
        const bmiDisplay = document.getElementById('bmiDisplay');
        if(bmiDisplay) {
            bmiDisplay.innerText = `Your BMI: ${metrics.bmi.toFixed(2)}`;
        }
    }
    // Generate recommendations based on calculated metrics and user input
    function generateRecommendation(data, metrics) {
        let recommendation = "";
        const { bmi } = metrics;

        if (bmi < 18.5) {
            recommendation += "Your BMI indicates you are underweight. Consider consulting a doctor or nutritionist.\n";
        } else if (bmi >= 18.5 && bmi < 25) {
            recommendation += "Your BMI is within the normal range. Keep up the healthy lifestyle!\n";
        } else if (bmi >= 25 && bmi < 30) {
            recommendation += "Your BMI indicates you are overweight. Consider increasing physical activity and improving your diet.\n";
        } else {
            recommendation += "Your BMI indicates obesity. It's recommended to consult a doctor or nutritionist for a personalized plan.\n";
        }

        if (data.age > 60) {
            recommendation += "Given your age, make sure to consult with your doctor about appropriate exercise routines.\n";
        }

        if (data.activity_level === 'sedentary') {
            recommendation += "Your activity level is sedentary.  Try to incorporate more movement into your day.\n";
        }

        if (data.fitness_goal === 'weight_loss' && data.calories > 2000) {
            recommendation += "To achieve weight loss, consider reducing your daily calorie intake.\n";
        }
        if (data.fitness_goal === 'muscle_gain' && data.calories < 2500) {
            recommendation += "To gain muscle, you may need to increase your daily calorie intake, focusing on protein.\n";
        }
        if (data.diet_preference === 'vegetarian') {
            recommendation += "As a vegetarian, ensure you're getting enough protein from plant-based sources.\n";
        }
        if (data.diet_preference === 'keto') {
            recommendation += "On a keto diet, focus on high-fat, low-carb foods and monitor your ketone levels.\n";
        }
        if (data.sleep_hours < 7) {
            recommendation += "You're not getting enough sleep. Aim for at least 7-8 hours of sleep per night for optimal health.\n"
        }
        if(data.gym_sessions > 7){
            recommendation += "You have to rest tow days in week.\n"
        }

        return recommendation;
    }

    nextDayBtn.addEventListener("click", () => {
        const today = new Date().toLocaleDateString();

        // Get values from input fields, converting to numbers where necessary
        const newData = {
            name: nameInput.value,
            email: emailInput.value,
            phone: phoneInput.value,
            age: parseInt(ageInput.value) || 0,
            gender: genderSelect.value,
            heightCm: parseInt(heightCmInput.value) || 0,
            weightKg: parseInt(weightKgInput.value) || 0,
            fitness_goal: fitnessGoalSelect.value,
            calories: parseInt(caloriesInput.value) || 0,
            diet_preference: dietPreferenceSelect.value,
            activity_level: activityLevelSelect.value,
            gym_sessions: parseInt(gymSessionsInput.value) || 0,
            time_in_gym: parseInt(timeInGymInput.value) || 0,
            sleep_hours: parseInt(sleepHoursInput.value) || 0
        };

        localStorage.setItem(today, JSON.stringify(newData));
        updateDisplay();
    });



    // Event listener for weight input (for immediate BMI calculation)
    weightKgInput.addEventListener('input', () => {
        const height = parseFloat(heightCmInput.value);
        const weight = parseFloat(weightKgInput.value);

        if (height && weight) {
            const bmi = (weight / Math.pow(height / 100, 2)).toFixed(2);
            const bmiDisplay = document.getElementById('bmiDisplay');
            if(bmiDisplay){
                bmiDisplay.innerText = `Your BMI: ${bmi}`;
            }

            // Calculate needle rotation (same logic as in updateDisplay)
            let rotation = -90;
            if (bmi >= 18.5 && bmi <= 50) {
                rotation = -90 + ((bmi - 18.5) / (50 - 18.5)) * 180;
            } else if (bmi > 50) {
                rotation = 90;
            }
            if(needle){
                needle.style.transform = `translateX(-50%) rotate(${rotation}deg)`;
            }

        } else {
            const bmiDisplay = document.getElementById('bmiDisplay');
            if(bmiDisplay){
                bmiDisplay.innerText = ''; // Clear if inputs are invalid
            }
        }
    });

    // Also update BMI when height changes
    heightCmInput.addEventListener('input', () => {
    weightKgInput.dispatchEvent(new Event('input')); // Trigger the weight input event
    });

    // Initial display
    updateDisplay();
});
