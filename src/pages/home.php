<style>
  #reviews-row {
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  #reviews-row::-webkit-scrollbar {
    display: none;
  }
</style>
<?php
require_once('../backend/session_check.php');
$isLoggedIn = isLoggedIn();

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

require_once('../layouts/app.php');
renderHeader([
  'title' => 'Home - Promise',
  'isLoggedIn' => $isLoggedIn,
  'bodyClass' => 'flex min-h-screen flex-col bg-white',
  'mainClass' => 'flex-1 flex flex-col'
]);

// HERO
$title = "WELCOME TO";
$highlight = 'PROMISE';
$subtitle = "We design and curate stunning wedding dresses for brides and grooms, blending elegance, comfort, and romance—because every couple deserves to shine on their wedding day.";
$extra_class = "";

include('../components/hero.php');
?>


<?php
$showWelcomeFromServer = false;
if (isset($_SESSION['show_welcome']) && $_SESSION['show_welcome']) {
  $showWelcomeFromServer = true;
  unset($_SESSION['show_welcome']);
}
?>
<?php if ($showWelcomeFromServer): ?>
  <div id="welcome-modal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none">
    <!-- Backdrop -->
    <div id="welcome-modal-backdrop" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity" data-close="true">
    </div>

    <!-- Modal dialog -->
    <div role="dialog" aria-modal="true" aria-labelledby="welcome-modal-title" tabindex="-1"
      class="relative mx-4 w-full max-w-xl transform rounded-2xl bg-white p-6 shadow-lg transition-all scale-95 opacity-0">
      <!-- Close button intentionally removed per request -->

      <div class="text-center">
        <h2 id="welcome-modal-title" class="text-3xl font-bold text-dark mb-4">Welcome,
          <?php echo htmlspecialchars($user_name); ?>!
        </h2>
        <p class="text-slate-700 mb-6 max-w-lg mx-auto">Continue your bridal journey with personalized recommendations and
          exclusive offers.</p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="shop.php" class="btn-primary">Continue Shopping</a>
          <a href="profile.php" class="btn-secondary">View Profile</a>
        </div>
      </div>
    </div>
  </div>


<?php endif; ?>

<!-- FEATURED PRODUCTS -->
<section class="grow py-16 md:py-20">
  <div class="relative z-10 m-auto max-w-7xl justify-center py-2">
    <!-- Revamped heading: centered uppercase with horizontal rules each side -->
    <div class="mx-auto max-w-5xl">
      <div class="flex items-center gap-6">
        <div class="h-px flex-1 bg-candy-lavender"></div>
        <h2
          class="font-Tinos text-center text-2xl leading-none tracking-widest text-slate-900 uppercase md:tracking-[0.6em] lg:tracking-[0.8em]">
          OUR BRIDES
        </h2>
        <div class="h-px flex-1 bg-candy-lavender"></div>
      </div>

      <p class="font-Unna mx-auto mt-6 mb-24 text-center text-base leading-7 text-slate-700 sm:text-lg md:text-xl">
        Promise couture aesthetics can be summed up in three words:
        feminine, flattering, and modern. Her wedding gowns are a
        magnificent assemblage of intricate beadworks and graceful patterns
        that perfectly fit the sensible romantic bride. It is of no surprise
        that Orlina is one of the sought-after wedding gown designers in the
        Philippines.
      </p>
    </div>

    <div class="group relative cursor-pointer">
      <div class="absolute top-3 right-3 flex items-center gap-3 p-1">
        <button id="reviews-prev" aria-label="Previous reviews" aria-controls="reviews-row"
          class="cursor-pointer rounded-md border border-white/60 bg-white p-2 text-slate-900 opacity-0 shadow-sm transition-opacity duration-300 group-hover:opacity-100 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button id="reviews-next" aria-label="Next reviews" aria-controls="reviews-row"
          class="cursor-pointer rounded-md border border-white/60 bg-white p-2 text-slate-900 opacity-0 shadow-sm transition-opacity duration-300 group-hover:opacity-100 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>

      <div class="overflow-hidden">
        <div id="reviews-row" tabindex="0"
          class="reviews-row scrollbar-none flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-6"
          role="list" aria-label="Customer reviews">
          <!-- Item 1 -->
          <figure class="min-w-[220px] snap-center sm:min-w-[260px] md:min-w-[320px] md:snap-start lg:min-w-[360px]"
            role="listitem">
            <div class="aspect-3/4 overflow-hidden rounded-lg bg-white">
              <img src="../img/p-1.webp" alt="Gwynne M." loading="lazy" decoding="async"
                sizes="(min-width: 1024px) 360px, (min-width: 768px) 320px, (min-width: 640px) 260px, 220px"
                class="h-full w-full object-cover" />
            </div>
            <figcaption class="mt-4 text-center">
              <div class="font-semibold text-slate-900">Gwynne M.</div>
              <blockquote class="mt-2 min-h-14 text-sm text-slate-700 sm:min-h-12">
                "I knew the Elmi was everything I wanted, but I was nervous
                to order online. I did it anyway and was blown away."
              </blockquote>
            </figcaption>
          </figure>

          <!-- Item 2 -->
          <figure class="min-w-[220px] snap-center sm:min-w-[260px] md:min-w-[320px] md:snap-start lg:min-w-[360px]">
            <div class="aspect-3/4 overflow-hidden rounded-lg bg-white">
              <img src="../img/p-5.webp" alt="Brianna F.K." loading="lazy" decoding="async"
                sizes="(min-width: 1024px) 360px, (min-width: 768px) 320px, (min-width: 640px) 260px, 220px"
                class="h-full w-full object-cover" />
            </div>
            <figcaption class="mt-4 text-center">
              <div class="font-semibold text-slate-900">Brianna F.K.</div>
              <blockquote class="mt-2 min-h-14text-sm text-slate-700 sm:min-h-12">
                "The quality is INSANE. The glitter was perfect, boning and
                structure were top tier in the corset."
              </blockquote>
            </figcaption>
          </figure>

          <!-- Item 3 -->
          <figure class="min-w-[220px] snap-center sm:min-w-[260px] md:min-w-[320px] md:snap-start lg:min-w-[360px]">
            <div class="aspect-3/4 overflow-hidden rounded-lg bg-white">
              <img src="../img/p-3.webp" alt="Brittany F." loading="lazy" decoding="async"
                sizes="(min-width: 1024px) 360px, (min-width: 768px) 320px, (min-width: 640px) 260px, 220px"
                class="h-full w-full object-cover" />
            </div>
            <figcaption class="mt-4 text-center">
              <div class="font-semibold text-slate-900">Brittany F.</div>
              <blockquote class="mt-2 min-h-14text-sm text-slate-700 sm:min-h-12">
                "I just wanna say a big thank you to everyone who made our
                big day so incredible."
              </blockquote>
            </figcaption>
          </figure>

          <!-- Item 4 -->
          <figure class="min-w-[220px] snap-center sm:min-w-[260px] md:min-w-[320px] md:snap-start lg:min-w-[360px]">
            <div class="aspect-3/4 overflow-hidden rounded-lg bg-white">
              <img src="../img/p-4.webp" alt="Camille R." loading="lazy" decoding="async"
                sizes="(min-width: 1024px) 360px, (min-width: 768px) 320px, (min-width: 640px) 260px, 220px"
                class="h-full w-full object-cover" />
            </div>
            <figcaption class="mt-4 text-center">
              <div class="font-semibold font-Tinos text-slate-900">Camille R.</div>
              <blockquote class="mt-2 min-h-14text-sm text-slate-700 sm:min-h-12">
                "The staff was incredible and the dress was perfect."
              </blockquote>
            </figcaption>
          </figure>

          <!-- Item 5 -->
          <figure class="min-w-[220px] snap-center sm:min-w-[260px] md:min-w-[320px] md:snap-start lg:min-w-[360px]">
            <div class="aspect-3/4 overflow-hidden rounded-lg bg-white">
              <img src="../img/p-2.jpg" alt="Samantha P." loading="lazy" decoding="async"
                sizes="(min-width: 1024px) 360px, (min-width: 768px) 320px, (min-width: 640px) 260px, 220px"
                class="h-full w-full object-cover" />
            </div>
            <figcaption class="mt-4 text-center">
              <div class="font-semibold text-slate-900">Samantha P.</div>
              <blockquote class="mt-2 min-h-14text-sm text-slate-700 sm:min-h-12">
                "Absolutely beautiful gown and top notch service."
              </blockquote>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Story & Image -->
<section class="py-16 md:py-5">
  <div class="mx-auto max-w-7xl px-4">
    <div class="rounded-xl bg-candy-mint p-6 sm:p-10 md:p-12">
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 md:gap-8">
        <!-- Left: text panel -->
        <div class="flex items-center justify-center md:justify-start">
          <div class="mx-auto max-w-xl text-center md:mx-0 md:text-left">
            <h2 class="font-Tinos mt-2 text-4xl text-slate-900 sm:text-5xl">
              OUR STORY
            </h2>
            <p class="font-Unna mt-6 text-xl  text-slate-700">
              Promise was founded to bring beautifully crafted wedding
              attire to couples who want timeless elegance with modern
              comfort. We blend artisanal techniques with carefully chosen
              fabrics, focusing on fit, detail and sustainable practices.
              Our mission is to make every couple feel confident and
              celebrated.
            </p>
            <a href="../pages/contact.php" aria-label="Learn more about our trunk show"
              class="mt-8 inline-block rounded-md border border-slate-900 px-6 py-3 text-sm font-medium text-slate-900 transition-colors hover:bg-white/40 focus:ring-2 focus:ring-slate-700 focus:ring-offset-2 focus:ring-offset-[#a8c4d6] focus:outline-none">
              Contact Us
            </a>
          </div>
        </div>

        <!-- Right: image panel -->
        <div class="relative">
          <div class="overflow-hidden rounded-lg shadow-[0_10px_30px_rgba(2,6,23,0.15)]">
            <div class="aspect-3/4 md:aspect-3/4">
              <img src="../img/about-image.webp" alt="Brides trying on dresses at a trunk show" loading="lazy"
                decoding="async" class="h-full w-full object-cover" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- OUR PROCESS (Blog-style card) -->
<section class="bg-candy-cream py-16 md:py-20">
  <div class="mx-auto max-w-7xl px-4">
    <div class="mx-auto max-w-6xl">
      <div class="grid grid-cols-1 items-start gap-8 md:grid-cols-12">
        <!-- Left image with double border frame -->
        <div class="flex justify-center md:col-span-4 md:justify-start">
          <div class="border border-slate-700 p-2">
            <div class="border border-slate-700">
              <img src="../img/our-process.jpg" alt="Detailed bodice of a wedding gown on a mannequin" loading="lazy"
                decoding="async" class="h-auto w-full object-cover" />
            </div>
          </div>
        </div>

        <!-- Right content -->
        <div class="md:col-span-8">
          <div class="flex items-baseline justify-between gap-4">
            <h3 class="font-Tinos text-2xl text-slate-800 sm:text-3xl md:text-4xl">
              OUR PROCESS
            </h3>
          </div>
          <hr class="mt-2 border-slate-300" />
          <p class="font-unna mt-6 leading-7 text-slate-700">
            From initial design sketches to the final fitting, our process
            centers on collaboration. We consult closely with you to select
            fabrics, refine silhouettes, and ensure your dress or suit
            reflects your vision. Small production runs allow for careful
            quality control at every stage.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Go Shopping Button -->
<div class="m-6 flex justify-center sm:m-8">
  <a href="../pages/shop.php"
    class="inline-block rounded-full transition-colors hover:bg-pink-400 bg-pink-300 px-8 py-4 text-base font-Unna-bold text-white focus:outline-none sm:px-10 sm:py-5 sm:text-lg">SHOP
    NOW</a>
</div>

<?php
renderFooter([
  'scripts' => [
    '<script src="https://unpkg.com/motion@latest/dist/motion.umd.js"></script>',
    '<script src="../js/main.js"></script>',
    '<script src="../js/featured-carousel.js"></script>',
    '<script src="../js/reviews-drag.js"></script>',
    '<script src="../js/scroll-fade.js"></script>',
    '<script src="../js/validation-integration.js"></script>',
    '<script src="../js/auth.js"></script>',
    '<script src="../js/reveal.js"></script>',
    '<script src="../js/reviews.js"></script>',
    '<script src="../js/home-page.js"></script>'
  ]
]);
?>