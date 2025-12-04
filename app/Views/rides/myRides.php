<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Rides</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/myRides.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <h1>My rides</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-box">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>


        <div class="button-cont">
            <a id="newRideBtn" class="button" href = "<?= base_url('rides/newRide')?>">New Ride</a>
            
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Seats</th>
                    <th>Time</th>
                    <th>Days</th>
                    
                    <th id="feeTable">Fee</th>
                    <th>Status</th>
                    <th id="actionTable">Actions</th>

                </tr>
            </thead>
            <tbody id="ride_list">
    
            <?php foreach ($rides as $ride): ?>

            <tr>
                        
                        <td><a href="<?= base_url('rides/rideDetails/' . $ride['idRide']) ?>"><?= $ride['origin']?></a></td> 
                        <td><?= htmlspecialchars($ride['destination']) ?></td>
                        <td><?= htmlspecialchars($ride['availableSeats']) ?></td>
                        <td><?= htmlspecialchars($ride['departureTime']) ?></td>
                        <td><?= htmlspecialchars($ride['rideDate']) ?></td>
                        <td><?= htmlspecialchars($ride['costPerSeat']) ?></td>       
                        <td><?= htmlspecialchars($ride['status']) ?></td>   
                        <td>
                            <a href="<?= base_url('rides/editRide/' . $ride['idRide']) ?>">Edit</a>
                        </td>
            </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>

</html>