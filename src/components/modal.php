<!-- Login Modal -->
<div id="login-modal" class="modal-panel hidden" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-backdrop" onclick="closeModal('login-modal')"></div>
    <div class="modal-surface max-w-md">
        <div class="modal-header">
            <div>
                <h2 class="headline">Sign in to your account</h2>
                <p class="text-sm text-white/80 mt-1">
                    Welcome back! Please enter your credentials.
                </p>
            </div>
            <button class="close-btn" aria-label="Close login" onclick="closeModal('login-modal')">
                ×
            </button>
        </div>

        <div class="modal-body">
            <form id="login-form" action="../backend/login_process.php" method="POST" class="space-y-6">
                <div id="login-message" class="hidden"></div>
                <div>
                    <label class="form-label" for="login-email">Email Address</label>
                    <input id="login-email" name="email" type="email" class="form-input" placeholder="Enter your email"
                        required />
                </div>

                <div>
                    <label class="form-label" for="login-password">Password</label>
                    <input id="login-password" name="password" type="password" class="form-input"
                        placeholder="Enter your password" required />
                </div>

                <div class="flex items-center justify-between text-sm text-neutral">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" class="h-4 w-4 rounded border-neutral focus:ring-candy-peach" />
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="font-medium text-primary hover:text-secondary">Forgot password?</a>
                </div>

                <button type="submit" class="btn-primary w-full">Sign In</button>
            </form>

            <div class="mt-8 mb-6">
                <div class="relative text-center text-sm text-neutral">
                    <span class="relative z-10 bg-white px-4">Don't have an account?</span>
                    <span
                        class="absolute inset-x-0 top-1/2 -z-10 h-px bg-linear-to-r from-transparent via-[var(--color-neutral-light)] to-transparent"></span>
                </div>
            </div>

            <button onclick="switchToRegister()" class="btn-outline w-full">
                Create New Account
            </button>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="register-modal" class="modal-panel hidden" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-backdrop" onclick="closeModal('register-modal')"></div>
    <div class="modal-surface max-w-3xl">
        <div class="modal-header">
            <div>
                <h2 class="headline text-slate-900 =">Create Account</h2>
                <p class="text-xs text-slate-700 mt-2">
                    Join us for exclusive bridal services.
                </p>
            </div>
            <button class="close-btn" aria-label="Close register" onclick="closeModal('register-modal')">
                ×
            </button>
        </div>

        <div class="modal-body max-h-[65vh] overflow-y-auto">
            <form id="register-form" action="../backend/reg_process.php" method="POST" class="space-y-6">
                <div id="register-message" class="hidden"></div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="form-label" for="reg-first-name">First Name</label>
                        <input id="reg-first-name" name="first_name" type="text" class="form-input"
                            placeholder="Enter first name" required />
                    </div>
                    <div>
                        <label class="form-label" for="reg-last-name">Last Name</label>
                        <input id="reg-last-name" name="last_name" type="text" class="form-input"
                            placeholder="Enter last name" required />
                    </div>
                </div>

                <div>
                    <label class="form-label" for="reg-email">Email Address</label>
                    <input id="reg-email" name="email" type="email" class="form-input" placeholder="Enter your email"
                        required />
                </div>

                <div>
                    <label class="form-label" for="reg-contact">Phone Number</label>
                    <input id="reg-contact" name="contact_number" type="tel" class="form-input"
                        placeholder="Enter phone number" required />
                </div>

                <div>
                    <label class="form-label" for="reg-password">Password</label>
                    <input id="reg-password" name="password" type="password" class="form-input"
                        placeholder="Create a password" required />
                </div>

                <div>
                    <label class="form-label" for="reg-confirm-password">Confirm Password</label>
                    <input id="reg-confirm-password" name="confirm_password" type="password" class="form-input"
                        placeholder="Confirm your password" required />
                </div>

                <label class="flex items-start gap-3 text-sm text-neutral">
                    <input id="agree-terms" name="agree-terms" type="checkbox"
                        class="mt-1 h-4 w-4 rounded border-neutral focus:ring-candy-peach" />
                    <span>I agree to the
                        <a href="#" class="font-medium text-primary hover:text-secondary">Terms of Service</a>
                        and
                        <a href="#" class="font-medium text-primary hover:text-secondary">Privacy Policy</a>
                    </span>
                </label>
            </form>
        </div>

        <div class="modal-footer">
            <div class="flex gap-3">
                <button type="button" class="btn-secondary flex-1" onclick="closeModal('register-modal')">
                    Cancel
                </button>
                <button type="submit" form="register-form" class="btn-primary hover:text-slate-900 flex-1">
                    Create Account
                </button>
            </div>
            <p class="text-center text-sm text-neutral">
                Already have an account?
                <a href="#" onclick="switchToLogin()" class="font-medium text-primary hover:text-secondary">Sign in
                    here</a>
            </p>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.classList.remove("hidden");
        el.classList.add("is-open");

        if (
            id === "register-modal" &&
            typeof resetRegisterFormValidation === "function"
        ) {
            resetRegisterFormValidation();
        }
    }

    function closeModal(id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.classList.add("hidden");
        el.classList.remove("is-open");
    }

    function switchToRegister() {
        closeModal("login-modal");
        openModal("register-modal");
    }

    function switchToLogin() {
        closeModal("register-modal");
        openModal("login-modal");
    }

    document.addEventListener("DOMContentLoaded", function () {
        const openLoginBtn = document.getElementById("open-login");
        const openRegisterBtn = document.getElementById("open-register");

        if (openLoginBtn) {
            openLoginBtn.addEventListener("click", function (event) {
                event.preventDefault();
                openModal("login-modal");
            });
        }

        if (openRegisterBtn) {
            openRegisterBtn.addEventListener("click", function (event) {
                event.preventDefault();
                openModal("register-modal");
            });
        }
    });

    function logout() {
        if (!window.confirm("Are you sure you want to logout?")) {
            return;
        }
        $.ajax({
            url: "../backend/logout.php",
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    resetNavbarToGuest();
                    alert("Logged out successfully!");
                }
            },
            error: function () {
                resetNavbarToGuest();
            },
        });
    }

    function resetNavbarToGuest() {
        const guestMenu = document.getElementById("guest-menu");
        if (guestMenu) guestMenu.style.display = "block";

        const userMenu = document.getElementById("user-menu");
        if (userMenu) userMenu.classList.add("hidden");

        const accountText = document.getElementById("account-text");
        if (accountText) accountText.textContent = "My Account";
    }

    window.logout = logout;
</script>