<?php
require_once('../backend/session_check.php');
$isLoggedIn = isLoggedIn();

require_once('../layouts/app.php');

renderHeader([
  'title' => 'Size Guide - Promise Shop',
  'isLoggedIn' => $isLoggedIn,
  'bodyClass' => 'flex min-h-screen flex-col bg-white',
  'mainClass' => 'flex-1'
]);

$title = 'SIZE';
$highlight = 'GUIDE';
$subtitle = 'Find your perfect fit with our comprehensive wedding dress sizing guide and measurement instructions.';
include('../components/hero.php');
?>

<section class="py-16 md:py-10">
  <div class="relative z-10 m-auto max-w-7xl justify-center px-4 pb-4">

    <div class="text-center">
      <?php
      $imgDir = __DIR__ . '/../img';
      $available = [];
      if (is_dir($imgDir)) {
        $files = scandir($imgDir);
        foreach ($files as $f) {
          $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
          if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $available[] = $f;
          }
        }
      }

      $images = ['bg-2.png', 'bg-3.png', 'bg-4.png', 'bg-5.png'];
      ?>

      <section class="py-8 md:py-12">
        <div class="mx-auto  ">
          <div class="mx-auto max-w-5xl">
            <h3
              class="font-Tinos text-center text-3xl leading-none tracking-widest text-slate-900 uppercase md:tracking-[0.6em] lg:tracking-[0.8em] mb-4">
              Our Universal Sizing System</h3>

            <div id="featured-carousel" class="relative overflow-hidden rounded-lg w-full ">
              <!-- Slides wrapper -->
              <div class="carousel-track relative flex transition-transform duration-700 ease-in-out">
                <?php foreach ($images as $idx => $img): ?>
                  <div class="carousel-slide shrink-0 w-full md:w-full">
                    <div class="aspect-10/10 md:aspect-3/2 overflow-hidden rounded-lg bg-white">
                      <img src="../img/<?php echo htmlspecialchars($img); ?>" alt="Featured <?php echo $idx + 1; ?>"
                        class="h-full w-full object-contain" loading="lazy" decoding="async" />
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Left & Right click zones -->
              <button id="carousel-prev" aria-label="Previous"
                class="absolute left-0 top-0 h-full w-1/4 bg-transparent focus:outline-none md:w-12"></button>
              <button id="carousel-next" aria-label="Next"
                class="absolute right-0 top-0 h-full w-1/4 bg-transparent focus:outline-none md:w-12"></button>

              <!-- Indicators -->
              <div class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                <?php foreach ($images as $i => $img): ?>
                  <button data-slide="<?php echo $i; ?>"
                    class="indicator h-2 w-8 rounded-full bg-white/50 ring-1 ring-slate-200 transition-all duration-300"></button>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <p class="text-slate-700 max-w-4xl mx-auto mb-6">
        We have created our own universal sizing chart that we use against all dresses on rack in store. We do not go
        off each dress's tagged sizes. With dresses being made from all over the world, size categories are not in sync.
        We have decided to have one system and measurements for each size category, every dress is measured and placed
        in a size on our universal list.
      </p>
      <p class="text-slate-700 max-w-4xl mx-auto mb-6">
        Wedding Dresses tend to measure much smaller than everyday clothes. Whilst this may be the case for all sizes,
        size 14 and up can differ by several sizes. You need to know your measurements to know what size category you
        fall in. We have provided a size chart below to help you work out what size you fall into with our dresses.
      </p>
      <div class="bg-pink-50 rounded-lg p-6 max-w-4xl mx-auto">
        <p class="text-slate-700 ">
          All wedding dresses will need alterations to make the dress fit perfectly. Hemming is always required. Please
          make sure you allow enough time to have alterations done before your wedding. Check with your local seamstress
          to know what time they require to have alterations done in time for your wedding. This is a separate cost
          through a seamstress of your choice.
        </p>
      </div>
    </div>


    <!-- How to Measure Section -->
    <div class="mb-16">
      <div class="bg-white rounded-lg shadow-[0_8px_30px_rgba(210,199,229,0.12)] p-8">
        <h3 class="font-Tinos text-2xl text-slate-900 mb-6 text-center">How to Measure Yourself</h3>
        <p class="text-center text-slate-700 mb-8 py-4">Dresses are measured and put into their closest size category.
          Please
          allow for a couple centimeters discrepancy. If a dress has a lace-up back, size can be adjustable, please
          message to check fit before purchasing.</p>

        <!-- Measurement Images -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
          <div class="text-center">
            <img src="../img/size1.jpg" alt="How to measure yourself - visual guide"
              class="w-full max-w-md mx-auto rounded-lg shadow-lg">
            <p class="text-sm text-gray-600 mt-2">Measurement Guide</p>
          </div>
          <div class="text-center">
            <img src="../img/size2.jpg" alt="Size chart visual guide"
              class="w-full max-w-md mx-auto rounded-lg shadow-lg">
            <p class="text-sm text-gray-600 mt-2">Size Chart Reference</p>
          </div>
        </div>

        <!-- Simple Checklist -->
        <div class="bg-candy-cream rounded-lg p-6 mb-8">
          <h4 class="font-semibold text-pink-950 mb-4 text-center">What You Need:</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="flex items-center space-x-2">
              <span class="text-candy-peach">✓</span>
              <span>A measuring tape (like the ones tailors use)</span>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-candy-peach">✓</span>
              <span>A friend or family member to help</span>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-candy-peach">✓</span>
              <span>The bra you'll wear on your wedding day</span>
            </div>
            <div class="flex items-center space-x-2">
              <span class="text-candy-peach">✓</span>
              <span>Your wedding shoes (for length measurement)</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Measurement Instructions -->
          <div class="space-y-6">
            <div class="border-l-4 border-candy-peach pl-4">
              <h4 class="font-semibold text-pink-950 mb-2">1. Around Your Chest (Bust)</h4>
              <p class="text-gray-700 text-sm">
                <strong>Step 1:</strong> Put on the bra you'll wear on your wedding day
                <br><strong>Step 2:</strong> Wrap the measuring tape around the biggest part of your chest
                <br><strong>Step 3:</strong> Make it tight enough to stay in place, but not so tight you can't breathe
                <br><strong>Write down:</strong> The number where the tape meets itself
              </p>
            </div>

            <div class="border-l-4 border-candy-peach pl-4">
              <h4 class="font-semibold text-pink-950 mb-2">2. Around Your Waist</h4>
              <p class="text-gray-700 text-sm">
                <strong>Step 1:</strong> Find the smallest part of your waist (bend sideways - where it creases is your
                waist)
                <br><strong>Step 2:</strong> Wrap the measuring tape around this spot
                <br><strong>Step 3:</strong> Don't suck in your stomach - just stand normally
                <br><strong>Write down:</strong> The number where the tape meets itself
              </p>
            </div>

            <div class="border-l-4 border-candy-peach pl-4">
              <h4 class="font-semibold text-pink-950 mb-2">3. Around Your Hips</h4>
              <p class="text-gray-700 text-sm">
                <strong>Step 1:</strong> Find the biggest part of your hips and bottom
                <br><strong>Step 2:</strong> Wrap the measuring tape around this spot
                <br><strong>Step 3:</strong> Make sure the tape is straight all the way around (not higher on one side)
                <br><strong>Write down:</strong> The number where the tape meets itself
              </p>
            </div>

            <div class="border-l-4 border-candy-peach pl-4">
              <h4 class="font-semibold text-pink-950 mb-2">4. Hollow to Hem (Length)</h4>
              <p class="text-gray-700 text-sm">
                <strong>Step 1:</strong> Put on your wedding shoes
                <br><strong>Step 2:</strong> Start measuring from the base of your neck (where your neck dips in)
                <br><strong>Step 3:</strong> Measure straight down to where you want your dress to end
                <br><strong>Write down:</strong> The number where you want the dress to stop
              </p>
            </div>
          </div>

          <!-- Visual Guide -->
          <div class="flex items-center justify-center">
            <div class="bg-linear-to-br from-candy-cream to-candy-pink-light rounded-lg p-8 text-center">
              <div class="w-32 h-48 mx-auto mb-4 bg-white rounded-lg shadow-lg flex items-center justify-center">
                <div class="text-center">
                  <div class="w-16 h-16 bg-candy-peach rounded-full mx-auto mb-2 flex items-center justify-center">
                    <span class="text-white text-xs font-bold">B</span>
                  </div>
                  <div class="w-12 h-12 bg-candy-lavender rounded-full mx-auto mb-2 flex items-center justify-center">
                    <span class="text-white text-xs font-bold">W</span>
                  </div>
                  <div class="w-14 h-14 bg-candy-mint rounded-full mx-auto flex items-center justify-center">
                    <span class="text-white text-xs font-bold">H</span>
                  </div>
                </div>
              </div>
              <p class="text-pink-800 text-sm">
                <span class="font-semibold">B</span> = Bust<br>
                <span class="font-semibold">W</span> = Waist<br>
                <span class="font-semibold">H</span> = Hips
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Size Chart -->
    <div class="mb-16">
      <div class="bg-white rounded-lg shadow-[0_8px_30px_rgba(210,199,229,0.12)] p-8">
        <h3 class="font-Tinos text-2xl text-slate-900 mb-6 text-center">Our Universal Size Chart</h3>
        <p class="text-center text-slate-700 mb-8">Below is our universal size chart and you will find instructions on
          how to measure yourself.</p>

        <div class="overflow-x-auto">
          <table class="w-full border-collapse">
            <thead>
              <tr class="bg-candy-cream">
                <th class="border border-candy-lavender-light px-4 py-3 text-left text-pink-950 font-semibold">Size</th>
                <th class="border border-candy-lavender-light px-4 py-3 text-center text-pink-950 font-semibold">Bust
                  (cm)</th>
                <th class="border border-candy-lavender-light px-4 py-3 text-center text-pink-950 font-semibold">Waist
                  (cm)</th>
                <th class="border border-candy-lavender-light px-4 py-3 text-center text-pink-950 font-semibold">Hips
                  (cm)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">4</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">82-84</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">61-63</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">89-91</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">6</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">85-87</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">64-67</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">92-95</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">8</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">88-90</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">68-71</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">96-99</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">10</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">91-94</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">72-75</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">100-103</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">12</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">95-99</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">76-80</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">104-108</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">14</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">100-104</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">81-85</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">109-113</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">16</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">105-109</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">86-90</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">114-118</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">18</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">110-114</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">91-95</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">119-123</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">20</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">115-119</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">96-100</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">124-128</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">22</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">120-124</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">101-105</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">129-133</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">24</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">125-130</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">106-111</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">134-139</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">26</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">131-137</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">112-117</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">140-145</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">28</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">138-143</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">118-123</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">146-151</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">30</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">144-149</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">124-129</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">152-157</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">32</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">150-155</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">130-135</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">158-163</td>
              </tr>
              <tr class="hover:bg-candy-cream transition-colors">
                <td class="border border-candy-lavender-light px-4 py-3 text-pink-950 font-medium">34</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">156-161</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">136-141</td>
                <td class="border border-candy-lavender-light px-4 py-3 text-center text-gray-700">164-169</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Height Requirements -->
    <div class="mb-16">
      <div class="bg-white rounded-lg shadow-[0_8px_30px_rgba(210,199,229,0.12)] p-8">
        <h3 class="font-Tinos text-2xl text-pink-950 mb-6 text-center">Height Requirements</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <div class="space-y-4">
            <p class="text-gray-700">
              Please know that most brides of average height do not need to worry about the length of the gown being too
              short. Most brides will need their gown hemmed to the perfect length by their bridal seamstress, which is
              absolutely normal.
            </p>
            <p class="text-gray-700">
              When comparing your height to the length of each gown, please compare your hollow to hem measurement to
              the hollow to hem measurement of each gown. This measurement is "not" your actual height.
            </p>
            <p class="text-gray-700">
              The hollow to hem measurement is the measurement from the base of your neck (where your neck dips in) to
              the hem of where you would the hem to end. Try to get someone to help as you will need to stand up
              straight without looking down when taking this measurement.
            </p>
            <p class="text-gray-700 font-semibold">
              It is always a good idea to have the same or similar shoe height on that you plan to wear the day of the
              wedding.
            </p>
          </div>

          <div class="text-center">
            <img src="../img/tips.jpg" alt="Alteration tips and height requirements"
              class="w-full max-w-md mx-auto rounded-lg shadow-lg">
            <p class="text-sm text-gray-600 mt-2">Alteration Tips & Height Guide</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Alteration Tips -->
    <div class="mb-16">
      <div class="bg-white rounded-lg shadow-[0_8px_30px_rgba(210,199,229,0.12)] p-8">
        <h3 class="font-Tinos text-2xl text-slate-900 mb-6 text-center">Alteration Tips</h3>

        <div class="space-y-6">
          <p class="text-gray-700">
            Most bridal gowns can be altered at least 1-2 sizes smaller, however, some bridal gowns usually can not be
            let out (made larger), since the interior seams are notched for the best couture fit. If your not sure
            please contact us about the specific dress and we can check it for you and discuss the possibilities.
          </p>
          <p class="text-gray-700">
            We also suggest consulting a local professional, experienced bridal seamstress so he/she can give you their
            opinion on whether they personally would be able to do the alterations. Our past brides have had positive
            success with taking the listed pictures to their local bridal seamstress to see if it is possible.
          </p>
        </div>
      </div>
    </div>


    <!-- Call to Action -->
    <div class="text-center">
      <h2 class="font-Tinos text-3xl text-slate-900 mb-4">Need Help Finding Your Size?</h2>
      <p class="text-slate-700 mb-8 max-w-2xl mx-auto">
        Our experienced bridal consultants are here to help you find the perfect fit. Schedule a consultation or contact
        us for personalized sizing assistance.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="../pages/reservation.php"
          class="inline-block rounded-full border-3 border-pink-500 px-8 py-4 text-base font-semibold text-slate-900 transition-all hover:bg-pink-500 hover:text-white focus:ring-2 focus:ring-candy-peach focus:ring-offset-2 focus:ring-offset-candy-cream focus:outline-none">
          Schedule Consultation
        </a>
        <a href="../pages/contact.php"
          class="inline-block rounded-full border-3 border-pink-500 px-8 py-4 text-base font-semibold text-slate-900 transition-all hover:bg-pink-500 hover:text-white focus:ring-2 focus:ring-candy-peach focus:ring-offset-2 focus:ring-offset-candy-cream focus:outline-none">
          Contact Us
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
    '<script src="../js/featured-carousel.js"></script>',
    '<script src="../js/validation-integration.js"></script>',
    '<script src="../js/auth.js"></script>',
    '<script src="../js/reveal.js"></script>',
    '<script src="../js/scroll-fade.js"></script>',
    '<script src="../js/reviews.js"></script>'
  ]
]);
?>