<?php
require_once __DIR__ . '/kode/utils.php';
require_once __DIR__ . '/kode/Raticate.php';
require_once __DIR__ . '/kode/Training.php';

$dataPath = __DIR__ . '/data/raticate.json';
$riwayatPath = __DIR__ . '/data/riwayat.json';

if (!file_exists($dataPath)) {
    $r = new Raticate();
    save_json($dataPath, $r->toArray());
}

$rdata = load_json($dataPath);
$raticate = new Raticate($rdata);

$trainer = new Training();
$hasilLatihan = null;
$pesan = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'reset') {
        $raticate->resetToBase();
        save_json($dataPath, $raticate->toArray());
        $pesan = "Pokémon telah di-reset ke kondisi awal.";
    } else {
        $jenis = $_POST['jenis'] ?? 'Attack';
        $intensity = intval($_POST['intensity'] ?? 1);
        if ($intensity < 1) $intensity = 1;
        if ($intensity > 10) $intensity = 10;

        $calc = $trainer->calculate($raticate, $jenis, $intensity);

        $applied = $raticate->applyTrainingResult($calc);

        $log = [
            'jenis' => $calc['type'],
            'intensitas' => $calc['intensity'],
            'exp_gain' => $calc['exp'],
            'beforeLevel' => $applied['before']['level'],
            'afterLevel' => $applied['after']['level'],
            'beforeStats' => $applied['before']['stats'],
            'afterStats' => $applied['after']['stats'],
            'waktu' => date("Y-m-d H:i:s")
        ];

        $existing = load_json($riwayatPath, []);
        $existing[] = $log;
        save_json($riwayatPath, $existing);

        save_json($dataPath, $raticate->toArray());

        $hasilLatihan = $log;
    }
}

$stats = $raticate->getStats();
$specialMoveName = "Hyper Fang";
$specialMoveDesc = "Serangan gigitan cepat yang memiliki peluang besar memberikan kerusakan berat pada lawan.";
$level = $raticate->getLevel();
$exp = $raticate->getExp();
$nextLevelExp = $raticate->expForLevel($level + 1);
$progress = 0;
if ($level >= 100) {
    $progress = 100;
} else {
    $prevReq = $raticate->expForLevel($level);
    $needed = $nextLevelExp - $prevReq;
    $cur = $raticate->getExp() - $prevReq;
    if ($needed > 0) {
        $progress = max(0, min(100, (int)floor(($cur / $needed) * 100)));
    } else {
        $progress = 0;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Latihan - PokéCare</title>
    <link rel="stylesheet" href="styling/style.css">
</head>
<body>

<div class="container-training">

    <div class="training-left">
        <h1>Sesi Latihan</h1>

        <form method="POST">
            <div class="field">
                <label>Tipe Latihan</label><br>
                <button type="button" class="type-btn" data-type="Attack">Attack</button>
                <button type="button" class="type-btn" data-type="Speed">Speed</button>
                <button type="button" class="type-btn" data-type="Defense">Defense</button>
                <input type="hidden" name="jenis" id="jenis-input" value="Attack">
            </div>

            <div class="field">
                <label>Intensitas (1-10)</label><br>
                <div class="intensity-grid">
                    <?php for ($i=1;$i<=10;$i++): ?>
                        <button type="button" class="int-btn" data-int="<?= $i; ?>"><?= $i; ?></button>
                    <?php endfor; ?>
                    <input type="hidden" name="intensity" id="intensity-input" value="5">
                </div>
            </div>

            <div class="field">
                <button type="submit" class="main-btn">Latih!</button>
                <a href="index.php"><button type="button" class="main-btn">Beranda</button></a>
                <a href="riwayat.php"><button type="button" class="main-btn">Histori</button></a>

            </div>
        </form>
    </div>

    <div class="card-right">
        <div class="card-top">
            <div class="card-header">
                <span class="poke-name-small"><?= htmlspecialchars($raticate->getName()); ?></span>
                <span class="poke-level"><?= ($level >= 100) ? "Lv. 100 (Max)" : "Lv. ".$level; ?></span>
            </div>

            <div class="card-image">
                <img src="assets/bg_grass.jpg" class="bg-grass-card" alt="">
                <img src="assets/raticate.png" class="poke-img-card" alt="">
            </div>

            <div class="type-badge"><?= htmlspecialchars($raticate->getType()); ?></div>

            <div class="stats-list">
                <div class="stat-row"><span>HP</span><span><?= $stats['hp']; ?></span></div>
                <div class="stat-row"><span>Attack</span><span><?= $stats['atk']; ?></span></div>
                <div class="stat-row"><span>Defense</span><span><?= $stats['def']; ?></span></div>
                <div class="stat-row"><span>Sp. Attack</span><span><?= $stats['spatk']; ?></span></div>
                <div class="stat-row"><span>Sp. Defense</span><span><?= $stats['spdef']; ?></span></div>
                <div class="stat-row"><span>Speed</span><span><?= $stats['speed']; ?></span></div>
            </div>

            <div class="exp-section">
                <?php if ($level >= 100): ?>
                    <div class="exp-max">MAX</div>
                <?php else: ?>
                    <div class="exp-bar">
                        <div class="exp-fill" style="width: <?= $progress; ?>%"></div>
                    </div>
                    <div class="exp-text"><?= $exp; ?> / <?= $nextLevelExp; ?></div>
                <?php endif; ?>
            </div>

            <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="action" value="reset">
                <button type="submit" class="reset-btn">Reset Level</button>
            </form>

            <?php if ($hasilLatihan): ?>
                <div class="result-box">
                    <strong>Hasil Latihan:</strong><br>
                    Jenis: <?= htmlspecialchars($hasilLatihan['jenis']); ?><br>
                    Intensitas: <?= $hasilLatihan['intensitas']; ?><br>
                    EXP didapat: <?= $hasilLatihan['exp_gain']; ?><br>
                    Level: <?= $hasilLatihan['beforeLevel']; ?> → <?= $hasilLatihan['afterLevel']; ?><br>
                    HP: <?= $hasilLatihan['beforeStats']['hp']; ?> → <?= $hasilLatihan['afterStats']['hp']; ?><br>
                    Waktu: <?= $hasilLatihan['waktu']; ?>
                    
                    <br><br>
                    <strong>Kemampuan Spesial:</strong><br>
                    <?= $specialMoveName; ?> — <?= $specialMoveDesc; ?><br>

                </div>
            <?php endif; ?>

            <?php if ($pesan): ?>
                <div class="info-box"><?= htmlspecialchars($pesan); ?></div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){
    const typeBtns = document.querySelectorAll('.type-btn');
    const jenisInput = document.getElementById('jenis-input');
    typeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            typeBtns.forEach(b=>b.classList.remove('active-type'));
            btn.classList.add('active-type');
            jenisInput.value = btn.getAttribute('data-type');
        });
    });

    const intBtns = document.querySelectorAll('.int-btn');
    const intInput = document.getElementById('intensity-input');
    intBtns.forEach(b=>{
        b.addEventListener('click', ()=>{
            intBtns.forEach(x=>x.classList.remove('active-int'));
            b.classList.add('active-int');
            intInput.value = b.getAttribute('data-int');
        });
    });

    document.querySelector('.type-btn[data-type="Attack"]').classList.add('active-type');
    document.querySelector('.int-btn[data-int="5"]').classList.add('active-int');
});
</script>

</body>
</html>
