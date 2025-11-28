
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('styles/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/booking.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <img src="<?= base_url('images/logo.png') ?>" class="design-logo" alt="Aventones Logo">

        <div class="menu-cont">

            
            <nav class="Head" aria-label="Main menu">
                <ul>
                    <?php 
                        
                    ?>
                </ul>
            </nav>

            <div class="navigation-cont">
                <div class="user-menu">
                    <img src="<?= base_url('images/user.png') ?>" class="navigation-image" alt="User icon">
                    <nav class="menu-hover">
                        <ul>
                            <li><a href="../actions/logout.php">Logout</a></li>
                            <li><a href="editProfile.php">Profile</a></li>
                            <li><a href="configuration.php">Configuration</a></li>
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

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
                                <a href="<?= base_url('bookings/update/'.$booking['idBooking'].'/accept') ?>">Accept</a>
                            <?php endif; ?>

                            <?php if ($booking['canReject']): ?>
                                <a href="<?= base_url('bookings/update/'.$booking['idBooking'].'/reject') ?>">Reject</a>
                            <?php endif; ?>

                            <?php if ($booking['canCancel']): ?>
                                <a href="<?= base_url('bookings/update/'.$booking['idBooking'].'/reject') ?>"
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

    <footer>
        <hr>
        <nav aria-label="Footer navigation">
            <a href="editProfile.php" class="foot">Profile</a> |
            <a href="configuration.php" class="foot">Settings</a>
        </nav>
        <p>&copy; 2025 Aventones.com</p>

    </footer>

</body>

</html>