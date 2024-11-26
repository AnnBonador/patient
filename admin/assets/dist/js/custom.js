$(document).ready(function () {

  togglePasswordVisibility("password", "eye");
  togglePasswordVisibility("confirmPassword", "cf-eye");

  jQuery(function ($) {
    $(".js-phone").inputmask({
      mask: ["+639999999999"],
      jitMasking: 3,
      showMaskOnHover: false,
      autoUnmask: true,
    });
  });
  $("#scheddate").datepicker({
    startDate: new Date(),
  });
  $("#datepicker").datepicker({
    todayHighlight: true,
    clearBtn: true,
    autoclose: true,
    endDate: new Date(),
  });

  $(document).on("click", ".logoutbtn", function () {
    $("#logoutModal").modal("show");
  });

  $(document).on("click", ".viewbtn", function () {
    var userid = $(this).data("id");

    $.ajax({
      url: "code.php",
      type: "post",
      data: { userid: userid },
      success: function (response) {
        $(".patient_viewing_data").html(response);
        $("#ViewPatientModal").modal("show");
      },
    });
  });

  $(document).on("click", ".editbtn", function () {
    var user_id = $(this).data("id");

    $.ajax({
      type: "POST",
      url: "code.php",
      data: {
        checking_editbtn: true,
        user_id: user_id,
      },
      success: function (response) {
        $.each(response, function (key, value) {
          $("#edit_id").val(value["id"]);
          $("#edit_fname").val(value["fname"]);
          $("#edit_address").val(value["address"]);
          $("#edit_dob").val(value["dob"]);
          $("#edit_gender").val(value["gender"]);
          $("#edit_phone").val(value["phone"]);
          $("#edit_email").val(value["email"]);
          $("#edit_password").val(value["password"]);
          $("#edit_cpassword").val(value["password"]);
        });

        $("#EditPatientModal").modal("show");
      },
    });
  });

  var password = document.getElementById("password"),
    confirmPassword = document.getElementById("confirmPassword");

  function validatePassword() {
    if (password.value != confirmPassword.value) {
      confirmPassword.setCustomValidity("Password does not match");
    } else {
      confirmPassword.setCustomValidity("");
    }
  }
  password.onchange = validatePassword;
  confirmPassword.onkeyup = validatePassword;

  $("#example1")
    .DataTable({
      responsive: true,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");
  $("#example").DataTable({
    paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
  });
});

function togglePasswordVisibility(passwordId, eyeId) {
  const passwordInput = document.querySelector(`#${passwordId}`);
  const eye = document.querySelector(`#${eyeId}`);

  eye.addEventListener("click", function() {
    this.classList.toggle("fa-eye-slash");
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
  });
}

$(document).ready(function() {
  $("#datepicker").on("change", function() {
    var today = new Date();
    var selectedDate = new Date($(this).val());
    var age = today.getFullYear() - selectedDate.getFullYear();

    if (age < 7) {
      alert("You must be at least 7 years old to use this service.");
      $(this).val("");
    }
  });
});

function checkStrength(password) {
  var strength = 0;

  // Check for uppercase and lowercase letters
  if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
    strength += 1;
    $('.low-upper-case').addClass('text-success');
    $('.low-upper-case i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    $('#popover-password-top').addClass('hide');
  } else {
    $('.low-upper-case').removeClass('text-success');
    $('.low-upper-case i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    $('#popover-password-top').removeClass('hide');
  }

  // Check for numbers and characters
  if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
    strength += 1;
    $('.one-number').addClass('text-success');
    $('.one-number i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    $('#popover-password-top').addClass('hide');
  } else {
    $('.one-number').removeClass('text-success');
    $('.one-number i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    $('#popover-password-top').removeClass('hide');
  }

  // Check for special characters
  if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
    strength += 1;
    $('.one-special-char').addClass('text-success');
    $('.one-special-char i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    $('#popover-password-top').addClass('hide');
  } else {
    $('.one-special-char').removeClass('text-success');
    $('.one-special-char i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    $('#popover-password-top').removeClass('hide');
  }

  // Check for minimum length
  if (password.length > 7) {
    strength += 1;
    $('.eight-character').addClass('text-success');
    $('.eight-character i').removeClass('fa-exclamation-triangle').addClass('fa-check');
    $('#popover-password-top').addClass('hide');
  } else {
    $('.eight-character').removeClass('text-success');
    $('.eight-character i').addClass('fa-exclamation-triangle').removeClass('fa-check');
    $('#popover-password-top').removeClass('hide');
  }

  // Return strength value for further use
  return strength;
}

function setCustomValidity(password, strength) {
  if (checkStrength(password) == false) {
    $('#password')[0].setCustomValidity(''); // Reset validity
  }

  // Update password strength feedback
  if (strength < 2) {
    $('#result').removeClass();
    $('#password-strength').addClass('bg-danger');
    $('#result').addClass('text-danger').text('Very Weak');
    $('#password-strength').css('width', '10%');
  } else if (strength == 2) {
    $('#result').addClass('good');
    $('#password-strength').removeClass('bg-danger').addClass('bg-warning');
    $('#result').addClass('text-warning').text('Weak');
    $('#password-strength').css('width', '60%');
  } else if (strength == 4) {
    $('#result').removeClass();
    $('#result').addClass('strong');
    $('#password-strength').removeClass('bg-warning').addClass('bg-success');
    $('#result').addClass('text-success').text('Very Strong');
    $('#password-strength').css('width', '100%');
  }
}

function initializeDatepickerAndPreventInput(selector) {
  // Initialize the datepicker
  $(selector).datepicker({
      todayHighlight: true,
      clearBtn: true
  });

  // Prevent letter input for the date field
  $(selector).on('input', function() {
      // Allow only numbers and separators (e.g., / or -)
      this.value = this.value.replace(/[^0-9\/-]/g, '');
  });
}

function initializeDatetimePicker(selector) {
  $(selector).datetimepicker({
    format: 'LT'
  });
}


function initializeSummernote(textareaId) {
  $(textareaId).summernote({
      height: 150
  });
}

function initializeSelect2(selector,placeholder) {
  $(selector).select2({
      theme: "bootstrap4",           
      placeholder: placeholder,
      allowClear: true              
  });
}

function initializeCalendarDate(selector) {
  $(selector).datepicker({
      autoclose: true,
      startDate: new Date(),
  });
}

function handleTimeSlotClick(className, inputId, dataAttribute) {
  $(document).on("click", className, function () {
    $(className).removeClass("active");
    $(this).addClass("active");

    $(inputId).val($(this).data(dataAttribute));
  });
}

function validateFormSubmission(formId, selectedTimeSlotSelector) {
  document.querySelector(formId).addEventListener("submit", function (event) {
    const selectedTimeSlot = document.querySelector(selectedTimeSlotSelector).value;

    if (!selectedTimeSlot) {
      event.preventDefault(); // Prevent form submission
      alert("Please select a time slot before submitting the form.");
    }
  });
}



