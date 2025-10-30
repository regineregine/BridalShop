<?php
$host = 'localhost';
$db = 'wedding_shop';
$user = 'root';
$pass = 'Mysqlpass@';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

function pdo_connect_mysql()
{
    global $pdo;
    return $pdo;
}

function format_price($price)
{
    return '₱' . number_format($price, 2);
}

function template_header($title)
{
    ob_start();
    include('../components/navbar.php');
    $navbarHtml = ob_get_clean();

    ob_start();
    include('../components/modal.php');
    $modalHtml = ob_get_clean();

    ob_start();
    include_once('../layouts/styles-inline.php');
    renderInlineStylesFromFiles(['../output.css']);
    $inlineCss = ob_get_clean();

    $header = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($title) . ' - Promise Shop</title>
    ' . $inlineCss . '
    <link href="https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&family=Unna:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-pink-50 to-rose-50 min-h-screen">
    <!-- NAVBAR -->
    ' . $navbarHtml . '
    <!-- MODAL -->
    ' . $modalHtml . '
    <main class="mx-auto max-w-screen-xl flex-1">';
    return $header;
}

// Template footer function
function template_footer()
{
    // Buffer footer component to execute any PHP
    ob_start();
    include('../components/footer.php');
    $footerComp = ob_get_clean();

    $footer = '</main>
    <!-- FOOTER -->
    ' . $footerComp . '
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="../js/filter.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/validation-integration.js"></script>
    <script src="../js/auth.js"></script>
    <script src="../js/reveal.js"></script>
</body>
</html>';
    return $footer;
}
?>