<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link rel="stylesheet" href="<?=base_url('css/generalStyle.css')?>">
    <link rel="stylesheet" href="<?=base_url('css/myRides.css')?>">

     
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <h1>All Users</h1>

        <div class="button-cont">
            <a id="newRideBtn" class="button" href="<?= base_url('admin/newAdmin') ?>">New Admin</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="hidden">id</th>
                    <th>ID</th>
                    <th>Full name</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="ride_list">
                <?php foreach ($users as $user): ?>
                <tr>
                    <td class="hidden"><?= htmlspecialchars($user['idUser']) ?></td> 
                    <td><?= htmlspecialchars($user['ID']) ?></td>
                    <td><?= htmlspecialchars($user['name'] . ' ' . $user['lastName']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>

                    <?php 
                        // Agregar atributo data-id con el id del usuario
                        // Mostrar checkbox marcado si el estado es 'active'
                    ?>
                        <input 
                            type="checkbox"
                            class="status-toggle"
                            data-id="<?= htmlspecialchars($user['idUser']) ?>"
                            data-url="<?= base_url('user/desactivate') ?>"
                            <?= $user['status'] === 'active' ? 'checked' : '' ?>>
                    </td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </main>


    <script src="<?= base_url('js/updateStatusCheckBox.js') ?>"></script>
</body>
</html>