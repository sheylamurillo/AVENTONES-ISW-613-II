<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Configuration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/generalStyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/configuration.css')?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <h1>Configuration</h1>
        <form action="<?= base_url('configuration/save')?>" method="POST" id="configuration_form">
            <label for="public-name">Public Name</label>
            <input type="text" id="public-name" name="public-name" value="<?= $configuration['publicname'] ?? ''?>">

            <label for="public-bio">Public Bio</label>
            <textarea id="public-bio" name="public-bio"> <?= $configuration['publicbio'] ?? '' ?> </textarea>

            <div class="buttons">

                <button type="submit">Save</button>
            </div>
        </form>
    </main>


</body>

</html>