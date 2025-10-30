<?php
require_once('../backend/session_check.php');
require_once('../backend/connections.php');

if (!isLoggedIn()) {
    header('Location: home.php');
    exit;
}

$orderId = $_SESSION['last_order_id'] ?? null;
if ($orderId) {
    unset($_SESSION['last_order_id']);
}

$orderDetails = null;
$orderItems = [];

if ($orderId) {
    $summaryQuery = '
        SELECT o.*, COUNT(oi.order_item_id) AS item_count
        FROM orders o
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        WHERE o.order_id = ? AND o.customer_id = ?
        GROUP BY o.order_id
    ';

    $summaryStmt = $pdo->prepare($summaryQuery);
    $summaryStmt->execute([$orderId, $_SESSION['user_id']]);
    $orderDetails = $summaryStmt->fetch();

    if ($orderDetails) {
        $itemsQuery = '
            SELECT oi.*, p.product_name, p.image_path, p.material
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?
            ORDER BY oi.order_item_id
        ';

        $itemsStmt = $pdo->prepare($itemsQuery);
        $itemsStmt->execute([$orderId]);
        $orderItems = $itemsStmt->fetchAll();
    }
}

function formatCurrency($value)
{
    return '₱' . number_format((float) $value, 2);
}

function formatStatus($status)
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
    'title' => 'Order Placed - Promise Shop',
    'isLoggedIn' => true,
    'bodyClass' => 'flex min-h-screen flex-col bg-gradient-to-br from-pink-50 to-rose-50',
    'mainClass' => 'flex-1'
]);
?>

<section class="py-16">
    <div class="mx-auto max-w-4xl px-4">
        <div
            class="overflow-hidden rounded-3xl border border-pink-200 bg-white shadow-[0_10px_30px_rgba(236,72,153,0.08)]">
            <div class="bg-linear-to-r from-pink-500 to-rose-500 p-10 text-center text-white">
                <div
                    class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-white text-pink-500">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="mb-3 text-4xl font-semibold">Your order has been placed!</h1>
                <p class="mx-auto max-w-2xl font-secondary text-lg text-pink-100">
                    Thank you for choosing Promise Shop. We will email you the order details and shipping information
                    shortly.
                </p>
            </div>

            <div class="space-y-8 p-8">
                <?php if ($orderDetails): ?>
                    <div class="rounded-2xl border border-pink-200 bg-pink-50 p-6">
                        <h2 class="mb-4 text-lg font-semibold text-pink-800">Order details</h2>
                        <div class="grid gap-4 text-sm text-pink-700 sm:grid-cols-2">
                            <div>
                                <p><strong>Order #:</strong> <?= (int) $orderDetails['order_id']; ?></p>
                                <p><strong>Items:</strong> <?= (int) $orderDetails['item_count']; ?> item(s)</p>
                            </div>
                            <div>
                                <p><strong>Total:</strong> <?= formatCurrency((float) $orderDetails['total_amount']); ?></p>
                                <p><strong>Status:</strong>
                                    <span
                                        class="ml-1 rounded-full px-2 py-1 text-xs font-semibold <?= formatStatus($orderDetails['status']); ?>">
                                        <?= htmlspecialchars(ucfirst($orderDetails['status'])); ?>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($orderItems)): ?>
                            <div class="mt-6 border-t border-pink-200 pt-4">
                                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-pink-700">Ordered items</h3>
                                <div class="space-y-3">
                                    <?php foreach ($orderItems as $item): ?>
                                        <div class="flex items-center gap-3 rounded-xl border border-pink-100 bg-white p-3">
                                            <img src="../<?= str_replace('src/img/', 'img/', $item['image_path']); ?>"
                                                alt="<?= htmlspecialchars($item['product_name']); ?>"
                                                class="h-16 w-16 rounded-lg object-cover" />
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-pink-800">
                                                    <?= htmlspecialchars($item['product_name']); ?>
                                                </h4>
                                                <p class="text-sm text-pink-600"><?= htmlspecialchars($item['material']); ?></p>
                                                <p class="text-sm text-pink-700">Quantity: <?= (int) $item['quantity']; ?> ×
                                                    <?= formatCurrency((float) $item['unit_price']); ?>
                                                </p>
                                            </div>
                                            <div class="text-right font-semibold text-pink-800">
                                                <?= formatCurrency((float) $item['quantity'] * (float) $item['unit_price']); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="rounded-2xl border border-pink-200 bg-pink-50 p-6 text-center text-pink-700">
                        <p>We could not locate the order details. If this keeps happening, please contact support.</p>
                    </div>
                <?php endif; ?>

                <div class="space-y-4">
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="orders.php" class="btn-primary">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            View my orders
                        </a>
                        <a href="shop.php" class="btn-secondary">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Continue shopping
                        </a>
                    </div>
                    <div class="text-center text-sm">
                        <a href="home.php"
                            class="inline-flex items-center text-pink-600 transition-colors hover:text-pink-800">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Back to home
                        </a>
                    </div>
                </div>
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