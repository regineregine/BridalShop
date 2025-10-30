

$(document).ready(function() {
    
    $.validator.addMethod("noSpaces", function(value, element) {
        return this.optional(element) || /^\S*$/.test(value);
    }, "Spaces are not allowed");
    
    $.validator.addMethod("phoneNumber", function(value, element) {
        return this.optional(element) || /^\+?[0-9\s\-\(\)]+$/.test(value);
    }, "Please enter a valid phone number");

    $.validator.addMethod("zipCode", function(value, element) {
        return this.optional(element) || /^\+?[0-9]+$/.test(value);
    }, "Please enter a valid ZIP code");
    
    $.validator.addMethod("strongPassword", function(value, element) {
        return this.optional(element) || 
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
    }, "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character");
    
    $("#register-form").validate({
        rules: {
            "first_name": {
                required: true,
                minlength: 2
            },
            "last_name": {
                required: true,
                minlength: 2
            },
            "email": {
                required: true,
                email: true,
                noSpaces: true
            },
            "contact_number": {
                required: true,
                phoneNumber: true,
                noSpaces: true
            },
            "password": {
                required: true,
                minlength: 6,
                noSpaces: true
            },
            "confirm_password": {
                required: true,
                equalTo: "#reg-password",
                noSpaces: true
            }
        },
        messages: {
            "first_name": {
                required: "Please enter your first name",
                minlength: "First name must be at least 2 characters long"
            },
            "last_name": {
                required: "Please enter your last name",
                minlength: "Last name must be at least 2 characters long"
            },
            "email": {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                noSpaces: "Spaces are not allowed in email"
            },
            "contact_number": {
                required: "Please enter your contact number",
                phoneNumber: "Please enter a valid phone number (only + and numbers allowed)"
            },
            "password": {
                required: "Please enter a password",
                minlength: "Password must be at least 6 characters long",
                noSpaces: "Spaces are not allowed in password"
            },
            "confirm_password": {
                required: "Please confirm your password",
                equalTo: "Passwords do not match",
                noSpaces: "Spaces are not allowed in confirm password"
            }
        },
        errorClass: "error",
        validClass: "valid",
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            submitRegistrationForm(form);
            return false; 
        }
    });
    
    $("#reg-email").on("keyup", function() {
        $(this).valid();
    });
    
    $("#reg-email, #reg-contact, #reg-password, #reg-confirm-password").on("keypress", function(e) {
        if (e.which === 32) {
            e.preventDefault();
            return false;
        }
    });
    
    function resetRegisterFormValidation() {
        $("#register-form").validate().resetForm();
        $("#register-form").find('input').removeClass('error valid');
    }
    
    window.resetRegisterFormValidation = resetRegisterFormValidation;
    
    function submitRegistrationForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.textContent = 'Creating Account...';
        submitBtn.disabled = true;
        
        const formData = new FormData(form);
        
        $.ajax({
            url: form.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showMessage('register-message', response.message, 'success');
                    form.reset();
                    resetRegisterFormValidation();
                    setTimeout(function() {
                        closeModal('register-modal');
                    }, 2000);
                } else {
                    showMessage('register-message', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                showMessage('register-message', 'Registration failed. Please try again.', 'error');
            },
            complete: function() {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    function showMessage(elementId, message, type) {
        const messageElement = document.getElementById(elementId);
        if (messageElement) {
            messageElement.textContent = message;
            messageElement.className = type === 'success' ? 'text-green-600 bg-green-100 p-3 rounded mb-4' : 'text-red-600 bg-red-100 p-3 rounded mb-4';
            messageElement.classList.remove('hidden');
            
            setTimeout(function() {
                messageElement.classList.add('hidden');
            }, 5000);
        }
    }
    
    window.submitRegistrationForm = submitRegistrationForm;
    window.showMessage = showMessage;
});
