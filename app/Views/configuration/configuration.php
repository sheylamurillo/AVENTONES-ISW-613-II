<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Configuration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/configuration.css')?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="<?= base_url('uploads/logo.png') ?>" class="design-logo" alt="Aventones Logo">

        <div class="menu-cont">
            <nav class="Head" aria-label="Main menu">
                <ul>
                </ul>
            </nav>

            <div class="navigation-cont">
                <div class="user-menu">
                    <img src="<?= base_url('uploads/user.png') ?>" class="navigation-image" alt="User icon">
                    <nav class="menu-hover">
                        <ul>
                            <li><a href="../actions/logout.php">Logout</a></li>
                            <li><a href="editProfile.php">Profile</a></li>
                            <li><a href="configuration.php">Configuration</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main>
        <h1>Configuration</h1>
        <form action="<?= base_url('configuration/save')?>" method="POST" id="configuration_form">
            <label for="public-name">Public Name</label>
            <input type="text" id="public-name" name="public-name" value="<?= $configuration['publicname'] ?? ''?>">

            <label for="public-bio">Public Bio</label>
            <textarea id="public-bio" name="public-bio"> <?= $configuration['publicbio'] ?? '' ?> </textarea>

            <div class="buttons">

                <button type="submit">Save</button>
            </div>
        </form>
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