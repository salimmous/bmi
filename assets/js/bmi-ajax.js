jQuery(document).ready(function($) {
  $('#bmi-form').submit(function(event) {
    event.preventDefault();

    // Collect all form data
    var formData = {
      'action'              : 'bmi_calculate',
        'nonce'             : bmi_ajax_obj.nonce,
        'name'              : $('#name').val(),
        'email'             : $('#email').val(),
        'phone'             : $('#phone').val(),
        'age'               : $('#age').val(),
        'gender'            : $('#gender').val(),
        'height'            : $('#height').val(),
        'weight'            : $('#weight').val(),
        'fitness_goal'      : $('#fitness_goal').val(),
        'calories_per_day' : $('#calories_per_day').val(),
        'diet_preference'   : $('#diet_preference').val(),
        'activity_level'    : $('#activity_level').val(),
        'gym_sessions_per_week' : $('#gym_sessions_per_week').val(),
        'time_in_gym'       => $('#time_in_gym').val(),
        'hours_of_sleep'    : $('#hours_of_sleep').val(),
        'emotional_state'   : $('#emotional_state').val(),
    };

    $.ajax({
      type: 'POST',
      url: bmi_ajax_obj.ajax_url,
      data: formData,
      dataType: 'json',
      beforeSend: function() {
        // Clear previous results and errors
        $('.bmi-error').remove();
        $('.bmi-result').remove();
      },
      success: function(response) {
        if (response.success) {
          // Display results
          $('#result-bmi').text(response.data.bmi);
          $('#result-bfp').text(response.data.bfp);
          $('#result-bmr').text(response.data.bmr);
          $('#result-ideal-weight').text(response.data.ideal_weight);
          $('#result-recommendations').text(response.data.recommendations);
          // Update the gauge
          updateBMIGauge(parseFloat(response.data.bmi));

        } else {
          // Display errors
          $.each(response.data.errors, function(index, error) {
            $('#bmi-form').prepend('<p class="bmi-error">' + error + '</p>');
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
        $('#bmi-form').prepend('<p class="bmi-error">An error occurred: ' + errorThrown + '</p>');
      }
    });
  });
});
