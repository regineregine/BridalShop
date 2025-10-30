<?php
require_once('../backend/session_check.php');

if (!isLoggedIn()) {
    header('Location: ../pages/home.php');
    exit;
}

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_name'] ?? null;
$userEmail = $_SESSION['user_email'] ?? null;

if (!$userId || !$userName || !$userEmail) {
    session_destroy();
    header('Location: ../pages/home.php');
    exit;
}

require_once('../backend/connections.php');

$ordersQuery = '
    SELECT o.*, COUNT(oi.order_item_id) AS item_count
    FROM orders o
    LEFT JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.customer_id = ?
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
';

$ordersStmt = $pdo->prepare($ordersQuery);
$ordersStmt->execute([$userId]);
$orders = $ordersStmt->fetchAll();

$orderItems = [];
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

require_once('../layouts/app.php');

renderHeader([
    'title' => 'My Orders - Promise Shop',
    'isLoggedIn' => true,
    'bodyClass' => 'flex min-h-screen flex-col bg-white',
    'mainClass' => 'flex-1'
]);
?>

<section class="py-16 md:py-20">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mb-12 text-center">
            <h1
                class="font-Tinos  text-2xl leading-none tracking-widest text-slate-900 uppercase md:tracking-[0.6em] lg:tracking-[0.8em] mb-8 text-center">
                My Orders</h1>
            <p class="text-slate-700">Track and manage your bridal orders with ease.</p>
        </div>

        <?php if (empty($orders)): ?>
            <div class="card">
                <div class="py-12 text-center">
                    <div class="mb-6 text-slate-700">
                        <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-semibold text-dark">No orders yet</h3>
                    <p class="mb-6 text-slate-700">You haven't placed any orders yet. Start shopping to see your orders
                        here.
                    </p>
                    <a href="shop.php" class="btn-primary">Continue Shopping</a>
                </div>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($orders as $order): ?>
                    <div class="card">
                        <div class="mb-4 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Order #<?= (int) $order['order_id']; ?></h3>
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
                            <div class="mb-4 space-y-3">
                                <?php foreach ($orderItems[$order['order_id']] as $item): ?>
                                    <div class="flex items-center gap-3 rounded-xl border border-light bg-gray-50 p-3">
                                        <img src="../<?= str_replace('src/img/', 'img/', $item['image_path']); ?>"
                                            alt="<?= htmlspecialchars($item['product_name']); ?>" loading="lazy" decoding="async"
                                            class="h-16 w-16 rounded-lg object-cover" />
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-slate-900"><?= htmlspecialchars($item['product_name']); ?>
                                            </h4>
                                            <p class="text-sm text-slate-700"><?= htmlspecialchars($item['material']); ?></p>
                                            <p class="text-sm text-slate-700">Quantity: <?= (int) $item['quantity']; ?> ×
                                                ₱<?= number_format($item['unit_price'], 2); ?></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-slate-900">
                                                ₱<?= number_format($item['quantity'] * $item['unit_price'], 2); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div
                            class="flex flex-col gap-4 border-t border-light pt-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-slate-700">
                                <p><strong>Total:</strong> ₱<?= number_format($order['total_amount'], 2); ?></p>
                                <p><strong>Items:</strong> <?= (int) $order['item_count']; ?></p>
                            </div>
                            <div class="flex flex-col gap-3 sm:flex-row">
                                <a href="order-detail.php?id=<?= (int) $order['order_id']; ?>" class="btn-secondary ">View
                                    Details</a>
                                <a href="../backend/order_receipt.php?id=<?= (int) $order['order_id']; ?>"
                                    class="btn-primary hover:text-slate-900" target="_blank" rel="noopener">Download Receipt</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="flex justify-center mt-10">
                    <a href="shop.php" class="btn-primary">Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
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