<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit;
}
include_once __DIR__ . '/../database/utils/getAll.php';

$notifications = getAll("SELECT * FROM notifications ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/includes/head.php' ?>
    <title>Nofifications</title>
</head>

<body>
    <?php include_once __DIR__ . '/includes/header.php' ?>
    <main>
        <h1>Vos notifications</h1>
        <?php if (empty($notifications)): ?>
            <p>Vous n'avez pas de notifications.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($notifications as $notification): ?>
                    <li><?php echo htmlspecialchars($notification['content']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </main>
    <?php include_once __DIR__ . '/includes/footer.php' ?>
</body>

</html>
