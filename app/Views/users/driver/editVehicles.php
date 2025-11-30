<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Vehicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/newVehicle.css') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="<?= base_url('uploads/logo.png') ?>" class="design-logo" alt="Aventones Logo">

        <div class="menu-cont">
            <nav class="Head" aria-label="Main menu">
                <ul>
                    <li><a href="">Home</a></li>
                    <li id="rides-navegation"><a href="" class="activo">Rides</a></li>
                    <li><a href="">Bookings</a></li>
                </ul>
            </nav>

            <div class="navigation-cont">
                <div class="user-menu">
                    <img src="<?= base_url('uploads/user.png') ?>" class="navigation-image" alt="User icon">
                    <nav class="menu-hover">
                        <ul>
                            <li><a href="../actions/logout.php" id="logout-link">Logout</a></li>
                            <li><a href="editProfile.html">Profile</a></li>
                            <li><a href="configuration.html" class="activo">Configuration</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <main class="container">
    <h1>Edit Vehicle</h1>
    <hr>

    <form class="formNewVehicle" method="POST"
          action="<?= base_url('vehicles/update/' . $vehicle['idVehicle']) ?>"
          enctype="multipart/form-data">

        <label for="plateNumber">Plate<span class="req">*</span></label>
        <input class="input-design" id="plateNumber" type="text" name="plateNumber"
               value="<?= esc($vehicle['plateNumber']) ?>" required>

        <label for="color">Color<span class="req">*</span></label>
        <select id="color" name="color" required>
            <?php
                $colors = ["Red","Blue","Black","White","Grey","Green","Brown","Yellow"];
                foreach ($colors as $color):
            ?>
                <option value="<?= $color ?>" <?= ($color == $vehicle['color']) ? 'selected' : '' ?>>
                    <?= $color ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="brand">Brand<span class="req">*</span></label>
        <input id="brand" type="text" name="brand"
               value="<?= esc($vehicle['brand']) ?>" required>

        <label for="model">Model<span class="req">*</span></label>
        <input id="model" type="text" name="model"
               value="<?= esc($vehicle['model']) ?>" required>

        <label for="seatCapacity">Seats<span class="req">*</span></label>
        <input id="seatCapacity" type="number" name="seatCapacity" min="1" max="10" step="1"
               value="<?= esc($vehicle['seatCapacity']) ?>" required>

        <label for="year">Year<span class="req">*</span></label>
        <input id="year" type="text" name="year"
               value="<?= esc($vehicle['year']) ?>" required>
               
       
        <label for="picture">Picture</label>
        <div class="file-field">
            <input type="file" id="picture" name="picture" accept="image/*">
            <img id="preview" src="<?=base_url($vehicle['picture']) ?>"
                 class="preview" style="max-width: 120px;">
                

        </div>

        <div class="form-actions">
            <a class="btn btn-secondary" href="<?= base_url('vehicles') ?>">Cancel</a>

            <a class="inactivate"
               href="<?= base_url('vehicles/inactivate/' . $vehicle['idVehicle']) ?>">
               Inactivate Vehicle
            </a>

            <button class="btn btn-primary" type="submit">Save Vehicle</button>
        </div>
    </form>
    </main>



    <footer>
        <hr>
        <nav aria-label="Footer navigation">
            <a href="" class="foot">Home</a> |
            <a href="" class="foot">Rides</a> |
            <a href="" class="foot">Bookings</a> |
            <a href="" class="foot">Settings</a> |
            <a href="" class="foot">Login</a> |
            <a href="" class="foot">Register</a>
        </nav>
        <p>&copy; 2025 Aventones.com</p>

    </footer>

    <script src="../JavaScript/newVehicle.js"></script>
</body>

</html>