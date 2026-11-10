<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rental Kamera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Sistem Manajemen Rental Kamera</h2>
    <nav>
        <a href="index.php?page=customers" class="<?= ($page === 'customers') ? 'active' : '' ?>">Pelanggan</a>
        <a href="index.php?page=cameras" class="<?= ($page === 'cameras') ? 'active' : '' ?>">Kamera</a>
        <a href="index.php?page=rentals" class="<?= ($page === 'rentals') ? 'active' : '' ?>">Transaksi Rental</a>
    </nav>
