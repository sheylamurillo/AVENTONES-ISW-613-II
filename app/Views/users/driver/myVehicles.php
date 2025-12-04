<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Vehicles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/myRides.css') ?>">

    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <h1>My Vehicles</h1>
        <?php if (isset($_GET['error'])): ?> 
            <div class="error-box">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="button-cont">
            <a id="newVehicleBtn" class="button" href="<?= base_url('vehicles/newVehicle')?>" >Add New Vehicle</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Plate</th>
                    <th>Color</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Seats</th>
                    <th id="picture"></th>
                    <th id="actionTable">Actions</th>

                </tr>
            </thead>
            <tbody id="vehicle_list">
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= htmlspecialchars($vehicle['plateNumber']) ?></td>
                        <td><?= htmlspecialchars($vehicle['color']) ?></td>
                        <td><?= htmlspecialchars($vehicle['brand']) ?></td>
                        <td><?= htmlspecialchars($vehicle['model']) ?></td>
                        <td><?= htmlspecialchars($vehicle['year']) ?></td>
                        <td><?= htmlspecialchars($vehicle['seatCapacity']) ?></td>
                        <td>
                        <img src="<?= base_url(esc($vehicle['picture'])) ?>" alt="Vehicle Image" width="120">
                        </td>
                        <td>
                           <a href="<?= base_url('vehicles/edit/' . $vehicle['idVehicle']) ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>

</html>