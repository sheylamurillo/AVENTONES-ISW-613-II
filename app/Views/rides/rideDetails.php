<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ride Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/rides.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>

<main>
    <h1>Ride Details</h1>

    <figure class="driver-photo">
        <img src="<?= base_url($driver['picture'] ?? 'uploads/user.png') ?>"
             alt="Driver photo" class="profile-picture">

        <figcaption class="driver-name">
            <?= esc($driver['name']) . ' ' . esc($driver['lastName']) ?>
        </figcaption>
    </figure>

    <form class="formm" method="POST" action="<?= base_url('bookings/create/' . $ride['idRide']) ?>">

        <input type="hidden" name="idRide" value="<?= $ride['idRide'] ?>">

        <div class="input-design-right">
            <label>Departure from</label>
            <input disabled type="text" value="<?= esc($ride['origin']) ?>">
        </div>

        <div class="input-design-left">
            <label>Arrive To</label>
            <input disabled type="text" value="<?= esc($ride['destination']) ?>">
        </div>

        <h2>Days</h2>

        <fieldset class="rows">
            <?php foreach ($days as $d): ?>
                <label>
                    <input type="checkbox" disabled
                           <?= in_array($d, $rideDays) ? 'checked' : '' ?>>
                    <?= $d ?>
                </label>
            <?php endforeach; ?>
        </fieldset>

        <fieldset class="details-rows">

            <div>
                <label>Time</label>
                <input disabled type="time" value="<?= esc($ride['departureTime']) ?>">
            </div>

            <div>
                <label>Seats</label>
                <input disabled type="number" value="<?= esc($ride['availableSeats']) ?>">
            </div>

            <div>
                <label>Fee per Seat</label>
                <input disabled type="number" value="<?= esc($ride['costPerSeat']) ?>">
            </div>

        </fieldset>

        <h2>Vehicle Details</h2>

        <div class="vehicle-details">
            <div>
            <label for="plate">Plate & Brand<br></label>
            <input type="text" id="plate-brand" name="plate-brand" disabled
                   value="<?= esc($vehicle['plateNumber']) . ' - ' . esc($vehicle['brand']) ?>">
            </div>  
        </div>



        <div class="button-rows">
            <a href="<?= base_url('rides') ?>">Cancel</a>

            <?php if ($role !== "Driver"): ?>
                <button type="submit">Request</button>
            <?php else: ?>
                <button disabled type="button">Request</button>
            <?php endif; ?>
        </div>

    </form>

</main>

</body>
</html>
