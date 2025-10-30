$(document).ready(function() {
    
    $("#login-form").validate({
        rules: {
            "email": {
                required: true,
                email: true
            },
            "password": {
                required: true,
                minlength: 1
            }
        },
        messages: {
            "email": {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            "password": {
                required: "Please enter your password"
            }
        },
        errorClass: "error",
        validClass: "valid",
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            submitLoginForm(form);
            return false; 
        }
    });
    
    function submitLoginForm(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.textContent = 'Signing In...';
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
                    showLoginMessage('login-message', response.message, 'success');

                    setTimeout(function() {
                        try { closeModal('login-modal'); } catch (e) { /* ignore */ }
                        var dest = (response.redirect) ? response.redirect : '../pages/home.php';
                        window.location.href = dest;
                    }, 800);
                } else {
                    showLoginMessage('login-message', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                showLoginMessage('login-message', 'Login failed. Please try again.', 'error');
            },
            complete: function() {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    function showLoginMessage(elementId, message, type) {
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
    
    function updateNavbarForLoggedInUser(user) {
        const guestMenu = document.getElementById('guest-menu');
        if (guestMenu) {
            guestMenu.style.display = 'none';
        }
        
        const userMenu = document.getElementById('user-menu');
        if (userMenu) {
            userMenu.classList.remove('hidden');
        }
        
        const userName = document.getElementById('user-name');
        const userEmail = document.getElementById('user-email');
        if (userName) {
            userName.textContent = 'Welcome, ' + user.name;
        }
        if (userEmail) {
            userEmail.textContent = user.email;
        }
        
        const accountText = document.getElementById('account-text');
        if (accountText) {
            accountText.textContent = user.name;
        }
    }
    
    window.submitLoginForm = submitLoginForm;
    window.showLoginMessage = showLoginMessage;
    window.updateNavbarForLoggedInUser = updateNavbarForLoggedInUser;
});