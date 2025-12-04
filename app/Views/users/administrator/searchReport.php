<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/searchReport.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

</head>

<body>
    <main>

        <h1>Search Report</h1>

        <form id="search-form" method="POST"
            action="<?=base_url('admin/searchReport')?>">>

            <section class="section-search">

                <div class="places">

                    <label>From</label>
                    <input type="date" id="dateFrom" name="dateFrom" value="<?= $dateFrom ?>">

                    <label>To</label>
                    <input type="date" id="dateTo" name="dateTo"  value="<?= $dateTo ?>">

                    <button type="submit"> Find Search</button>
                </div>


            </section>


            <section class="section-information">

               <p class="text" id="rides-info-text">Search found from <strong><?= $dateFrom ?></strong> to <strong><?= $dateTo ?></strong></p>


                <table>
                    <thead>
                        <tr>
                            <th>Id user</th>
                            <th>User name</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Results Obtained</th>
                            <th>Search Date</th>
                        </tr>
                    </thead>
                    <tbody id="search_list">

                    <?php foreach($search as $s) { ?>

                        <tr>
                            <td> <?= $s['ID'] == null ? 'No reconocido ' : $s['ID'] ?> </td>
                            <td> <?=  $s['ID'] == null ? 'Usuario no reconocido' : $s['name'] . " " . $s['lastName'] ?> </td>
                            <td><?= $s['origin'] ?></td>
                            <td><?= $s['destination'] ?></td>
                            <td><?= $s['results_count'] ?></td>
                            <td><?= $s['search_date']?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </section>

        </form>

    </main>


</body>

</html>