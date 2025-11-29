<?php
require_once __DIR__ . '/kode/utils.php';
require_once __DIR__ . '/kode/Raticate.php';

$dataPath = __DIR__ . '/data/raticate.json';
if (!file_exists($dataPath)) {
    $r = new Raticate();
    save_json($dataPath, $r->toArray());
}

// Load data
$rdata = load_json($dataPath, null);

// Restore objek
$raticate = new Raticate($rdata);
$stats = $raticate->getStats();
$base = $raticate->getBaseStats();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PokéCare - Beranda</title>
    <link rel="stylesheet" href="styling/style.css">
</head>
<body>

<div class="header">
    <h1>PokéCare</h1>
</div>

<div class="pokedex-container">

    <div class="left-info">
        <h2>Informasi</h2>
        <p><strong>Tipe:</strong> <?= htmlspecialchars($raticate->getType()); ?></p>
        <p><strong>Kelemahan:</strong> Petarung (Fighting)</p>
    </div>

    <div class="center-display">

        <div class="image-wrapper">
            <img src="assets/bg_grass.jpg" class="bg-grass" alt="">
            <img src="assets/raticate.png" class="poke-img" alt="Raticate">
        </div>

        <h2 class="poke-name"><?= htmlspecialchars($raticate->getName()); ?></h2>

    </div>

    <div class="right-info">
        <h2>Detail Fisik</h2>
        <p><strong>Tinggi:</strong> <?= $raticate->getHeight(); ?> m</p>
        <p><strong>Berat:</strong> <?= $raticate->getWeight(); ?> kg</p>
        <p><strong>Kategori:</strong> <?= $raticate->getCategory(); ?></p>
        <p><strong>Kemampuan:</strong> <?= implode(", ", $raticate->getAbilities()); ?></p>
        <p><strong>Gender:</strong> <?= $raticate->getGender(); ?></p>
    </div>

</div>

<div class="bottom-container">

    <div class="description-box">
        <h3>Deskripsi</h3>
        <p>Raticate dikenal memiliki gigi depan yang sangat kuat. Ia dapat menggigit apa saja untuk mempertahankan diri dan berburu.</p>
    </div>

    <div class="ability">
        <h3>Kemampuan Spesial</h3>
        <p><strong>Hyper Fang</strong>: Serangan gigitan cepat yang memiliki peluang besar memberikan kerusakan berat pada lawan.</p>
    </div>

    <div class="stats-box">
        <h3>Statistik (Current)</h3>
        <table>
            <tr><td>Level</td><td><strong><?= $raticate->getLevel(); ?></strong></td></tr>
            <tr><td>HP</td><td><strong><?= $stats['hp']; ?></strong></td></tr>
            <tr><td>Attack</td><td><strong><?= $stats['atk']; ?></strong></td></tr>
            <tr><td>Defense</td><td><strong><?= $stats['def']; ?></strong></td></tr>
            <tr><td>Sp. Attack</td><td><strong><?= $stats['spatk']; ?></strong></td></tr>
            <tr><td>Sp. Defense</td><td><strong><?= $stats['spdef']; ?></strong></td></tr>
            <tr><td>Speed</td><td><strong><?= $stats['speed']; ?></strong></td></tr>
        </table>
    </div>

</div>

<div class="buttons-home" style="text-align:center; padding: 20px;">
    <a href="latihan.php"><button class="main-btn">Mulai Latihan</button></a>
    <a href="riwayat.php"><button class="main-btn">Riwayat Latihan</button></a>
</div>

</body>
</html>
