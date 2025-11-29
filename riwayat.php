<?php
require_once __DIR__ . '/kode/utils.php';

$riwayatPath = __DIR__ . '/data/riwayat.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    save_json($riwayatPath, []);
    header("Location: riwayat.php");
    exit;
}

$riwayat = load_json($riwayatPath, []);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Latihan</title>
    <link rel="stylesheet" href="styling/style.css">
</head>
<body>

<div class="history-wrap">
    <h1>Riwayat Latihan Pokémon</h1>

    <?php if (empty($riwayat)): ?>
        <p class="empty-note">Belum ada riwayat latihan.</p>
    <?php else: ?>
        <?php foreach (array_reverse($riwayat) as $log): ?>
            <div class="history-card">
                <div class="row"><strong>Jenis Latihan:</strong> <?= htmlspecialchars($log['jenis']); ?></div>
                <div class="row"><strong>Intensitas:</strong> <?= htmlspecialchars($log['intensitas']); ?></div>
                <div class="row"><strong>EXP:</strong> <?= htmlspecialchars($log['exp_gain']); ?></div>
                <div class="row"><strong>Level:</strong> <?= $log['beforeLevel']; ?> → <?= $log['afterLevel']; ?></div>
                <div class="row"><strong>HP:</strong> <?= $log['beforeStats']['hp']; ?> → <?= $log['afterStats']['hp']; ?></div>

                <?php if (isset($log['specialName'])): ?>
                    <div class="row"><strong>Spesial:</strong> <?= htmlspecialchars($log['specialName']); ?></div>
                    <div class="row"><em><?= htmlspecialchars($log['specialDesc']); ?></em></div>
                <?php endif; ?>

                <div class="row"><strong>Waktu:</strong> <?= htmlspecialchars($log['waktu']); ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="text-align:center; margin-top:25px;">
        <a href="latihan.php">
            <button class="main-btn">Latihan</button>
        </a>

        <a href="index.php">
            <button class="main-btn">Beranda</button>
        </a>

        <form method="POST" style="display:inline-block; margin-left:10px;">
            <input type="hidden" name="hapus" value="1">
            <button type="submit" class="reset-btn" 
                onclick="return confirm('Yakin ingin menghapus semua riwayat?')">
                Hapus Riwayat
            </button>
        </form>
    </div>

</div>

</body>
</html>
