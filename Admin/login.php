<?php
require(__DIR__ . './../vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (isset($_POST['password'])) {
    $pw = trim(htmlspecialchars($_POST['password']));
    if ($pw === $_ENV['API_KEY']) {
        $_SESSION['user-auth'] = true;
        header('Location: /Admin');
    } else {
        echo "Wrong password";
    }
}
?>

<main class="login-main">
    <form method="POST">
        <section>
            <label for="password">Enter password: </label>
            <input type="password" name="password">
        </section>
        <section class="login-btn">
            <button type="submit">Enter</button>
        </section>
    </form>
    <picture>
        <source srcset="../Images/luxury-large.jpg" media="(min-width: 768px)">
        <source srcset="../Images/luxury-medium.jpg" media="(min-width: 400px">
        <img src="../Images/luxury-small.jpg" alt="luxury hotel room with a nice and tidy area!">
    </picture>
</main>