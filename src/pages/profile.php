<?php
require_once('../backend/session_check.php');

if (!isLoggedIn()) {
  header('Location: ../pages/home.php');
  exit;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

if (!$user_id || !$user_name || !$user_email) {
  session_destroy();
  header('Location: ../pages/home.php');
  exit;
}

require_once('../backend/connections.php');
$stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id = ?");
$stmt->execute([$user_id]);
$userData = $stmt->fetch();
if (!$userData || !is_array($userData)) {
  session_destroy();
  header('Location: ../pages/home.php');
  exit;
}

if (!function_exists('resolveStatusBadge')) {
  function resolveStatusBadge($status)
  {
    switch ($status) {
      case 'pending':
        return 'bg-blue-100 text-blue-800';
      case 'processing':
        return 'bg-yellow-100 text-yellow-800';
      case 'shipped':
        return 'bg-green-100 text-green-800';
      case 'delivered':
        return 'bg-purple-100 text-purple-800';
      case 'cancelled':
        return 'bg-red-100 text-red-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  }
}

$avatarSrc = (function ($ud) {
  $img = $ud['profile_img'] ?? '';
  if (!empty($img)) {
    $path = '../img/' . $img;
    if (file_exists($path)) {
      return $path . '?v=' . time();
    }
  }
  return '../img/default-avatar.png';
})($userData);

$genderVal = $userData['gender'] ?? '';
$selectedFemale = ($genderVal === 'Female') ? 'selected' : '';
$selectedMale = ($genderVal === 'Male') ? 'selected' : '';
$selectedOther = ($genderVal === 'Other') ? 'selected' : '';

$dobVal = $userData['date_of_birth'] ?? '';


$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$cartProducts = array();
$cartSubtotal = 0.00;
if ($products_in_cart) {
  $placeholders = implode(',', array_fill(0, count($products_in_cart), '?'));
  $cartStmt = $pdo->prepare('SELECT * FROM products WHERE product_id IN (' . $placeholders . ')');
  $cartStmt->execute(array_keys($products_in_cart));
  $cartProducts = $cartStmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($cartProducts as $p) {
    $cartSubtotal += (float) $p['price'] * (int) $products_in_cart[$p['product_id']];
  }
}

// Orders and items
$orders = [];
$orderItems = [];
try {
  $ordersQuery = '
        SELECT o.*, COUNT(oi.order_item_id) AS item_count
        FROM orders o
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        WHERE o.customer_id = ?
        GROUP BY o.order_id
        ORDER BY o.order_date DESC
    ';
  $ordersStmt = $pdo->prepare($ordersQuery);
  $ordersStmt->execute([$user_id]);
  $orders = $ordersStmt->fetchAll();
  if (!empty($orders)) {
    $itemsQuery = '
            SELECT oi.*, p.product_name, p.image_path, p.material
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?
            ORDER BY oi.order_item_id
        ';
    foreach ($orders as $order) {
      $itemsStmt = $pdo->prepare($itemsQuery);
      $itemsStmt->execute([$order['order_id']]);
      $orderItems[$order['order_id']] = $itemsStmt->fetchAll();
    }
  }
} catch (Exception $e) {
}

$updateMessage = '';
$updateType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['change_password']) && !isset($_POST['update_address'])) {
  $first_name = trim($_POST['first_name'] ?? $userData['first_name']);
  $contact_number = trim($_POST['contact_number'] ?? $userData['contact_number']);
  $gender = trim($_POST['gender'] ?? $userData['gender']);
  $date_of_birth = trim($_POST['date_of_birth'] ?? $userData['date_of_birth']);
  $email = trim($_POST['email'] ?? $userData['email']);
  $profile_img = $userData['profile_img'] ?? '';
  if ($date_of_birth === '') {
    $date_of_birth = null;
  }

  if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
    $imgTmp = $_FILES['profile_img']['tmp_name'];
    $imgName = basename($_FILES['profile_img']['name']);
    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
    $newImgName = 'profile_' . $user_id . '_' . time() . '.' . $imgExt;
    $imgPath = '../img/' . $newImgName;
    if (move_uploaded_file($imgTmp, $imgPath)) {
      $profile_img = $newImgName;
    } else {
      $updateMessage = 'Failed to upload image.';
      $updateType = 'error';
    }
  }

  try {
    $updateStmt = $pdo->prepare("UPDATE customers SET first_name=?, contact_number=?, gender=?, date_of_birth=?, email=?, profile_img=? WHERE customer_id=?");
    $result = $updateStmt->execute([$first_name, $contact_number, $gender, $date_of_birth, $email, $profile_img, $user_id]);
    if ($result) {
      $updateMessage = 'Profile updated successfully!';
      $updateType = 'success';
      // Refresh user data
      $stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id = ?");
      $stmt->execute([$user_id]);
      $userData = $stmt->fetch();
    } else {
      $updateMessage = 'Failed to update profile. Please try again.';
      $updateType = 'error';
    }
  } catch (PDOException $e) {
    $updateMessage = 'Database error: ' . $e->getMessage();
    $updateType = 'error';
  }
}

// Handle address update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_address'])) {
  $street_address = trim($_POST['street_address'] ?? $userData['street_address']);
  $city = trim($_POST['city'] ?? $userData['city']);
  $province = trim($_POST['province'] ?? $userData['province']);
  $barangay = trim($_POST['barangay'] ?? $userData['barangay']);
  $zip_code = trim($_POST['zip_code'] ?? $userData['zip_code']);
  try {
    $updateStmt = $pdo->prepare("UPDATE customers SET street_address=?, city=?, province=?, barangay=?, zip_code=? WHERE customer_id=?");
    $result = $updateStmt->execute([$street_address, $city, $province, $barangay, $zip_code, $user_id]);
    if ($result) {
      $updateMessage = 'Address updated successfully!';
      $updateType = 'success';
      // Refresh user data
      $stmt = $pdo->prepare("SELECT * FROM customers WHERE customer_id = ?");
      $stmt->execute([$user_id]);
      $userData = $stmt->fetch();
    } else {
      $updateMessage = 'Failed to update address. Please try again.';
      $updateType = 'error';
    }
  } catch (PDOException $e) {
    $updateMessage = 'Database error: ' . $e->getMessage();
    $updateType = 'error';
  }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
  $current_password = $_POST['current_password'] ?? '';
  $new_password = $_POST['new_password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';
  if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    $updateMessage = 'All password fields are required.';
    $updateType = 'error';
  } elseif ($new_password !== $confirm_password) {
    $updateMessage = 'New passwords do not match.';
    $updateType = 'error';
  } else {
    // Verify current password
    $stmt = $pdo->prepare('SELECT password_hash FROM customers WHERE customer_id = ?');
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();
    if ($row && password_verify($current_password, $row['password_hash'])) {
      // Update password
      $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
      $updateStmt = $pdo->prepare('UPDATE customers SET password_hash = ? WHERE customer_id = ?');
      if ($updateStmt->execute([$new_hash, $user_id])) {
        $updateMessage = 'Password changed successfully!';
        $updateType = 'success';
      } else {
        $updateMessage = 'Failed to change password.';
        $updateType = 'error';
      }
    } else {
      $updateMessage = 'Current password is incorrect.';
      $updateType = 'error';
    }
  }
}
?>
<?php
require_once('../layouts/app.php');
renderHeader([
  'title' => 'Profile Settings - Promise Shop',
  'isLoggedIn' => true,
  'bodyClass' => 'flex min-h-screen flex-col bg-neutral-50',
  'mainClass' => 'flex-1 py-8 md:py-12'
]);
?>
<div class="mx-auto max-w-7xl px-2 md:px-6 lg:px-8">
  <div class="flex flex-col md:flex-row gap-8">
    <!-- Sidebar -->
    <aside
      class="w-full md:w-72 bg-white rounded-xl shadow-sm border border-neutral-200 p-6 flex flex-col items-center md:items-start">
      <div class="flex flex-col items-center md:items-start w-full">
        <div class="w-20 h-20 rounded-full bg-neutral-200 mb-2 overflow-hidden flex items-center justify-center">
          <img src="<?= $avatarSrc ?>" alt="Profile" class="w-full h-full object-cover rounded-full" />
        </div>
        <div class="font-semibold text-lg text-slate-900 mb-1">
          <?= htmlspecialchars($userData['username'] ?? $user_name); ?>
        </div>
        <a href="#edit-profile" class="text-sm text-pink-500 hover:underline mb-4" id="edit-profile-link"><svg
            xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15.232 5.232l3.536 3.536M9 13h3l9-9a1.414 1.414 0 00-2-2l-9 9v3z" />
          </svg>Edit Profile</a>
      </div>
      <hr class="w-full my-4 border-neutral-200" />
      <nav class="w-full">
        <ul class="space-y-1 text-base">
          <li><a href="#" id="sidebar-profile"
              class="sidebar-link flex items-center gap-2 rounded-lg px-4 py-2">Profile</a></li>
          <li><a href="#" id="sidebar-cart" class="sidebar-link flex items-center gap-2 rounded-lg px-4 py-2">My
              Cart</a></li>
          <li><a href="#" id="sidebar-orders" class="sidebar-link flex items-center gap-2 rounded-lg px-4 py-2">My
              Orders</a></li>
          <li><a href="#" id="sidebar-addresses"
              class="sidebar-link flex items-center gap-2 rounded-lg px-4 py-2">Addresses</a></li>
          <li><a href="#" id="sidebar-change-password"
              class="sidebar-link flex items-center gap-2 rounded-lg px-4 py-2">Change Password</a></li>
        </ul>
      </nav>
    </aside>
    <!-- Main profile content -->
    <div class="flex-1">
      <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-1">My Profile</h1>
        <p class="text-slate-700">Manage and protect your account</p>
        <?php if (!empty($updateMessage)): ?>
          <div
            class="mt-4 px-4 py-2 rounded-lg <?php echo ($updateType === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?= htmlspecialchars($updateMessage) ?>
          </div>
        <?php endif; ?>
      </div>
      <div id="section-profile">
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
          <form method="post" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start"
            id="profile-info-form">
            <div class="space-y-6">
              <div>
                <label class="block text-sm text-slate-700 mb-1">Username</label>
                <input type="text" class="form-input w-full"
                  value="<?= htmlspecialchars($userData['username'] ?? $user_name); ?>" name="username" readonly />
                <span class="text-xs text-slate-500">Username can only be changed once.</span>
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Name</label>
                <input type="text" class="form-input w-full" value="<?= htmlspecialchars($userData['first_name']); ?>"
                  name="first_name" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Email</label>
                <input type="email" class="form-input w-full" value="<?= htmlspecialchars($userData['email']); ?>"
                  name="email" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Phone Number</label>
                <input type="text" class="form-input w-full"
                  value="<?= htmlspecialchars($userData['contact_number'] ?? ''); ?>" name="contact_number" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Gender <span class="text-xs text-slate-400"
                    title="Gender is required">?</span></label>
                <select class="form-input w-full" name="gender">
                  <option value="Female" <?= $selectedFemale ?>>Female</option>
                  <option value="Male" <?= $selectedMale ?>>Male</option>
                  <option value="Other" <?= $selectedOther ?>>Other</option>
                </select>
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Date of birth <span class="text-xs text-slate-400"
                    title="Date of birth is required">?</span></label>
                <input type="date" class="form-input w-full" value="<?php echo htmlspecialchars($dobVal); ?>"
                  name="date_of_birth" />
              </div>
              <button type="submit"
                class="mt-4 px-8 py-2 rounded-lg bg-pink-500 text-white font-semibold hover:bg-pink-600">Save</button>
            </div>
            <div class="flex flex-col items-center justify-center gap-4">
              <div class="w-32 h-32 rounded-full bg-neutral-200 overflow-hidden flex items-center justify-center mb-2">
                <img src="<?= $avatarSrc ?>" alt="Profile" class="w-full h-full object-cover rounded-full" />
              </div>
              <input type="file" name="profile_img"
                class="border border-neutral-300 rounded-lg px-4 py-2 bg-white text-slate-700 hover:bg-neutral-100" />
            </div>
          </form>
        </div>
      </div>
      <div id="section-addresses" style="display:none;">
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 mt-8">
          <h2 class="text-lg font-semibold text-slate-900 mb-4">My Address</h2>
          <div id="address-warning" class="mb-4" style="display:none;"></div>
          <form method="post" autocomplete="off">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm text-slate-700 mb-1">Street Address</label>
                <input type="text" class="form-input w-full" name="street_address"
                  value="<?= htmlspecialchars($userData['street_address'] ?? '') ?>" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">City</label>
                <input type="text" class="form-input w-full" name="city"
                  value="<?= htmlspecialchars($userData['city'] ?? '') ?>" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Province</label>
                <input type="text" class="form-input w-full" name="province"
                  value="<?= htmlspecialchars($userData['province'] ?? '') ?>" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Barangay</label>
                <input type="text" class="form-input w-full" name="barangay"
                  value="<?= htmlspecialchars($userData['barangay'] ?? '') ?>" />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Zip Code</label>
                <input type="text" class="form-input w-full" name="zip_code"
                  value="<?= htmlspecialchars($userData['zip_code'] ?? '') ?>" />
              </div>
            </div>
            <button type="submit" name="update_address"
              class="mt-6 px-8 py-2 rounded-lg bg-pink-500 text-white font-semibold hover:bg-pink-600">Save
              Address</button>
          </form>
        </div>
      </div>
      <div id="section-change-password" style="display:none;">
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 mt-8">
          <div class="space-y-6 mt-8">
            <h2 class="text-lg font-semibold text-slate-900 mb-2">
              <button type="button" id="show-change-password" class="text-pink-500 hover:underline">Change
                Password</button>
            </h2>
            <form method="post" autocomplete="off" id="change-password-form" style="display:none;">
              <div>
                <label class="block text-sm text-slate-700 mb-1">Current Password</label>
                <input type="password" class="form-input w-full" name="current_password" required />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">New Password</label>
                <input type="password" class="form-input w-full" name="new_password" required />
              </div>
              <div>
                <label class="block text-sm text-slate-700 mb-1">Confirm New Password</label>
                <input type="password" class="form-input w-full" name="confirm_password" required />
              </div>
              <button type="submit" name="change_password"
                class="mt-4 px-8 py-2 rounded-lg bg-pink-500 text-white font-semibold hover:bg-pink-600">Change
                Password</button>
            </form>
          </div>
        </div>
      </div>
      <div id="section-cart" style="display:none;">
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 mt-8">
          <h2 class="text-lg font-semibold text-slate-900 mb-4">My Cart</h2>
          <?php if (empty($cartProducts)): ?>
            <div class="flex flex-col items-center justify-center min-h-[180px]">
              <h3 class="text-xl font-semibold text-slate-900 mb-2">Your cart is empty.</h3>
              <p class="text-slate-700 mb-4">Browse our products and add items to see them here.</p>
              <a href="shop.php" class="btn-primary">Start Shopping</a>
            </div>
          <?php else: ?>
            <div class="overflow-x-auto mb-6">
              <table class="w-full">
                <thead class="bg-pink-50">
                  <tr>
                    <td class="p-4 font-semibold text-slate-900" colspan="2">Product</td>
                    <td class="p-4 font-semibold text-slate-900">Price</td>
                    <td class="p-4 font-semibold text-slate-900">Quantity</td>
                    <td class="p-4 font-semibold text-slate-900">Total</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cartProducts as $product): ?>
                    <tr class="border-t border-pink-100">
                      <td class="p-4">
                        <img src="../<?= str_replace('src/img/', 'img/', $product['image_path']) ?>" width="60" height="60"
                          alt="<?= htmlspecialchars($product['product_name']) ?>" class="rounded-lg object-cover">
                      </td>
                      <td class="p-4">
                        <span
                          class="font-semibold text-slate-700"><?= htmlspecialchars($product['product_name']) ?></span><br>
                        <small class="text-pink-600"><?= htmlspecialchars($product['material']) ?></small>
                      </td>
                      <td class="p-4 font-semibold text-slate-700">
                        <?= format_price($product['price']) ?>
                      </td>
                      <td class="p-4">
                        <?= (int) $products_in_cart[$product['product_id']] ?>
                      </td>
                      <td class="p-4 font-semibold text-slate-700">
                        <?= format_price($product['price'] * $products_in_cart[$product['product_id']]) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="text-right font-semibold text-lg text-slate-900 mb-2">Subtotal:
              <?= format_price($cartSubtotal) ?>
            </div>
            <a href="cart.php" class="btn-primary">Go to Cart</a>
          <?php endif; ?>
        </div>
      </div>
      <div id="section-orders" style="display:none;">
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6 mt-8">
          <h2 class="text-lg font-semibold text-slate-900 mb-4">My Orders</h2>
          <?php if (empty($orders)): ?>
            <div class="flex flex-col items-center justify-center min-h-[180px]">
              <h3 class="text-xl font-semibold text-slate-900 mb-2">No orders yet</h3>
              <p class="text-slate-700 mb-4">You haven't placed any orders yet. Start shopping to see your
                orders here.</p>
              <a href="shop.php" class="btn-primary">Start Shopping</a>
            </div>
          <?php else: ?>
            <div class="space-y-6">
              <?php foreach ($orders as $order): ?>
                <div class="border rounded-xl p-4 mb-2 bg-gray-50">
                  <div class="mb-2 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                      <h3 class="text-lg font-semibold text-slate-900">Order
                        #<?= (int) $order['order_id']; ?></h3>
                      <p class="text-sm text-slate-700">Placed on
                        <?= date('F d, Y', strtotime($order['order_date'])); ?>
                      </p>
                    </div>
                    <span
                      class="self-start rounded-full px-3 py-1 text-sm font-medium <?= resolveStatusBadge($order['status']); ?>">
                      <?= htmlspecialchars(ucfirst($order['status'])); ?>
                    </span>
                  </div>
                  <?php if (!empty($orderItems[$order['order_id']])): ?>
                    <div class="mb-2 space-y-2">
                      <?php foreach ($orderItems[$order['order_id']] as $item): ?>
                        <div class="flex items-center gap-3 rounded border bg-white p-2">
                          <img src="../<?= str_replace('src/img/', 'img/', $item['image_path']); ?>"
                            alt="<?= htmlspecialchars($item['product_name']); ?>" class="h-12 w-12 rounded-lg object-cover" />
                          <div class="flex-1">
                            <span class="font-semibold text-slate-900"><?= htmlspecialchars($item['product_name']); ?></span>
                            <span class="text-xs text-slate-700 ml-2">Qty: <?= (int) $item['quantity']; ?> ×
                              ₱<?= number_format($item['unit_price'], 2); ?></span>
                          </div>
                          <div class="text-right">
                            <span
                              class="font-semibold text-slate-900">₱<?= number_format($item['quantity'] * $item['unit_price'], 2); ?></span>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                  <div class="flex flex-col gap-2 border-t pt-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-slate-700">
                      <span><strong>Total:</strong>
                        ₱<?= number_format($order['total_amount'], 2); ?></span>
                      <span class="ml-4"><strong>Items:</strong> <?= (int) $order['item_count']; ?></span>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row">
                      <a href="order-detail.php?id=<?= (int) $order['order_id']; ?>" class="btn-secondary">View Details</a>
                      <a href="../backend/order_receipt.php?id=<?= (int) $order['order_id']; ?>" class="btn-primary"
                        target="_blank" rel="noopener">Download Receipt</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
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
    // Consolidated page JS
    '<script src="../js/profile-page.js"></script>'
  ]
]);
?>