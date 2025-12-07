$(document).ready(function () {
    /* 
      script.js
      Client-side validation using jQuery
    */

    // Helper: Validate Email Regex
    function isValidEmail(email) {
        // Standard email regex
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Helper: Validate Phone (10 digits only)
    function isValidPhone(phone) {
        const re = /^\d{10}$/;
        return re.test(phone);
    }

    // Real-time validation on input blur (focus out)
    $('#fullName').on('blur', validateName);
    $('#email').on('blur', validateEmail);
    $('#phone').on('blur', validatePhone);
    $('#course').on('change', validateCourse);
    $('#terms').on('change', validateTerms);
    $('input[name="gender"]').on('change', validateGender);

    // Form Submission Handler
    $('#registrationForm').on('submit', function (e) {
        let valid = true;

        // Execute all validations
        if (!validateName()) valid = false;
        if (!validateEmail()) valid = false;
        if (!validatePhone()) valid = false;
        if (!validateGender()) valid = false;
        if (!validateCourse()) valid = false;
        if (!validateTerms()) valid = false;

        if (!valid) {
            e.preventDefault(); // Stop submission if invalid
        } else {
            // Check if running locally (file protocol)
            if (window.location.protocol === 'file:') {
                e.preventDefault(); // Stop real submission
                alert("⚠️ NOTICE: You are running this file locally without a server.\n\nPHP cannot run directly in the browser. I will redirect you to a 'Simulation Page' so you can see what the success screen looks like.\n\nTo make the real PHP work, you must upload these files to InfinityFree.");
                window.location.href = 'success_mock.html';
            }
            // If running on a server (http/https), let it submit normally to submit.php
        }
    });

    // --- Validation Functions ---

    function validateName() {
        const input = $('#fullName');
        const error = $('#nameError');
        const val = input.val().trim();

        if (val.length < 2) {
            showError(input, error);
            return false;
        } else {
            clearError(input, error);
            return true;
        }
    }

    function validateEmail() {
        const input = $('#email');
        const error = $('#emailError');
        const val = input.val().trim();

        if (!isValidEmail(val)) {
            showError(input, error);
            return false;
        } else {
            clearError(input, error);
            return true;
        }
    }

    function validatePhone() {
        const input = $('#phone');
        const error = $('#phoneError');
        const val = input.val().trim();

        if (!isValidPhone(val)) {
            showError(input, error);
            return false;
        } else {
            clearError(input, error);
            return true;
        }
    }

    function validateCourse() {
        const input = $('#course');
        const error = $('#courseError');
        // Check if value is empty or default disabled selected
        if (!input.val()) {
            showError(input, error);
            return false;
        } else {
            clearError(input, error);
            return true;
        }
    }

    function validateGender() {
        const error = $('#genderError');
        if ($('input[name="gender"]:checked').length === 0) {
            error.show();
            return false;
        } else {
            error.hide();
            return true;
        }
    }

    function validateTerms() {
        const input = $('#terms');
        const error = $('#termsError');
        if (!input.is(':checked')) {
            // For checkbox, we might just show error text
            error.show();
            return false;
        } else {
            error.hide();
            return true;
        }
    }

    // --- UI Helpers ---

    function showError(input, errorMsgElement) {
        input.addClass('error');
        errorMsgElement.show();
    }

    function clearError(input, errorMsgElement) {
        input.removeClass('error');
        errorMsgElement.hide();
    }
});
