<?php
require_once('../backend/session_check.php');
$isLoggedIn = isLoggedIn();

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;
require_once('../layouts/app.php');
renderHeader([
  'title' => 'About - Promise',
  'isLoggedIn' => $isLoggedIn,
  'bodyClass' => 'flex min-h-screen flex-col bg-white',
  'mainClass' => 'flex-1'
]);
// HERO
$title = "BOOK YOUR";
$highlight = 'RESERVATION';
$subtitle = "Reserve your appointment with Promise Atelier for fittings, consultations, or custom designs.";
$extra_class = "py-32";

include('../components/hero.php');
?>

<div class="mx-auto max-w-7xl px-4 py-20">

  <!-- Reservation Form -->
  <section class="mb-12 card grid grid-cols-1 gap-6">
    <div>
      <h3 class="mb-2 text-lg font-semibold text-slate-900 sm:text-xl">Reservation Form</h3>
      <p class="mb-4 text-sm font-Unna text-slate-700 sm:text-base">Fill in your details below to schedule your visit.
        We’ll confirm your reservation via email.</p>
      <form id="reservation-form" action="" method="POST" class="space-y-4" novalidate>
        <div>
          <label for="res-name" class="block text-slate-900 font-medium mb-1">Full Name <span
              class="text-red-500">*</span></label>
          <input id="res-name" name="name" type="text" required minlength="2" autocomplete="name"
            placeholder="Your full name" value="<?php echo htmlspecialchars($user_name); ?>"
            class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
          <p class="text-red-500 text-sm mt-1 hidden" id="res-name-error"></p>
        </div>
        <div>
          <label for="res-email" class="block text-slate-900 font-medium mb-1">Email <span
              class="text-red-500">*</span></label>
          <input id="res-email" name="email" type="email" required autocomplete="email" placeholder="you@email.com"
            value="<?php echo htmlspecialchars($user_email); ?>"
            class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
          <p class="text-red-500 text-sm mt-1 hidden" id="res-email-error"></p>
        </div>
        <div>
          <label for="res-phone" class="block text-slate-900 font-medium mb-1">Phone Number <span
              class="text-red-500">*</span></label>
          <input id="res-phone" name="phone" type="text" required maxlength="13" minlength="10"
            placeholder="e.g. 09123456789"
            class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
          <p class="text-red-500 text-sm mt-1 hidden" id="res-phone-error"></p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="res-date" class="block text-slate-900 font-medium mb-1">Date <span
                class="text-red-500">*</span></label>
            <input id="res-date" name="date" type="date" required
              class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
            <p class="text-red-500 text-sm mt-1 hidden" id="res-date-error"></p>
          </div>
          <div>
            <label for="res-time" class="block text-slate-900 font-medium mb-1">Time <span
                class="text-red-500">*</span></label>
            <input id="res-time" name="time" type="time" required
              class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
            <p class="text-red-500 text-sm mt-1 hidden" id="res-time-error"></p>
          </div>
        </div>
        <div>
          <label for="res-guests" class="block text-slate-900 font-medium mb-1">Number of Guests <span
              class="text-red-500">*</span></label>
          <input id="res-guests" name="guests" type="number" required min="1" placeholder="e.g. 1"
            class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400" />
          <p class="text-red-500 text-sm mt-1 hidden" id="res-guests-error"></p>
        </div>
        <div>
          <label for="res-message" class="block text-slate-900 font-medium mb-1">Message (optional)</label>
          <textarea id="res-message" name="message" rows="3"
            placeholder="Additional details (min 10 characters if filled)"
            class="w-full rounded-xl border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400 resize-none"></textarea>
          <p class="text-red-500 text-sm mt-1 hidden" id="res-message-error"></p>
        </div>
        <button type="submit" class="w-full bg-pink-500 text-white py-2 rounded-xl hover:bg-pink-600 transition">Submit
          Reservation</button>
      </form>
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
      '<script src="../js/reviews.js"></script>',
      '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>',
      '<script src="../js/reservation-page.js"></script>'
    ]
  ]);
  ?>