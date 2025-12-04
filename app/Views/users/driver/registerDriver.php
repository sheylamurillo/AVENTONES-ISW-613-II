<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rider Registration</title>
    <link rel="stylesheet" href="<?= base_url('/css/register.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>

    <main>
        <h1>Rider Registration</h1>

        <form action="<?= base_url('driver/store')?>" method="POST" class="formRider" enctype="multipart/form-data">
            <div>
                <label for="name">First Name <br></label>
                <input type="text" id="name" name="name">
            </div>

            <div>
                <label for="lastName">Last Name<br></label>
                <input type="text" id="lastName" name="lastName">
            </div>

            <div>
                <label for="ID">ID<br></label>
                <input type="text" id="ID" name="ID">
            </div>

            <div>
                <label for="birthDate">Birth Date<br></label>
                <input type="date" id="birthDate" name="birthDate" required>
            </div>

            <div class="bigElement">
                <label for="gmail">Email<br></label>
                <input type="email" id="gmail" name="gmail" required>
            </div>

            <div>
                <label for="password">Password<br></label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="repeat-password">Repeat Password<br></label>
                <input type="password" id="repeat-password" name="repeat-password" required>
            </div>

            <div class="bigElement">
                <label for="address">Address<br></label>
                <input type="text" id="address" name="address">
            </div>

            <div>
                <label for="phoneNumber">Phone Number<br></label>
                <input type="tel" id="phoneNumber" name="phoneNumber">
            </div>
            <div>
                <label for="picture">Photo<br></label>
                <input type="file" id="picture" name="picture" accept="image/*">
            </div>

            <p class="left">Already a driver? <a href="<?= base_url('/') ?>">Login here</a></p>
            <p class="right">Register as user? <a href="<?= base_url('auth/registerPassenger') ?>">Click here</a></p>
            <div class="bigElement" id="buttonId">
                <button type="submit" class="buttonClass">Sign up</button>
            </div>
        </form>

    </main>
</body>

</html>