<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Rides</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/searchRides.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <img src="<?= base_url('uploads/logo.png') ?>" class="design-logo" alt="Aventones Logo">

        <div class="menu-cont">
            <nav class="Head" aria-label="Main menu">
                <ul>
                  
                </ul>
            </nav>

            <div class="navigation-cont">
                <div class="user-menu">
                    <img src="<?= base_url('uploads/logo.png') ?>" class="navigation-image" alt="User icon">
                    <nav class="menu-hover">
                        <ul>
                           
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main>

        <h1>Search Rides</h1>

        <form id="search-form" method="POST" action="<?= $isPublic ? base_url('searchRides/public') : base_url('searchRides') ?>">>

            <section class="section-search">

                <div class="places">

                    <label>From</label>

                    <select class="select-from" id="from-select" name="from">
                        <option value="">Select origin</option> 
                        <?= renderOptions($origins, $originSelected, 'origin') ?>
                    </select>

                    <label>To</label>

                    <select class="select-to" id="to-select" name="to">
                        <option value="">Select destination</option> 
                        <?= renderOptions($destinations, $destinationSelected, 'destination') ?>
                    </select>

                    <button type="submit"> Find Rides</button>
                </div>

                <div class="main-days-cont">
                    <label>Days</label>
                    <div class="all-days">
                        <?= renderDays(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], $days) ?>
                    </div>
                </div>

            </section>


            <section class="section-information">

            <p class="text" id="rides-info-text">Rides found from <strong> <?= $originSelected ?></strong>  to  <strong> <?=$destinationSelected?> </strong></p>

            <input type="hidden" name="order" value="<?= $order ?>">
            <input type="hidden" name="orderBy" value="<?= $orderBy ?>">
            
            <table>
                <thead>
                    <tr>
                         <?php if (!$isPublic): ?>
                            <th>Driver</th>
                            
                        <?php endif; ?>

                        <th>
                            From
                            <button form="search-form" type="submit" name="change_order" value="from">
                                <?= ($orderBy === 'from' && $order === 'DESC') ? 'DESC' : 'ASC' ?>
                            </button>
                        </th>

                        <th>
                            To
                            <button form="search-form" type="submit" name="change_order" value="to">
                                <?= ($orderBy === 'to' && $order === 'DESC') ? 'DESC' : 'ASC' ?>
                            </button>
                        </th>

                        <th>Seats</th>
                        <th>Car</th>
                        <th>Fee</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody id="search_list">

                    <?php foreach ($rides as $ride) { ?>

                        <tr>
                            <?php if (!$isPublic): ?>
                                <td><?= $ride['name'] . " " . $ride['lastName'] ?></td>
                                <td><a href="<?= base_url('rideDetails/' . $ride['idRide']) ?>"> <?= $ride['origin'] ?></a></td>
                            <?php else: ?>
                                <td><?= $ride['origin'] ?></td>
                            <?php endif; ?>

                            <td> <?= $ride['destination'] ?></td>
                            <td> <?= $ride['availableSeats'] ?></td>
                            <td> <?= $ride['brand'] . " - " . $ride['model'] . " - " . $ride['year']?> </td>
                            <td> <?= $ride['costPerSeat'] ?></td>
                            <?php if (!$isPublic): ?>
                                <td>
                                    <a href="<?= base_url('bookings/create/' . $ride['idRide']) ?>">Request</a>
                                </td>
                            <?php else: ?>
                                <td>
                                    <a href="<?= base_url('login?req=1') ?>">Login to request</a>
                                </td>
                                
                            <?php endif; ?>
                            
                        </tr>

                    <?php } ?>

                </tbody>
            </table>

        </section>

        </form>


        
        <section>
            <iframe class="map-image"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3930.1184828238515!2d-84.4230223!3d10.3142701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa065e88d7467c3%3A0x4601c6c51fd48543!2sBarrio%20Gamonales%2C%20Cd%20Quesada!5e0!3m2!1ses!2scr!4v1724025000000!5m2!1ses!2scrs"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </section>

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