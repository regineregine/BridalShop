<?php
require_once('../backend/session_check.php');
$isLoggedIn = isLoggedIn();

// Get user data directly from session for consistency
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

require_once('../layouts/app.php');
renderHeader([
  'title' => 'Collections - Promise',
  'isLoggedIn' => $isLoggedIn,
  'bodyClass' => 'flex min-h-screen flex-col bg-white',
  'mainClass' => 'flex-1'
]);

// HERO
$title = "THE BRIDAL";
$highlight = "COLLECTIONS";
$subtitle = "Discover our exquisite collection of wedding dresses, each designed to make your special day unforgettable.";
$extra_class = "py-32";
include('../components/hero.php');
?>

<section class="grow py-5 md:py-5">


  <div class="relative z-10 m-auto max-w-7xl justify-center py-5">
    <!-- Collections Grid -->
    <div class="grid grid-cols-1 gap-8 px-4 sm:grid-cols-2 lg:grid-cols-3">

      <!-- Collection 1: Issa 2 -->
      <div
        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-[0_8px_30px_rgba(210,199,229,0.12)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(210,199,229,0.2)]">
        <div class="aspect-3/4 overflow-hidden bg-linear-to-br from-amber-900 to-amber-700">
          <img src="../img/pp-1.webp" alt="Issa 2 Wedding Dress"
            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="p-6 text-center">
          <h3 class="font-Tinos text-xl text-pink-950">Issa</h3>
          <p class="mt-2 text-sm text-slate-700">Elegant off-the-shoulder gown with delicate lace detailing</p>
          <div class="mt-4">
            <span class="text-lg font-semibold text-slate-700">₱2,500</span>
          </div>
        </div>
      </div>

      <!-- Collection 2: Jenna -->
      <div
        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-[0_8px_30px_rgba(210,199,229,0.12)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(210,199,229,0.2)]">
        <div class="aspect-3/4 overflow-hidden bg-linear-to-br from-amber-900 to-amber-700">
          <img src="../img/pp-2.webp" alt="Jenna Wedding Dress"
            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="p-6 text-center">
          <h3 class="font-Tinos text-xl text-pink-950">Jenna</h3>
          <p class="mt-2 text-sm text-slate-700">Romantic A-line gown with voluminous tulle skirt</p>
          <div class="mt-4">
            <span class="text-lg font-semibold text-slate-700">₱2,800</span>
          </div>
        </div>
      </div>

      <!-- Collection 3: Mia 2 -->
      <div
        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-[0_8px_30px_rgba(210,199,229,0.12)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(210,199,229,0.2)]">
        <div class="aspect-3/4 overflow-hidden bg-linear-to-br from-amber-900 to-amber-700">
          <img src="../img/pp-3.jpg" alt="Mia 2 Wedding Dress"
            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="p-6 text-center">
          <h3 class="font-Tinos text-xl text-pink-950">Allia</h3>
          <p class="mt-2 text-sm text-slate-700">Dramatic high-low gown with structured corset bodice</p>
          <div class="mt-4">
            <span class="text-lg font-semibold text-slate-700">₱3,200</span>
          </div>
        </div>
      </div>

      <!-- Collection 4: Mia -->
      <div
        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-[0_8px_30px_rgba(210,199,229,0.12)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(210,199,229,0.2)]">
        <div class="aspect-3/4 overflow-hidden bg-linear-to-br from-gray-900 to-gray-700">
          <img src="../img/pp-4.jpg" alt="Mia Wedding Dress"
            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="p-6 text-center">
          <h3 class="font-Tinos text-xl text-pink-950">Mia</h3>
          <p class="mt-2 text-sm text-slate-700">Chic tea-length dress with modern A-line silhouette</p>
          <div class="mt-4">
            <span class="text-lg font-semibold text-slate-700">₱1,800</span>
          </div>
        </div>
      </div>

      <!-- Collection 5: Juliette -->
      <div
        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-[0_8px_30px_rgba(210,199,229,0.12)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(210,199,229,0.2)]">
        <div class="aspect-3/4 overflow-hidden bg-linear-to-br from-gray-900 to-gray-700">
          <img src="../img/pp-5.jpg" alt="Juliette Wedding Dress"
            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="p-6 text-center">
          <h3 class="font-Tinos text-xl text-pink-950">Juliette</h3>
          <p class="mt-2 text-sm text-slate-700">Timeless long-sleeved gown with boat neck elegance</p>
          <div class="mt-4">
            <span class="text-lg font-semibold text-slate-700">₱2,900</span>
          </div>
        </div>
      </div>

      <!-- Collection 6: Sarah -->
      <div
        class="group cursor-pointer overflow-hidden rounded-lg bg-white shadow-[0_8px_30px_rgba(210,199,229,0.12)] transition-all duration-300 hover:shadow-[0_12px_40px_rgba(210,199,229,0.2)]">
        <div class="aspect-3/4 overflow-hidden bg-linear-to-br from-gray-900 to-gray-700">
          <img src="../img/pp-6.webp" alt="Sarah Wedding Dress"
            class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="border-pink-500 p-6 text-center">
          <h3 class="font-Tinos text-xl text-pink-950">Sarah</h3>
          <p class="mt-2 text-sm text-slate-700">Relaxed flowing gown with modern pocket details</p>
          <div class="mt-4">
            <span class="text-lg font-semibold text-slate-700">₱2,200</span>
          </div>
        </div>
      </div>

    </div>

    <!-- Call to Action -->
    <div class="mt-10 text-center">
      <h2 class="font-Tinos text-3xl font-simebold text-slate-900 mb-4">Ready to Find Your Perfect Dress?</h2>
      <p class="text-slate-700 mb-8 max-w-2xl mx-auto">
        Schedule a private consultation to try on these beautiful gowns and find the one that makes you feel absolutely
        stunning on your special day.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="../pages/reservation.php"
          class=" inline-block rounded-full border-2 border-pink-500 px-8 py-4 text-base font-semibold text-slate-700 transition-all hover:bg-pink-400 hover:text-white focus:ring-2 focus:ring-candy-peach focus:ring-offset-2 focus:ring-offset-candy-cream focus:outline-none">
          Book Consultation
        </a>
        <a href="../pages/shop.php"
          class="inline-block rounded-full border-2 border-pink-500 px-8 py-4 text-base font-semibold text-slate-700 transition-all hover:bg-pink-400 hover:text-white focus:ring-2 focus:ring-candy-peach focus:ring-offset-2 focus:ring-offset-candy-cream focus:outline-none">
          View All Dresses
        </a>
      </div>
    </div>
  </div>
</section>

<?php
renderFooter([
  'scripts' => [
    '<script src="https://unpkg.com/motion@latest/dist/motion.umd.js"></script>',
    '<script src="../js/main.js"></script>',
    '<script src="../js/validation-integration.js"></script>',
    '<script src="../js/auth.js"></script>',
    '<script src="../js/reveal.js"></script>',
    '<script src="../js/scroll-fade.js"></script>',
    '<script src="../js/reviews.js"></script>'
  ]
]);
?>