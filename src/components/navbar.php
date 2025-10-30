<?php
require_once('../backend/session_check.php');
$isLoggedIn = isLoggedIn();

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
?>

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 h-auto md:h-20 flex bg-pink-100 shadow-soft">
    <div class="container mx-auto flex flex-col items-center justify-between gap-4 p-4 md:flex-row md:gap-0">
        <div class="flex w-full items-center justify-between md:w-auto">
            <a href="../pages/home.php"
                class="text-3xl font-GreatVibes md:text-4xl lg:text-5xl text-pink-950 hover:text-pink-500">
                Pro<span class="text-pink-500 hover:text-pink-950">mise</span></a>
            <!-- mobile menu button -->
            <button id="nav-toggle" type="button" aria-controls="nav-menu" aria-expanded="false"
                class="inline-flex items-center justify-center rounded-md p-2 text-dark hover:bg-white/10 focus:ring-2 focus:ring-primary focus:outline-none md:hidden">
                <span class="sr-only">Open main menu</span>
                <!-- hamburger icon -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- NAV MENU -->
        <ul id="nav-menu"
            class="hidden w-full flex-col items-center space-y-2 text-center text-lg text-pink-950 sm:text-xl md:w-auto md:flex md:flex-row md:space-y-0 md:space-x-8">
            <li>
                <a href="../pages/home.php" class="px-4 py-2 align-middle hover:text-pink-500 md:px-2">Home</a>
            </li>

            <li class="relative group">
                <a id="shop-toggle" href="../pages/shop.php"
                    class="px-4 py-2 align-middle hover:text-pink-500 md:px-2 flex items-center" aria-haspopup="true"
                    aria-expanded="false">
                    Shop
                    <svg class="w-2 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>

                <!-- Shop Dropdown -->
                <div id="shop-dropdown"
                    class="absolute left-0 top-full mt-2 bg-white shadow-medium border border-light rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50"
                    style="width: 220px">
                    <div class="py-2">
                        <a href="../pages/collections.php"
                            class="block px-4 py-3 hover:text-pink-500 hover:bg-light transition-colors">
                            Collections
                        </a>
                        <a href="../pages/dresses-robes.php"
                            class="block px-4 py-3 hover:text-pink-500 hover:bg-light transition-colors">
                            Dresses/Robes
                        </a>
                        <a href="../pages/veils-accessories.php"
                            class="block px-4 py-3 hover:text-pink-500 hover:bg-light transition-colors">
                            Veils and Accessories
                        </a>
                    </div>
                </div>
            </li>
            <li>
                <a href="../pages/size-guide.php" class="px-4 py-2 align-middle hover:text-pink-500 md:px-2">Size
                    Guide</a>
            </li>
            <li>
                <a href="../pages/reservation.php"
                    class="px-4 py-2 align-middle hover:text-pink-500 md:px-2">Reservation</a>
            </li>
            <li>
                <a href="../pages/contact.php" class="px-4 py-2 align-middle hover:text-pink-500 md:px-2">Contact</a>
            </li>
            <!-- Cart Nav with badge -->
            <li class="relative">
                <a href="../pages/cart.php"
                    class="px-4 py-2 align-middle hover:text-pink-500 md:px-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-pink-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.6 17h8.8a1 1 0 00.95-.68L21 13M7 13V6a1 1 0 011-1h9a1 1 0 011 1v7" />
                    </svg>
                    Cart
                    <?php
                    $cartCount = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        $cartCount = count($_SESSION['cart']); // Unique items only
                    }
                    if (
                        $cartCount >
                        0
                    ): ?>
                        <span
                            class="ml-2 inline-flex items-center justify-center rounded-full bg-pink-500 text-white text-xs font-bold px-2 py-1 min-w-[22px]"
                            style="min-width: 22px">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>

            <!-- USER-SPECIFIC NAVIGATION -->
            <?php if ($isLoggedIn): ?>
                <!-- Logged in user menu -->
                <li class="relative group">
                    <a id="account-toggle" href="../pages/profile.php"
                        class="px-4 py-2 align-middle hover:text-pink-500 md:px-2 flex items-center" aria-haspopup="true"
                        aria-expanded="false">
                        <span id="account-text">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-pink-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9.001 9.001 0 0112 15c2.21 0 4.21.805 5.879 2.146M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <svg class="w-2 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>

                    <!-- User Dropdown -->
                    <div id="user-dropdown"
                        class="absolute right-0 top-full mt-2 bg-white shadow-medium border border-light rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50"
                        style="width: 200px">
                        <div class="py-2" id="user-menu">
                            <div class="px-4 py-2 border-b border-light">
                                <p class="text-sm font-medium text-dark">
                                    Welcome,
                                    <?php echo htmlspecialchars($user_name); ?>
                                </p>
                                <p class="text-xs text-neutral">
                                    <?php echo htmlspecialchars($user_email); ?>
                                </p>
                            </div>
                            <a href="../backend/logout.php"
                                class="block px-4 py-3 hover:text-pink-500 hover:bg-light transition-colors">
                                Logout
                            </a>
                        </div>
                    </div>
                </li>
            <?php else: ?>
                <!-- Guest user menu -->
                <li class="relative group">
                    <a id="account-toggle" href="../pages/profile.php"
                        class="px-4 py-2 align-middle hover:text-pink-500 md:px-2 flex items-center" aria-haspopup="true"
                        aria-expanded="false">
                        <span id="account-text">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-pink-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A9.001 9.001 0 0112 15c2.21 0 4.21.805 5.879 2.146M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <svg class="w-2 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>

                    <!-- Guest Dropdown -->
                    <div id="guest-dropdown"
                        class="absolute right-0 top-full mt-2 bg-white shadow-medium border border-light rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50"
                        style="width: 200px">
                        <div class="py-2" id="guest-menu">
                            <a href="#" id="open-login"
                                class="block px-4 py-3 hover:text-pink-500 hover:bg-light transition-colors">
                                Login
                            </a>
                            <a href="#" id="open-register"
                                class="block px-4 py-3 hover:text-pink-500 hover:bg-light transition-colors">
                                Register
                            </a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php /* Modal included via layout */ ?>

<script>
    (function () {
        var toggle = document.getElementById("nav-toggle");
        var menu = document.getElementById("nav-menu");
        var shopToggle = document.getElementById("shop-toggle");
        var shopDropdown = document.getElementById("shop-dropdown");
        var accountToggles = document.querySelectorAll("#account-toggle");
        var userDropdown = document.getElementById("user-dropdown");
        var guestDropdown = document.getElementById("guest-dropdown");
        if (!toggle || !menu) return;
        function openMenu() {
            menu.classList.remove("hidden");
            menu.classList.add("flex");
            document.body.style.overflow = "hidden";
            toggle.setAttribute("aria-expanded", "true");
        }
        function closeMenu() {
            menu.classList.add("hidden");
            menu.classList.remove("flex");
            document.body.style.overflow = "";
            toggle.setAttribute("aria-expanded", "false");
        }
        toggle.addEventListener("click", function () {
            var isHidden = menu.classList.contains("hidden");
            isHidden ? openMenu() : closeMenu();
        });
        // Mobile: toggle dropdowns on click instead of hover
        function isMobile() {
            return window.innerWidth < 768;
        }
        function toggleDropdown(dropdownEl, triggerEl) {
            if (!dropdownEl) return;
            var isOpen = dropdownEl.classList.contains("opacity-100");
            if (isOpen) {
                dropdownEl.classList.remove("opacity-100", "visible");
                dropdownEl.classList.add("opacity-0", "invisible");
                if (triggerEl) triggerEl.setAttribute("aria-expanded", "false");
            } else {
                dropdownEl.classList.remove("opacity-0", "invisible");
                dropdownEl.classList.add("opacity-100", "visible");
                if (triggerEl) triggerEl.setAttribute("aria-expanded", "true");
            }
        }
        if (shopToggle && shopDropdown) {
            shopToggle.addEventListener("click", function (e) {
                if (isMobile()) {
                    e.preventDefault();
                    toggleDropdown(shopDropdown, shopToggle);
                }
            });
        }
        if (accountToggles && (userDropdown || guestDropdown)) {
            accountToggles.forEach(function (btn) {
                btn.addEventListener("click", function (e) {
                    if (!isMobile()) return;
                    e.preventDefault();
                    var dd = userDropdown || guestDropdown;
                    toggleDropdown(dd, btn);
                });
            });
        }
        menu.addEventListener("click", function (e) {
            var target = e.target;
            if (window.innerWidth >= 768) return;
            if (target.tagName === "A") closeMenu();
        });
        window.addEventListener("resize", function () {
            if (window.innerWidth >= 768) {
                menu.classList.remove("hidden");
                menu.classList.remove("flex");
                toggle.setAttribute("aria-expanded", "false");
                [shopDropdown, userDropdown, guestDropdown].forEach(function (dd) {
                    if (!dd) return;
                    dd.classList.remove("opacity-100", "visible");
                    dd.classList.add("opacity-0", "invisible");
                });
            } else {
                if (!menu.classList.contains("hidden")) closeMenu();
            }
        });
    })();
</script>