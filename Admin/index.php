<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS-Admin/header.css">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/typography.css">
    <link rel="stylesheet" href="../CSS/admin-login.css">
    <title>Document</title>
</head>

<body>
    <header class="admin-header">
        <section class="heading">
            <h1>Hotell</h1>
            <div class="header-exit">
                <div></div>
                <div></div>
            </div>
        </section>
    </header>
    <?php
    session_start();
    // unset($_SESSION['user-auth']);
    if (!isset($_SESSION['user-auth'])) {
        require(__DIR__ . '/login.php');
    } else {
        require(__DIR__ . '/main-admin.php');
    }
    ?>
</body>

</html>