<?php
require_once('../backend/session_check.php');
require_once('../backend/connections.php');

$isLoggedIn = isLoggedIn();

$num_products_on_each_page = 9;

$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int) $_GET['p'] : 1;

$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');

$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_products = $pdo->query('SELECT * FROM products')->rowCount();

require_once('../layouts/app.php');
renderHeader([
  'title' => 'Products - Promise Shop',
  'isLoggedIn' => $isLoggedIn,
  'bodyClass' => 'bg-white min-h-screen flex flex-col',
  'mainClass' => 'flex-1'

]);

// HERO
$title = "OUR";
$highlight = 'PRODUCTS';
$subtitle = "We Browse our curated collection of wedding attire crafted for elegance, comfort and timeless memories.";
$extra_class = "py-32";

include('../components/hero.php');
?>



<div class="mx-auto max-w-7xl py-10">
  <div class="flex flex-col gap-8">
    <!-- ALL PRODUCTS -->
    <h2
      class="font-Tinos text-center text-2xl leading-none tracking-widest text-pink-950 uppercase md:tracking-[0.6em] lg:tracking-[0.8em]">
      All Products
    </h2>
    <!-- Results Count -->
    <div class="w-full mb-6">
      <div class="text-center">
        <p class="text-slate-900 font-medium"><?= $total_products ?> Products Available</p>
      </div>
    </div>

    <div class="mx-auto max-w-7xl">
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php if (empty($products)): ?>
          <div class="col-span-full text-center py-12">
            <h3 class="font-Tinos text-2xl text-slate-700 mb-4">No products found</h3>
            <p class="text-slate-700">Check back later for new arrivals!</p>
          </div>
        <?php else: ?>
          <?php foreach ($products as $product): ?>
            <article
              class="product-card flex flex-col overflow-hidden rounded-lg border border-pink-200 bg-white text-pink-950 shadow-[0_8px_30px_rgba(236,72,153,0.08)]">
              <div class="relative h-56 overflow-hidden sm:h-64 md:h-72 lg:h-80">
                <a href="product-detail.php?id=<?= $product['product_id'] ?>">
                  <img src="../<?= str_replace('src/img/', 'img/', $product['image_path']) ?>"
                    alt="<?= htmlspecialchars($product['product_name']) ?>" loading="lazy" decoding="async"
                    sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw"
                    class="h-full w-full object-cover hover:scale-105 transition-transform duration-300">
                </a>
                <button
                  class="absolute top-3 right-3 rounded-full bg-white/80 p-2 text-pink-500 shadow hover:bg-white transition-colors ">
                  ♡
                </button>
              </div>
              <div class="flex flex-1 flex-col justify-between p-4">
                <div>
                  <h3 class="font-semibold text-slate-900 mb-2">
                    <a href="product-detail.php?id=<?= $product['product_id'] ?>"
                      class="hover:text-slate-700 transition-colors">
                      <?= htmlspecialchars($product['product_name']) ?>
                    </a>
                  </h3>
                  <p class="mt-1 text-slate-700 text-sm mb-2">
                    <?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...
                  </p>
                  <p class="text-slate-900  text-xs">
                    Material: <?= htmlspecialchars($product['material']) ?>
                  </p>
                </div>
                <div class="mt-4 flex items-center justify-between">
                  <div class="font-bold text-slate-900"><?= format_price($product['price']) ?></div>
                  <?php if ($isLoggedIn): ?>
                    <form action="cart.php" method="post" class="inline">
                      <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit"
                        class="cursor-pointer rounded-md bg-linear-to-r from-pink-500 to-rose-500 px-4 py-2 text-white transition hover:shadow-[0_0_30px_rgba(236,72,153,0.25)] hover:scale-105">
                        Add to Cart
                      </button>
                    </form>
                    <?php
                    // Determine if the current user has a complete address
                    $hasAddress = false;
                    if ($isLoggedIn && isset($_SESSION['user_id'])) {
                      $chk = $pdo->prepare("SELECT street_address, barangay, city, province, zip_code FROM customers WHERE customer_id = ?");
                      $chk->execute([$_SESSION['user_id']]);
                      $u = $chk->fetch();
                      $parts = array_filter([
                        $u['street_address'] ?? '',
                        $u['barangay'] ?? '',
                        $u['city'] ?? '',
                        $u['province'] ?? '',
                        $u['zip_code'] ?? ''
                      ]);
                      $hasAddress = count($parts) === 5;
                    }
                    ?>
                    <?php if ($hasAddress): ?>
                      <!-- Direct order form: posts single product to backend -->
                      <form action="../backend/place_order.php" method="post" class="inline direct-order-form">
                        <input type="hidden" name="direct_product_id" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="direct_quantity" value="1">
                        <button type="submit"
                          class="cursor-pointer rounded-md bg-pink-700 px-4 py-2 text-white transition hover:shadow-[0_0_30px_rgba(236,72,153,0.25)] hover:scale-105">
                          Place Order
                        </button>
                      </form>
                    <?php else: ?>
                      <!-- Prompt user to add address before allowing direct order -->
                      <a href="profile.php?error=missing_address"
                        class="cursor-pointer rounded-md bg-yellow-500 px-4 py-2 text-white transition hover:shadow-[0_0_30px_rgba(234,179,8,0.25)] hover:scale-105 needs-address">
                        Add Address
                      </a>
                    <?php endif; ?>
                  <?php else: ?>
                    <button type="button" onclick="openModal('login-modal')"
                      class="cursor-pointer rounded-md bg-linear-to-r from-pink-500 to-rose-500 px-4 py-2 text-white transition hover:shadow-[0_0_30px_rgba(236,72,153,0.25)] hover:scale-105">
                      Add to Cart
                    </button>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Warning Message for Logged Out Users -->
      <?php if (!$isLoggedIn): ?>
        <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-center">
          <p class="text-yellow-800">You must create an account and upload your address before placing an order.</p>
        </div>
      <?php endif; ?>

      <!-- Address Incompletion Warning -->
      <?php
      $showAddressWarning = false;
      if ($isLoggedIn && isset($_SESSION['user_id'])) {
        $user_stmt = $pdo->prepare("SELECT street_address, barangay, city, province, zip_code FROM customers WHERE customer_id = ?");
        $user_stmt->execute([$_SESSION['user_id']]);
        $user = $user_stmt->fetch();
        $address_parts = array_filter([
          $user['street_address'] ?? '',
          $user['barangay'] ?? '',
          $user['city'] ?? '',
          $user['province'] ?? '',
          $user['zip_code'] ?? ''
        ]);
        if (count($address_parts) < 5) {
          $showAddressWarning = true;
        }
      }
      ?>
      <?php if ($showAddressWarning): ?>
        <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-center">
          <p class="text-yellow-800">Please complete your address in your profile before placing an order.</p>
        </div>
      <?php endif; ?>

      <!-- Pagination -->
      <?php if ($total_products > $num_products_on_each_page): ?>
        <div class="flex justify-center items-center mt-12 space-x-4">
          <?php if ($current_page > 1): ?>
            <a href="shop.php?p=<?= $current_page - 1 ?>"
              class="px-4 py-2  text-slate-700 rounded-lg hover:bg-pink-300 transition-colors">
              Previous
            </a>
          <?php endif; ?>

          <span class="px-4 py-2  text-slate-700 rounded-lg">
            Page <?= $current_page ?> of <?= ceil($total_products / $num_products_on_each_page) ?>
          </span>

          <?php if ($total_products > ($current_page * $num_products_on_each_page)): ?>
            <a href="shop.php?p=<?= $current_page + 1 ?>"
              class="px-4 py-2  text-slate-700 rounded-lg hover:bg-pink-300 transition-colors">
              Next
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
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
      '<script src="../js/shop-page.js"></script>'
    ]
  ]);
  ?>