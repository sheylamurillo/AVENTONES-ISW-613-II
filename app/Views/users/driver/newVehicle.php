<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Vehicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/newVehicle.css') ?>">
   
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main class="container">
        <h1>New Vehicle</h1>
        <hr>

        <form class="formNewVehicle" method="POST" action="<?= base_url('vehicles/store')?>" enctype="multipart/form-data">

            <label for="plateNumber">Plate<span class="req">*</span></label>
            <input class="input-design" id="plate" type="text" name="plateNumber" placeholder="Enter your plate" required>


            <label for="color">Color<span class="req">*</span></label>
            <select id="color" name="color" required>
                <option value="">Select a color…</option>
                <option>Red</option>
                <option>Blue</option>
                <option>Black</option>
                <option>White</option>
                <option>Grey</option>
                <option>Green</option>
                <option>Brown</option>
                <option>Yellow</option>
            </select>


            <label for="brand">Brand<span class="req">*</span></label>
            <input id="brand" type="text" name="brand" placeholder="Enter the Vehicle brand" required>


            <label for="model">Model<span class="req">*</span></label>
            <input id="model" type="text" name="model" placeholder="Enter the Vehicle model" required>

            <label for="year">Year<span class="req">*</span></label>
            <input id="year" type="text" name="year" placeholder="Enter the Vehicle Year" required>


            <label for="seatCapacity">Seats<span class="req">*</span></label>
            <input id="seats" type="number" name="seatCapacity" placeholder="Enter the Vehicle Seats" min="1" max="10" step="1" required>


            <label for="picture">Picture</label>
            <div class="file-field">
                <input type="file" id="picture" name="picture" accept="image/*">
                <img id="preview" alt="" class="preview hidden">
            </div>


            <div class="form-actions">
                <a class="btn btn-secondary" href="<?= base_url('vehicles') ?>">Cancel</a>
                <button class="btn btn-primary" type="submit">Save vehicle</button>
            </div>
        </form>
    </main>

    <script src="../JavaScript/newVehicle.js"></script>
</body>

</html>