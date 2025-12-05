<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>

    <main>
        <header>
            <img src="<?=base_url('uploads/logo.png')?>"  class="imageLogo" alt="Aventones Logo" />
        </header>

        <section class="contLogin">


           <form action="<?= base_url('auth/store') ?>" method="POST">
                <div class="inputClass">
                    <label for="gmail">Gmail <br></label>
                   <input type="text" name="gmail" value="<?= old('gmail') ?>">
                </div>

                <br>
                <div class="inputClass">
                    <label for="password">Password <br></label>
                    <input type="password" id="password" name="password">
                </div>

                <?php 
                    $error = session()->getFlashdata('error');
                    $success = session()->getFlashdata('success');
                ?>

                    <?php if ($error): ?>
                    <p id="loginError">
                        <?php
                            switch($error) {
                                case "password": echo "Incorrect password"; break;
                                case "inactive": echo "Your account is inactive"; break;
                                case "pending": echo "Account pending approval"; break;
                                case "notfound": echo "User not found"; break;
                                case "noSession": echo "You must log in"; break;
                                case "permission": echo "You do not have permissions to access"; break;
                            }
                        ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($success): ?>
                    <p id="successMesssage">
                        <?php
                            switch ($success) {
                                case "linkSent": echo "A login link has been sent to your email."; break;
                            }
                        ?>
                    </p>
                    <?php endif; ?>




                <p>Not a user? <a href="<?= base_url('auth/registerPassenger') ?>">Register Now</a></p>
            
                <p><a href="<?= base_url('searchRides/public') ?>">Public Rides</a></p>


                <div class="contButton">
                    <button type="submit" name="action" value="login" class="button">Login</button>
                    <button type="submit" name="action" value="passwordless" class="button-alt">PasswordLess </button>
                </div>

            </form>

        </section>
    </main>
</body>

</html>