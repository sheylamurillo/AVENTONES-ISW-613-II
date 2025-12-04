
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/booking.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <h1>Bookings</h1>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Ride</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="bookings_list">
                <?php foreach ($bookings as $booking) { ?>
                    <tr>
                        <td> <?= $booking['name'] . " " . $booking['lastName'] ?> </td>
                        <td> <?= $booking['origin'] . " - " . $booking['destination'] ?> </td>
                        <td> <?= $booking['status'] ?></td>
                        <td>
                            <?php if ($booking['canAccept']): ?>
                                <a href="<?= base_url('/bookings/update/'.$booking['idBooking'].'/accept') ?>">Accept</a>
                            <?php endif; ?>

                            <?php if ($booking['canReject']): ?>
                                <a href="<?= base_url('/bookings/update/'.$booking['idBooking'].'/reject') ?>">Reject</a>
                            <?php endif; ?>

                            <?php if ($booking['canCancel']): ?>
                                <a href="<?= base_url('/bookings/update/'.$booking['idBooking'].'/reject') ?>"
                                onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                            <?php endif; ?>

                            <?php if (!$booking['canAccept'] && !$booking['canReject'] && !$booking['canCancel']): ?>
                                <span style="color: gray;">—</span>
                            <?php endif; ?>
                       
                        </td>
                    </tr>
                <?php } ?>

            </tbody>

        </table>
    </main>

</body>

</html>