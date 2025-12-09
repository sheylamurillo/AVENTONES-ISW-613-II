<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Administrator</title>
    <link rel="stylesheet" href="<?=base_url('css/editProfile.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/generalStyle.css')?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <h1>New Administrator</h1>

        <form action="<?= base_url('admin/saveAdmin') ?>" 
            method="post" 
            class="formRider" 
            enctype="multipart/form-data">

            <div>
                <label for="name">First Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div>
                <label for="ID">ID</label>
                <input type="text" id="ID" name="ID" required>
            </div>

            <div>
                <label for="birthDate">Birth Date</label>
                <input type="date" id="birthDate" name="birthDate" required>
            </div>

            <div class="bigElement">
                <label for="gmail">Email</label>
                <input type="email" id="gmail" name="gmail" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="repeat-password">Repeat Password</label>
                <input type="password" id="repeat-password" name="repeat-password" required>
            </div>

            <div class="bigElement">
                <label for="address">Address</label>
                <input type="text" id="address" name="address">
            </div>

            <div>
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" id="phoneNumber" name="phoneNumber">
            </div>

            <div>
                <label for="picture">Photo</label>
                <input type="file" id="picture" name="picture" accept="image/*">
            </div>

            <div>
                <a href="<?= base_url('/allUsers') ?>">Cancel</a>
            </div>

            <div class="contenedor-boton">
                <button type="submit">Save</button>
            </div>

        </form>
    </main>

</body>

</html>