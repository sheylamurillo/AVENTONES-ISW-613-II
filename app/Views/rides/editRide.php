<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Ride</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/rides.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>

<main>
    <h1>Edit Ride</h1>

    <form class="formm" action="<?= base_url('rides/update/' . $ride['idRide']) ?>" method="POST">

        <div class="input-design-right">
            <label>Departure from</label>
            <input type="text" id="origin" name="origin"
                   value="<?= esc($ride['origin']) ?>">
        </div>

        <div class="input-design-left">
            <label>Arrive To</label>
            <input type="text" id="destination" name="destination"
                   value="<?= esc($ride['destination']) ?>">
        </div>

        <h2>Days</h2>

        <fieldset class="rows">
            <?php foreach ($days as $d): ?>
                <label>
                    <input type="checkbox"
                           name="days[]"
                           value="<?= $d ?>"
                           <?= in_array($d, $selectedDays) ? 'checked' : '' ?>>
                    <?= $d ?>
                </label>
            <?php endforeach; ?>
        </fieldset>

        <fieldset class="details-rows">
            <div>
                <label>Time</label>
                <input type="time"
                       name="departureTime"
                       value="<?= esc($ride['departureTime']) ?>">
            </div>

            <div>
                <label>Seats</label>
                <input type="number"
                       name="availableSeats"
                       min="1"
                       value="<?= esc($ride['availableSeats']) ?>">
            </div>

            <div>
                <label>Fee per Seat</label>
                <input type="number"
                       name="costPerSeat"
                       min="1"
                       value="<?= esc($ride['costPerSeat']) ?>">
            </div>
        </fieldset>

        <h2>Vehicle</h2>

        <div class="vehicle-details">
            <label>Plate & Brand</label>
            <select name="plate">
                <?php foreach ($vehicles as $v): ?>
                    <option value="<?= $v['plateNumber'] ?>"
                        <?= $v['idVehicle'] == $ride['idVehicle'] ? 'selected' : '' ?>>
                        <?= $v['plateNumber'] . ' - ' . $v['brand'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="button-rows">
            <a href="<?= base_url('rides') ?>">Cancel</a>

            <a class="inactivate"
               href="<?= base_url('rides/inactivate/' . $ride['idRide']) ?>">
                Inactivate Ride
            </a>

            <button type="submit">Save / Activate</button>
        </div>

    </form>
</main>

</body>
</html>
