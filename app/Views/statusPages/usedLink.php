
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="<?=base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?=base_url('css/activateAccount.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="../images/logo.png" class="design-logo" alt="Aventones Logo">
    </header>

    <main>
        <h1>Passwordless Login Information</h1>

        <p class="message"><?= $message?></p>

        <a href="<?= base_url('login') ?>" class="btn">Ir a Login</a>
    </main>
    
    <footer>
        <hr>
        <nav aria-label="Footer navigation">
            <a href="editProfile.php" class="foot">Profile</a> |
            <a href="configuration.php" class="foot">Settings</a>
        </nav>
        <p>&copy; 2025 Aventones.com</p>

    </footer>
</body>

</html>